<?php defined('SYSPATH') or die('No direct script access.');

class Model_App_Token extends Model
{

	/**
	 * Timestamp of creation
	 */
	public $date_created;

	/**
	 * Is the token permanent ?
	 */
	public $is_permanent;

	/**
	 * Id of the concerned object
	 */
	public $target_id;

	/**
	 * Model type of the target
	 */
	public $target_type;

	/**
	 * Reserved values to not return
	 */
	protected $_reserved = array();

	/**
	 * Format values
	 *
	 * @param {array} $data
	 * @return {array}
	 */
	public function format_data ( array $data )
	{
		// This is the current time
		$timestamp = time();

		// Set creation time
		if (!$this->date_created)
			$data['date_created'] = $timestamp;

		if (!isset($data['is_permanent']))
			$data['is_permanent'] = false;

		return $data;
	}

	/**
	 * Determine if this token is still valid
	 *
	 * @return {boolean}
	 */
	public function is_valid ()
	{
		if (!$this->loaded())
			return FALSE;

		// Get the expiration time
		$expiration_time = Kohana::$config->load('app.token_expiration');

		// This is the current time
		$timestamp = time();

		return $this->is_permanent || $this->date_created + $expiration_time > $timestamp;
	}

	/**
	 * Get loaded data
	 *
	 * @return {array}
	 */
	public function get_data ()
	{
		if (!$this->loaded())
			return array();

		return array(
			'id' => $this->id(),
			'date_created' => $this->date_created,
			'is_permanent' => $this->permanent,
			'target_id' => $this->target_id,
			'target_type' => $this->target_type
		);
	}

	/**
	 * Search by target id
	 *
	 * @param {string} $id
	 * @param {boolean} $only_permanent
	 * @param {boolean} $only_temporary
	 * @return {array}
	 */
	public function search_by_target ( $id, $only_permanent = false, $only_temporary = false )
	{
		$collection = new Mongo_Collection('App_Token');

		// Build the query
		$query = array('target_id' => $id);

		// If we want only permanent tokens or not
		if ($only_permanent)
			$query['is_permanent'] = true;

		// If wen want only temporary token
		if ($only_temporary)
			$query['is_permanent'] = false;

		return $collection->find($query);
	}

	/**
	 * Set data
	 *
	 * @param {array} $data
	 * @param {boolean} $format
	 */
	public function set_data ( array $data, $format = true )
	{
		if ($format)
		{
			$data = $this->format_data($data);
		}

		return $this->values($data);
	}

}
