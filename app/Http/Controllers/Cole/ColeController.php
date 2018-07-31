<?php

namespace App\Http\Controllers\Cole;
use App\Http\Controllers\Controller;
use Image;
use Illuminate\Database\Schema\Blueprint;
use Spatie\Analytics\Period;
use Analytics;
use PragmaRX\Google2FA\Google2FA;
use DB;
use Illuminate\Support\Facades\Cache;


class ColeController extends Controller
{
	/*
		* ColeController
		*
		* The core functionality of the Cole Core System
		*
		* @author     Peter Day <peterday.main@gmail.com>
		* @copyright  2018-2019 Cole CMS.
	*/
   
    public function GetModules(){
	    // GetModules
	    // Load all available modules into the sidebar and hide any without nessecary permissions
	    
	    $Modules = DB::table('Modules')
		->where('Codename','!=','today')		
		->get();
		$Modules = collect($Modules)->map(function($x){ return (object)(array) $x; })->toArray(); 
		$Permissions = $this->GetPermissions();

		foreach($Modules as $Module){
			$Module->DoNotLoad = true;
		}
		
		foreach($Permissions as $PermissionName => $Permission){
			if(in_array('get', (array)$Permission)){
				foreach($Modules as $Module){
					if($Module->Codename==$PermissionName){
						$Module->DoNotLoad = false;
					}
				}
			}
		}
		
		return (object)$Modules;
    }
    
    public function GetPermissions($LookupUser = null){
		// GetPermissions
	    // Gets the Permissions for the active user of Cole
	    
	    if(isset($LookupUser)){
	    	$ColeUser = $LookupUser;
	    }else{
		    $ColeUser = (object)$this->AccountDetails();		    
	    }
		
		try {
			$Permissions = DB::table('Permissions')
			->where('User',$ColeUser->id)
			->get();
	
		}
		catch (\Exception $e) {
			$Permissions = array();
		}

		
		$PermissionOutput = array();
		
		foreach($Permissions as $Permission){
			
			$PermissionOutput[$Permission->Module] = array();
			
			if($Permission->Get==1){
				$PermissionOutput[$Permission->Module][] = 'get';
			}
			if($Permission->Create==1){
				$PermissionOutput[$Permission->Module][] = 'create';
			}
			if($Permission->Save==1){
				$PermissionOutput[$Permission->Module][] = 'save';
			}
			if($Permission->Delete==1){
				$PermissionOutput[$Permission->Module][] = 'delete';
			}
			
			$PermissionOutput[$Permission->Module] = (object)$PermissionOutput[$Permission->Module];
			
		}
		
		return (object)$PermissionOutput;
		 
    }
    
    public function GetPermissionsModule($LookupUser){
	   	// GetPermissionsModule
	    // Loads all modules and gets permissions if they exist for the user in question
	    
	    $ColeUser = $LookupUser;

	    $Modules = DB::table('Modules')
		->get();
				
		$PermissionOutput = array();
		
		foreach($Modules as $Module){
		    $Permissions = DB::table('Permissions')
		    ->where('User',$ColeUser->id)
		    ->where('Module',$Module->Codename)
			->get();

			$PermissionOutput[$Module->Codename] = array();
			$PermissionSet = false;
			
			$PermissionOutput[$Module->Codename]['ModuleInfo'] = $Module;
			
			if(count($Permissions)!=0){				
				$Permission = $Permissions[0];				
				if($Permission->Get==1){
					$PermissionOutput[$Module->Codename]['Permissions'][] = 'get';
					$PermissionSet = true;
				}
				if($Permission->Create==1){
					$PermissionOutput[$Module->Codename]['Permissions'][] = 'create';
					$PermissionSet = true;
				}
				if($Permission->Save==1){
					$PermissionOutput[$Module->Codename]['Permissions'][] = 'save';
					$PermissionSet = true;					
				}
				if($Permission->Delete==1){
					$PermissionOutput[$Module->Codename]['Permissions'][] = 'delete';
					$PermissionSet = true;					
				}
			}
			
			if(!$PermissionSet){
				$PermissionOutput[$Module->Codename]['Permissions'][] = 'base';
			}
			$PermissionOutput[$Module->Codename] = (object)$PermissionOutput[$Module->Codename];
			
		}

		return (object)$PermissionOutput;
    }
    
