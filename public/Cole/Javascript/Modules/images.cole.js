ImageToolkit = {
	"Tweaks": {
		"blur": 0,
		"brightness": 0,
		"contrast": 0,
		"flip": null,
		"rotate": 0,
		"greyscale": null
	},
	"Meta": {}
};

var ChosenImage;

// Cole Images specific Module controls
$('body').on('click', 'div.imagesModule .ColeCancelTrigger', function() {
	var Module = $(this).parent().data('module');	
	swal({
		title: "Cancel",
		text: "Are you sure you want to return to Today? You will lose any unsaved changes.",
		type: "warning",
		showCancelButton: true,
	}).then((result) => {
		if (result.value){
			$( "ul.Modules li a[data-module=today]" ).click(); // Default to Dashboard
		}
	});	
});
$('body').on('click', 'div.imagesModule .ColeBackTrigger', function() {
	var Module = $(this).parent().data('module');	
	swal({
		title: "Cancel",
		text: "Are you sure you want to go back? You will lose any unsaved changes.",
		type: "warning",
		showCancelButton: true,
	}).then((result) => {
		if (result.value){
			$( "ul.Modules li a[data-module=images]" ).click(); // Default to Dashboard
		}
	});	
});

// Menu
$('body').on('click', 'div.imagesModule .ImagesContainer .Image .ColeResetImage', function() {
	var ImageID = $(this).parent().parent().data('id');
	console.log('Cole: Going to reset ImageID ' + ImageID);
	swal({
		title: "Reset Image",
		html: "Are you sure you want to reset this image?<br/><br/>This will remove any tweaks and metadata applied to this image.",
		type: "warning",
		showCancelButton: true,
	}).then((result) => {
		if (result.value){
			// Preform image reset
			$('body').addClass('Loading');
			$.post("/Cole/ImageToolkit/ResetImage",{
			id: ImageID,
			},function(api, status){
				if(api.Outcome=="Success"){
					swal({
						title: "Image Reset",
						text: "The image has been reset successfully.",
						type: "success",
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=images]').click();
						}
					});
				}else{
					swal({
						title: "Image Reset",
						text: "An unknown error occurred whilst resetting the image. Please try again.",
						type: "error",
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=images]').click();
						}
					});					
				}
			});
		}
	});	
});

$( "body" ).off( "click", "div.imagesModule .ImagesContainer .Image .ColeTweakImage");
$('body').on('click', 'div.imagesModule .ImagesContainer .Image .ColeTweakImage', function() {
	ChosenImage = $(this).parent().parent().find('img').attr('src');
	var ImageID = $(this).parent().parent().data('id');
	$('body').addClass('Loading');
	$('div.imagesModule .ImageTweaker img').attr('src',ChosenImage);	
	$('div.imagesModule').attr('data-image',ImageID);
	$('div.imagesModule .ColeBackTrigger').css('display', 'inline-block');
	$('div.imagesModule .ColeSaveImageTweaksTrigger').css('display', 'inline-block');	
	$('div.imagesModule .ColeCancelTrigger').hide();	
	
   	$.post("/Cole/ImageToolkit/GetTweaks", {
        ImageID: ImageID
    },
    function(api, status){
        console.log(api);
        if(api.length!=0){
	        var api = jQuery.parseJSON(api);
	        ImageToolkit.Tweaks = api;
        }
		$('.imagesModule .ImagesContainer').hide();
		$('.imagesModule .ImageTweaker').fadeIn();
		$('body').removeClass('Loading');
        
    });
	

});

// Meta controls
$( "body" ).off( "click", "div.imagesModule .ImagesContainer .Image .ColeEditImage");
$('body').on('click', 'div.imagesModule .ImagesContainer .Image .ColeEditImage', function() {
	ChosenImage = $(this).parent().parent().find('img').attr('src');
	var ImageID = $(this).parent().parent().data('id');
	$('div.imagesModule').data('image',ImageID);
	$('body').addClass('Loading');
	
	// Start loading existing meta
	$('div.imagesModule .ImageMeta img').attr('src',ChosenImage)
	$('div.imagesModule .ColeBackTrigger').css('display', 'inline-block');
	$('div.imagesModule .ColeSaveImageMetaTrigger').css('display', 'inline-block');	
	$('div.imagesModule .ColeCancelTrigger').hide();	
	
	$.post("/Cole/ImageToolkit/GetMeta",{
        ImageID: ImageID,
    },
    function(api, status){
        console.log(api);
        
        var output = '';
        
		$.each(api.Meta, function( key, value ) {
			if(value==null){
				value = '';
			}
			output += '<div class="m-t-20 form-group"><label>' + key + '</label><input class="form-control" id="' + key + '" type="text" placeholder="' + key + '" value="' + value + '" /></div>';
		});
		
		$('div.MetaFields').html(output);
		
        $('.imagesModule .ImagesContainer').hide();
		$('.imagesModule .ImageMeta').fadeIn();
		$('body').removeClass('Loading');

    });

});

