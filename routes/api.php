<?php

use Illuminate\Http\Request;

Route::post('/pages/save', ['uses' =>'Cole\ColeController@SavePage']);


// Widgets

// Payload
Route::get('/payload/catchup', ['uses' =>'Cole\ColeController@PayloadCatchup']);

Route::get('/server/check', ['uses' =>'Cole\ColeController@ServerCheck']);

Route::post('/cer/report', ['uses' =>'Cole\ColeController@CustomerExceptionReport']);

Route::post('/me/profilepicture/upload', ['uses' =>'Cole\ColeControllers\MeController@ProfilePictureUpload']);

Route::get('/notifications/read/{Module?}', ['uses' =>'Cole\ColeController@ReadNotifications']);
Route::post('/notifications/send/{Module}/{User?}', ['uses' =>'Cole\ColeController@DeliverNotification']);

Route::get('/pages/bit/get/{PageID}', ['uses' =>'Cole\Core\BackInTimeController@BackInTimeGet']);
Route::get('/pages/bit/backup/get/{BackupID}', ['uses' =>'Cole\Core\BackInTimeController@BackInTimeBackupGet']);

Route::post('/pages/panels/delete', ['uses' =>'Cole\Core\PanelsController@PanelsDelete']);
Route::get('/pages/panels/list', ['uses' =>'Cole\Core\PanelsController@PanelsList']);
Route::get('/pages/panels/uid/get', ['uses' =>'Cole\Core\PanelsController@PanelNewUidGet']);


Route::get('/pages/bit/backup/{PageID}', ['uses' =>'Cole\Core\BackInTimeController@BackInTimeBackup']);
Route::get('/pages/bit/restore/{BackupID}', ['uses' =>'Cole\Core\BackInTimeController@BackInTimeRestore']);

Route::get('/install/db/vet', ['uses' =>'Cole\Core\DatabaseController@DbVet']);
Route::post('/install/db/set', ['uses' =>'Cole\Core\DatabaseController@DbSet']);
Route::post('/install/db/make', ['uses' =>'Cole\Core\DatabaseController@DbMake']);
Route::post('/install/db/wipe', ['uses' =>'Cole\Core\DatabaseController@DbWipe']);