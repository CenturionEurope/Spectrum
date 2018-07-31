<?php

namespace App\Http\Controllers\Cole\Modules;
use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;


class ImagesController extends Controller
{
	
    // About: Cole DataAction Plugins
    // Define a plugin below to be used with a DataAction.
    // DataActions will pass the Data Affected to the Plugin via $Object

    // ColeDatabaseBoot - Build the database if it does not exist    
	// ColeGetPlugin($Object,$Pre) - Define a plugin when ColeGet is run
	// ColeCreatePlugin($Object,$Pre) - Define a plugin when data is created
	// ColeSavePlugin($Object,$Pre) - Define a plugin when data is updated
	// ColeDeletePlugin($Object,$Pre) - Define a plugin when data is deleted
	
		
	public function ColeDatabaseBoot(){
		\Schema::create('ColeMod_Pages_Images', function(Blueprint $table)
	    {
	        $table->increments('id');
	        $table->string('Tag');
	        $table->string('Value')->nullable();
	        $table->integer('Width')->nullable();
	        $table->integer('Height')->nullable();
	        $table->text('Alt')->nullable();
	        $table->text('Tweaks')->nullable();

	    });  
	}
	
	public function ColeGetPlugin($Object){
		// Ask the frontend for the base path

		$Settings = app('App\Http\Controllers\Cole\ColeController')->Settings();
		
		$Images = \DB::table('ColeMod_Pages_Images')
		->get();
		
		foreach($Images as $Image){
			$Image->Value = $Settings->SiteURL.'/Cole/Pages/Images/'.$Image->Tag;
		}
		
		return $Images;
					
	}
		
	public function GetMeta(){
		
		$Columns = (array)\DB::getSchemaBuilder()->getColumnListing('ColeMod_Pages_Images'); // Get cols
		$Columns = array_diff($Columns, array('id','Tag','Value','Tweaks'));
		$Columns = array_values($Columns); // reset index
		
		$Meta = \DB::table('ColeMod_Pages_Images')
		->where('id',$_POST['ImageID'])
		->select($Columns)
		->first();

		$Meta->TableViewMapper = \DB::table('TableViewMapper')
		->where('Table','ColeMod_Pages_Images')		
		->get();
		
		return array(
			'Outcome' => 'Success',
			'Meta' => $Meta
		);
		
	}
	
	public function SaveMeta(){
		\DB::table('ColeMod_Pages_Images')
		->where('id',$_POST['id'])
		->update($_POST); 
		
		return array(
			'Outcome' => 'Success'
		);
	}
	
	public function GetTweaks(){
		$Image = \DB::table('ColeMod_Pages_Images')
		->where('id',$_POST['ImageID'])
		->first();
				
		return json_decode(json_encode($Image->Tweaks));
	}
	
	public function SaveTweaks(){
		\DB::table('ColeMod_Pages_Images')
		->where('id',$_POST['id'])
		->update([
			'Tweaks' => $_POST['Tweaks']
		]); 
		
		return array(
			'Outcome' => 'Success'
		);
		
	}
	
	public function ResetImage(){
		
		$Columns = (array)\DB::getSchemaBuilder()->getColumnListing('ColeMod_Pages_Images'); // Get cols
		$Columns = array_diff($Columns, array('id','Tag','Value','Width','Height'));
		$Columns = array_values($Columns); // reset index
		
		foreach($Columns as $Column){
			\DB::table('ColeMod_Pages_Images')
			->where('id',$_POST['id'])
			->update([
				$Column => null
			]); 
		}
		
		return array(
			'Outcome' => 'Success'
		);
		
	}

}