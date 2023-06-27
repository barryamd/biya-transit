<?php

use App\Http\Controllers\AjaxRequestController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\FolderCreateForm;
use App\Http\Livewire\FolderDetails;
use App\Http\Livewire\FolderEditForm;
use App\Http\Livewire\InvoiceDetails;
use App\Http\Livewire\InvoiceForm;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login');

// Route qui permet de connaître la langue active
// Route::get('locale', [LocalizationController::class, 'getLang'])->name('getlang');
// Route qui permet de modifier la langue
// Route::get('locale/{lang}', [LocalizationController::class, 'setLang'])->name('setlang');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::view('users', 'users.index')->name('users.index');
    Route::view('customers','customers.index')->name('customers.index');
    Route::view('document-types','document-types.index')->name('document-types.index');
    Route::view('folders','folders.index')->name('folders.index');
    Route::get('folders/create', FolderCreateForm::class)->name('folders.create');
    Route::get('folders/{folder}/edit', FolderEditForm::class)->name('folders.edit');
    Route::get('folders/{folder}/show', FolderDetails::class)->name('folders.show');
    Route::view('pending-folders','folders.index')->name('pending-folders.index');
    Route::view('progress-folders','folders.index')->name('progress-folders.index');
    Route::view('closed-folders','folders.index')->name('closed-folders.index');
    Route::view('transporters','transporters.index')->name('transporters.index');
    Route::view('tvas','tvas.index')->name('tvas.index');
    Route::view('services','services.index')->name('services.index');
    Route::view('invoices','invoices.index')->name('invoices.index');
    Route::get('invoices/create', InvoiceForm::class)->name('invoices.create');
    Route::get('invoices/invoice/edit', InvoiceForm::class)->name('invoices.edit');
    Route::get('invoices/{invoice}/show', InvoiceDetails::class)->name('invoices.show');

    Route::post('/getCustomers', [AjaxRequestController::class, 'getCustomers'])->name('getCustomers');
    Route::post('/getProducts', [AjaxRequestController::class, 'getProducts'])->name('getProducts');
    Route::post('/getTransporters', [AjaxRequestController::class, 'getTransporters'])->name('getTransporters');
    Route::post('/getFolders', [AjaxRequestController::class, 'getFolders'])->name('getFolders');
});
