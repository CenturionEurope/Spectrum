<?php

namespace App\Http\Controllers\ColeCore;
use App\Http\Controllers\Controller;
use DB;

class BackInTimeController extends Controller
{
	public function BackInTimeGet($PageID){
		header('Access-Control-Allow-Origin: *');
		$Secret = $_GET['Secret'];
		// Authenticate Secret
		$TagTest = \DB::table('Users')
		->where('Secret',$Secret)
		->get();

		if(count($TagTest)==0){
			return array(
				'Outcome' => 'Failure',
				'Reason' => 'There was an error authenticating the user secret.'
			);
		}

		return \DB::table('ColeMod_Pages_BackInTime')
		->where('PageID',$PageID)
		->orderby('id','DESC')
		->select('id','DateTime')
		->limit(10)
		->get();
	}

	public function BackInTimeBackup($PageID){
		header('Access-Control-Allow-Origin: *');
		$Secret = $_GET['Secret'];
		// Authenticate Secret
		$TagTest = \DB::table('Users')
		->where('Secret',$Secret)
		->get();

		if(count($TagTest)==0){
			return array(
				'Outcome' => 'Failure',
				'Reason' => 'There was an error authenticating the user secret.'
			);
		}

		// Get Page Url
		$PageUrl = \DB::table('ColeMod_Pages')
		->where('id',$PageID)
		->first()->Url;
		// Grab all the pagefields
		$PageFields = \DB::table('ColeMod_Pages_Fields')
		->where('Url',$PageUrl)
		->select('Tag','Value')
		->get();
		$PageFields = json_encode($PageFields);
		// Insert into a backup
		\DB::table('ColeMod_Pages_BackInTime')
		->insert([
			'PageID' => $PageID,
			'DateTime' => date('Y-m-d H:i:s'),
			'Object' => $PageFields
		]);

		return array(
			'Outcome' => 'Success'
		);
	}

	public function BackInTimeRestore($BackupID){
		header('Access-Control-Allow-Origin: *');
		$Secret = $_GET['Secret'];
		// Authenticate Secret
		$TagTest = \DB::table('Users')
		->where('Secret',$Secret)
		->get();

		if(count($TagTest)==0){
			return array(
				'Outcome' => 'Failure',
				'Reason' => 'There was an error authenticating the user secret.'
			);
		}
		

		// Get the PageID from BackupID
		$BackupData = \DB::table('ColeMod_Pages_BackInTime')
		->where('id',$BackupID)
		->first();
		$PageID = $BackupData->PageID;

		// Get the data on the page
		$PageMeta = \DB::table('ColeMod_Pages')
		->where('id',$PageID)
		->first();
		// Deconvert JSON to an object
		$JSON = json_decode($BackupData->Object);

		// Gut old pagefield values
		\DB::table('ColeMod_Pages_Fields')
		->where('Url',$PageMeta->Url)
		->delete();

		// Cycle round the JSON and insert the new fields
		foreach($JSON as $Field){
			\DB::table('ColeMod_Pages_Fields')
			->insert([
				'Url' => $PageMeta->Url,
				'Tag' => $Field->Tag,
				'Value' => $Field->Value
			]);
		}

		return array(
			'Outcome' => 'Success'
		);

	}

	public function BackInTimeBackupGet($BackupID){
		header('Access-Control-Allow-Origin: *');
		$Secret = $_GET['Secret'];
		// Authenticate Secret
		$TagTest = \DB::table('Users')
		->where('Secret',$Secret)
		->get();
		
		if(count($TagTest)==0){
			return array(
				'Outcome' => 'Failure',
				'Reason' => 'There was an error authenticating the user secret.'
			);
		}
		
		// Expand the BackupID fields
		$BackupData = \DB::table('ColeMod_Pages_BackInTime')
		->where('id',$BackupID)
		->first()->Object;
		return array(
			'Outcome' => 'Success',
			'BackupData' => json_decode($BackupData)
		);
		
	}
}