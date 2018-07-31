<?php

namespace App\Http\Controllers\Cole\Core;
use App\Http\Controllers\Controller;
use DB;

class PanelsController extends Controller
{
	public function PanelsDelete(){
		header('Access-Control-Allow-Origin: *');
		$Secret = $_POST['Secret'];
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

		$Page = \DB::table('ColeMod_Pages')
		->where('id',$_POST['PageID'])
		->first();

		$Page->Panels = json_decode($Page->Panels);
		$Page->Panels = array_diff($Page->Panels, array($_POST['PanelID']));
		$Page->Panels = array_values($Page->Panels);

		\DB::table('ColeMod_Pages_Panels_Uids')
		->where('PageID', $_POST['PageID'])
		->where('PanelID', $_POST['PanelID'])
		->where('Uid', $_POST['Uid'])
		->delete();

		// Write this back to the db
		\DB::table('ColeMod_Pages')
		->where('id',$_POST['PageID'])
		->update([
			'Panels' => json_encode($Page->Panels)
		]);

		return array(
			'Outcome' => 'Success'
		);

	}

	public function PanelsList(){
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
		
		$Panels = \DB::table('ColeMod_Pages_Panels')
		->get();

		return $Panels;

	}
	
	public function PanelNewUidGet(){
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
		
		$Uid = \DB::table('ColeMod_Pages_Panels_Uids')
		->orderby('id','DESC')
		->first();

		return $Uid->Uid;

		return $Uid;

	}
	
		
}