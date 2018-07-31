 <div class="col-lg-3 col-md-6">
		<div class="card-box widget">

			<h4 class="header-title m-t-0 m-b-30">{{ $Widget->Title }}</h4>

         <div class="widget-box-2">
             <div class="widget-detail-2">
                 <h2 class="m-b-0"> {{ $Widget->Content->Free }} </h2>
                 <p class="text-muted m-b-25">Free Space</p>
             </div>
             <div class="progress progress-bar-{{ $Widget->Content->Class }}-alt progress-sm m-b-0">
                 <div class="progress-bar progress-bar-{{ $Widget->Content->Class }}" role="progressbar"
                      aria-valuenow="{{ $Widget->Content->Percentage }}" aria-valuemin="0" aria-valuemax="100"
                      style="width: {{ $Widget->Content->Percentage }}%;">
                     <span class="sr-only">{{ $Widget->Content->Percentage }}% Complete</span>
                 </div>
             </div>
         </div>
		</div>
 </div><!-- end col -->