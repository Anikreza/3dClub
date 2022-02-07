<?php

use App\Http\Controllers\Api\App\AppController;
use App\Http\Controllers\Api\App\ArticleController as AppArticleController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1/',
    'namespace' => 'Api'
], function () {
    Route::post('/send-mail', [WebsiteController::class, 'sendMail'])->name('send.mail');
});

Route::group([
    'prefix' => 'v1/auth',
    'namespace' => 'Api'
], function () {
    Route::post("/login", [AuthController::class, 'login']);
    Route::post("/forgot-password", [AuthController::class, 'forgotPassword']);
    Route::post("/token-verification", [AuthController::class, 'tokenVerification']);
    Route::post("/reset-password", [AuthController::class, 'resetPassword']);
});

Route::group([
    'middleware' => ['auth:sanctum'],
    "prefix" => "v1",
], function () {
    Route::post("/auth/logout", [AuthController::class, "logout"]);
    Route::post("/auth/save-profile", [ProfileController::class, "update"]);
    Route::post("/email-update", [ProfileController::class, "emailUpdate"]);
    Route::post("/update-password", [ProfileController::class, "passwordUpdate"]);

    Route::post("categories/priority-update", [CategoryController::class, 'priorityUpdate']);
    Route::apiResource("categories", CategoryController::class);

    Route::get("articles/{slug}/edit", [ArticleController::class, 'edit']);
    Route::post("articles/{id}", [ArticleController::class, 'update']);
    Route::apiResource("articles", ArticleController::class);

    Route::get("fetch-all-published-pages", [PageController::class, 'get']);
    Route::get("pages/{slug}/edit", [PageController::class, 'edit']);
    Route::post("pages/{id}", [PageController::class, 'update']);
    Route::apiResource("pages", PageController::class);

    Route::get("settings", [SettingsController::class, 'get']);
    Route::post("settings", [SettingsController::class, 'set']);

    Route::post("save-page-ids", [PageController::class, 'savePageIds']);
});
