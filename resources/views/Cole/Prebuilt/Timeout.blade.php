<script type="text/javascript">
	var Timeout = {{ $Cole->Settings->Timeout }};
	var TimeoutTotal = {{ $Cole->Settings->Timeout }};
	
	setInterval(function(){
		if(Timeout==0){
			$('body').addClass('Loading');
			$.get("/ColeAccounts/Logout", function(api, status){
				location.reload();
			});
		}else{
			Timeout = Timeout - 1;
			var percentage = 100 - (Timeout / TimeoutTotal) * 100;
			if(percentage>=35){
				$('div.topbar,div.left.side-menu,div.content-page,footer').fadeOut(5000);
			}
		}
	}, 1000);
	
	$(function() {
	    console.log( "Cole: Idle timeout initialised" );
		$('body').mousemove(function(event) {
			Timeout = TimeoutTotal; // reset the countdown
			$('div.topbar,div.left.side-menu,div.content-page,footer').fadeIn('fast');
		});
	});	
</script>