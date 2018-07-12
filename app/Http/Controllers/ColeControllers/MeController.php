<?php

namespace App\Http\Controllers\ColeControllers;
use App\Http\Controllers\Controller;


class MeController extends Controller
{
	
    // About: Cole DataAction Plugins
    // Define a plugin below to be used with a DataAction.
    // DataActions will pass the Data Affected to the Plugin via $Object
 
    // ColeDatabaseBoot - Build the database if it does not exist   
	// ColeGetPlugin($Object,$Pre) - Define a plugin when ColeGet is run
	// ColeCreatePlugin($Object,$Pre) - Define a plugin when data is created
	// ColeSavePlugin($Object,$Pre) - Define a plugin when data is updated
	// ColeDeletePlugin($Object,$Pre) - Define a plugin when data is deleted

	
	public function ColeGetPlugin($Object){
		$ActivityLog = (object)app('App\Http\Controllers\ColeController')->ActivityLog(); // load activityfeed

		$API = array(
			'Outcome' => 'Success',
			'ActivityLogPlugin' => $ActivityLog,
			'PassedObject' => $Object
		);
		
		if(isset($Object->id)){
			$API['UserPermissions'] = (object)app('App\Http\Controllers\ColeController')->GetPermissionsModule($Object);
		}
		
		return (object)$API;
	}
	
	public function ColeCreatePlugin($Object){
		// Build the user's permissions
		
		$Modules = \DB::table('Modules')
		->get();
		foreach($Modules as $Module){
			
			\DB::table('Permissions')
			->insert([
				'User' => $Object[0]->id,
				'Module' => $Module->Codename,
				'Get' => 1,
				'Create' => 1,
				'Save' => 1,
				'Delete' => 1
			]);
						
		}
		
	}
	
	
	public function ColeSavePlugin($Object,$Pre){
		
		return (object)array(
			'Saved' => $Object[0],
			'ActiveUser' => app('App\Http\Controllers\ColeController')->AccountDetails()
		);
		
	}
	
	public function ProfilePictureUpload(){
		$User = (object)app('App\Http\Controllers\ColeController')->AccountDetails();
		$data = array();

		

		if(isset($_GET['files']))
		{
		    $error = false;
		    $files = array();
			
			if(file_exists('Storage/ProfilePictures/'. $User->id . '_ProfilePicture.jpg')){
				unlink('Storage/ProfilePictures/'. $User->id . '_ProfilePicture.jpg');
			}
			
			if(!isset($_POST['Path'])){
				$_POST['Path'] = 'Storage/ProfilePictures/';
			}
		    $uploaddir = $_POST['Path'];
		    foreach($_FILES as $file)
		    {
		        if(move_uploaded_file($file['tmp_name'], $uploaddir . $User->id . '_ProfilePicture.jpg'))
		        {
		            $files[] = $uploaddir .$file['name'];
		        }
		        else
		        {
		            $error = true;
		        }
		    }
		    $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
		}
		else
		{
		    $data = array('success' => 'Form was submitted', 'formData' => $_POST);
		}

		return json_encode($data);
	}
	
	
	    
}