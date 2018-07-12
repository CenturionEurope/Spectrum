<?php

namespace App\Http\Controllers\ColeControllers;
use App\Http\Controllers\Controller;


class LibrariesController extends Controller
{
	
    // About: Cole DataAction Plugins
    // Define a plugin below to be used with a DataAction.
    // DataActions will pass the Data Affected to the Plugin via $Object

    // ColeDatabaseBoot - Build the database if it does not exist    
	// ColeGetPlugin($Object,$Pre) - Define a plugin when ColeGet is run
	// ColeCreatePlugin($Object,$Pre) - Define a plugin when data is created
	// ColeSavePlugin($Object,$Pre) - Define a plugin when data is updated
	// ColeDeletePlugin($Object,$Pre) - Define a plugin when data is deleted
	
	public function UidToLinkDecoder($Data,$Edit = null){
		if(!empty($Data)){
			return '<a target="_blank" class="btn btn-info" href="http://beta.fast2foto.co.uk/library/'.$Data.'">Open this Library on the Fast2foto Frontend</a>';
		}
	}
	
	public function TocStatusDecoder($Data,$Edit = null){
		if($Data==0){
			return  '<span class="label label-danger">Terms not agreed, library inactive</span>';
		}else if($Data==1){
			return  '<span class="label label-success">Terms agreed, library active</span>';
		}
	}

	public function ColeCreatePlugin($Object,$Pre){
		
        \DB::table('ColeMod_Libraries')
	    ->where('id',$Object[0]->id)
		->update([
			'Uid' => md5(time().rand())
		]);

	}

}