    public function SavePermissions(){
	    
	    $isAllowed = $this->isAllowed('me','save');
	    
	    if(isset($_POST['User'])){
		    
		    // Searching for an account
			$ColeUser = DB::table('Users')
			->where('id',$_POST['User'])
			->first();

	    }else{
	    
			$ColeUser = (object)$this->AccountDetails();
		
		}
	
		if($isAllowed){
			
			// Allowed to update permissions
			
			// Search for permissions record for this user and create if not exist
			$PermissionsCheck = DB::table('Permissions')
			->where('Module',$_POST['Module'])
			->where('User',$ColeUser->id)			
			->get();
			if(count($PermissionsCheck)==0){
				// Create this first
				DB::table('Permissions')
				->where('Module',$_POST['Module'])
				->where('User',$ColeUser->id)
				->insert([
					'Module' => $_POST['Module'],
					'User' => $ColeUser->id,
					'Get' => 0,
					'Create' => 0,
					'Save' => 0,
					'Delete' => 0									
				]);  
			}
			
			if(isset($_POST['get'])){
				DB::table('Permissions')
				->where('Module',$_POST['Module'])
				->where('User',$ColeUser->id)
				->update([
					'Get' => $_POST['get']				
				]);  
			}
			if(isset($_POST['create'])){
				DB::table('Permissions')
				->where('Module',$_POST['Module'])
				->where('User',$ColeUser->id)
				->update([
					'Create' => $_POST['create']				
				]);  
			}
			if(isset($_POST['save'])){
				DB::table('Permissions')
				->where('Module',$_POST['Module'])
				->where('User',$ColeUser->id)
				->update([
					'Save' => $_POST['save']				
				]);  							
			}
			if(isset($_POST['delete'])){
				DB::table('Permissions')
				->where('Module',$_POST['Module'])
				->where('User',$ColeUser->id)
				->update([
					'Delete' => $_POST['delete']				
				]);  
			}
			
			$Cole = array(
				'Outcome' => 'Success'
			);			
			
		}else{
			$Cole = array(
				'Outcome' => 'Failure',
				'Reason' => 'Sorry, You lack the relevant permissions to do that.'
			);			
		}
		
		return $Cole;

    }
    
    public function isAllowed($Codename,$DataAction){
	    // isAllowed
	    // Tests if the DataAction is allowed to be preformed
	    // Will return true or false
	    
	    $Permissions = $this->GetPermissions(); // load permissions lib	    
	    $ModulePermissionset = (array)$Permissions->$Codename;		
		return in_array($DataAction, $ModulePermissionset);				
    }
    
    public function ConstructModule($ModuleCodename){
	    // ConstructModule
	    // Builds the module with its DataObject and return HTML
	    $ModuleData = DB::table('Modules')
	    ->where('Codename',$ModuleCodename)
		->first();
	
		$ColeUser = (object)$this->AccountDetails();
		
		if(!empty($ModuleData)){
			if (!\Schema::hasTable($ModuleData->Database)) {		    
			    if(method_exists($ModuleData->Controller, 'ColeDatabaseBoot')){
					app($ModuleData->Controller)->ColeDatabaseBoot(); // Init the db
				}
			}
		}
		
		
	 	$Cole = (object)array(
			'Modules' => $this->GetModules(),
			'Permissions' => $this->GetPermissions(),
			'Module' => (object)array(
				'ModuleData' => $ModuleData,
				'ModuleContent' => $this->ColeGet($ModuleData->Controller,$ModuleData->Database),
				'ModuleTableViewMapper' => $this->TableViewMapper($ModuleData->Database)
			),
			'User' => $ColeUser,
			'Settings' => $this->Settings(),
			'Notifications' => $this->Notifications()
		);
		
		// Build and init widgets
		if($ModuleCodename=="today"){
			$Widgets = DB::table('Widgets')
			->get();
			
			foreach($Widgets as $Widget){
				$Controller = $Widget->Controller;
				$Function = $Widget->Function;
				
				if(method_exists($Controller, $Function)){
					$Widget->Content = app($Controller)->$Function(); // Init the widget
				}
			}
			
			$Cole->Module->Widgets = $Widgets;
		}
		
		if($ModuleData->Custom==1){
			if(view()->exists('Cole.Modules.Custom.'.$ModuleData->Template)){
				return \View::make('Cole.Modules.Custom.'.$ModuleData->Template)->with('Cole', $Cole);
			}else{
				return \View::make('Cole.Modules.Base.TableView')->with('Cole', $Cole);
			}
		}else{
			if(view()->exists('Cole.Modules.'.$ModuleData->Template)){
				return \View::make('Cole.Modules.'.$ModuleData->Template)->with('Cole', $Cole);
			}else{
				return \View::make('Cole.Modules.Base.TableView')->with('Cole', $Cole);
			}
		}
    }
    
    public function ConstructEditPane($Special = null){

	    $ModuleData = DB::table('Modules')
	    ->where('Codename',$_POST['Data']['ModuleCodename'])
		->first();

	    if(isset($Special)){
			$_POST['SpecialMode'] = true;
		}

		if(!isset($ModuleData->EditView)){
			$View = 'Cole/Prebuilt/EditPane';
		}else{
			$View = $ModuleData->EditView;
		}

	
	    $_POST['ModuleData'] = $ModuleData;
	    return \View::make($View)->with('Cole', $_POST);
	    
    }
    
