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

	app('App\Http\Controllers\ColeController')->InstallCheck(); // Check Cole is installed
	app('App\Http\Controllers\ColeController')->UpdateCheck(); // Check Cole needs to update
		
	$ColeUser = (object)app('App\Http\Controllers\ColeController')->AccountDetails();
	
	if(isset($ColeUser->id)){
		$Cole = (object)array(
			'Modules' => app('App\Http\Controllers\ColeController')->GetModules(),
			'User' => $ColeUser,
			'Settings' => app('App\Http\Controllers\ColeController')->Settings(),
			'PageReference' => 'MainUI',
			'Notifications' => app('App\Http\Controllers\ColeController')->Notifications(),
			'NotificationsList' => app('App\Http\Controllers\ColeController')->NotificationsList(),
			
		);
		$View = 'MainUI';
	}else{
		$Cole = (object)array(
			'Settings' => app('App\Http\Controllers\ColeController')->Settings(),
			'PageReference' => 'Login'
		);
		$View = 'Login';		
	}
	
    return View::make($View)->with('Cole', $Cole);
});

// Basic pages
Route::get('/what-is-cole', function () {
	app('App\Http\Controllers\ColeController')->InstallCheck(); // Check Cole is installed
	app('App\Http\Controllers\ColeController')->UpdateCheck(); // Check Cole needs to update
		
    $Cole = (object)array(
	    'PageReference' => 'what-is-cole'
    );
    return View::make('AboutCole')->with('Cole', $Cole);
});
Route::get('/credits', function () {
	app('App\Http\Controllers\ColeController')->InstallCheck(); // Check Cole is installed	
    $Cole = (object)array(
	    'PageReference' => 'credits'
    );
    return View::make('Credits')->with('Cole', $Cole);
});
Route::get('/install', function () {	
	app('App\Http\Controllers\ColeController')->InstallCheck(true); // Check Cole is installed	
    $Cole = (object)array(
	    'PageReference' => 'install'
    );
    return View::make('Install')->with('Cole', $Cole);
});
Route::get('/update', function () {	
	app('App\Http\Controllers\ColeController')->UpdateCheck(true); // Check Cole needs to update	
    $Cole = (object)array(
	    'PageReference' => 'update'
    );
    return View::make('Update')->with('Cole', $Cole);
});

// Constructors
Route::get('/Module/{ModuleCodename}', ['uses' =>'ColeController@ConstructModule']); // construct module
Route::post('/Construct/EditPane/{Special?}', ['uses' =>'ColeController@ConstructEditPane']); // construct edit pane
Route::get('/Error/{ErrorCode}', ['uses' =>'ColeController@ConstructError']); // construct error message
Route::get('/Cole/Logo', ['uses' =>'ColeController@ColeBranding']); // construct error message
\View::composer('errors::500', function($view){
    $Cole = (object)array(
	    'PageReference' => 'error500'
    );
    $view->with('Cole', $Cole);
});

// DataActions
Route::any('/DataAction/{ModuleCodename}/{DataAction}/{ObjectID?}', ['uses' =>'ColeController@ConstructDataAction']);

// Accounts
Route::post('/ColeAccounts/Login', ['uses' =>'ColeController@AccountLogin']);
Route::get('/ColeAccounts/Logout', ['uses' =>'ColeController@AccountLogout']);
Route::get('/ColeAccounts/AccountProfilePicture', ['uses' =>'ColeController@AccountProfilePicture']);
Route::post('/ColeAccounts/SetProfilePicture', ['uses' =>'ColeController@SetProfilePicture']);

// Me
Route::get('/Cole/Me/Banner', ['uses' =>'ColeController@MeBanner']);
Route::post('/Cole/Permissions/Save', ['uses' =>'ColeController@SavePermissions']);

// Update
Route::get('/Cole/Update/Query', ['uses' =>'ColeController@UpdateQuery']); // construct module
Route::get('/Cole/Update/Run', ['uses' =>'ColeController@ProcessUpdate']); // construct module
Route::get('/Cole/GitHub', ['uses' =>'ColeController@GitHubTest']); // construct module


// Settings
Route::post('/Cole/Settings/Publish', ['uses' =>'ColeController@PublishSettings']);

// Images
Route::post('/Cole/ImageToolkit/GetMeta', ['uses' =>'ColeControllers\ImagesController@GetMeta']);
Route::post('/Cole/ImageToolkit/SaveMeta', ['uses' =>'ColeControllers\ImagesController@SaveMeta']);
Route::post('/Cole/ImageToolkit/GetTweaks', ['uses' =>'ColeControllers\ImagesController@GetTweaks']);
Route::post('/Cole/ImageToolkit/SaveTweaks', ['uses' =>'ColeControllers\ImagesController@SaveTweaks']);
Route::post('/Cole/ImageToolkit/ResetImage', ['uses' =>'ColeControllers\ImagesController@ResetImage']);


// Install
Route::post('/Cole/Install', ['uses' =>'ColeController@InstallCole']);
Route::get('/Cole/Install/Reset', ['uses' =>'ColeController@ResetCole']);
