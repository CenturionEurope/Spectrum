@if(!file_exists('../.env'))


@include('Globals.Header')

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
           
            <div class="text-center">
                <a href="/" class="logo"><img src="/Cole/Brand/coleTransparentWhite.png" width="120"/></a>
            </div>
            
            <h1><span class="name">install</span>@<span class="location">cole:</span><span class="tilde">~</span>$ sh install.sh<i>&marker;</i></h1>
             
            
            <p><small>&copy; Cole {{ date('Y') }}</small></p> 
            

        </div>
            
@include('Globals.Footer')

		@php
			die();
		@endphp
@else
                <div class="content ErrorView">
                    <div class="container">
                        <div class="row">

                            <div class="col-xs-12">
	                            <div class="Welcome">
		                            <div class="Text">
										<div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: block;margin-left:0px;"><span class="swal2-x-mark swal2-animate-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div>

										<h1 style="margin-bottom:10px;">Oops!</h1>
										<h2>Cole has crashed</h2>
										<p>Cole encountered an error it could not move past and has subsequently had to stop. Any unsaved changes may have been lost.</p>
										<p>We have sent an alert to the developers of Cole about this problem, so if there is a problem with Cole, A fix will be on the way soon.</p>
										<p>From here, You can choose what to do next. You can look at the problem yourself or move onto another module.</p>
										<pre class="ErrorTxt"></pre>

										<div class="btn-container" style="margin-top:20px;">

										<button class="btn btn-warning" href="#" onclick="$('ul.Modules li a[data-module=today]').click();"><i class="zmdi zmdi-arrow-left"></i> Back to Today</button>

										<button class="btn btn-danger" href="#" onclick="$('pre.ErrorTxt').slideToggle('fast');"><i class="zmdi zmdi-info"></i> Show Error</button>

										</div>

										


		                            </div>
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
			                        	body .content-page[data-module=error]{
				                        	background-image: url('/Cole/Images/Heros/{{ $Image }}');
				                        	background-size: cover;
			                        	}
			                        	
			                        </style>
	                            </div>
                            </div>
                            
                        </div>


                    </div> <!-- container -->
@endif