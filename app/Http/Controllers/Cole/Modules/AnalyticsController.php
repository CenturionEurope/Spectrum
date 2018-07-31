<?php

namespace App\Http\Controllers\Cole\Modules;
use App\Http\Controllers\Controller;
use Spatie\Analytics\Period;
use Analytics;
use Illuminate\Support\Facades\Cache;

class AnalyticsController extends Controller
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
			'AnalyticsConstruct' => app('App\Http\Controllers\Cole\Modules\AnalyticsController')->AnalyticsConstruct()
		);
		
		return $API;
	}
	
	

	
	public function AnalyticsConstruct(){

        if(isset($_ENV['ANALYTICS_VIEW_ID'])){

			// Visitors and page views
			if (Cache::has('GAVisitorsFull')){
			    $Visitors = Cache::get('GAVisitorsFull');
			} else {
				$Visitors = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
			    Cache::put('GAVisitorsFull', $Visitors, 1440);
			}
			
			// Count visitors and page views
			$TotalVisitors = 0;
			foreach($Visitors as $Day){
				// Total up the visitors
				$TotalVisitors = $TotalVisitors + $Day['visitors'];				
			}

			// Landing pages
			if (Cache::has('GALanding')){
			    $LandingPages = Cache::get('GALanding');
			} else {
				$LandingPages = Analytics::fetchMostVisitedPages(Period::days(30));
			    Cache::put('GALanding', $LandingPages, 1440);
			}

			// Top referrers
			if (Cache::has('GARef')){
				$TopRef = Cache::get('GARef');
			} else {
				$TopRef = Analytics::fetchTopReferrers(Period::days(30));
				Cache::put('GARef', $TopRef, 1440);
			}

			// Top Browsers
			if (Cache::has('GATopBrowsers')){
				$TopBrowsers = Cache::get('GATopBrowsers');
			} else {
				$TopBrowsers = Analytics::fetchTopBrowsers(Period::days(30));
				Cache::put('GATopBrowsers', $TopBrowsers, 1440);
			}


			// Bounce rate
			if (Cache::has('GABounce')){
				$Bounces = Cache::get('GABounce');
			} else {
				$Bounces = Analytics::performQuery(
					Period::days(30),
					'ga:bounces',
					[
						'metrics' => 'ga:bounceRate',
						'dimensions' => 'ga:pagePath'
					]
				);
				Cache::put('GABounce', $Bounces, 1440);
			}


			

			return (object)array(
				'Visitors' => $Visitors,
				'TotalVisitors' => $TotalVisitors,
				'LandingPages' => $LandingPages,
				'TopRef' => $TopRef,
				'TopBrowsers' => $TopBrowsers,
				'Bounces' => $Bounces
			);
	
        }
        
	}
	
	
	    
}