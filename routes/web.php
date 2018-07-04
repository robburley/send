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

Route::middleware(['guest'])->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('login.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::redirect('/', '/emails', 301);
    Route::get('/emails', 'Emails\InboxController@index');
    Route::get('/emails/sent', 'Emails\SentController@index');
    Route::get('/emails/trash', 'Emails\TrashController@index');
    Route::get('/emails/{folder}', 'Emails\FolderController@index');
});

Route::any('/catch-emails', 'Emails\CatchInboundEmailController@store');

Route::get('/create-me', function () {
    \App\Models\User::create([
        'name'     => 'Rob',
        'email'    => 'rob@robburley.co.uk',
        'username' => 'rob',
        'password' => 'Burley',
    ]);
});
