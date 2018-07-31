<?php

namespace App\Http\Controllers\Cole\Modules;
use App\Http\Controllers\Controller;

class HelpController extends Controller
{
	
    // About: Cole DataAction Plugins
    // Define a plugin below to be used with a DataAction.
    // DataActions will pass the Data Affected to the Plugin via $Object

    // ColeDatabaseBoot - Build the database if it does not exist    
	// ColeGetPlugin($Object) - Define a plugin when ColeGet is run
	// ColeCreatePlugin($Object) - Define a plugin when data is created
	// ColeSavePlugin($Object,$Pre) - Define a plugin when data is updated
	// ColeDeletePlugin($Object) - Define a plugin when data is deleted
    
    public function ColeGetPlugin(){
        
		$Categories = \DB::table('Help_Categories')
        ->get();
        $Compiled = array();
        foreach($Categories as $Category){
            
            $Data = \DB::table('Help')
            ->where('Category',$Category->id)
            ->get();

            $Compiled[] = (object)array(
                'Category' => $Category,
                'Data' => $Data
            );
            

        }
        
        return (object)$Compiled;
    }
	
	
	    
}