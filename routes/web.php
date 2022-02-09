<?php

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\WebsiteController;
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

/**
 * PUBLIC ROUTES
 */
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('/send-notification', [NotificationController::class, 'sendNotification'])->name('send.notification');
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('model/{slug}', [WebsiteController::class, 'articleDetails'])->name('productDetails');
Route::get('/category/{slug}', [WebsiteController::class, 'categoryDetails'])->name('category');
Route::get('/search', [WebsiteController::class, 'searchArticle'])->name('search');
Route::get('/shop', [WebsiteController::class, 'shop'])->name('shop');
Route::get('/columnist', [WebsiteController::class, 'getColumnistPage'])->name('columnist');
Route::get('tag/{slug}', [WebsiteController::class, 'tagDetails'])->name('tag');
Route::post('/addToCart', [WebsiteController::class, 'addToCart'])->name('addToCart');
Route::get('/cartItems', [WebsiteController::class, 'showCart'])->name('cartItems');
Route::get('/deleteCart', [WebsiteController::class, 'deleteCart'])->name('removeCart');

Route::get('/about', function () {
    return view('pages.about.index');
});

//Route::get('/cartItems', function () {
//    return view('pages.cart.index');
//})->name('cartItems');

Route::get('/contact', function () {
    return view('pages.contact.index');
});


/**
 * ADMIN ROUTES
 */
Route::get('/dashboard/{any}', [ApplicationController::class, 'index'])->where('any', '(.*)');

Route::get('/{slug}/{nextSlug}', function ($slug, $nextSlug) {
    if ($nextSlug == "amp" || $nextSlug == "feed") {
        return redirect()->route('article-details', ['slug' => $slug]);
    }
    abort(404);
    return false;
});
