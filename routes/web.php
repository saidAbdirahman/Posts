<?php

use Illuminate\Support\Facades\Route;
use Illuminate\http\Request;
use App\http\Controllers\PostController;
use App\http\Controllers\RegisterUserController;
use App\http\Controllers\LoginUserController;
use App\http\Controllers\AdminController;
use App\http\Controllers\AdminPostController;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::view('/','welcome');
// Route::get('/posts', [PostController::class,'index']);
// Route::post('/posts/create', [PostController::class,'create']);
// Route::post('/posts', [PostController::class,'store']);
// Route::get('/posts/{id}',[PostController::class, 'show']);
// Route::put('/posts/{id}/edit',[PostController::class, 'edit']);
// Route::put('/posts/{id}',[PostController::class, 'update']);
// Route::delete('/posts/{id}', [PostController::class,'destroy']);

Route::prefix('posts')->group(function() {

    Route::middleware('auth')->group(function (){

        Route::get('/create', [PostController::class,'create'])->name('posts.create');
         Route::post('/', [PostController::class,'store'])->name('posts.store');
         Route::get('/{post}/edit',[PostController::class, 'edit'])->can('update','post')->name('posts.edit');
          Route::put('/{post}',[PostController::class, 'update'])->name('posts.update');
         Route::delete('/{post}', [PostController::class,'destroy'])->name('posts.destroy');
         Route::post('/logout',[LoginUserController::class,'logout'])->name('logout');


        });
        
        Route::get('/', [PostController::class,'index'])->name('posts.index');
        Route::get('/{post}', [PostController::class,'show'])->name('posts.show');


});

Route::middleware('auth')->group(function (){

Route::middleware('is-admin')->group(function () {

    Route::get('/admin',[AdminController::class, 'index'])->name('admin');
    Route::get('admin/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    Route::delete('admin/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
});

});
// Route::resource('/posts',PostController::class)->middleware('auth');

Route::middleware('guest')->group(function (){

    Route::get('/register',[RegisterUserController::class,'register'])->name('register');
    Route::post('/register',[RegisterUserController::class,'store'])->name('register.store');
    Route::get('/login',[LoginUserController::class,'login'])->name('login');
    Route::post('/login',[LoginUserController::class,'store'])->name('login.store');
    });
;
