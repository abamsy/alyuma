<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Allocations;
use App\Http\Livewire\BAllocations;
use App\Http\Livewire\LAllocations;
use App\Http\Livewire\AWaybills;
use App\Http\Livewire\Plants;
use App\Http\Livewire\Points;
use App\Http\Livewire\Users;
use App\Http\Livewire\Products;
use App\Http\Livewire\Waybills;
use App\Models\Waybill;
use App\Models\Allocation;


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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


/*Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'can:manage-users'], function () {
        Route::get('/users', Users::class)->name('users');
    });

    Route::get('/parties', Parties::class)->name('parties');
    Route::get('/transactions/{party}', Transactions::class)->name('transactions');
});
*/



Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'can:manage-users'], function () {
        Route::get('/users', Users::class)->name('users');
        Route::get('/plants', Plants::class)->name('plants');
        Route::get('/points', Points::class)->name('points');
        Route::get('/products', Products::class)->name('products');
    });
    
    Route::get('/ballocations/{plant}', BAllocations::class)->name('ballocations');
    Route::get('/lallocations/{point}', LAllocations::class)->name('lallocations');
    Route::get('/awaybills/{allocation}', AWaybills::class)->name('awaybills');
    

    Route::get('/waybill/{id}', function ($id) {
        $waybill = Waybill::find($id);
        $pdf = PDF::loadView('waybill', ['waybill' => $waybill]);
        return $pdf->stream('waybill.pdf');
    })->name('waybill');

    Route::get('/allocation/{id}', function ($id) {
        $allocation = Allocation::find($id);
        $sum = $allocation->waybills()->sum('dquantity');
        $balance =  $allocation->quantity - $sum;
        $waybills = $allocation->waybills()->get();
        $pdf = PDF::loadView('allocation', ['allocation' => $allocation, 'waybills' => $waybills, 'sum' => $sum, 'balance' => $balance]);
        return $pdf->stream('allocation.pdf');
    })->name('allocation');
});

Route::get('/set-password/{user}', [App\Http\Controllers\SetPasswordController::class, 'create'])->name('setpassword.create');
Route::post('/set-password', [App\Http\Controllers\SetPasswordController::class, 'store'])->name('setpassword.store');
