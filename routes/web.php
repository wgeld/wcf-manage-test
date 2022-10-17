php <?php

use App\Http\Controllers\AMSSoapController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/account', 'account.show')->name('account');

    Route::view('/account/lookup', 'account.lookup')->name('account.lookup');
    Route::view('/account/terminations', 'account.terminations')->name('account.terminations');

    Route::view('/account/connections', 'account.connections')->name('account.connections');

    Route::view('/apc/configured-services', 'apc.configured-services')->name('apc.configured-services');

    Route::get('apc/suspend/{id}', [AMSSoapController::class, 'suspendByEquipmentID'])->name('apc.suspend');
    Route::get('apc/resume/{id}', [AMSSoapController::class, 'resumeByEquipmentID'])->name('apc.resume');

});



