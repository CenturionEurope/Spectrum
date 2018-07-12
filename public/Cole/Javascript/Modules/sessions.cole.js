ColeArrayFormatter.sessions = function (Method,Data,MasterData) {
	console.log('Worked', Data);	
	if(Method=="RemainingBalance"){
				Data = Data[0];
				PayPalItem = '<p>&pound;' + Data.Cost.toFixed(2) + '</p>';
		

		return PayPalItem;
	}
}