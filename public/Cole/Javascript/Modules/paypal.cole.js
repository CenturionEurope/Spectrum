ColeArrayFormatter.paypal = function (Method,Data,MasterData) {
	console.log('Worked', MasterData);	
	if(Method=="OrderProductsArray"){
				
		PayPalItem = '<table id="datatable" class="table table-striped table-bordered">';
		PayPalItem += '<thead>';
			PayPalItem += '<tr>';
				PayPalItem += '<td><strong>Item Description</strong></td>';
				PayPalItem += '<td><strong>Item Quantity</strong></td>';
				PayPalItem += '<td><strong>Item Cost</strong></td>';
			PayPalItem += '</tr>';
		PayPalItem += '</thead>';
		PayPalItem += '<tbody>';		
		$.each( Data.Items, function( key, Item ) {
			PayPalItem += '<tr>';
				PayPalItem += '<td>' + Item.Description + '</td>';
				PayPalItem += '<td>' + Item.Quantity + '</td>';
				PayPalItem += '<td>&pound;' + Item.Cost.toFixed(2) + '</td>';				
			PayPalItem += '</tr>';
		});	
		
		PayPalItem += '<tr>';
		PayPalItem += '<td></td>';
		PayPalItem += '<td><strong>GRAND TOTAL:</strong></td>';
		PayPalItem += '<td>&pound;' + Data.GrandTotal + '</td>';
		
		PayPalItem += '</tr>';

		
		PayPalItem += '</tbody>';
		PayPalItem += '</table>';
		
		// Bump2Birthday custom
		if(Data.Photos != null){
			var ColeEmail = MasterData.Content[0].CustomerAccount;
			PayPalItem += '<p><strong>Order photos</strong></p>';
			PayPalItem += '<ul style="padding:0; margin:0 -20px;">';
			$.each( Data.Photos, function( key, Photo ) {
				
				// Get last value
				var Photo = Photo.split("/").pop(-1);
				
				PayPalItem += '<li style="display:inline-block;width:25%;padding:20px;">';
					PayPalItem += '<img src="https://bump2birthday.net/Bump2birthday/MyPhotos/' + Photo + '?ColeEmail=' + ColeEmail + '" style="width:100%;" />';				
				PayPalItem += '</li>';
			});	
			PayPalItem += '</ul>';
		}

		return PayPalItem;
	}
}