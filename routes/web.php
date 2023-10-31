<?php

use App\Http\Controllers\AjaxRequestController;
use App\Http\Controllers\PrintController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\FolderChargeDetails;
use App\Http\Livewire\FolderForm;
use App\Http\Livewire\FolderDetails;
use App\Http\Livewire\FolderProcessForm;
use App\Http\Livewire\InvoiceDetails;
use App\Http\Livewire\InvoiceForm;
use App\Http\Livewire\RoleForm;
use App\Http\Livewire\RoleShow;
use App\Http\Livewire\Settings;
use App\Models\Setting;
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
    Route::get('settings', Settings::class)->name('settings');

    Route::view('users', 'users.index')->name('users.index');
    Route::view('roles','users.index')->name('roles.index');
    Route::get('roles/create', RoleForm::class)->name('roles.create');
    Route::get('roles/{role}/edit', RoleForm::class)->name('roles.edit');
    Route::get('roles/{role}/show', RoleShow::class)->name('roles.show');

    Route::view('customers','customers.index')->name('customers.index');

    Route::view('transporters','transporters.index')->name('transporters.index');

    Route::view('folders','folders.index')->name('folders.index');
    Route::get('folders/create', FolderForm::class)->name('folders.create');
    Route::get('folders/{folder}/edit', FolderForm::class)->name('folders.edit');
    Route::get('folders/{folder}/process', FolderProcessForm::class)->name('folders.process');
    Route::get('folders/{folder}/show', FolderDetails::class)->name('folders.show');
    Route::view('pending-folders','folders.index')->name('pending-folders.index');
    Route::view('progress-folders','folders.index')->name('progress-folders.index');
    Route::view('closed-folders','folders.index')->name('closed-folders.index');

    Route::view('container-types','container-types.index')->name('container-types.index');
    Route::view('document-types','document-types.index')->name('document-types.index');
    Route::view('tvas','tvas.index')->name('tvas.index');
    Route::view('services','services.index')->name('services.index');

    Route::view('occasional-charges','charges.index')->name('occasional-charges.index');
    Route::view('current-charges','charges.index')->name('current-charges.index');
    Route::view('folder-charges','folder-charges.index')->name('folder-charges.index');
    Route::get('folder-charges/{folder}/show', FolderChargeDetails::class)->name('folder-charges.show');

    Route::view('invoices','invoices.index')->name('invoices.index');
    Route::get('invoices/create', InvoiceForm::class)->name('invoices.create');
    Route::get('invoices/{invoice}/edit', InvoiceForm::class)->name('invoices.edit');
    Route::get('invoices/{invoice}/show', InvoiceDetails::class)->name('invoices.show');
    Route::view('invoice-payments','invoice-payments.index')->name('invoice-payments.index');

    Route::post('/getCustomers', [AjaxRequestController::class, 'getCustomers'])->name('getCustomers');
    Route::post('/getProducts', [AjaxRequestController::class, 'getProducts'])->name('getProducts');
    Route::post('/getTransporters', [AjaxRequestController::class, 'getTransporters'])->name('getTransporters');
    Route::post('/getFolders', [AjaxRequestController::class, 'getFolders'])->name('getFolders');

    Route::get('invoice/{folder}/print', [PrintController::class, 'generateInvoice'])->name('invoice.print');
});
