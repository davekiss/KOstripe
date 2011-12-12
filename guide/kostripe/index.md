##Example Usage

	$params = array(
		'amount' => '400', // Amount in pennies, this is equal to $4.00
		'currency' => 'usd',
		'card' => 'tok_aZ73vDCfSzXRcB', // Tokenized on client side by stripe.js
		'description' => 'Order from Angus Mugford',
	);
			
	$kostripe = Kostripe::instance();
	$result = $kostripe->charge($params);
	die(vardump($result));