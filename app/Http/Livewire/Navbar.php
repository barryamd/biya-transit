<?php

namespace App\Http\Livewire;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public $notifications;
    public $unreadNotifications;
    //public $caisse;

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navbar' => '$refresh',
    ];

    public function mount()
    {
        $this->setNotifications();

        //$sales = Sale::query()->withSum('saleProducts', 'profit')->get();
        //$payments = EmployeePayment::all();
        //$charges = FolderCharge::all();
        //$this->caisse = $sales->sum(fn($item) => $item->sale_products_sum_profit) - $charges->sum(fn($item) => $item->amount) - $payments->sum(fn($item) => $item->amount);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.navbar');
    }

    private function setNotifications()
    {
        $user = auth()->user();
        $this->notifications = $user->notifications;
        $this->unreadNotifications = $user->unreadNotifications;
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        $this->unreadNotifications = Auth::user()->unreadNotifications;
    }

    public function markAllAsRead()
    {
        foreach ($this->notifications as $notification) {
            $notification->markAsRead();
        }
        //$this->unreadNotifications->markAsRead();
        $this->unreadNotifications = Auth::user()->unreadNotifications;
    }

    public function delete(DatabaseNotification $notification)
    {
        $notification->delete();
        $this->setNotifications();
    }

    public function deleteAll()
    {
        foreach ($this->unreadNotifications as $notification) {
            $notification->delete();
        }
        //$this->notifications->delete();
        $this->setNotifications();
    }

    public function viewAll()
    {
        $this->unreadNotifications = Auth::user()->unreadNotifications;
    }

    public function viewDetail(DatabaseNotification $notification) {
    }
}
