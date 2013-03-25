<?php

class MY_Model extends CI_Model{
	
	public $primary = 'id';
	public $table = NULL;
	public $db = NULL;
	public $db_group = 'default';
	
	public function __construct($table = FALSE, $db_group = 'default')
	{
		parent::__construct();
		
		$class = get_class($this);
		
		if ($class != 'MY_Model' && $class != 'Default_model')
		{
			$this->init($table, $db_group);
		}
	}
	
	public function init($table = FALSE, $db_group = 'default')
	{
		if ($db_group !== FALSE)
		{
			$this->db_group = $db_group;
		}
		
		if ($table)
		{
			$this->table = $table;
		}
		else
		{
			$this->table = $this->_get_table_name();
		}
		
		$this->_connect();
	}
	

	/**
	 * Fetch a record by primary key.
	 * 
	 * @access public
	 * @param mixed $id
	 * @return object Database Result Resource
	 */
	public function get($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($this->primary, $id);
		$this->db->limit(1);
		return $this->db->get();
	}
	
	/**
	 * Fetch records by a column with optional order and limit.
	 * 
	 * @access public
	 * @param mixed $column
	 * @param mixed $value (default: NULL)
	 * @param mixed $order_by (default: FALSE)
	 * @param mixed $limit (default: FALSE)
	 * @return object Database Result Resource
	 */
	public function get_by($column, $value = NULL, $order_by = FALSE, $limit = FALSE)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		
		if (is_array($column))
		{
			$this->db->where($column);	
		}
		else
		{
			$this->db->where($column, $value);	
		}

		if ($order_by)
		{
			$this->db->order_by($order_by);
		}
		
		if ($limit)
		{
			$this->db->limit($limit);
		}
		
		return $this->db->get();
	}


	/**
	 * Get all records from a table with optional order and limit.
	 * 
	 * @access public
	 * @param mixed $order_by (default: FALSE)
	 * @param mixed $limit (default: FALSE)
	 * @return object Database Result Resource
	 */
	public function get_all($order_by = FALSE, $limit = FALSE)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		
		if ($order_by)
		{
			$this->db->order_by($order_by);
		}
		
		if ($limit)
		{
			$this->db->limit($limit);
		}
		
		return $this->db->get();
	}

		
	/**
	 * Insert data into the table.
	 * 
	 * @access public
	 * @param mixed $data May be object or array
	 * @return object Database Result Resource
	 */
	public function insert($data)
	{
		$success = $this->db->insert($this->table, $data);
	
		if ($success === TRUE)
		{
			$id = $this->db->insert_id();
			return $this->get($id);
		}
		else
		{
			return FALSE;
		}
	}

		
	/**
	 * Update a record by primary key.
	 * 
	 * @access public
	 * @param mixed $data
	 * @param mixed $id (default: FALSE)
	 * @return object Database Result Resource
	 */
	public function update($data, $id = FALSE)
	{
		if (!is_array($data))
		{
			$data = (array) $data; // Cast to an array.
		}

		// Primary key was part of data		
		if (array_key_exists($this->primary, $data))
		{
			// Get the primary key
			$id = $data[$this->primary];
			unset($data[$this->primary]);
		}

		if ($id)
		{
			$this->db->where($this->primary, $id);

			$success = $this->db->update($this->table, $data);

			if ($success == TRUE)
			{
				return $this->get($id);
			}
			else
			{
				return FALSE; // There was an error.
			}
		}
		else
		{
			return FALSE; // Only allow update by primary key.			
		}
	}


	/**
	 * Delete a record by primary key.
	 * 
	 * @access public
	 * @param mixed $id
	 * @return object Database Result Resource
	 */
	public function delete($id)
	{
		$this->db->where($this->primary, $id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}


	/**
	 * Run any SQL you want,  If using parameter binding, 2nd arg should be array of replacement values.
	 * 
	 * @access public
	 * @param mixed $sql
	 * @param mixed $params (default: NULL)
	 * @return void
	 */
	public function query($sql, $params = NULL)
	{
		return $this->db->query($sql, $params);
	}

	public function get_last_query()
	{
		return $this->db->last_query();
	}

	
	/**
	 * Get information about last error message.
	 * 
	 * @access public
	 * @return error detail object
	 */
	public function get_last_error()
	{
		$error = new stdclass();
		$error->number = $this->db->_error_number();
		$error->message = $this->db->_error_message();
		$error->query = $this->db->last_query();

		return $error;
	}
	
	
	/**
	 * Provides the get_by_* feature.
	 * Determines the column being searched based on method name called, and passes to get_by() method.
	 * 
	 * @access public
	 * @param mixed $name
	 * @param mixed $args
	 * @return object Database Result Resource
	 */
	public function __call($name, $args)
	{
		if (preg_match('/get_by_/', $name))
		{
			$column = str_replace('get_by_', '', $name);

			$value = $args[0];
			$order_by = count($args) >= 2 ? $args[1] : FALSE;
			$limit = count($args) >= 3 ? $args[2] : FALSE;
			
			return $this->get_by($column, $value, $order_by, $limit);
		}	
	}
	
	/**
	 * Determines table name based on class name.
	 * 
	 * @access protected
	 * @return string table name
	 */
	protected function _get_table_name()
	{
		$this->load->helper('inflector');
		
		$class = get_class($this);
		return plural(strtolower(substr($class, 0, strpos($class, '_'))));
	}
	
	protected function _connect()
	{
		$this->config->load('application');
		
		$dsn_config = $this->db_group . '_dsn';
		
		$dsn = $this->config->item($dsn_config);
		
		if (!$dsn)
		{
			show_error(sprintf('Database config %s is not defined.', $dsn_config));
		}
		
		$this->db = $this->load->database($dsn, TRUE);
	}
}