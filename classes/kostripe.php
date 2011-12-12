<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Stripe implementation for Kohana.
 *
 * @package    Kostripe
 * @category   Base
 * @author     Dave Kiss <iamdavekiss@gmail.com>
 * @copyright  (c) 2011 Dave Kiss
 * @license    MIT
 */
abstract class Kostripe {
	
	const VERSION = '0.0.9';
			
	/**
	 * @var  object  Kostripe instance
	 */
	protected static $_instance;

	/**
	 * Creates a Kostripe instance.
	 *
	 * @return  object  Kostripe object
	 */
	public static function instance()
	{
		if ( ! Kostripe::$_instance)
		{
			// Load stripe configuration, make sure minimum defaults are set
			$config = Kohana::config('kostripe');	

			// Create the Stripe instance
			Kostripe::$_instance = new Kostripe_Charge($config['environment'] == 'live' ? $config['live_key'] : $config['test_key']);
		}
		
		return Kostripe::$_instance;
		
	}
	
	// Stripe API Key
	protected $_stripe_key;
	
	/**
	 * Creates a new Stripe instance for the given API key.
	 *
	 * @param   string  API key
	 * @return  void
	 */
	public function __construct($stripe_key)
	{
		// Set the API username and password
		$this->_stripe_key = $stripe_key;
		Stripe::setApiKey($this->_stripe_key);
		Stripe::setVerifySslCerts(false);
	}
	
	/**
	 * Makes a POST request to Stripe with the given parameters.
	 *
	 * @see  https://stripe.com/docs/api
	 *
	 * @throws  Kohana_Exception
	 * @param   array   POST parameters (amount, currency, card, description)
	 * @return  array
	 */
	protected function _charge(array $params)
	{
			
		// create the charge on Stripe's servers - this will charge the user's card
		$charge = Stripe_Charge::create($params);
		
		
		if ($charge === FALSE)
		{
			echo 'error!<hr>';
			// Get the error code and message
			echo '<pre>';print_r($charge);echo '</pre>';die;

			throw new Kohana_Exception('Stripe API request failed: :error (:code)',
				array(':error' => 'my error message', ':code' => 'my error code number'));
		}

		return $charge;
	}

} // End Kostripe