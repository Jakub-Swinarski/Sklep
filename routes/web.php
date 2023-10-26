<?php


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

Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post("/register", [\App\Http\Controllers\AuthController::class, 'register']);

    Route::middleware('auth')->group(function () {
        Route::post("/logout", [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::get('/user', [\App\Http\Controllers\AuthController::class, 'getUser']);
        Route::delete('/user', [\App\Http\Controllers\AuthController::class, 'delete']);
    });
});
Route::prefix('user')->group(function () {
    Route::post('/forgotPassword', [\App\Http\Controllers\UserController::class, 'emailPasswordReset'])
        ->name('password.email');
    Route::post('/resetPassword', [\App\Http\Controllers\UserController::class, 'resetPassword']);
    Route::get('/resetPassword/{token}', function (string $token) {
        $email = $_GET['email'];
        $email = base64_encode($email);
        return redirect()->to(url(env("FRONTEND_URL") . "/reset/password/$token/email/$email"));
    })->middleware('guest')->name('password.reset');
    Route::get('email/{uuid}', [\App\Http\Controllers\AuthController::class, 'acceptEmail'])->name('verification.verify');

    Route::middleware('auth')->group(function () {
        Route::put('/password', [\App\Http\Controllers\UserController::class, 'changePassword']);
        Route::put('/email', [\App\Http\Controllers\UserController::class, 'changeEmail']);
        Route::put('/username', [\App\Http\Controllers\UserController::class, 'changeUsername']);
    });
});
Route::middleware('auth')->group(function () {
    Route::prefix('address')->group(function () {
        Route::post('/', [\App\Http\Controllers\AddressController::class, 'addAddress']);
        Route::post('/', [\App\Http\Controllers\AddressController::class, 'editAddress']);
        Route::delete('/', [\App\Http\Controllers\AddressController::class, 'deleteAddress']);
        Route::get('/', [\App\Http\Controllers\AddressController::class, 'getUserAddress']);
    });
    Route::prefix('category')->group(function () {
        Route::post('/', [\App\Http\Controllers\CategoryController::class, 'newCategory']);
        Route::put('/', [\App\Http\Controllers\CategoryController::class, 'editCategory']);
        Route::delete('/', [\App\Http\Controllers\CategoryController::class, 'deleteCategory']);
        Route::get('/all', [\App\Http\Controllers\CategoryController::class, 'getAllCategories']);
        Route::get('/product', [\App\Http\Controllers\CategoryController::class, 'getProductCategory']);
    });
    Route::prefix('product')->group(function () {
        Route::get('/', [\App\Http\Controllers\ProductController::class, 'getProduct']);
        Route::post('/', [\App\Http\Controllers\ProductController::class, 'newProduct']);
        Route::put('/supply', [\App\Http\Controllers\ProductController::class, 'changeSupply']);
        Route::put('/name', [\App\Http\Controllers\ProductController::class, 'changeName']);
        Route::put('/description', [\App\Http\Controllers\ProductController::class, 'changeDescription']);
        Route::put('/price', [\App\Http\Controllers\ProductController::class, 'changePrice']);
        Route::delete('/', [\App\Http\Controllers\ProductController::class, 'deleteProduct']);
    });
    Route::prefix('rating')->group(function () {
        Route::post('/', [\App\Http\Controllers\RatingsController::class, 'newRating']);
        Route::put('/', [\App\Http\Controllers\RatingsController::class, 'editRating']);
        Route::get('/all',[\App\Http\Controllers\RatingsController::class, 'getRating']);
        Route::get('/product',[\App\Http\Controllers\RatingsController::class, 'getProductRatings']);
        Route::get('/user',[\App\Http\Controllers\RatingsController::class, 'getUserRatings']);
        Route::delete('/',[\App\Http\Controllers\RatingsController::class, 'deleteRating']);
    });
    Route::prefix('order')->group(function (){
        Route::post('/',[\App\Http\Controllers\OrderController::class, 'newOrder']);
        Route::get('/all',[\App\Http\Controllers\OrderController::class,'getOrder']);
        Route::get('/user',[\App\Http\Controllers\OrderController::class,'getUserOrders']);
        Route::put('/',[\App\Http\Controllers\OrderController::class,'editOrder']);
        Route::delete('',[\App\Http\Controllers\OrderController::class,'deleteOrder']);
    });
});
