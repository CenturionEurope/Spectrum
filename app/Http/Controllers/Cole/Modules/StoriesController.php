<?php

namespace App\Http\Controllers\Cole\Modules;
use App\Http\Controllers\Controller;
use DB;
use GrahamCampbell\Markdown\Facades\Markdown;

class StoriesController extends Controller
{
    
    // About: Cole DataAction Plugins
    // Define a plugin below to be used with a DataAction.
    // DataActions will pass the Data Affected to the Plugin via $Object
    
    // ColeDatabaseBoot - Build the database if it does not exist
	// ColeGetPlugin($Object,$Pre) - Define a plugin when ColeGet is run
	// ColeCreatePlugin($Object,$Pre) - Define a plugin when data is created
	// ColeSavePlugin($Object,$Pre) - Define a plugin when data is updated
	// ColeDeletePlugin($Object,$Pre) - Define a plugin when data is deleted
	
 
}
