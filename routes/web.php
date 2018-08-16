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
if (strpos(url()->full(), '://cole.') !== false) {

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
				'Unsplash' => app('App\Http\Controllers\Cole\ColeController')->UnsplashWallpaper()
			);
			$View = 'Cole.MainUI';
		}else{
			$Cole = (object)array(
				'Settings' => app('App\Http\Controllers\Cole\ColeController')->Settings(),
				'PageReference' => 'Login',
				'Unsplash' => app('App\Http\Controllers\Cole\ColeController')->UnsplashWallpaper()
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
			'PageReference' => 'install',
			'Unsplash' => app('App\Http\Controllers\Cole\ColeController')->UnsplashWallpaper()
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
			'PageReference' => 'error500',
			'Unsplash' => app('App\Http\Controllers\Cole\ColeController')->UnsplashWallpaper()
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

}else{

	try {
		$Pages = \DB::table("ColeMod_Pages")
		->get();
	}
	catch (\Exception $e) {
		if($_ENV['APP_NAME']!='Laravel'){
			abort(401,'Cole was unable to load the pages database table. Please check that you have configured your .env file correctly.');
		}else{
			$Pages = array();
		}
	}

	if(count($Pages)==0){
		if($_ENV['APP_NAME']!='Laravel'){
			abort(401,'You do not have any pages in your Pages database table. You need at least one to start your Cole website');
		}
	}

	foreach($Pages as $Page){

		Route::any($Page->Url, function () {

			$Url = Route::getFacadeRoot()->current()->uri();

			if(empty($Url)){
				$Url = '/';
			}

			$PageToploader = \DB::table('ColeMod_Pages')
			->where('Url',$Url)
			->first();
			$Template = $PageToploader->Template;
			$AccountLocked = $PageToploader->AccountLocked;

			if(isset($_GET['ColeEdit'])){
				// Check for secret match
				$AffectorLookup = \DB::table('Users')
				->where('id',$_GET['Affector'])
				->where('Secret',$_GET['ColeEdit'])
				->get();

				if(count($AffectorLookup)!=0){
					$EditMode = true;
				}else{
					$EditMode = false;
				}
			}else{
				$EditMode = false;
			}
			$Cole = app('App\Http\Controllers\Cole\ColeTools')->PageConstructor($Url,$EditMode);
			if(isset($_GET['ColeJSON'])){
				return response()->json($Cole);
			}else{
				return View::make('Site.'.$Template)->with('Cole',$Cole);
			}
		});

	}

	// Errors
	\View::composer('errors::404', function($view)
	{
		// Ensure the Cole Object comes in even in 404 instances
		$Cole = app('App\Http\Controllers\Cole\ColeTools')->PageConstructor('404');
		$view->with('Cole', $Cole);
	});
	\View::composer('errors::503', function($view)
	{
		// Ensure the Cole Object comes in even in 404 instances
		$Cole = app('App\Http\Controllers\Cole\ColeTools')->PageConstructor('404');
		$view->with('Cole', $Cole);
	});


	// Images subsystem
	Route::get('/Cole/Pages/Images/{Tag}/{Width?}/{Height?}', ['uses' =>'Cole\ColeController@ColeImage']);
	Route::get('/Cole/Pages/ImgBrowse/{Path?}', ['uses' =>'Cole\ColeController@ColeImageBrowse']);
	Route::post('/Cole/Pages/ImgSave', ['uses' =>'Cole\ColeController@ColeImageSave']);
	Route::post('/Cole/Pages/ImgFolderMake', ['uses' =>'Cole\ColeController@ColeImageFolderMake']);
	Route::post('/Cole/Pages/ImgUpload', ['uses' =>'Cole\ColeController@ColeImageUpload']);
	Route::get('/Cole/Pages/ImgPickerThumbnail', ['uses' =>'Cole\ColeController@ColeImagePickerThumbnail']);
	Route::post('/Cole/Pages/ImgMoveFile', ['uses' =>'Cole\ColeController@ColeImagePickerMoveFile']);

	// Panels subsystem
	Route::any('/Cole/Panels/Load', ['uses' =>'Cole\ColeController@LoadPanel']);

	// ColeTools Update
	Route::get('/Cole/Update/Query', ['uses' =>'Cole\ColeController@UpdateQuery']);
	Route::get('/Cole/Update/Run', ['uses' =>'Cole\ColeController@ProcessUpdate']); // construct module

	// ** CUSTOM ROUTES FOR THIS SITE **
	if(file_exists('cole.php')){
		include('cole.php');
	}

}