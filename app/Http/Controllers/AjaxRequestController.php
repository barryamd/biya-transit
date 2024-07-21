<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Folder;
use App\Models\Product;
use App\Models\Transporter;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AjaxRequestController extends Controller
{
    public function getFolders(Request $request): JsonResponse
    {
        $query = Folder::query()->select('id', 'number')->limit(5);

        $search = $request->search;
        if ($search != '') {
            $query->where(function($query) use ($search) {
                $query->whereNotNull('number')->where('number', 'LIKE', $search . '%');
            });
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->id,
                "text" => $record->number
            );
        }
        return response()->json($response);
    }

    public function getFoldersDoesntHaveInvoice(Request $request): JsonResponse
    {
        $query = Folder::query()->whereDoesntHave('invoice')->where('status', 'Fermé')
            ->select('id', 'number')->limit(5);

        $search = $request->search;
        if ($search != '') {
            $query->where(function($query) use ($search) {
                $query->whereNotNull('number')->where('number', 'LIKE', $search . '%');
            });
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->id,
                "text" => $record->number
            );
        }
        return response()->json($response);
    }

    public function getFoldersHaveInvoice(Request $request): JsonResponse
    {
        $query = Folder::query()->whereHas('invoice')
            ->withSum('payments', 'amount')->select('id', 'number')->limit(5);

        $search = $request->search;
        if ($search != '') {
            $query->where(function($query) use ($search) {
                $query->whereNotNull('number')->where('number', 'LIKE', $search . '%');
            });
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->id,
                "text" => $record->number
            );
        }
        return response()->json($response);
    }

    public function getTransporters(Request $request): JsonResponse
    {
        $query = Transporter::query()->select('id', 'numberplate')->limit(5);

        $search = $request->search;
        if ($search != '') {
            $query->where(function($query) use ($search) {
                $query->whereNotNull('numberplate')->where('numberplate', 'LIKE', $search . '%');
            })->orWhere(function($query) use ($search) {
                $query->whereNotNull('driver_phone')->where('driver_phone', 'LIKE', '%' . $search . '%');
            });
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->id,
                "text" => $record->numberplate
            );
        }
        return response()->json($response);
    }

    public function getProducts(Request $request): JsonResponse
    {
        $query = Product::query()->select('id', 'designation')->limit(5)
            ->orderby('designation');

        $search = $request->search;
        if ($search != '') {
            $query->where(function($query) use ($search) {
                $query->whereNotNull('designation')->where('designation', 'LIKE', $search . '%');
            });
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->id,
                "text" => $record->designation
            );
        }
        return response()->json($response);
    }

    public function getProductsBy(Request $request): JsonResponse
    {
        $query = Product::query()->select('id', 'name')->limit(5)->orderby('name');

        $search = $request->search;
        $searchBy = $request->searchBy;
        if($search == '') {
            $query->where($searchBy, 'LIKE', $search . '%');
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->id,
                "text" => $record->name
            );
        }
        return response()->json($response);
    }

    public function getCustomers(Request $request): JsonResponse
    {
        $query = User::with('customer')->select('id', 'first_name', 'last_name')
            ->limit(5)->orderby('first_name')->orderBy('last_name');

        $search = $request->search;
        if ($search != '') {
            $query->whereHas('customer', function(Builder $query) use ($search) {
                $query->where('nif', 'LIKE', $search . '%')
                    ->orWhere(function (Builder $query) use($search) {
                        $query->whereNotNull('name')->where('name', 'LIKE', $search . '%');
                    });
            })
                ->orWhere('first_name', 'LIKE', $search . '%')
                ->orWhere('last_name', 'LIKE', $search . '%');
                //->orWhere('phone', 'LIKE', '%' . $search . '%');
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->customer->id,
                "text" => $record->full_name
            );
        }
        return response()->json($response);
    }

    public function getDataForSelect2($request, $model, $column): JsonResponse
    {
        $query = $model::orderby($column,'asc')->select('id',$column)->limit(5);

        $search = $request->search;
        if ($search != '') {
            $query->where(function($query) use ($search, $column) {
                $query->whereNotNull($column)->where($column, 'LIKE', $search . '%');
            });
        }
        $records = $query->get();

        $response = array();
        foreach($records as $record){
            $response[] = array(
                "id" => $record->id,
                "text" => $record->$column
            );
        }
        return response()->json($response);
    }
}
