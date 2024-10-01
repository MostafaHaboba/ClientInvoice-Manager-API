<?php
namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// api/v1
// Route::group(['prefix'=>'v1'], function(){
//     Route::apiResource('customers',CustomerController::class);
//     Route::apiResource('invoices',InvoiceController::class);
//     Route::post('invoices/bulk',[InvoiceController::class,'bulkStore']);
// });

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
});
