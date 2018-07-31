@include('Cole.Globals.Header')

@php
	$Images = scandir('Cole/Images/Heros');
	foreach($Images as $key => $one) {
	    if(strpos($one, '.jpg') === false)
	        unset($Images[$key]);
	}
	$Images = array_values($Images);
	$Image = $Images[rand(0,count($Images)-1)];

@endphp
<style>
	body[data-pagereference=Login]{
		background-image: url('/Cole/Images/Heros/{{ $Image }}');
	}

	</style>
        <div class="clearfix"></div>
        <div class="Login">
            <div class="col-xs-8"></div>
        	<div class="col-xs-4 card-box LoginPanel">
                <div class="panel-body">
                    <div class="form-horizontal m-t-20">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <video width="240" autoplay="true" muted>
                                    <source src="/Cole/Brand/ColeWelcomeSpin.m4v" type="video/mp4" />
                                </video>
                            </div>
                        </div>       
						<div class="form-group">
                            <div class="col-xs-12">
                                <input id="Email" class="form-control" type="text" required="" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="Password" class="form-control" type="password" required="" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12">
                                <button class="btn btn-custom btn-block waves-effect waves-light Login" type="button">Login</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center m-t-30">
                                <p class="text-muted icons"><a href="https://github.com/genericmilk/Cole" target="_blank"><b><i class="zmdi zmdi-github-alt"></i></b></a></p>
                                <p class="text-muted">&copy; Cole {{ date('Y') }} - Version {{ $Cole->Settings->SystemVersion }}</p>
                            </div>
                        </div>                   
                    </div>
                </div>
            </div>
            <!--
            <div class="m-t-40 card-box ResponsiveNotice">
                <div class="panel-body">
                    <div class="form-horizontal m-t-20">
						<div class="form-group">
                            <div class="col-xs-12">
                                <h3>Welcome to Cole</h3>
                                <p>Please visit Cole on a desktop computer in order to login.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <!-- end card-box-->
        </div>
            
@include('Cole.Globals.Footer')
