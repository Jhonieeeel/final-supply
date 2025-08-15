<?php

use App\Livewire\Pages\Afms\RequisitionTable;
use App\Livewire\Pages\Afms\RsmiTable;
use App\Livewire\Pages\Afms\StockTable;
use App\Livewire\Pages\Afms\SupplyTable;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {


    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('supply', SupplyTable::class)->name('supply')->lazy();
    Route::get('stock', StockTable::class)->name('stock')->lazy();
    Route::get('requisition', RequisitionTable::class)->name('requisition')->lazy();
    Route::get('rsmi', RsmiTable::class)->name('rsmi')->lazy();

    // profile
    Route::view('profile', 'profile')->name('profile');
});


require __DIR__ . '/auth.php';
