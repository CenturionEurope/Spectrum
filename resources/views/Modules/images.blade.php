<div class="content">
    <div class="container">
	<pre><?php print_r($Cole);?></pre>
	<div class="TableList">
        <div class="row">
            <div class="col-sm-12">
                    <div class="card-box imagesModule" data-image="">
       					<div class="ImagesContainer">
							<h3>Tagged images</h3>
							@foreach($Cole->Module->ModuleContent->Plugin as $Image)
								<div class="col-xs-3 Image" data-id="{{ $Image->id }}">
									<img src="{{ $Image->Value }}" />
									
									<div class="button-container">
										<div class="btn btn-success ColeEditImage"><i class="zmdi zmdi-edit"></i></div>
										<div class="btn btn-info ColeTweakImage"><i class="zmdi zmdi-palette"></i></div>
										<div class="btn btn-danger ColeResetImage"><i class="zmdi zmdi-undo"></i></div>
									</div>
								</div>
							@endforeach
							

							


							@if(count($Cole->Module->ModuleContent->Plugin)==0)
								<h3>You have no tagged images on your website.</h3>
							@endif
       					</div>       					
       					<div class="ImageTweaker">       						
       						<img src="" />       						
       						<ul class="Tools">
       							<li data-control="brightness"><i class="zmdi zmdi-brightness-6"></i></li>
       							<li data-control="contrast"><i class="zmdi zmdi-exposure-alt"></i></li>
       							<li data-control="rotate"><i class="zmdi zmdi-rotate-right"></i></li>
       							<li data-control="flip"><i class="zmdi zmdi-flip"></i></li>
       							<li data-control="blur"><i class="zmdi zmdi-blur"></i></li>
       							<li data-control="greyscale"><i class="zmdi zmdi-tonality"></i></li>       							
       						</ul>
	   						<div class="SliderContainer">
								<div id="slider"></div>      
	   						</div> 						
       					</div>
       					<div class="ImageMeta">
       						<div class="col-xs-6">
       							<img src="" />
       						</div>
       						<div class="col-xs-6 MetaFields">
	       						<div class="m-t-20 form-group">
	               					<label>Width</label>
	               					<input class="form-control" id="With" type="text" placeholder="Width" value="Value" />
	           					</div>
       						</div>
       					</div>
	   					<div class="Buttons">
		   					<div class="btn btn-success ColeSaveImageTweaksTrigger"><i class="zmdi zmdi-check"></i> Save</div>
		   					<div class="btn btn-success ColeSaveImageMetaTrigger"><i class="zmdi zmdi-check"></i> Save</div>	   					
		   					<div class="btn btn-warning ColeBackTrigger"><i class="zmdi zmdi-arrow-left"></i> Back</div>	   					
	       					<div class="btn btn-warning ColeCancelTrigger"><i class="zmdi zmdi-close"></i> Back to Today</div>
	   					</div>
                    </div>
            </div><!-- end col -->
        </div>
	</div>
</div> <!-- container -->