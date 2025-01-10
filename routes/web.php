<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WantedController;
use App\Http\Controllers\WikiController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\GyrosController;
use App\Http\Controllers\SoloController;

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

// Localization
/* Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale'); */

Route::resource('/admin', AdminController::class);

Route::resource('/', IndexController::class);
Route::get('/search', [IndexController::class, 'search'])->name('search');

Route::prefix('collections')->group(function () {
    Route::resource('/games', GameController::class);
    Route::get('/games/{id}/delete-photo', [GameController::class, 'deletePhoto'])->name('game-delete-photo');
    Route::get('/games/{id}/count-like', [GameController::class, 'countLike'])->name('game-count-like');

    Route::resource('/series', SeriesController::class);
    Route::get('/series/{id}/delete-photo', [SeriesController::class, 'deletePhoto'])->name('series-delete-photo');
});

Route::prefix('sales')->group(function () {
    Route::resource('/games', SaleController::class);
    Route::get('/games/sold/{id}', [SaleController::class, 'sold'])->name('sales-sold');

    Route::resource('/consoles', ConsoleController::class);
    Route::get('/consoles/sold/{id}', [ConsoleController::class, 'sold'])->name('consoles-sold');

    Route::resource('/accessories', AccessoryController::class);
    Route::get('/accessories/sold/{id}', [AccessoryController::class, 'sold'])->name('accessories-sold');

    Route::resource('/packs', PackController::class);
    Route::get('/packs/sold/{id}', [PackController::class, 'sold'])->name('packs-sold');
});

Route::resource('/wanteds', WantedController::class);
Route::get('/wanteds/found/{id}', [WantedController::class, 'found'])->name('wanteds-found');

Route::resource('/help', HelpController::class);
Route::post('/help/{id}/post-answer', [HelpController::class, 'postAnswer'])->name('help-post-answer');

Route::resource('/users', UserController::class);
Route::get('/user/{id}/delete-photo', [UserController::class, 'deletePhoto'])->name('user-delete-photo');

Route::prefix('wiki')->group(function () {
    Route::resource('/platforms', PlatformController::class);
    Route::get('/platform/{id}/delete-photo', [PlatformController::class, 'deletePhoto'])->name('platform-delete-photo');

    Route::get('/general', [WikiController::class, 'index'])->name('general-wiki');
    Route::get('/general/read/{id}', [WikiController::class, 'setRead'])->name('general-wiki-read');
});

Route::resource('/messages', MessageController::class);
Route::get('/messages/buy/{type}/{id}', [MessageController::class, 'buy'])->name('message-buy');
Route::get('/messages/offer/{id}', [MessageController::class, 'offer'])->name('message-offer');
Route::post('/messages/storeajax', [MessageController::class, 'storeAjax'])->name('message-storeajax');
Route::get('/messages/sync/{id}', [MessageController::class, 'sync'])->name('message-sync');

//Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
//Route::post('/send-contact-email', [IndexController::class, 'sendContactEmail'])->name('send-contact-email');

Route::get('/op-birthdays', [IndexController::class, 'birthdays'])->name('op-birthdays');

Route::get('/gyros', [GyrosController::class, 'index'])->name('gyros-counter');
Route::get('/gyros-increment', [GyrosController::class, 'increment'])->name('gyros-increment');

require __DIR__.'/auth.php';
