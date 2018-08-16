@include('Cole.Globals.Header')

<style>
	body[data-pagereference=install]{
		background-image: url('{!! $Cole->Unsplash->Url !!}');
	}
</style>
        <div class="clearfix"></div>
        <div class="Login">
            <div class="col-xs-8"></div>
        	<div class="col-xs-4 card-box InstallPanel">
                <div class="panel-body">
                    <div class="form-horizontal m-t-20">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <img class="Logo" src="/Cole/Brand/Cole.png" />
                            </div>
                        </div>  

                        <div class="installpage" data-installpage="1">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <h1>Welcome to Cole</h1>
                                    <p>Cole is a CMS that is unlike others you have used before. Cole builds itself based off the data it is provided, rather than the other way around.</p>
                                    <p>You are seeing this page because you have setup Cole to be visible but it is not installed in a Database. To get started, Click next.</p>

                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <button class="btn btn-custom btn-block waves-effect waves-light Next" type="button" data-topage="2">Next</button>
                                    @isset($Cole->Unsplash->Author)
                                    
                                        <p class="text-muted"><br/>Wallpaper by {{$Cole->Unsplash->Author}} on Unsplash</p>
                                    @endisset
                                </div>
                            </div>
                        </div>

                        <div class="installpage" data-installpage="2">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <h1>What's your database server login?</h1>
                                    
                                    <p>Let us know your database login details. This login requires write access, so a root user if available would be best.</p>
                                            
                                    <input id="DbUsername" class="form-control" type="text" data-lpignore="true" required="" placeholder="Database Username">
                                    <input id="DbPassword" class="form-control" type="password" data-lpignore="true" required="" placeholder="Database Password">

                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <button class="btn btn-custom btn-block waves-effect waves-light Next" type="button" data-action="true" data-topage="3">Next</button>
                                </div>
                            </div>
                        </div>

                        <div class="installpage" data-installpage="3">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <h1>Where is your Database server running?</h1>
                                    
                                    <p>It doesn't look like your Database server is running on localhost@3306. What's the details for it?</p>
                                            
                                    <input id="DbHost" class="form-control" type="text" required="" placeholder="Database Host">
                                    <input id="DbPort" class="form-control" type="text" required="" placeholder="Database Port (Leave blank for default of 3306)" maxlength="4">

                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <button class="btn btn-custom btn-block waves-effect waves-light Next" type="button" data-action="true" data-topage="4">Next</button>
                                </div>
                            </div>
                        </div>

                        <div class="installpage" data-installpage="4">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <h1>What database do you want to install Cole to?</h1>
                                    
                                    <p>Specify a database name for Cole to install itself to. You can provide a pre-existing database or have Cole create it for you, but if you provide a database that prexists, all tables will be removed from the database first, so it is imperitive you backup your data first.</p>
                                            
                                    <input id="DbDatabase" class="form-control" type="text" required="" placeholder="Database Name">

                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <button class="btn btn-custom btn-block waves-effect waves-light Next" type="button" data-action="true" data-topage="5">Next</button>
                                </div>
                            </div>
                        </div>

                        <div class="installpage" data-installpage="5">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <h1>And finally</h1>
                                    
                                    <p>Specify a database name for Cole to install itself to. You can provide a pre-existing database or have Cole create it for you, but if you provide a database that prexists, all tables will be removed from the database first, so it is imperitive you backup your data first.</p>
                                            
                                    <p>We will need to take some details from you to create the first account on Cole. This account will by default have permissions over all modules in the system. Once installed you can add additional user accounts with different permissions</p>
                                            
                                    <input id="FullName" class="form-control" type="text" required="" lpignore="true" placeholder="Full Name">
                                    <input id="Email" class="form-control" type="text" required="" lpignore="true" placeholder="Email">
                                    <input id="Password" class="form-control" type="password" lpignore="true" required="" placeholder="Password">
                                    <input id="Password2" class="form-control" type="password" lpignore="true" required="" placeholder="Confirm Password">

                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <button class="btn btn-custom btn-block waves-effect waves-light Install" type="button">Install</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
            
@include('Cole.Globals.Footer')