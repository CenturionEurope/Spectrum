<?php

namespace App\Http\Controllers\Cole\Core;
use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use DB;

class DatabaseController extends Controller
{
	public static function setEnvironmentValue($key,$value){
		$path = base_path('.env');
	
		if(is_bool(env($key)))
		{
			$old = env($key)? 'true' : 'false';
		}
		elseif(env($key)===null){
			$old = 'null';
		}
		else{
			$old = env($key);
		}
	
		if (file_exists($path)) {
			file_put_contents($path, str_replace(
				"$key=".$old, "$key=".$value, file_get_contents($path)
			));
		}
	}



	public function DbVet(){
		try {
			DB::connection()->getPdo();
			return array(
				'Status' => 1
			);
		} catch (\Exception $e) {
			if (strpos($e, 'Access denied') !== false) {
				// Looks like db is running on localhost, but we need to login to it.
				return array(
					'Status' => 0,
					'Type' => 1,
					'Exception' => $e
				);
			}else{
				// Can't see a MySQL instance running on localhost
				return array(
					'Status' => 0,
					'Type' => 2,
					'Exception' => $e
				);
			}
		}
	}

	public function DbSet(){

		try {
			
			$Altered = array();
			if(isset($_POST['DbHost'])){
				$this->setEnvironmentValue('DB_HOST', $_POST['DbHost']);
				array_push($Altered,'DbHost');
			}
			if(isset($_POST['DbPort'])){
				$this->setEnvironmentValue('DB_PORT', $_POST['DbPort']);
				array_push($Altered,'DbPort');
			}
			if(isset($_POST['DbDatabase'])){
				$this->setEnvironmentValue('DB_DATABASE', $_POST['DbDatabase']);
				array_push($Altered,'DbDatabase');
			}
			if(isset($_POST['DbUsername'])){
				$this->setEnvironmentValue('DB_USERNAME', $_POST['DbUsername']);
				array_push($Altered,'DbUsername');
			}
			if(isset($_POST['DbPassword'])){
				$this->setEnvironmentValue('DB_PASSWORD', $_POST['DbPassword']);
				array_push($Altered,'DbPassword');
			}

			return array(
				'Outcome' => 'Success',
				'Altered' => $Altered
			);

		}catch (\Exception $e) {
			return array(
				'Outcome' => 'Failure',
				'Reason' => 'There was an issue writing your database details to disk. Please chmod your Cole installation folder to 777 and try again.',
				'Exception' => $e
			);
		}
		
	}

	public function DbMake(){

			try{
				$dsn = "mysql:host=".$_ENV['DB_HOST'].";port=".$_ENV['DB_PORT'].";";
				$db = new \PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']); // connect
				$statement = $db->prepare('CREATE DATABASE `'.$_POST['DbDatabase'].'`');
				$statement->execute();
				
				return array(
					'Outcome' => 'Success'
				);
			}catch (\Exception $e) {
				return array(
					'Outcome' => 'Failure',
					'Reason' => 'Cole was unable to create that database. You might want to try again or failing that, create a blank database manually.',
					'Exception' => $e
				);
			}
	}

	public function DbWipe(){
		foreach(DB::select('SHOW TABLES') as $table) {
			$table_array = get_object_vars($table);
			\Schema::drop($table_array[key($table_array)]);
		}
		return array(
			'Outcome' => 'Success'
		);
	}

