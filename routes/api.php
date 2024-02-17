<?php

use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsrfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SearchController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('sanctum/csrf-cookie', function (Request $request) {
//     return response()->json(['message' => 'CSRF cookie set']);
// });

// Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);



Route::post('/registration', [UserController::class, 'registration']);
Route::post('/signin', [UserController::class, 'signin']);

Route::post('/forgetpassword', [UserController::class, 'forgetpassword']);
Route::post('/resetpassword', [UserController::class, 'resetpassword']);

Route::get('/', [ProductController::class, 'showproduct']);

Route::post('/contactus', [ContactUsController::class, 'contactus']);

Route::get('/getcategories', [CategoryController::class, 'showcategory']);

Route::get('/products/{id}/viewproduct', [ProductController::class, 'eachproduct']);

Route::get('/categories/{categorySearchTerm}', [CategoryController::class, 'searchcategory']);
Route::get('/search/', [SearchController::class, 'searchProducts']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/favourite', [FavoriteController::class, 'addToFavourite']);
    Route::get('/getfavourite', [FavoriteController::class, 'getfavourite']);
    // Route::get('/getuserfavourite', [FavoriteController::class, 'getuserfavourite']);
    Route::post('/removefromfavourite', [FavoriteController::class, 'removefromfavourite']);
    Route::post('/removeallfromfavourite', [FavoriteController::class, 'removeallfromfavourite']);
    Route::post('/signout', [UserController::class, 'signout']);
    Route::get('/loggedinuser', [UserController::class, 'loggedinuser']);

    Route::post('/order', [OrderController::class, 'orderStore']);
    Route::get('/getuserorder', [OrderController::class, 'getuserorder']);

    Route::get('/order/receipt/{transactionId}/view', [ReceiptController::class, 'viewReceipt']);
    Route::get('/order/receipt/{transactionId}/download', [ReceiptController::class, 'downloadReceipt']);

    Route::get('/userinfo', [UserController::class, 'userinfo']);
    Route::post('/userinfoupdate', [UserController::class, 'userinfoUpdate']);



    // Route::get('/products/{id}/viewproduct', [ProductController::class, 'eachproduct']);
});



// Route::middleware('auth:sanctum')->post('/favourite', [UserController::class, 'addToFavourite']);
// Route::middleware('auth:sanctum')->post('/signout', [UserController::class, 'signout']);
// Route::middleware('auth:sanctum')->get('/loggedinuser', [UserController::class, 'loggedinuser']);





// Route::post('/product/{id}', [ProductController::class, 'addtocart']);
// Route::middleware('auth:sanctum')->post('/updatecart', [ProductController::class, 'updateCart']);

// Route::middleware('auth:sanctum')->post('/addproduct', [AdminController::class, 'addproduct']);



// Route::group(['middleware'=>['auth:sanctum']], function () {
//     Route::get('/user/{id}', [UserController::class, 'userinfo']);

// });
// Route::get('/user/{id}', [UserController::class, 'userinfo'])->middleware('auth:sanctum');
// Route::middleware('auth:sanctum')->get('/user/{id}', [UserController::class, 'userinfo']);



// Admin Controller