    public function ConstructError($ErrorCode){
	    // ConstructError
	    // Outputs why the system crashed
		
		return \View::make('errors.'.$ErrorCode);

    }

    public function ConstructDataAction($ModuleCodename,$DataAction,$ObjectID = null){
		// ConstructDataAction
		// Pipe into the relative controller and preform action after testing if allowed to do so

		$ModuleData = DB::table('Modules')
		->where('Codename',$ModuleCodename)
		->first();

		$isAllowed = $this->isAllowed($ModuleData->Codename,$DataAction);

		if($isAllowed){
			$Cole = array(
				'Outcome' => 'Success'
			);

			if($DataAction=='get'){
				$Cole['DataActionResult'] = $this->ColeGet($ModuleData->Controller,$ModuleData->Database,$ObjectID);
			}else if($DataAction=='create'){	
				$Cole['DataActionResult'] = $this->ColeCreate($ModuleData->Controller,$ModuleData->Database);
			}else if($DataAction=='save'){
				$Cole['DataActionResult'] = $this->ColeSave($ModuleData->Controller,$ModuleData->Database,$ObjectID);
			}else if($DataAction=='delete'){
				$Cole['DataActionResult'] = $this->ColeDelete($ModuleData->Controller,$ModuleData->Database,$ObjectID);
			}

			$Cole['DataActionResult']->ModuleCodename = $ModuleCodename;

		}else{
			$Cole = array(
				'Outcome' => 'Failure',
				'Reason' => 'Sorry, You lack the relevant permissions to do that.'
			);			
		}
		return $Cole;
    }
   
    public function TableViewMapper($Database){
		$TableViewMapper = DB::table('TableViewMapper')
		->where('Table',$Database)
		->get();
		$TableViewMapper = collect($TableViewMapper)->map(function($x){ return (object)(array) $x; })->toArray(); 
		return (object)$TableViewMapper;
    }

    public function Settings(){
		$Settings = DB::table('Settings')
		->get();
		
		
		$Output = array();
		foreach($Settings as $Setting){
			$Output[$Setting->settingCodeName] = $Setting->settingValue;
		}
		
		return (object)$Output;
    }
    
    public function AccountDetails($LookupUser = null){
			
			if(!isset($LookupUser)){			
			    // Active User
			    if(isset($_COOKIE['ColeUser'])){

					// Lookup token in db
					$ColeUser = DB::table('Users')
					->where('Token',$_COOKIE['ColeUser'])
					->first();
					
					unset($ColeUser->Password);
					
					return $ColeUser;
					
				}else{
					return array();
				}
			}else{
				// Get accountdetails from provided user
				$AccountData = DB::table('Users')
				->where('id',$LookupUser)
				->first();
				return $AccountData;
			}
    }
    
    public function AccountLogin(){
	    
	    $_POST['Password'] = md5($_POST['Password'].'ColePasswordSalt');
	    
		$AuthenticationObject = DB::table('Users')
		->where('Email',$_POST['Email'])
		->where('Password',$_POST['Password'])		
		->get();
		
		if(count($AuthenticationObject)!=0){
			// Login details match
			
			// Deploy new token
			$Token = $this->TokenGenerate();
			
			// Quickly update Authentication Object to have new secret and token
			DB::table('Users')
			->where('Email',$_POST['Email'])
			->where('Password',$_POST['Password'])
			->update([
				'Secret' => rand(),
				'Token' => $Token
			]);  
			
		    $expire=time()+(86400); // 1 day
			$path = "/";
			
			setcookie("ColeUser", $Token, $expire, $path); 	
			
			// Generate a 2FASK if NULL
			$this->Generate2FASK($AuthenticationObject[0]->id);

			$Response = array(
				'Outcome' => 'Success'
			);
			
		}else{
			// Password not correct
			
			$Response = array(
				'Outcome' => 'Failure',
				'Reason' => 'Sorry, your login details are incorrect. Please check and try again.'
			);
			
		}
		
		return $Response;
    
    }
    
    public function AccountLogout(){
		$path = "/";
		$past = time() - 3600;
		setcookie("ColeUser", "", $past, '/');
		return array('Outcome' => 'Success');
    }
    
    public function AccountCreate(){
	    // Salt is ColePasswordSalt
    }
	
