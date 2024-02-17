<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Folder;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [], $years = [], $total = [];
    public $stat , $year, $month, $week, $yearweeek, $date;

    public array $colors = [], $months = [];

    public bool $firstRun = true, $showDataLabels = true;

    public $folders = [], $products = [], $customers = [], $containers = [], $breakdowns = [];

    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
    ];

    public function mount()
    {
        $this->colors = [
            '#64748b', '#364152','#1a202e', // cool-gray
            '#f05252', '#c81e1e', '#771d1d', // red
            '#ff5a1f', '#b43403', '#771d1d', // orange
            '#c27803', '#8e4b10', '#633112', // yellow
            '#0e9f6e', '#046c4e', '#014737', // green
            '#0694a2', '#036672', '#014451', // teal
            '#3f83f8', '#1a56db', '#233876', // blue
            '#6875f5', '#5145cd', '#362f78', // indigo
            '#9061f9', '#6c2bd9', '#4a1d96', // purple
            '#e74694', '#bf125d', '#751a3d', // pink
        ];

        $this->months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December'
        ];

        $this->stats = [
            'productsSalesCount' => 'Les matériels les plus vendus',
            'bikesSalesCount' => 'Les types de motos les plus vendus',
            'bikesReparationsCount' => 'Les types de motos les plus reparés',
            'repairBreakdownsCount' => 'Les pannes les plus fréquentes',
            'repairmansReparationsCount' => 'Les reparateurs qui ont plus reparer',
            'customersSalesSum' => 'Les meilleurs clients'
        ];

        // Années disponibles
        array_push($this->years, 'Toutes les années');
        $this->year = now()->format('Y');

        $customer = Auth::user()->customer;
        $query = Folder::query();
        if ($customer) {
            $query->where('customer_id', $customer->id);
        }
        $this->folders = $query->get();

        $firstFolder = $this->folders->first();
        if ($firstFolder)
            $this->years = range(Date::create($firstFolder->created_at)->format('Y'), (int)$this->year);

        $this->total['folders'] = $this->folders->count();
        $this->total['pending_folders'] = $this->folders->where('status', 'En attente')->count();
        $this->total['process_folders'] = $this->folders->where('status', 'En cours')->count();
        $this->total['closed_folders'] = $this->folders->where('status', 'Fermé')->count();
        $this->total['late_folders'] = Folder::query()->where('status', '<>','Fermé')
            ->whereHas('containers', function (Builder $query) {
                $query->whereDate('arrival_date', '<=', now()->format('Y-m-d'));
            })
            ->count();
        $this->total['customers'] = Customer::query()->count();
    }

    public function render()
    {
        return view('dashboard');
    }
}
