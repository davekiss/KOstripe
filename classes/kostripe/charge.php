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
class Kostripe_Charge extends Kostripe {

	// Default parameters
	protected $_default = array(
		'currency' => 'usd',
	);

	/**
	 * Make a charge request.
	 *
	 * @param  array   POST parameters (amount, currency, card, description)
	 */
	public function charge(array $params = NULL)
	{
		if ($params === NULL)
		{
			throw new Kohana_Exception('You must provide all required Stripe parameters, including the amount, currency, card and description.');
		}
		else if ( ! isset($params['currency']))
		{
			$params['currency'] = $this->_default['currency'];
		}

		if ( ! isset($params['amount']))
		{
			throw new Kohana_Exception('You must provide a :param parameter.',
				array(':param' => 'Amount'));
		}
		
		if ( ! isset($params['card']))
		{
			throw new Kohana_Exception('You must provide a :param parameter.',
				array(':param' => 'Card'));
		}
		
		if ( ! isset($params['description']))
		{
			throw new Kohana_Exception('You must provide a :param parameter.',
				array(':param' => 'Description'));
		}

		return $this->_charge($params);
	}

} // End Kostripe_Charge