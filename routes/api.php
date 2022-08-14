<?php

use App\Http\Controllers\Api\{HomeController,UserController,AuthController};
use App\Http\Controllers\Auth\{ForgotPasswordController,ResetPasswordController};
// use App\Http\Middleware\Cors;
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

Route::middleware(['cors'])->group(function () {


    //Open routes
    Route::get('home', [HomeController::class,'home']);
    Route::get('about', [HomeController::class,'about']);
    Route::get('services', [HomeController::class,'services']);
    Route::get('contact', [HomeController::class,'contact']);
    Route::get('app-data', [HomeController::class,'index']);
    Route::get('blogs', [HomeController::class,'blogs'])->middleware('throttle:300,1');;
    Route::get('categories', [HomeController::class,'getCategories']);
    Route::get('recentpost', [HomeController::class,'recentPost']);
    Route::get('blog/{slug?}', [HomeController::class,'blogDetail']);
    Route::post('newsletter', [HomeController::class,'newsletter']);
    Route::post('contact-us', [HomeController::class,'contactUs']);
    Route::get('resume-data', [HomeController::class,'resumeData']);
    Route::get('testimonial', [HomeController::class,'testimonial']);
    Route::get('projects', [HomeController::class,'projects']);
    Route::get('portfolio/{slug?}', [HomeController::class,'portfolioDetail']);
    Route::get('download-cv', [HomeController::class,'downloadCv']);

    //Auth routes
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('verify/{id}', [AuthController::class, 'verifyAccount']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmailApi']);
    Route::post('reset-password', [ResetPasswordController::class, 'apiResetPassword']);

    //Authorized routes
    Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
        Route::get('get-profile', [UserController::class, 'getProfile']);
        Route::post('update-profile', [UserController::class, 'updateProfile']);
        Route::post('change-password', [UserController::class, 'changePassword']);
        Route::post('post-comment', [UserController::class, 'postComment']);
        Route::post('post-like', [UserController::class, 'postLike']);
        Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    });



});