	public function AccountProfilePicture($ReturnURL = null){
		// AcountProfilePicture()
		// Loads a profile picture based on provided AccountID or grab the logged in user's.
		// If AccountID GET is not supplied the system will load local user's.		
		if(isset($_GET['AccountID'])){
			$User = (object)$this->AccountDetails($_GET['AccountID']);
		}else{
			$User = (object)$this->AccountDetails();		
		}
		if(isset($User->ProfilePicture)){
			// Internal profile picture
			$ImageURL = $User->ProfilePicture;
		}elseif($User->FacebookID!=0){
			// Facebook Profile Picture
			$ImageURL = 'https://graph.facebook.com/'.$User->FacebookID.'/picture?width=1000&height=1000';
		}else{
			// No profile picture found, output default
			$ImageURL = 'Cole/UI/images/UserDefault.jpg';
		}
			
		if(!isset($ReturnURL)){
		
			$img = Image::make($ImageURL)->resize(500, 500);
			return $img->response('jpg');
		
		}else{
						
			return $ImageURL;
		
		}		
	}
	
	public function SetProfilePicture(){
		$User = (object)$this->AccountDetails();
		
		DB::table('Users')
		->where('id',$User->id)
		->update([
			'ProfilePicture' => $_POST['ProfilePicture']
		]);
		
		return array(
			'Outcome' => 'Success'
		);
	}
	
	public function MeBanner(){
		// 2560 x 500
		$Me = $this->AccountDetails();
		$ImageURL = $this->AccountProfilePicture(true);
		
		if(!is_dir('Storage')){
			mkdir('Storage');
		}
		if(!is_dir('Cole/Storage/ProfilePictures')){
			mkdir('Cole/Storage/ProfilePictures');
		}
		
	
		$img = Image::make($ImageURL);
	    $img = $img->resize(500, null, function ($constraint) {
	    	$constraint->aspectRatio();
		});
	    $img = $img->resizeCanvas(500, 98);
	    $img = $img->blur(50);
	    $img = $img->brightness(-10);
	    
		$img->save('Cole/Storage/ProfilePictures/'.$Me->id.'_Banner.jpg');
		
		return $img->response('jpg');
		
	}

	public function Ago($datetime, $full = false,$future = null) {
	    $now = new \DateTime;
	    $ago = new \DateTime($datetime);
	    $diff = $now->diff($ago);
	
	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;
	
	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }
	
