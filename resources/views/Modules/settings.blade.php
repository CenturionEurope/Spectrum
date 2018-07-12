       <div class="content">
                    <div class="container">
					<pre><?php print_r($Cole);?></pre>
                       
  
					<div class="TableList">
                        <div class="row">
                            <div class="col-sm-12">
	                            
	                            
                                <div class="card-box settingsModule">
	               					
	               					@foreach($Cole->Module->ModuleContent->Plugin->SettingsConstruct as $Key => $Setting)
		               					<div class="m-t-20 form-group">
			               					<label>{{ $Setting->settingEnglishName }}</label>
			               					<input class="form-control" id="{{ $Key }}" type="text" placeholder="{{ $Setting->settingEnglishName }}" value="{{ $Setting->settingValue }}" />
		               					</div>
	               					@endforeach
	               					
	               					<div class="btn btn-success ColeSaveTrigger"><i class="zmdi zmdi-check"></i> Save changes</div>
	               					<div class="btn btn-warning ColeCancelTrigger"><i class="zmdi zmdi-close"></i> Back to Today</div>
									
                                </div>

	                            
	                            
	                            
                            </div><!-- end col -->
                        </div>
					</div>
                </div> <!-- container -->