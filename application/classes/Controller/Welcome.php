<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This is the default controller which deserved the main page.
 */
class Controller_Welcome extends Controller
{

	/**
	 * Default action which render the main page.
	 */
	public function action_index()
	{
		$view = View::factory('smarty:App/Welcome.tpl');
		$this->response->body($view);
	}

}