<?php

namespace App\Http\Controllers\ColeControllers;
use App\Http\Controllers\Controller;


class SettingsController extends Controller
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
		
		$API = (object)array(
			'Outcome' => 'Success',
			'SettingsConstruct' => app('App\Http\Controllers\ColeControllers\SettingsController')->SettingsConstruct()
		);
		
		return $API;
	}
	
	

	
	public function SettingsConstruct(){

		$Settings = \DB::table('Settings')
		->where('Locked',0)
		->get();

		$SettingsOutput = array();

		// Convert epochs to time strings
		foreach($Settings as $Setting){
			
			if($Setting->settingB64==1){
				$Setting->settingValue = base64_decode($Setting->settingValue);
			}
			
			$SettingsOutput[$Setting->settingCodeName] = (object)array(
				'settingEnglishName' => $Setting->settingEnglishName,
				'settingValue' => $Setting->settingValue,
			);
		}		
		
		return (object)$SettingsOutput;	
	}
	
	
	    
}