	    if (!$full) $string = array_slice($string, 0, 1);
	    if($future){
		    return $string ? implode(', ', $string) . '' : 'a short while';
	    }else{
	    	return $string ? implode(', ', $string) . ' ago' : 'just now';
	    }
	}

	public function ActivityLog(){
		$ActivityLog = DB::table('ActivityLog')
		->orderby('id','DESC')
		->take(5)
		->get();
		
		foreach($ActivityLog as $LogItem){
			$UserData = DB::table('Users')
			->where('id',$LogItem->AccountID)
			->get();
			
			if($UserData){
				$UserData = $UserData[0];
				$UserData->Password = ''; // Clear password for safety
				$LogItem->AccountData = $UserData;
			}else{
				$LogItem->AccountData = (object)array();
			}
			
		}
		
		$API = (object)array(
			'Outcome' => 'Success',
			'ActivityLog' => $ActivityLog
		);
		
		return $API;
	}
	
	public function SubmitActivityLog($Database,$DataAction){
		$ColeUser = (object)$this->AccountDetails();
		
		// Look up the module name and if it is available convert database to module name
		$ModuleConversion = DB::table('Modules')
		->where('Database',$Database)
		->first();
		if($ModuleConversion){
			$ModuleConversion = $ModuleConversion->ModuleName;
		}else{
			$ModuleConversion = $Database;
		}
		
		
		DB::table('ActivityLog')
		->insert([
			'AccountID' => $ColeUser->id,
			'ModuleUpdated' => $ModuleConversion,
			'DataAction' => $DataAction,
			'Time' => time()
		]);
	}
	
	public function ArrayConversion($Database,$Controller,$id){
		// Seems to be deprecated along with moving to EditPane (01/01/17)
		
		// Convert any items that have been defined as an array into an array
		// $Data is an object of the data that came back
		$Data = DB::table($Database)
		->where('id',$id)
		->get();
		
		foreach($Data as $Item){
			// Now load a check for this table
	    	$DataCheck = DB::table('TableViewMapper')
			->where('Table',$Database)
			->where('isArray',1)
			->get();
			if($DataCheck){
				$DataCheck = $DataCheck[0];
				$ColName = $DataCheck->ColName;
				$Function = $DataCheck->ArrayDecoderPlugin;
				$Array = $Item->$ColName;
				$Item->$ColName = (object)app($Controller)->$Function($Array);
			}
			
		}				

		return $Data;
	}
	
	// ColeGet($Database) - Loads the data from the provided Database table
	// ColeCreate($Database) - Creates the data into the provided Database table
	// ColeSave($Database,id) - Saves changes to the data into the provided Database table
	// ColeDelete($Database,id) - Deletes the data from the provided Database table
	    
    public function ColeGet($Controller,$Database,$id = null){
	    
	    if(isset($id)){
		    
		    if($id=="ColumnValues"){
				// Load col values
				$ModuleContent = \Schema::getColumnListing($Database);
			}else{
		    	$ModuleContent = DB::table($Database)
				->where('id',$id)
				->first();
			
			}
			
		}else{
			if(isset($Database)){
				$ModuleContent = DB::table($Database)
				->get();
				$ModuleContent = collect($ModuleContent)->map(function($x){ return (object)(array) $x; })->toArray(); 
			}else{
				$ModuleContent = array();
			}
		}
				
		$DataObject = (object)array(
			'Content' => (object)$ModuleContent,
		);
		
		// Initialize plugin if it exists
		if(method_exists($Controller, 'ColeGetPlugin')){
			$DataObject->Plugin = (object)app($Controller)->ColeGetPlugin($ModuleContent);
		}
		
		// Initialize TVM if loading specific post
		if(isset($id)){
			$DataObject->TableViewMapper = $this->TableViewMapper($Database);
		}
		
		return $DataObject;
    }

	public function ColeCreate($Controller,$Database){
	    
	    if(!isset($Database)){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'No Database table provided'	
			);
	    }else if(!isset($_POST)){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'No POST Data provided'	
			);
	    }else{

			// First process any content that needs to be encrypted
			foreach($_POST as $Key => $Value){
			    $FieldData = DB::table('TableViewMapper')
			    ->where('Table',$Database)
			    ->where('ColName',$Key)
				->take(1)
				->get();
				$FieldData = collect($FieldData)->map(function($x){ return (object)(array) $x; })->toArray(); 
				
				if($FieldData){
					$FieldData = $FieldData[0];
					
					if($FieldData->SaltedMD5==1){
						$_POST[$Key] = md5($_POST['Password'].'ColePasswordSalt');
					}
					
					if($FieldData->B64==1){
						$_POST[$Key] = base64_encode($Value);
					}
					
					
				}
			}

	    	DB::table($Database)
			->insert($_POST);    
	    	
	    	// Get the data we have created
		    $ModuleContent = DB::table($Database)
			->orderby('id','DESC')
			->take(1)
			->get();
	    	
	    	
			$Outcome = (object)array(
				'Outcome' => 'Success'	
			);
			
			// Initalize plugins if exists because we did action OK
			if(method_exists($Controller, 'ColeCreatePlugin')){
				$Outcome->Plugin = (object)app($Controller)->ColeCreatePlugin($ModuleContent);
			}			
		
			// Record the data action to the activitylog
			$this->SubmitActivityLog($Database,'created');

			
				    	
		}

		return (object)$Outcome;
    }

	public function ColeSave($Controller,$Database,$id){
	    
	    if(!isset($Database)){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'No Database table provided'	
			);
	    }else if(!isset($_POST)){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'No POST Data provided'	
			);
	    }else if(!isset($id)){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'No Item ID provided'	
			);
	    }else{
			
			// Get the data before it changes
		    $ModuleContentPre = DB::table($Database)
			->where('id',$id)
			->get();

		    // First process any content that needs to be encrypted
			foreach($_POST as $Key => $Value){
			    $FieldData = DB::table('TableViewMapper')
			    ->where('Table',$Database)
			    ->where('ColName',$Key)
				->take(1)
				->get();
				$FieldData = collect($FieldData)->map(function($x){ return (object)(array) $x; })->toArray(); 
				
				if($FieldData){
					$FieldData = $FieldData[0];
					
					if($FieldData->SaltedMD5==1){
						if(empty($_POST[$Key])){
							unset($_POST[$Key]); // remove the password if not set
						}else{
							$_POST[$Key] = md5($_POST['Password'].'ColePasswordSalt');
						}
					}
					
					if($FieldData->B64==1){
						$_POST[$Key] = base64_encode($Value);
					}
					
					
				}
			}
			

	    	DB::table($Database)
			->where('id',$id)
			->update($_POST);
			
			// Get the data we have saved
		    $ModuleContentPost = DB::table($Database)
			->where('id',$id)
			->get();
			
			
	    	
			$Outcome = (object)array(
				'Outcome' => 'Success'	
			);	    	
			
			// Initalize plugins if exists because we did action OK
			if(method_exists($Controller, 'ColeSavePlugin')){
				$Outcome->Plugin = (object)app($Controller)->ColeSavePlugin($ModuleContentPost,$ModuleContentPre);
			}	
			
			// Record the data action to the activitylog
			$this->SubmitActivityLog($Database,'saved');			
			
			
		}

		return (object)$Outcome;
    }

	public function ColeDelete($Controller,$Database,$id){
	    
    	$ColeUser = (object)$this->AccountDetails();

	    
	    if(!isset($Database)){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'No Database table provided'	
			);
	    }else if(!isset($id)){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'No Object ID provided'	
			);
		}else if($Database=="Users" && $id==$ColeUser->id){
			$Outcome = (object)array(
				'Outcome' => 'Failure',
				'Reason' => 'You cannot delete your own User Account.'	
			);
		}else{
		    
		    // Get the data we are deleting first
		    $ModuleContent = DB::table($Database)
			->where('id',$id)
			->get();
		    
	    	DB::table($Database)->where('id', $id)->delete();
			
			// Write to ColeBin
			DB::table('Bin')->insert([
				[
					'Database' => $Database,
					'Object' => json_encode($ModuleContent),
					'DateTime' => date('Y-m-d H:i:s')
				]
			]);
			
			$Outcome = (object)array(
				'Outcome' => 'Success'	
			);
			
			// Initalize plugins if exists because we did action OK
			if(method_exists($Controller, 'ColeDeletePlugin')){
				$Outcome->Plugin = (object)app($Controller)->ColeDeletePlugin($ModuleContent);
			}	
			
			// Record the data action to the activitylog
			$this->SubmitActivityLog($Database,'deleted');
			
			   	
		}

		return (object)$Outcome;
    }

	public function PublishSettings(){
		// Write settings to the database
		
		if($this->isAllowed('settings','save')){
		
			if(!isset($_POST)){
				$Outcome = array(
					'Outcome' => 'Failure',
					'Reason' => 'No POST Data provided'	
				);
		    }else{
			    
			    foreach($_POST as $Key => $Setting){
				    
				    // Write setting
				    DB::table('Settings')
		            ->where('settingCodeName', $Key)
		            ->update([
		            	'settingValue' => $Setting
		            ]);			    
				    
			    }
	
				$Outcome = array(
					'Outcome' => 'Success'	
				);
			    
		    }
	    
	    }else{
		    
		    $Outcome = array(
		    	'Outcome' => 'Failure',
				'Reason' => 'Sorry, you lack the relevant permissions to do that.'	
			);
		    
	    }
	    return $Outcome;
	}
	
	public function InstallCheck($InstallPage = null){
		// Checks that Cole has been configured to read from Database
		// If not navigate forcibly to /install

		if(isset($InstallPage)){
			if($_ENV['APP_NAME']=="Cole"){
				// Trying to access the install page when product
				// is already installed
				header('Location: /');
				die();
			}			
		}else{
			if($_ENV['APP_NAME']=="Laravel"){
				// App name not set, navigate
				header('Location: /install');
				die();
			}
		}
	}
	
	public function UpdateCheck($UpdatePage = null){
		// Checks to see if Cole has got to fast forward the payload
		// if so, redirect to /update
		
		$CurrentPayload = $_ENV['COLE_PAYLOAD'];
		$ProjectPayload = $CurrentPayload + 1;		
		if(isset($UpdatePage)){
			if(!file_exists('Cole/Payload/'.$ProjectPayload.'.payload')){
				header('Location: /');
				die();
			}			
		}else{			
			if(file_exists('Cole/Payload/'.$ProjectPayload.'.payload')){
				// App name not set, navigate
				header('Location: /update');
				die();
			}	
		}		
	}
	
	public function InstallCole(){
		
		if($_ENV['APP_NAME']!="Cole"){
		
			$env = file_get_contents('../.env');
			file_put_contents('../.env_backup',$env); // backup env
			
			$env = str_replace('APP_NAME=Laravel', 'APP_NAME=Cole', $env);	
			$env = $env.PHP_EOL."COLE_PAYLOAD=0";
						
			file_put_contents('../.env',$env);
			
			// Test our ENV
			$api = array(
				'Outcome' => 'MidInstall'	
			);

							
			return $api;
			
		}else{
			// ENV File configured. Now import to the newly configured database
			app('App\Http\Controllers\Cole\Core\DatabaseController')->DatabaseInitialise();
			
			// Database configured. Now setup a user
			DB::table('Users')
			->insert([
				'FacebookID' => 0,
				'FullName' => $_POST['FullName'],
				'Email' => $_POST['Email'],
				'Password' => md5($_POST['Password'].'ColePasswordSalt'),
				'Secret' => 0
			]);  
			
			// Now configure Permissions
			$NewUser = DB::table('Users')		
			->get()[0];			
			
			$Modules = DB::table('Modules')
			->where('Codename','!=','today')	
			->get();
			
			foreach($Modules as $Module){
				DB::table('Permissions')
				->insert([
					'User' => $NewUser->id,
					'Module' =>$Module->Codename,
					'Get' => 1,
					'Create' => 1,
					'Save' => 1,
					'Delete' => 1
				]);  
			}
			
			if(file_exists('../.env.example.1')){
				try{
					unlink('../.env.example.1');
				}catch(Exception $e){
					// Unable to unlink extra env
				}
			}
					
			$api = array(
				'Outcome' => 'Success'	
			);
			
			return $api;
		
		}
		
	}
	
	public function ResetCole(){
		unlink('../.env'); // remove env		
		foreach(DB::select('SHOW TABLES') as $table) {
			$table_array = get_object_vars($table);
			\Schema::drop($table_array[key($table_array)]);
		}
	}
	
	
	
	public function ColeBranding(){
		if(file_exists('Cole/Images/Brand.png')){
			
			// Default to Cole Logo
			$img = Image::make('Cole/Images/Brand.png')->resize(null,358, function ($constraint) {
                $constraint->aspectRatio();
            });
		    $img = $img->resizeCanvas(1007, 358,'center');
		    
			// create a new Image instance for inserting
			$watermark = Image::make('Cole/Brand/coleTransparentWhitePb.png')->resize(360, 150);
			$img->insert($watermark, 'bottom-right', 10, 10);
			
			return $img->response('png');			

		}else{
			// Default to Cole Logo
			$img = Image::make('Cole/Brand/coleTransparentWhite.png');			
			return $img->response('png');			
		}
	}
	
	public function PayloadCatchup(){
		// Run SQL located in /public/Payload in order to
		// enable new features based on development
		ini_set('memory_limit', '-1');
		$CurrentPayload = $_ENV['COLE_PAYLOAD'];
		$ProjectPayload = $CurrentPayload + 1;
		
		$CatchupsToGo = array_values(array_diff(scandir('Cole/Payload/'), array('.', '..','.DS_Store')));
		natsort($CatchupsToGo);
		$CatchupsToGo = array_values($CatchupsToGo);
		$TopPayload = str_replace('.payload','',end($CatchupsToGo));
		foreach($CatchupsToGo as $Key => $Catchup){
			$CatchupNumber = str_replace('.payload','',$Catchup);
			if($CatchupNumber<=$CurrentPayload){
				unset($CatchupsToGo[$Key]);
			}
		}

		$CatchupsToGo = count($CatchupsToGo);

		if(file_exists('Cole/Payload/'.$ProjectPayload.'.payload')){
			DB::unprepared(file_get_contents('Cole/Payload/'.$ProjectPayload.'.payload'));
			// Update the Payload counter
			$env = file_get_contents('../.env');
			$env = str_replace('COLE_PAYLOAD='.$CurrentPayload, 'COLE_PAYLOAD='.$ProjectPayload, $env);
			file_put_contents('../.env',$env);
			// Update Payload
			try{
				DB::table('Settings')
				->where('settingCodeName','UpdatedAgo')
				->update([
					'settingValue' => time()
				]);
			}catch (\Exception $e) {
				// Catch failover
			}

			return array(
				'Outcome' => 'Success',
				'PayloadStatus' => 'Installed',
				'CatchupsToGo' => $CatchupsToGo,
				'CurrentPayload' => $CurrentPayload,
				'TopPayload' => $TopPayload,
			);
		}else{
			return array(
				'Outcome' => 'Success',
				'PayloadStatus' => 'UptoDate',
				'CatchupsToGo' => $CatchupsToGo,
				'CurrentPayload' => $CurrentPayload,
				'TopPayload' => $TopPayload			
			);			
		}
				
	}
	
	public function TokenGenerate(){
		// Generate a random token
		return md5(rand().time());
	}
	
	public function FormatSize($bytes){
        $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
                return( round( $bytes, 2 ) . " " . $types[$i] );
	}

	public function CustomerExceptionReport(){
		
		$Exception = $_POST['Exception'];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://hooks.slack.com/services/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");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\":\"$Exception\"}");
		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
		return response($result, 200)->header('Content-Type', 'application/json');
		
	}

	public function SavePage(){
		header('Access-Control-Allow-Origin: *');

		$Secret = $_POST['Secret'];
		$Fields = $_POST['Fields'];
		$Page = $_POST['Page'];

		// Authenticate Secret
		$TagTest = DB::table('Users')
		->where('Secret',$Secret)
		->get();

		if(count($TagTest)==0){
			return array(
				'Outcome' => 'Failure',
				'Reason' => 'There was an error authenticating the user secret.'
			);
		}

		// Cycle round fields and work out where they need to go
		foreach($Fields as $Key => $Value){

			$TagTest = DB::table('ColeMod_Pages_Fields')
			->where('Tag',$Key)
			->get();

			if(count($TagTest)!=0){

				// Tag exists SOMEWHERE
				$PageTest = DB::table('ColeMod_Pages_Fields')
				->where('Tag',$Key)
				->where('Url',$Page)
				->get();

				if(count($PageTest)!=0){
					// Tag and Page match so update
					DB::table('ColeMod_Pages_Fields')
					->where('Tag',$Key)
					->where('Url',$Page)
					->update([
						'Value' => $Value
					]);	
				}else{
					// Check for branding
					$BrandingTest = DB::table('ColeMod_Pages_Fields')
					->where('Tag',$Key)
					->where('Url','{ColeBranding}')
					->get();
					if(count($BrandingTest)!=0){
						// Tag and Branding match so update
						DB::table('ColeMod_Pages_Fields')
						->where('Tag',$Key)
						->where('Url','{ColeBranding}')
						->update([
							'Value' => $Value
						]);	
					}else{
						// Tag exists but Cannot page! Insert
						DB::table('ColeMod_Pages_Fields')
						->insert([
							'Tag' => $Key,
							'Value' => $Value,
							'Url' => $Page
						]);
					}
				}


			}else{
				// Tag doesn't even exist
				DB::table('ColeMod_Pages_Fields')
				->insert([
					'Tag' => $Key,
					'Value' => $Value,
					'Url' => $Page
				]);

			}
		}

		return array(
			'Outcome' => 'Success',
			'Fields' => $Fields,
			'Page' => $Page
		);

	}
	
	public function Generate2FASK($id){
		$ColeUser = (object)$this->AccountDetails($id);
		if(empty($ColeUser->Google2FASK)){
			$google2fa = new Google2FA();
			$Key = $google2fa->generateSecretKey();
			DB::table('Users')
			->where('id',$id)
			->update([
				'Google2FASK' => $Key
			]);
		}
	}

	public function ServerCheck(){
		// Server blacklisting
		if(file_get_contents("http://ipecho.net/plain")=='77.68.40.85'){
			return array(
				'Outcome' => 'Failure',
				'Reason' => 'It seems there is a problem with your license to use Cole. Please contact us at hello@poweredbycole.co.uk to continue.'
			);
		}
	}

	public function Notifications(){
		$ColeUser = (object)$this->AccountDetails();
		$Notifications = DB::table('Notifications')
		->where('Read',0)
		->where('User',$ColeUser->id)
		->orwhere('User',null)
		->orderby('Date','DESC')
		->get();

		$Build = (object)array();

		foreach($Notifications as $Notification){
			$Module = $Notification->Module;
			$Build->$Module->Details[] = (object)array(
				'Notification' => $Notification->Notification
			);
			$Build->$Module->Count = count($Build->$Module->Details);
		}

		return (object)array(
			'Count' => count($Notifications),
			'Notifications' => (object)$Build
		);

	}

	public function ReadNotifications($Module = null){
		$ColeUser = (object)$this->AccountDetails();
		
		if(isset($Module)){
			DB::table('Notifications')
			->where('User',$ColeUser->id)
			->where('Module',$Module)
			->update([
				'Read' => 1
			]);
			DB::table('Notifications')
			->where('User',null)
			->where('Module',$Module)
			->update([
				'Read' => 1
			]);			
		}else{
			DB::table('Notifications')
			->where('User',$ColeUser->id)
			->update([
				'Read' => 1
			]);
			DB::table('Notifications')
			->where('User',null)
			->update([
				'Read' => 1
			]);
		}
		
		return array(
			'Outcome' => 'Success',
			'Module' => $Module
		);
	}

	public function DeliverNotification($Module,$User = null){
		$Message = $_POST['Message'];

		if(!isset($User)){
			$User = (object)$this->AccountDetails()->id;
		}

		DB::table('Notifications')
		->insert([
			'User' => $User,
			'Module' => $Module,
			'Notification' => $Message,
			'Date' => date('Y-m-d H:i:s')
		]);

		return array(
			'Outcome' => 'Success'
		);
		
	}

	public function NotificationsList(){
		$ColeUser = (object)$this->AccountDetails();
		$Notifications = DB::table('Notifications')
		->where('User',$ColeUser->id)
		->where('Read',0)
		->orwhere('User',NULL)
		->orderby('id','DESC')
		->limit(10)
		->get();
		foreach($Notifications as $Notification){
			$Module = DB::table('Modules')
			->where('Codename',$Notification->Module)
			->select('ModuleName','Codename','Icon')
			->first();
			$Notification->Module = $Module;
			
			if(isset($Notification->Date)){
				$Notification->Date = $this->Ago($Notification->Date);
			}
		
		}

		return $Notifications;
	}

	
	



}
