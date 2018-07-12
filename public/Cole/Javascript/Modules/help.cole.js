$('body').off('click', 'div.helpModule .ColeCancelTrigger');
$('body').on('click', 'div.helpModule .ColeCancelTrigger', function() {
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

$(function() {
	$( "div.Index div.Categories ul li" ).click(function() {
		$('div.Content div.Title h1.Left').html($(this).data('title'));
		
		var Stars = '';
		
		if($(this).data('score')>=1){
			Stars += '<i class="zmdi zmdi-star"></i>';
		}
		
		if($(this).data('score')>=2){
			Stars += '<i class="zmdi zmdi-star"></i>';
		}
		
		if($(this).data('score')==3){
			Stars += '<i class="zmdi zmdi-star"></i>';
		}
		$('div.Content div.Title h1.Right').html('<span class="Score" data-score="score' + $(this).data('score') + '">' + Stars + '</span>');
		$.get('/Cole/' + $(this).data('template') + '.html', function(data){
			$('div.Content div.Body').html(data);
		});
		$('div.Index').hide();
		$('div.Content').fadeIn('fast');
	});
});