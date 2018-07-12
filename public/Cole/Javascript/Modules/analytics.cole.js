
var Analytics = $.parseJSON($('div#ColeGraphGen').html());
var data = [];


$.each( Analytics, function( key, value ) {
    var date = value.date.date;
    date = date.split('.');
    date = date[0];
    date = date.split(' ');
    date = date[0]; 
    var date = date.split("-").reverse().join("/");
    data.push({ y: date, a: value.visitors, b: value.pageViews});
  });

var  config = {
    data: data,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Visitors', 'Page Views'],
    fillOpacity: 0.6,
    hideHover: 'auto',
    behaveLikeLine: true,
    resize: true,
    pointSize: 0,
    lineColors:['#25c36c','#248cdf'],
    axes : 'y'
};

config.element = 'morris-line-example';
Morris.Line(config);

$('body').off('click', 'div.analyticsModule .ColeCancelTrigger');
$('body').on('click', 'div.analyticsModule .ColeCancelTrigger', function() {
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