    public function DatabaseInitialise(){
		
		/*
		*	DatabaseInitialise()
		*	Builds core database tables that the system relies on
		*/

		if (!\Schema::hasTable('TableViewMapper')) {
			\Schema::create('TableViewMapper', function(Blueprint $table)
		    {
		        $table->increments('id');
		        $table->text('Table')->nullable();
		        $table->text('ColName')->nullable();
		        $table->text('EnglishName')->nullable();
		        $table->integer('Show')->default(1);
		        $table->integer('Edit')->default(1);
		        $table->integer('IsBoolean')->default(0);
		        $table->integer('Currency')->default(0);
		        $table->integer('SaltedMD5')->default(0);
		        $table->integer('B64')->default(0);
		        $table->integer('isArray')->default(0);
		        $table->text('ArrayDecoderPlugin')->nullable();
		        $table->integer('isFlag')->default(0);
		        $table->text('FlagDecoderPlugin')->nullable();		        
		        $table->integer('isDate')->default(0);
		        $table->integer('isRTF')->default(0);
		        $table->integer('isImg')->default(0);
		        $table->integer('isThumb')->default(0);
		        $table->integer('MaxLength')->nullable();
			});
		}
		
		if (!\Schema::hasTable('ActivityLog')) {
			\Schema::create('ActivityLog', function(Blueprint $table)
		    {
		        $table->increments('id');
		        $table->integer('AccountID')->nullable();
		        $table->string('ModuleUpdated')->nullable();
		        $table->string('DataAction')->nullable();
		        $table->bigInteger('Time');
		    });
		}
		
		if (!\Schema::hasTable('Modules')) {
			\Schema::create('Modules', function(Blueprint $table)
		    {
		        $table->increments('id');
		        $table->string('ModuleName')->nullable();
		        $table->string('Codename')->nullable();
		        $table->text('Controller')->nullable();
		        $table->string('Database')->nullable();
		        $table->string('Template')->nullable();
		        $table->string('Icon')->nullable();
		        $table->tinyInteger('Custom')->default(0);
		        
		    });
		    
			// Install default collection of modules
			\DB::table('Modules')->insert([
			    [
					'ModuleName' => 'Today',
					'Codename' => 'today',
					'Controller' => 'App\Http\Controllers\Cole\Modules\TodayController',
					'Database' => null,
					'Template' => 'today',
					'Icon' => null
				],
				[
					'ModuleName' => 'Me',
					'Codename' => 'me',
					'Controller' => 'App\Http\Controllers\Cole\Modules\MeController',
					'Database' => 'Users',
					'Template' => 'me',
					'Icon' => 'zmdi-face'
				],
				[
					'ModuleName' => 'Edit Pages',
					'Codename' => 'pages',
					'Controller' => 'App\Http\Controllers\Cole\Modules\PagesController',
					'Database' => 'ColeMod_Pages',
					'Template' => 'pages',
					'Icon' => 'zmdi-edit'
				],
				[
					'ModuleName' => 'Settings',
					'Codename' => 'settings',
					'Controller' => 'App\Http\Controllers\Cole\Modules\SettingsController',
					'Database' => 'Settings',
					'Template' => 'settings',
					'Icon' => 'zmdi-settings'
				],
				[
					'ModuleName' => 'Images',
					'Codename' => 'images',
					'Controller' => 'App\Http\Controllers\Cole\Modules\ImagesController',
					'Database' => 'ColeMod_Pages_Images',
					'Template' => 'images',
					'Icon' => 'zmdi-image'
				]
			]);
		    
		    
		}
		
		if (!\Schema::hasTable('Permissions')) {
			\Schema::create('Permissions', function(Blueprint $table)
		    {
		        $table->increments('id');
		        $table->integer('User')->nullable();
		        $table->string('Module')->nullable();
		        $table->tinyInteger('Get')->default(0);
		        $table->tinyInteger('Create')->default(0);
		        $table->tinyInteger('Save')->default(0);
		        $table->tinyInteger('Delete')->default(0);
		    });
		}
		
		if (!\Schema::hasTable('Settings')) {
			\Schema::create('Settings', function(Blueprint $table)
		    {
		        $table->increments('id');
		        $table->string('settingEnglishName');
		        $table->string('settingCodeName');
		        $table->text('settingValue');
		        $table->tinyInteger('settingB64')->default(0);
		        $table->tinyInteger('Locked')->default(0);
		    });

			\DB::table('Settings')->insert([
			    [
					'settingEnglishName' => 'Website Name',
					'settingCodeName' => 'SiteName',
					'settingValue' => 'My Cole Website',
					'settingB64' => 0,
					'Locked' => 0
				],
			    [
					'settingEnglishName' => 'Site URL',
					'settingCodeName' => 'SiteURL',
					'settingValue' => 'http://coletools.local',
					'settingB64' => 0,
					'Locked' => 1
				],
			    [
					'settingEnglishName' => 'Version',
					'settingCodeName' => 'SystemVersion',
					'settingValue' => '3.5.1',
					'settingB64' => 0,
					'Locked' => 1
				],
			    [
					'settingEnglishName' => 'Cole URL',
					'settingCodeName' => 'ColeURL',
					'settingValue' => 'http://cole.local',
					'settingB64' => 0,
					'Locked' => 1
				],
			    [
					'settingEnglishName' => 'ColeTools Version',
					'settingCodeName' => 'ColeToolsVersion',
					'settingValue' => '1.1.0',
					'settingB64' => 0,
					'Locked' => 1
				]				
			]);

		}

		if (!\Schema::hasTable('Users')) {
			\Schema::create('Users', function(Blueprint $table)
		    {
		        $table->increments('id');
		        $table->bigInteger('FacebookID')->default(0);
		        $table->string('ProfilePicture')->nullable();
		        $table->string('FullName')->nullable();
		        $table->string('Email');		        
		        $table->text('Password');
		        $table->bigInteger('Secret')->nullable();
		        $table->tinyInteger('NightMode')->default(0);
		    });
		    
		    // Build TVM
		    \DB::table('TableViewMapper')->insert([
			    [
					'Table' => 'Users',
					'ColName' => 'id',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'Permissions',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'FullName',
					'EnglishName' => 'User&apos;s Full Name',
					'Show' => 1,
					'Edit' => 1,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'FacebookID',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'Password',
					'EnglishName' => 'Password',
					'Show' => 0,
					'Edit' => 1,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 1,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'Secret',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'Email',
					'EnglishName' => 'Email',
					'Show' => 0,
					'Edit' => 1,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'NightMode',
					'EnglishName' => 'Night Mode',
					'Show' => 0,
					'Edit' => 1,
					'IsBoolean' => 1,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
			    [
					'Table' => 'Users',
					'ColName' => 'ProfilePicture',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],

			]);
		}	
		
		if (!\Schema::hasTable('Widgets')) {
			\Schema::create('Widgets', function(Blueprint $table)
		    {
		        $table->increments('id');
		        $table->string('Title')->nullable();
		        $table->string('Controller')->nullable();
		        $table->string('Function')->nullable();
		        $table->string('Blade')->nullable();
		    });
		    
		    \DB::table('Widgets')
			->insert([
				'Title' => 'Server Storage',
				'Controller' => 'App\Http\Controllers\WidgetsController',
				'Function' => 'Storage',
				'Blade' => 'Widgets.Storage'
			]); 
		 
		}
		
		if (!\Schema::hasTable('ColeMod_Pages')) {
			\Schema::create('ColeMod_Pages', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('Url');
				$table->text('Title');
				$table->tinyInteger('AccountLocked')->default(0);
				$table->text('Template');
				$table->string('Modules');
				$table->string('Plugin');
			});
			\DB::table('Modules')->insert([
				'Url' => '/',
				'Title' => 'My Cole Website',
				'AccountLocked' => 0,
				'Template' => 'Index'
			]);
			\DB::table('TableViewMapper')->insert([
				[
					'Table' => 'ColeMod_Pages',
					'ColName' => 'id',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
				[
					'Table' => 'ColeMod_Pages',
					'ColName' => 'Title',
					'EnglishName' => 'Page Title',
					'Show' => 1,
					'Edit' => 1,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
				[
					'Table' => 'ColeMod_Pages',
					'ColName' => 'Url',
					'EnglishName' => 'Page Web Address',
					'Show' => 1,
					'Edit' => 1,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
				[
					'Table' => 'ColeMod_Pages',
					'ColName' => 'AccountLocked',
					'EnglishName' => 'Customer login Required?',
					'Show' => 1,
					'Edit' => 1,
					'IsBoolean' => 1,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
				[
					'Table' => 'ColeMod_Pages',
					'ColName' => 'Template',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
				[
					'Table' => 'ColeMod_Pages',
					'ColName' => 'Modules',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				],
				[
					'Table' => 'ColeMod_Pages',
					'ColName' => 'Plugin',
					'EnglishName' => null,
					'Show' => 0,
					'Edit' => 0,
					'IsBoolean' => 0,
					'Currency' => 0,
					'SaltedMD5' => 0,
					'B64' => 0,
					'isArray' => 0,
					'ArrayDecoderPlugin' => null,
					'isFlag' => 0,
					'FlagDecoderPlugin' => null,
					'isDate' => 0,
					'isRTF' => 0,
					'isImg' => 0,
					'isThumb' => 0
				]
			]);
		}

		if (!\Schema::hasTable('ColeMod_Pages_Fields')) {
			\Schema::create('ColeMod_Pages_Fields', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('Url');
				$table->text('Tag');
				$table->text('Value');
			});
		}
				
	}

	public function DatabaseSyndicate(){
		$BuildFiles = glob('Cole/Database/*.json', GLOB_BRACE);

		foreach($BuildFiles as $BuildFile){
			$BuildFile = json_decode(file_get_contents($BuildFile));
			$Table = $BuildFile->Table;
			$Structure = $BuildFile->Fields;
			$Content = $BuildFile->Content;

			// First check if the database table exists
			if(!Schema::hasTable($Table)){
				Schema::create($Table);
			}

		}
	}

}