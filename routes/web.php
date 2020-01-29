<?php

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

Route::get('/threads', function () {
    return \App\Thread::latest()->pluck('title');
});

Route::post('/threads', function () {
    $thread = \App\Thread::forceCreate(request(['title']));
    event(new \App\Events\ThreadCreated($thread));
});
