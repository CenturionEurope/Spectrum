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
						@php
							$Widget->Blade = 'Cole.'.$Widget->Blade;
						@endphp
						@include($Widget->Blade)
					@endforeach
					
                   



                </div>
            </div>

        </div>

    </div>
    <!-- container -->

</div>

