<?php namespace Rosswilson252\Html;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Html\TableBuilder
 */
class TableFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'table'; }

}