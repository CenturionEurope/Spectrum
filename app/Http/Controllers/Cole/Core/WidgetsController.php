<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Image;
use Illuminate\Database\Schema\Blueprint;
use Spatie\Analytics\Period;
use Analytics;
use Illuminate\Support\Facades\Cache;

class WidgetsController extends Controller
{
	/*
		
		Cole CMS -> WidgetsController
		(c) Peter Day 2018
				
	*/
	

	
	public function Storage(){
		
		/* get disk space free (in bytes) */
		$df = disk_free_space(base_path());
		/* and get disk space total (in bytes)  */
		$dt = disk_total_space(base_path());
		/* now we calculate the disk space used (in bytes) */
		$du = $dt - $df;
		/* percentage of disk used - this will be used to also set the width % of the progress bar */
		$dp = sprintf('%.2f',($du / $dt) * 100);
		
		/* and we formate the size from bytes to MB, GB, etc. */
		$df = app('App\Http\Controllers\Cole\ColeController')->FormatSize($df);
		$du = app('App\Http\Controllers\Cole\ColeController')->FormatSize($du);
		$dt = app('App\Http\Controllers\Cole\ColeController')->FormatSize($dt);
		
		
		if($dp<60){
			$Class = 'success';
		}else if($dp<90){
			$Class = 'warning';			
		}else{
			$Class = 'danger';			
		}
		
		return (object)array(
			'Percentage' => 100-$dp,
			'Class' => $Class,
			'Free' => $df
		);
		
	}

	public function Visitors(){
		
		if(isset($_ENV['ANALYTICS_VIEW_ID'])){
			if (Cache::has('GAVisitors')){
			    $Visitors = Cache::get('GAVisitors');
			} else {
				
				$analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
				
				$Visitors = 0;
				
				foreach($analyticsData as $Day){
					// Total up the visitors
					$Visitors = $Visitors + $Day['visitors'];				
				}
				
			    Cache::put('GAVisitors', $Visitors, 1440);
			}
			
			return (object)array(
				'Visitors' => $Visitors
			);
	
		}
	}

	public function ThisWeek(){
		// 1 week is 604800
		$ThisWeek = \DB::table('ActivityLog')
		->where('Time','>=',time()-604800)
		->get();
		return count($ThisWeek);
	}

	public function LastUpdated(){
		// 1 week is 604800
		$UpdatedAgo = \DB::table('Settings')
		->where('settingCodename','UpdatedAgo')
		->first();
		$UpdatedAgo = date('m/d/Y H:i:s', $UpdatedAgo->settingValue);

		return app('App\Http\Controllers\Cole\ColeController')->Ago($UpdatedAgo);
	}

	public function ColeNew(){
		return file_get_contents('Cole/UpdateNotes.txt');
	}
}
