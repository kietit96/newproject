<?php 

/**
* Search Advanced written by Quy (fb/GTFAF)
* @author Quy <yungbloodx02@gmail.com>
*/
class Search
{

	/**
	 * It copied from instance request
	 * @var array
	 */
	protected $request;

	/**
	 * Query language MYSQL
	 * @var string
	 */
	public $query;

	/**
	 * Fillable Columns
	 * @var array
	 */
	protected $fillable;

	/**
	 * @param array $Request It should be search[type][column][] params
	 * @param string $table      name of table
	 * @param array $table      array fill to search column
	 * @param string $getColumns specific column to get, like 'title, comment, body ... *'
	 */
	function __construct($Request, $table, $fillable, $getColumns = '*')
	{
		$this->request = $Request;
		$this->query = "SELECT $getColumns FROM $table WHERE 1 ";
		$this->fillable = $fillable;
		$this->switchCase();		
	}

	/**
	 * This function switch type to query
	 * @return void 
	 */
	protected function switchCase()
	{
		foreach ($this->request as $type => $column) {
			if (! method_exists($this, 'TYPE_' . $type)) 
					continue;

			foreach ($column as $col => $data) {
				if (in_array($col, $this->fillable) && count($data)) {
					$data = array_filter($data); //Fill null value

					$this->query .= " AND (";
					$this->{'TYPE_' . $type}($col, $data);
					$this->query .= ")";
				}
			}
		}
	}

	/**
	 * equal type
	 * @param  array $columnAndData ($col => $data)
	 */
	protected function TYPE_equal($column, $data)
	{
		foreach ($data as $key => $value) {
			$this->query .= "`$column` = '$value'";
			if (count($data) != $key + 1) $this->query .= " AND ";
		}
	}

	/**
	 * equal type
	 * @param  array $columnAndData ($col => $data)
	 */
	protected function TYPE_notequal($column, $data)
	{		
		foreach ($data as $key => $value) {
			$this->query .= "`$column` != '$value'";
			if (count($data) != $key + 1) $this->query .= " AND ";
		}
	}

	/**
	 * equal type
	 * @param  array $columnAndData ($col => $data)
	 */
	protected function TYPE_like($column, $data)
	{
		foreach ($data as $key => $value) {
			$this->query .= "`$column` LIKE '%$value%'";
			if (count($data) != $key + 1) $this->query .= " AND ";
		}
	}

	/**
	 * equal type
	 * @param  array $columnAndData ($col => $data)
	 */
	protected function TYPE_likeor($column, $data)
	{
		foreach ($data as $key => $value) {
			$this->query .= "`$column` LIKE '%$value%'";
			if (count($data) != $key + 1) $this->query .= " OR ";
		}
	}

	/**
	 * equal type
	 * @param  array $columnAndData ($col => $data)
	 */
	protected function TYPE_greaterthan($column, $data)
	{
		foreach ($data as $key => $value) {
			$this->query .= "`$column` > '$value'";
			if (count($data) != $key + 1) $this->query .= " AND ";
		}
	}

	/**
	 * equal type
	 * @param  array $columnAndData ($col => $data)
	 */
	protected function TYPE_lessthan($column, $data)
	{
		foreach ($data as $key => $value) {
			$this->query .= "`$column` < '$value'";
			if (count($data) != $key + 1) $this->query .= " AND ";
		}
	}

}