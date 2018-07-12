$(function() {
	
});


// Cole Settings specific Module controls
$('body').on('click', 'div.settingsModule .ColeCancelTrigger', function() {
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

$('body').on('click', 'div.settingsModule .ColeSaveTrigger', function() {
	swal({
		title: "Save Changes",
		text: "Are you sure you want to save your settings?",
		type: "question",
		showCancelButton: true,
	}).then((result) => {
		if (result.value){
			// Package fields
			var Fields = {};
			
			$( ".settingsModule .form-group input" ).each(function() {
				var Key = $(this).attr('id');
				var Value = $(this).val();
				Fields[Key] = Value;
			});
	
			console.log('Cole: Packaged Settings - ',Fields);
	
			
			$.post("/Cole/Settings/Publish",Fields,
		    function(api, status){
			    console.log(api);
			    if(api.Outcome=="Success"){
					swal({
						title: "Settings Saved",
						text: "Your settings have been saved successfully.",
						type: "success",
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=settings]').click();
						}
					});   
			    }else{
					swal({
						title: "Cole",
						text: api.Reason,
						type: "error",
						showCancelButton: false,
					});				    
			    }    
			});
			
		}
	});
});