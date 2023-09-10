<?php

use App\Http\Controllers\CustomerpdfController;
use App\Http\Controllers\Login;
use App\Http\Controllers\PaymentpdfController;
use App\Models\CustomPackage;
use App\Models\GeneralPackage;
use App\Models\Packages;
use App\Models\payment;
use App\Models\Places;
use App\Models\Posts;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
        return redirect('/admin');
});

Route::get('/{record}/view',[CustomerpdfController::class,'view'])->name('CustomPackage.pdf.view');
Route::get('/{record}/pdf',[CustomerpdfController::class,'pdf'])->name('CustomPackage.pdf.download');

Route::get('/{record}/voucher',[PaymentpdfController::class,'view'])->name('voucher.pdf.voucher');
Route::get('/{record}/download',[PaymentpdfController::class,'pdf'])->name('voucher.pdf.download');


