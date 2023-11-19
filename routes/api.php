<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\Auth\AuthAdminController;
use App\Http\Controllers\API\Admin\AdminsController;
use App\Http\Controllers\API\Admin\PaymentsController;
use App\Http\Controllers\API\Admin\TransactionsController;
use App\Http\Controllers\API\Customer\Auth\AuthCustomerController;
use App\Http\Controllers\API\Customer\Auth\ForgetPasswordController;
use App\Http\Controllers\API\Customer\Auth\ResetPasswordController;
use App\Http\Controllers\API\Customer\CustomerTransactionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('customer')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthCustomerController::class, 'login']);
        Route::post('register', [AuthCustomerController::class, 'register']);
        Route::get('logout', [AuthCustomerController::class, 'logOut'])->middleware('auth:customer');

        Route::post('send-reset-code', [ForgetPasswordController::class, 'sendResetCode']);
        Route::post('reset-password', [ResetPasswordController::class, 'setNewPassword']);
    });
    Route::get('/transactions', [CustomerTransactionsController::class, 'index'])->middleware('auth:customer');

});


Route::prefix('admin')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthAdminController::class, 'login']);
        Route::get('logout', [AuthAdminController::class, 'logOut'])->middleware('auth:admin');
    });

    Route::prefix('admins')->middleware('auth:admin')->group(function () {
        Route::get('/', [AdminsController::class, 'index'])->middleware('permission:view admins');
        Route::get('/{admin_id}', [AdminsController::class, 'show'])->middleware('permission:view admins');
        Route::post('/', [AdminsController::class, 'store'])->middleware('permission:create admins');
        Route::post('/{admin_id}/update', [AdminsController::class, 'update'])->middleware('permission:edit admins');
        Route::get('/{admin_id}/delete', [AdminsController::class, 'destroy'])->middleware('permission:delete admins');
    });


    Route::prefix('transactions')->middleware('auth:admin')->group(function () {
        Route::get('/', [TransactionsController::class, 'index'])->middleware('permission:view transactions');
        Route::get('/users-list', [TransactionsController::class, 'usersList'])->middleware('permission:view transactions');
        Route::get('/{transaction_id}', [TransactionsController::class, 'show'])->middleware('permission:view transactions');
        Route::post('/', [TransactionsController::class, 'store'])->middleware('permission:create admins');
        Route::post('/{transaction_id}/update', [TransactionsController::class, 'update'])->middleware('permission:edit transactions');
        Route::get('/{transaction_id}/delete', [TransactionsController::class, 'destroy'])->middleware('permission:delete transactions');

        Route::get('/monthly/report', [TransactionsController::class, 'report'])->middleware('permission:view transactions');
    });


    Route::prefix('payments')->middleware('auth:admin')->group(function () {
        Route::get('/transaction/{transaction_id}', [PaymentsController::class, 'index'])->middleware('permission:view payments');
        Route::get('/{payment_id}', [PaymentsController::class, 'show'])->middleware('permission:view payments');
        Route::post('/', [PaymentsController::class, 'store'])->middleware('permission:create admins');
        Route::post('/{payment_id}/update', [PaymentsController::class, 'update'])->middleware('permission:edit payments');
        Route::get('/{payment_id}/delete', [PaymentsController::class, 'destroy'])->middleware('permission:delete payments');
    });

});
