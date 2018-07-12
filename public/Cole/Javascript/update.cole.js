var TopPayload = null;

$(function() {
	Cole.Modules.Update.PayloadCatchup();
});

Cole.Modules.Update = {
	PayloadCatchup: function(){
		$.get("/api/payload/catchup", function(api, status){
			if(api.Outcome=="Success"){
				if (TopPayload == null){
					TopPayload = api.TopPayload;
				}
				if(api.PayloadStatus=="Installed"){
					var Progress = (api.CurrentPayload * 100) / TopPayload;
					$('.progress-bar').css('width',Progress.toString() + '%');
					Cole.Modules.Update.PayloadCatchup(); // Test for next catchup
				}else if(api.PayloadStatus=="UptoDate"){
					$('.progress-bar').css('width','100%');
					setTimeout(function(){
						document.location = '/';
					}, 1500);
				}
			}
		});
	}
};