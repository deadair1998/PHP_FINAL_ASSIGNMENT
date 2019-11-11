<?php
use App\Event;
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
Route::resource('feeds', 'FeedsController');
Route::post('handle-feed', 'FeedsController@handleFeed');

Route::get('/', 'FeedsController@index');
// Route::get('/test', function() {
//     return view('welcome');
// });
// Route::get('/events/{event}', 'EventsController@show')->name('events.show');
// Route::feeds();
