<?php

use App\Livewire\Pages\Afms\RequisitionTable;
use App\Livewire\Pages\Afms\StockTable;
use App\Livewire\Pages\Afms\SupplyTable;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('supply', SupplyTable::class)->middleware(['auth', 'verified'])->name('supply');
Route::get('stock', StockTable::class)->middleware(['auth', 'verified'])->name('stock');
Route::get('requisition', RequisitionTable::class)->middleware(['auth', 'verified'])->name('requisition');


Route::get('api_stocks', [RequisitionTable::class, 'supplies'])->middleware(['auth', 'verified'])->name('api.stocks.index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
