<div class="content">
    <div class="container">
    <pre><?php print_r($Cole);?></pre>
       

    <div class="TableList">
        <div class="row">
            <div class="col-sm-12">
                
                
                <div class="card-box analyticsModule">
                @isset($_ENV['ANALYTICS_VIEW_ID'])
                    
                <div class="TitleContainer">
                    <h3 class="Left">Pageviews and Visitors</h3>
                    <h3 class="Right">{{ number_format($Cole->Module->ModuleContent->Plugin->AnalyticsConstruct->TotalVisitors) }}</h3>
                    
                </div>
                    <div id="ColeGraphGen" style="display:none;">{!! json_encode($Cole->Module->ModuleContent->Plugin->AnalyticsConstruct->Visitors,TRUE) !!}</div>
                    <div id="morris-line-example"></div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel-group" id="accordion" role="tablist"
                                    aria-multiselectable="true">
                                <div class="panel panel-default bx-shadow-none">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse"
                                                data-parent="#accordion" href="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                Most visited pages
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in"
                                            role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <table class="table table-striped m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Url</th>
                                                        <th>Title</th>
                                                        <th>Views</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($Cole->Module->ModuleContent->Plugin->AnalyticsConstruct->LandingPages as $Page)
                                                    @if(strpos($Page['url'], '?ColeEdit=') == false)
                                                    <tr>
                                                        <th>{{$Cole->Settings->SiteURL}}{{$Page['url']}}</th>
                                                        <td>{{$Page['pageTitle']}}</td>
                                                        <td>{{$Page['pageViews']}}</td>
                                                        <td>
                                                            <a class="btn btn-success btn-xs" href="{{$Cole->Settings->SiteURL}}{{$Page['url']}}" target="_blank">
                                                                    <i class="zmdi zmdi-open-in-new"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default bx-shadow-none">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse"
                                                data-parent="#accordion" href="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Top Referrers
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse"
                                            role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <table class="table table-striped m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Url</th>
                                                        <th>Views</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($Cole->Module->ModuleContent->Plugin->AnalyticsConstruct->TopRef as $Page)
                                                    <tr>
                                                        <th>{{$Page['url']}}</th>
                                                        <td>{{$Page['pageViews']}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default bx-shadow-none">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse"
                                                data-parent="#accordion" href="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                Top Browsers
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse"
                                            role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <table class="table table-striped m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Browser</th>
                                                        <th>Sessions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($Cole->Module->ModuleContent->Plugin->AnalyticsConstruct->TopBrowsers as $Browser)
                                                    <tr>
                                                        <th>{{$Browser['browser']}}</th>
                                                        <td>{{$Browser['sessions']}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default bx-shadow-none">
                                        <div class="panel-heading" role="tab" id="headingFour">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse"
                                                    data-parent="#accordion" href="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                    Bounce Rate
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse"
                                                role="tabpanel" aria-labelledby="headingFour">
                                            <div class="panel-body">
                                                    <table class="table table-striped m-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Url</th>
                                                                <th>Bounce Rate</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($Cole->Module->ModuleContent->Plugin->AnalyticsConstruct->Bounces as $Page)
                                                            @if(strpos($Page[0], '?ColeEdit=') == false)
                                                            <tr>
                                                                <th>{{$Cole->Settings->SiteURL}}{{$Page[0]}}</th>
                                                                <td>{{number_format($Page[1])}}%</td>
                                                                <td>
                                                                    <a class="btn btn-success btn-xs" href="{{$Cole->Settings->SiteURL}}{{$Page[0]}}" target="_blank">
                                                                            <i class="zmdi zmdi-open-in-new"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                            </div>
                        </div><!-- end col -->
                    </div>

                   

                    <small>All Analytics data has been provided by Google Analytics and is over a 30 day rolling period. For more in depth information of your Analytics data, It's advised you login to your analytics account <a href="https://analytics.google.com" target="_blank">here</a></small>
                
                @else
                    <h1>Welcome to Analytics</h1>
                    <p>Cole can import data over a 30 day rolling period from your Google Analytics account and display it in this module.</p>
                    <p>Currently, Analytics has not been setup. It's advised that you only setup Analytics if you class yourself as a Developer as the instructions for setup might not be easy to follow for the average end user.</p>
                    <p>You can refer to the <a href="https://github.com/genericmilk/Cole/wiki/Analytics" target="_blank">Analytics Wiki</a> for installation instructions.</p>
                @endisset
                
                    
                       <div class="btn btn-warning ColeCancelTrigger"><i class="zmdi zmdi-close"></i> Back to Today</div>
                    
                </div>

                
                
                
            </div><!-- end col -->
        </div>
    </div>
</div> <!-- container -->