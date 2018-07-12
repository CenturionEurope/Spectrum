<div class="content">
    <div class="container">
        <pre><?php print_r($Cole);?></pre>
        <div class="row">

            <div class="col-xs-12">
                <div class="Today">

                	<!-- Crucial bits -->
                	<div class="Vitals">
                		<div class="col-xs-12">
							<h1>Good <?php if(date('H')<=11){echo 'Morning';}elseif(date('H')<=16){echo 'Afternoon';}else{echo 'Evening';} ?>, {{$Cole->User->FullName}}.</h1>
							@if($Cole->Notifications->Count==0)
								<h2>You have no unread notifications.</h2>
							@else
							<h2>You have {{ $Cole->Notifications->Count }} unread notifications.</h2>
							@endif
                		</div>
                	</div>

					@foreach($Cole->Module->Widgets as $Widget)
						@include($Widget->Blade)
					@endforeach
					
                   



                </div>
            </div>

        </div>

    </div>
    <!-- container -->

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
	body .content-page[data-module=today]{
		background-image: url('/Cole/Images/Heros/{{ $Image }}');
		background-size: cover;
	}

	</style>