$( "body" ).off( "click", "div.imagesModule .ColeSaveImageMetaTrigger");
$('body').on('click', 'div.imagesModule .ColeSaveImageMetaTrigger', function() {
	var ImageID = $('div.imagesModule').data('image');
	console.log(ImageID);
	ImageToolkit.Meta = {}; // Reset
	$( "div.imagesModule div.MetaFields input" ).each(function( index ) {
		if($(this).val().length==0){
			var value = null;
		}else{
			var value = $(this).val();
		}
		ImageToolkit.Meta[$(this).attr('id')] = value;
	});
	// Insert the ID into the Meta carry
	ImageToolkit.Meta['id'] = ImageID;
	console.log(ImageToolkit.Meta);
	
	swal({
		title: "Save Image META Data",
		html: "Are you sure you want to save these changes?",
		type: "question",
		showCancelButton: true,
	}).then((result) => {
		if (result.value) {
		    $.post("/Cole/ImageToolkit/SaveMeta",ImageToolkit.Meta,function(api, status){
		        if(api.Outcome=="Success"){
			        swal({
						title: "Image META Data",
						text: "The data was saved successfully.",
						type: "success",
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=images]').click();
						}
					});			        
		        }else{
			        swal({
						title: "Image META Data",
						text: "An unknown error occurred whilst saving the image. Please try again.",
						type: "error",
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=images]').click();
						}
					});	
		        }
		    });		
		}
	
	});
});

// Image Tweaker
$('body').on('change', 'div.imagesModule .ImageTweaker select', function() {
	ImageToolkit.Tweaks[$(this).data('control')] = $(this).val();
	$('div.imagesModule .ImageTweaker img').attr('src',ChosenImage + Cole.Modules.Images.ImageParameters());
	$('body').addClass('Loading');
	$("div.imagesModule .ImageTweaker img").one("load", function() {
	  $('body').removeClass('Loading')
	}).each(function() {
	  if(this.complete) $(this).load();
	});

});
$( "body" ).off( "click", "div.imagesModule .ImageTweaker ul.Tools li");
$('body').on('click', 'div.imagesModule .ImageTweaker ul.Tools li', function() {
	var control = $(this).data('control');
	if($(this).hasClass('Active')){
		$('div.imagesModule .ImageTweaker ul.Tools li').removeClass('Active');
		// Slide edit panel up
		Cole.Modules.Images.DestroyTweakerUI();
	}else{
		$('div.imagesModule .ImageTweaker ul.Tools li').removeClass('Active');
		$(this).addClass('Active');		
		
		Cole.Modules.Images.DestroyTweakerUI();		
		
		if(control=="brightness" || control=="contrast" || control=="blur"){
	
			noUiSlider.create(slider, {
				start: [ ImageToolkit.Tweaks[control] ],
				range: {
					'min': [ 0 ],
					'max': [ 100 ]
				}
			});
			
			slider.noUiSlider.on('change.one', function(e){
				var newvalue = Math.round(e);				
				ImageToolkit.Tweaks[control] = newvalue;
				console.log(ImageToolkit.Tweaks);		
				$('div.imagesModule .ImageTweaker img').attr('src',ChosenImage + Cole.Modules.Images.ImageParameters());
				$('body').addClass('Loading');
				$("div.imagesModule .ImageTweaker img").one("load", function() {
				  $('body').removeClass('Loading')
				}).each(function() {
				  if(this.complete) $(this).load();
				});
			});
	
		}
		
		if(control=="flip" || control=="rotate" || control=="greyscale"){
			// Dropdowns
			var output;
			
			if(control=="flip"){
				output = '<select data-control="flip" class="form-control">';
					
					output += '<option value="null">None</option>';
					output += '<option value="h">Horizontal</option>';
					output += '<option value="v">Vertical</option>';
					
				output += '</select>';
				
			}
			
			if(control=="rotate"){
				output = '<select data-control="rotate" class="form-control">';
					
					output += '<option value="null">0&deg;</option>';
					output += '<option value="90">90&deg;</option>';
					output += '<option value="180">180&deg;</option>';
					output += '<option value="270">270&deg;</option>';
					
				output += '</select>';
				
			}
			
			if(control=="greyscale"){
				output = '<select data-control="greyscale" class="form-control">';
					
					output += '<option value="null">Full colour</option>';
					output += '<option value="true">Black and White</option>';
					
				output += '</select>';
				
			}
			
			$('#slider').html(output);
		}
	}
});
Cole.Modules.Images = {
	DestroyTweakerUI: function(){
		var slider = document.getElementById('slider');
		try{
			slider.noUiSlider.destroy(); // Destroy any old instances
		}catch(e){
			console.log('Cole: Unable to destroy slider instance, Might not exist.');			
		}		
		$('#slider').html(''); // reset html
	},
	ImageParameters: function(){
		return '?' + $.param( ImageToolkit.Tweaks) + '&rand=' + Math.random();
	}
}
$('body').on('click', 'div.imagesModule .ColeSaveImageTweaksTrigger', function() {
	var ImageID = $(this).parent().parent().data('image');
	swal({
		title: "Tweak Image",
		html: "Are you sure you want to save these changes?",
		type: "question",
		showCancelButton: true,
	}).then((result) => {
		if (result.value) {
	    	$.post("/Cole/ImageToolkit/SaveTweaks",{
	        id: ImageID,
	        Tweaks: JSON.stringify(ImageToolkit.Tweaks)
	    },function(api, status){
	        if(api.Outcome=="Success"){
		        swal({
					title: "Image Tweaks",
					text: "The tweaks were saved successfully.",
					type: "success",
					showCancelButton: false,
				}).then((result) => {
					if (result.value){
						$('ul.Modules li a[data-module=images]').click();
					}
				});			        
	        }else{
		        swal({
					title: "Image Tweaks",
					text: "An unknown error occurred whilst saving the image. Please try again.",
					type: "error",
					showCancelButton: false,
				}).then((result) => {
					if (result.value){
						$('ul.Modules li a[data-module=images]').click();
					}
				});	
	        }
	    });
	    }		
	});
});