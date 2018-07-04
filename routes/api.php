<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/folders', 'API\FolderController@index');
    Route::post('/folders', 'API\FolderController@store');

    Route::get('/emails/folder/inbox', 'API\InboundEmailsController@index');
    Route::get('/emails/folder/sent', 'API\OutboundEmailsController@index');
    Route::get('/emails/folder/trash', 'API\TrashController@index');
    Route::get('/emails/folder/{folder_name}', 'API\FolderController@show');

    Route::post('/emails/{inboundEmail}/read', 'API\InboundEmailsController@update');
    Route::post('/emails/{inboundEmail}', 'API\InboundEmailsController@update');
    Route::delete('/emails/{inboundEmail}/delete', 'API\InboundEmailsController@destroy');

    Route::get('/emails/folder/update/inbox', 'API\Update\InboundEmailsController@index');
    Route::get('/emails/folder/update/sent', 'API\Update\OutboundEmailsController@index');
    Route::get('/emails/folder/update/trash', 'API\Update\TrashController@index');
    Route::get('/emails/folder/update/{folder_name}', 'API\Update\FolderController@show');

    Route::get('/outbound-emails', 'API\OutboundEmailsController@index');
    Route::post('/outbound-emails', 'API\OutboundEmailsController@store');
    Route::post('/outbound-emails/{outbound_email}', 'API\OutboundEmailsController@show');
    Route::delete('/outbound-emails/{outbound_email}/delete', 'API\OutboundEmailsController@destroy');
});
