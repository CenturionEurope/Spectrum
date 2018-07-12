<?php

use Illuminate\Http\Request;

Route::post('/pages/save', ['uses' =>'ColeController@SavePage']);


// Widgets

// Payload
Route::get('/payload/catchup', ['uses' =>'ColeController@PayloadCatchup']);

Route::get('/server/check', ['uses' =>'ColeController@ServerCheck']);

Route::post('/cer/report', ['uses' =>'ColeController@CustomerExceptionReport']);

Route::post('/me/profilepicture/upload', ['uses' =>'ColeControllers\MeController@ProfilePictureUpload']);

Route::get('/notifications/read/{Module?}', ['uses' =>'ColeController@ReadNotifications']);
Route::post('/notifications/send/{Module}/{User?}', ['uses' =>'ColeController@DeliverNotification']);

Route::get('/pages/bit/get/{PageID}', ['uses' =>'ColeCore\BackInTimeController@BackInTimeGet']);
Route::get('/pages/bit/backup/get/{BackupID}', ['uses' =>'ColeCore\BackInTimeController@BackInTimeBackupGet']);

Route::post('/pages/panels/delete', ['uses' =>'ColeCore\PanelsController@PanelsDelete']);
Route::get('/pages/panels/list', ['uses' =>'ColeCore\PanelsController@PanelsList']);
Route::get('/pages/panels/uid/get', ['uses' =>'ColeCore\PanelsController@PanelNewUidGet']);


Route::get('/pages/bit/backup/{PageID}', ['uses' =>'ColeCore\BackInTimeController@BackInTimeBackup']);
Route::get('/pages/bit/restore/{BackupID}', ['uses' =>'ColeCore\BackInTimeController@BackInTimeRestore']);

Route::get('/install/db/vet', ['uses' =>'ColeCore\DatabaseController@DbVet']);
Route::post('/install/db/set', ['uses' =>'ColeCore\DatabaseController@DbSet']);
Route::post('/install/db/make', ['uses' =>'ColeCore\DatabaseController@DbMake']);
Route::post('/install/db/wipe', ['uses' =>'ColeCore\DatabaseController@DbWipe']);