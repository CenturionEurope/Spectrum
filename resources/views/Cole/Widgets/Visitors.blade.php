<div class="col-lg-3 col-md-6">
	<div class="card-box widget">
		<h4 class="header-title m-t-0 m-b-30">{{ $Widget->Title }}</h4>		
		<div class="widget-box-2">
			<div class="widget-detail-2">
				@isset($_ENV['ANALYTICS_VIEW_ID'])
					<h2 class="m-b-0">{{ number_format($Widget->Content->Visitors) }}</h2>
					<p class="text-muted m-b-25">Visitors in the last 30 days</p>
				@else
					<p>Analytics has not been setup. Please refer to the <a href="https://github.com/genericmilk/Cole/wiki/Analytics" target="_blank">Analytics Wiki</a> for installation instructions.</p>
				@endisset
			</div>
		</div>
	</div>
</div><!-- end col -->