		<div class="AccountHero" style="background-image: url('/Cole/Me/Banner');">
			<img src="https://www.gravatar.com/avatar/{{ md5(strtolower($Cole->User->Email)) }}?s=200" />
			<h1>{{ $Cole->User->FullName }}</h1>
		</div>

       <div class="content">
                    <div class="container">
					<pre><?php print_r($Cole);?></pre>
					<div class="TableList">
                        <div class="row">
                            <div class="col-sm-12">
	                            
	                            <div class="col-xs-12 col-sm-6">
	                                <div class="card-box ActivityLog">
	               				
									<h4 class="header-title m-t-10 m-b-10">Activity Feed</h4>
									

	                                @foreach($Cole->Module->ModuleContent->Plugin->ActivityLogPlugin->ActivityLog as $LogItem)
                                    <div class="comment">
                                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($LogItem->AccountData->Email)) }}?s=200" alt="" class="comment-avatar">
                                        <div class="comment-body">
                                            <div class="comment-text">
                                                <div class="comment-header">
                                                    <a href="#" title="">{{ $LogItem->AccountData->FullName }}</a><span>{!! app('App\Http\Controllers\Cole\ColeController')->Ago(gmdate("Y-m-d\TH:i:s\Z", $LogItem->Time)) !!}</span>
                                                </div>
                                                {{ $LogItem->AccountData->FullName }} {{ $LogItem->DataAction }} an item in the {{ $LogItem->ModuleUpdated }} module.
                                            </div>
                                        </div>
                                    </div>
                                   @endforeach
                                </div>
	                            </div>
	                            
	                            <div class="col-xs-12 col-sm-6">
                                	<div class="card-box table-responsive">
                                    <div class="dropdown pull-right">
                                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                                    <ul class="dropdown-menu" role="menu">

                                        <li><a href="#" class="CreateItem" data-module="<?php echo $Cole->Module->ModuleData->Codename; ?>"><i class="zmdi zmdi-file-plus"></i> Create</a></li>
                                        
                                    </ul>
                                    </div>

                        			<h4 class="header-title m-t-0 m-b-30">Other Cole Users</h4>
									
									@include('Cole.Prebuilt.DatabaseTable')
									
									
                                   
                                </div>
	                            </div>
	                            
                            </div><!-- end col -->
                        </div>
					</div>
					
	                <div class="EditControls">
						<div class="row">
		                    <div class="col-sm-12">
		                            <div class="card-box EditModule">
		                            </div>
		                        </div>
		                    </div>
						</div>
             
                       
                       
                </div> <!-- container -->
