<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'BooksController@index')->name('books');
Route::get('/books', function () {
    return redirect()->route('books');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/books/{book}', 'BooksController@show');
Route::get('/authors/{author}', 'AuthorController@show');
Route::get('/history', 'HomeController@history');

Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/checkout/{book}/{user}', 'BooksController@checkout');
    Route::post('/checkout', 'BooksController@checkout');
    Route::get('/checkin/{book}/{user}', 'BooksController@checkin');
    Route::post('/authors', 'AuthorController@store');
    Route::post('/books', 'BooksController@store');
    Route::patch('/books/{book}', 'BooksController@update');
    Route::delete('/books/{book}', 'BooksController@destroy');
});