<?php

/*
	* routes/web.php
	*
	* The URL Structure for Cole
	*
	* @author     Peter Day <peterday.main@gmail.com>
	* @copyright  2018-2019 Cole CMS.
*/

// Main User Interface
Route::get('/', function () {

	app('App\Http\Controllers\Cole\ColeController')->InstallCheck(); // Check Cole is installed
	app('App\Http\Controllers\Cole\ColeController')->UpdateCheck(); // Check Cole needs to update
		
	$ColeUser = (object)app('App\Http\Controllers\Cole\ColeController')->AccountDetails();
	
	if(isset($ColeUser->id)){
		$Cole = (object)array(
			'Modules' => app('App\Http\Controllers\Cole\ColeController')->GetModules(),
			'User' => $ColeUser,
			'Settings' => app('App\Http\Controllers\Cole\ColeController')->Settings(),
			'PageReference' => 'MainUI',
			'Notifications' => app('App\Http\Controllers\Cole\ColeController')->Notifications(),
			'NotificationsList' => app('App\Http\Controllers\Cole\ColeController')->NotificationsList(),
			
		);
		$View = 'Cole.MainUI';
	}else{
		$Cole = (object)array(
			'Settings' => app('App\Http\Controllers\Cole\ColeController')->Settings(),
			'PageReference' => 'Login'
		);
		$View = 'Cole.Login';		
	}
	
    return View::make($View)->with('Cole', $Cole);
});

// Basic pages
Route::get('/what-is-cole', function () {
	app('App\Http\Controllers\Cole\ColeController')->InstallCheck(); // Check Cole is installed
	app('App\Http\Controllers\Cole\ColeController')->UpdateCheck(); // Check Cole needs to update
		
    $Cole = (object)array(
	    'PageReference' => 'what-is-cole'
    );
    return View::make('Cole.AboutCole')->with('Cole', $Cole);
});
Route::get('/credits', function () {
	app('App\Http\Controllers\Cole\ColeController')->InstallCheck(); // Check Cole is installed	
    $Cole = (object)array(
	    'PageReference' => 'credits'
    );
    return View::make('Cole.Credits')->with('Cole', $Cole);
});
Route::get('/install', function () {	
	app('App\Http\Controllers\Cole\ColeController')->InstallCheck(true); // Check Cole is installed	
    $Cole = (object)array(
	    'PageReference' => 'install'
    );
    return View::make('Cole.Install')->with('Cole', $Cole);
});
Route::get('/update', function () {	
	app('App\Http\Controllers\Cole\ColeController')->UpdateCheck(true); // Check Cole needs to update	
    $Cole = (object)array(
	    'PageReference' => 'update'
    );
    return View::make('Cole.Update')->with('Cole', $Cole);
});

// Constructors
Route::get('/Module/{ModuleCodename}', ['uses' =>'Cole\ColeController@ConstructModule']); // construct module
Route::post('/Construct/EditPane/{Special?}', ['uses' =>'Cole\ColeController@ConstructEditPane']); // construct edit pane
Route::get('/Error/{ErrorCode}', ['uses' =>'Cole\ColeController@ConstructError']); // construct error message
Route::get('/Cole/Logo', ['uses' =>'Cole\ColeController@ColeBranding']); // construct error message
\View::composer('Cole::errors::500', function($view){
    $Cole = (object)array(
	    'PageReference' => 'error500'
    );
    $view->with('Cole', $Cole);
});

// DataActions
Route::any('/DataAction/{ModuleCodename}/{DataAction}/{ObjectID?}', ['uses' =>'Cole\ColeController@ConstructDataAction']);

// Accounts
Route::post('/ColeAccounts/Login', ['uses' =>'Cole\ColeController@AccountLogin']);
Route::get('/ColeAccounts/Logout', ['uses' =>'Cole\ColeController@AccountLogout']);
Route::get('/ColeAccounts/AccountProfilePicture', ['uses' =>'Cole\ColeController@AccountProfilePicture']);
Route::post('/ColeAccounts/SetProfilePicture', ['uses' =>'Cole\ColeController@SetProfilePicture']);

// Me
Route::get('/Cole/Me/Banner', ['uses' =>'Cole\ColeController@MeBanner']);
Route::post('/Cole/Permissions/Save', ['uses' =>'Cole\ColeController@SavePermissions']);

// Update
Route::get('/Cole/Update/Query', ['uses' =>'Cole\ColeController@UpdateQuery']); // construct module
Route::get('/Cole/Update/Run', ['uses' =>'Cole\ColeController@ProcessUpdate']); // construct module
Route::get('/Cole/GitHub', ['uses' =>'Cole\ColeController@GitHubTest']); // construct module


// Settings
Route::post('/Cole/Settings/Publish', ['uses' =>'Cole\ColeController@PublishSettings']);

// Images
Route::post('/Cole/ImageToolkit/GetMeta', ['uses' =>'Cole\Cole\Modules\ImagesController@GetMeta']);
Route::post('/Cole/ImageToolkit/SaveMeta', ['uses' =>'Cole\Cole\Modules\ImagesController@SaveMeta']);
Route::post('/Cole/ImageToolkit/GetTweaks', ['uses' =>'Cole\Cole\Modules\ImagesController@GetTweaks']);
Route::post('/Cole/ImageToolkit/SaveTweaks', ['uses' =>'Cole\Cole\Modules\ImagesController@SaveTweaks']);
Route::post('/Cole/ImageToolkit/ResetImage', ['uses' =>'Cole\Cole\Modules\ImagesController@ResetImage']);


// Install
Route::post('/Cole/Install', ['uses' =>'Cole\ColeController@InstallCole']);
Route::get('/Cole/Install/Reset', ['uses' =>'Cole\ColeController@ResetCole']);
