<?
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_init
 * Class khoi tao ket noi database
 */
class db_init
{
	/** Ten Server */
	var $server;
	/** Ten User */
	var $username;
	/** Mat khau */
	var $passworddb;
	/** Ten CSDL */
	var $database;
	var $cookie_server = '';
	//khai báo max cho phép error connect  tầm 15k
	var $max_error_slave_size = 60000;
	//khai báo đường dẫn lưu các file log lỗi
	var $ipstore_dir = "";
	//khai báo đường dẫn lưu các file log lỗi slave
	var $ipdberror_dir = "";
	/*********************************************************************************************************/
	/**
	 * db_init::db_init()
	 * Ham khoi tao class
	 * @return
	 */
	function db_init()
	{

		//khai báo path lưu log
		$this->ipstore_dir = str_replace("classes", "ipstore", dirname(__file__)) . "/";
		$this->ipdberror_dir = str_replace("classes", "ipdberror", dirname(__file__)) . "/";

		// Khai bao Server localhost day
		$this->server = "localhost";
		$this->username = "root";
		$this->database = "giasu";
		//$this->database					= "myad_1";
		$this->passworddb = '';

		//Khai báo slave server
		$this->slave_username = $this->username;
		$this->slave_password = $this->passworddb;
		$this->slave_server = $this->getSlaveServer($this->server);

		if ($_SERVER['SERVER_NAME'] == 'localhost')
		{
			$this->cookie_server = '/'; //cau hinh server luu cookie
			$this->slave_server = "localhost";
		} else
		{
			$this->cookie_server = 'ad.vatgia.com'; //cau hinh server luu cookie
		}
	}

	/**
	 * Hàm lấy thông tin server slave
	 */
	function getSlaveServer($default_server = "192.168.1.124")
	{

		//Nếu đã có server trong Const rồi thì return luôn, trường hợp khi khai báo sử dụng 1 ip slave
		if (defined("SLAVE_SERVER_IP"))
			return SLAVE_SERVER_IP;

		//khai báo array chứa các ip slave và đặt trọng số cho từng ip đó để xác định mức chịu tải cho từng slave
		$array_server = array(
			"192.168.1.155" => 3,
			"192.168.1.143" => 1,
			);

		//Loop array để tạo array mới, dàn đều weight thành những phần tử để lấy random
		$total_weight = 0;
		$new_array_server = array();

		//Disable Server
		$disable_ip = "";

		//loop các
		foreach ($array_server as $m_key => $m_value)
		{
			//Nếu server khác server disable và file error nhỏ hơn max_error_slave_size
			if ($m_key != $disable_ip && intval(@filesize($this->ipdberror_dir . "/" . $m_key . "_error.cfn")) < $this->
				max_error_slave_size)
			{
				for ($i = 0; $i < $m_value; $i++)
				{
					$total_weight++;
					$new_array_server[$total_weight] = $m_key;
				} //end for
			} //end ìf
		} // foreach ($array_server as $m_key => $m_value)

		//Nếu ko có server nào thì trả về server default
		if ($total_weight < 1)
			return $default_server;

		//Bắt đầu lấy random
		$my_slave_server = rand(1, $total_weight);

		//Trả về server
		if (isset($new_array_server[$my_slave_server]))
		{
			//Nếu chưa có Const SLAVE_SERVER_IP thì gán bằng const
			if (!defined("SLAVE_SERVER_IP"))
				define("SLAVE_SERVER_IP", $new_array_server[$my_slave_server]);
			return $new_array_server[$my_slave_server];
		} else
		{
			return $default_server;
		}

	}

	/*********************************************************************************************************/
	/**
	 * db_init::log()
	 * Ham ghi log
	 * @param mixed $filename : ten file log
	 * @param mixed $content  : noi dung log
	 * @return
	 */
	function log($filename, $content)
	{

		//$log_path     =   $_SERVER["DOCUMENT_ROOT"] . "/ipstore/";
		$handle = @fopen($filename, "a");
		//Neu handle chua co mo thêm ../
		if (!$handle)
			$handle = @fopen($filename, "a");
		//Neu ko mo dc lan 2 thi exit luon
		if (!$handle)
			exit();
		fwrite($handle, gmdate("d/m/Y h:i:s A") . " " . $content . " " . @$_SERVER["REQUEST_URI"] . "\n");
		fclose($handle);

	}

	/*********************************************************************************************************/
	/**
	 * db_init::debug_query()
	 * Ham print query vào 1 file log de kiem tra loi
	 * @param string $query : cau query
	 * @param string $file_line_query : noi dung loi
	 * @return
	 */
	function debug_query($query, $file_line_query)
	{
		//neu localhost thi luon save query vào file con de kiem tra
		if (@$_SERVER["SERVER_ADDR"] == "127.0.0.1")
		{
			$this->log($this->ipstore_dir . "query.cfn", $file_line_query . " \n " . $query);
		}

	}

	/*********************************************************************************************************/
	/**
	 * db_init::__destruct()
	 * Ham huy tu dong chay khi unset class
	 * @return
	 */
	function __destruct()
	{
		unset($this->server);
		unset($this->username);
		unset($this->passworddb);
		unset($this->database);
	}

}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_query
 * Class thuc hien 1 truy van
 */
class db_query
{
	/** Ket qua cua cau truy van */
	var $result;
	/** ket noi */
	var $links;
	/** Thoi gian nhieu nhat 1 cau query duoc thuc hien */
	var $time_slow_log = 0.5; //
	//biến lưu query
	var $query;

	protected $use_slave;

	/*********************************************************************************************************/
	/**
	 * db_query::db_query()
	 *
	 * @param mixed $query : cau truy van
	 * @param string $file_line_query : loi se ghi
	 * @param string $use_slave (mặc định là rỗng) : Có sử dụng slave hay ko
	 * @return
	 */
	function db_query($query, $file_line_query = "", $use_slave = "")
	{
		$start_time = microtime_float();
		$this->query = $query;
		$this->use_slave = $use_slave;
		$dbinit = new db_init();
		$connect_successful = false;

		//Nếu use_slave
		/*
		if ( $use_slave == "USE_SLAVE" ){
		//Đối với slave thường là localhost nên sử dụng mysql_connect
		if ($this->links = @mysql_pconnect($dbinit->slave_server, $dbinit->slave_username, $dbinit->slave_password)){
		$connect_successful = true;
		}
		//Save log error slave
		else{

		$str         = "SLAVE: IP:" . $_SERVER['REMOTE_ADDR'] . " Not connect DB: host: " . $dbinit->slave_server . ", User : " . $dbinit->slave_username . " error: " . @mysql_error();
		$dbinit->log($dbinit->ipdberror_dir . $dbinit->slave_server . "_error.cfn", $str);
		}
		}
		*/

		//Kiểm tra connection với Master Database
		if (!$connect_successful)
		{
			//Khai bao connect
			$this->links = @mysql_pconnect($dbinit->server, $dbinit->username, $dbinit->passworddb);
			//Neu khong ket noi duoc
			if (!$this->links)
			{
				//ghi ra log loi query
				$str = "IP:" . $_SERVER['REMOTE_ADDR'] . " Not connect DB: host: " . $dbinit->server . ", User : " . $dbinit->username .
					" error: " . @mysql_error();
				$dbinit->log($dbinit->ipdberror_dir . $dbinit->server . "_error.cfn", $str);
				exit();
			}

		} // if (!$connect_successful)

		if (!$db_select = @mysql_select_db($dbinit->database, $this->links))
		{
			$dbinit->log($dbinit->ipstore_dir . "error_sql.cfn", "Cannot select database: " . $dbinit->database);
			exit();
		}
		@mysql_query("SET NAMES 'utf8'");
		$time_start = $this->microtime_float();
		$this->result = @mysql_query($query, $this->links);

		$time_end = $this->microtime_float();
		$time = $time_end - $time_start;
		//neu thoi gian thuc hien query lon hon hoac bang 0.05 thi ghi log lai.

		if ($time >= $this->time_slow_log)
		{

			//Ghi log o file
			$str = "File : " . $file_line_query . "\n";
			$str .= "Query time : " . number_format($time, 10, ".", ",") . "\n";
			$str .= "IP:" . $_SERVER['REMOTE_ADDR'] . $query . chr(13);
			$dbinit->log($dbinit->ipstore_dir . "slow_sql.cfn", $str);

		}

		//Neu query ko co ket qua -> dump log
		if (!$this->result)
		{

			$error = @mysql_error($this->links);
			@mysql_close($this->links);
			$dbinit->log($dbinit->ipstore_dir . "error_sql.cfn", $error . "\n" . $query);
			die($error . ": " . $query);
		}

		//ghi query ra log de kiem tra
		$dbinit->debug_query($query, $file_line_query);
		unset($dbinit);

      $end_tine = microtime_float();
		if (class_exists('MySQLStore'))
		{
			$backtrace = debug_backtrace();
			//Log query
			MySQLStore::$query[] = array(
				'query' => $query,
				'time' => $end_tine - $start_time,
				'module' => module()->name,
				'backtrace' => $backtrace);
         MySQLStore::$query_time += $end_tine - $start_time;
		}


	} //end function

	/*********************************************************************************************************/
	/**
	 * db_query::resultArray()
	 * Ham lay ket qua
	 * @return array $arrayReturn : Mang
	 */
	function result_array($field_id = "")
	{
		$arrayReturn = array();
		while ($row = mysql_fetch_assoc($this->result))
		{
			if ($field_id != "")
			{
				$arrayReturn[$row[$field_id]] = $row;
			} else
			{
				$arrayReturn[] = $row;
			}

		}
		return $arrayReturn;
	}

	/*********************************************************************************************************/
	/**
	 * db_query::close()
	 * Ham dong ket noi
	 * @return
	 */
	function close()
	{
		@mysql_free_result($this->result);
		if ($this->links)
		{
			@mysql_close($this->links);
		}
	}

	/*********************************************************************************************************/
	/**
	 * db_query::microtime_float()
	 * Ham tinh thoi gian(miligiay)
	 * @return float $return
	 */
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
}
//End class db_query

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_execute
 * Class thuc thi 1 query
 */
class db_execute
{
	/** ket noi */
	var $links;
	/** so dong bi anh huong */
	var $total = 0;
	var $query;

	/*********************************************************************************************************/
	/**
	 * db_execute::db_execute()
	 * Thuc hien 1 cau query
	 * @param mixed $query : Cau query
	 * @param string $file_line_query : Ghi loi
	 * @return
	 */
	function db_execute($query, $file_line_query = "")
	{
		$start_time = microtime_float();
		$this->query = $query;
		$dbinit = new db_init();
		$this->links = @mysql_pconnect($dbinit->server, $dbinit->username, $dbinit->passworddb);
		@mysql_select_db($dbinit->database);
		@mysql_query("SET NAMES 'utf8'");
		@mysql_query($query);
		//kiem tra thanh cong hay chua
		$this->total = @mysql_affected_rows();

		//neu ket qua query thuc thi khong thanh cong tru truong hop insert ignore
		if ($this->total < 0 && strpos($query, "IGNORE") === false)
		{
			$error = @mysql_error($this->links);
			@mysql_close($this->links);
			//ghi log
			$dbinit->log($dbinit->ipstore_dir . "error_sql.cfn", $file_line_query . " " . $error . "\n" . $query);
		}
		@mysql_close($this->links);

		//ghi query ra log de kiem tra
		$dbinit->debug_query($query, $file_line_query);
		unset($dbinit);

      $end_tine = microtime_float();
		if (class_exists('MySQLStore'))
		{
			$backtrace = debug_backtrace();
			//Log query
			MySQLStore::$query[] = array(
				'query' => $query,
				'time' => $end_tine - $start_time,
				'module' => module()->name,
				'backtrace' => $backtrace);
		}

	}
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_count
 * Class dem so ket qua cua cau query
 */
class db_count
{
	/** so luong ket qua */
	var $total;

	/*********************************************************************************************************/
	/**
	 * db_count::db_count()
	 *
	 * @param string $sql : Cau lenh sql
	 * @return int so ket qua
	 */
	function db_count($sql)
	{
		$db_ex = new db_query($sql);

		if ($row = mysql_fetch_assoc($db_ex->result))
		{
			$this->total = intval($row["count"]);
		} else
		{
			$this->total = 0;
		}
		$db_ex->close();
		unset($db_ex);

		return $this->total;
	}
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_execute_return
 * Class thuc hien 1 cau query,co tra ve ket qua la id cuoi cung dc insert.
 */
class db_execute_return
{
	/** ket noi*/
	var $links;
	/** ket qua*/
	var $result;
	var $query;

	/*********************************************************************************************************/
	/**
	 * db_execute_return::db_execute()
	 *
	 * @param string $query : cau truy van
	 * @param string $file_line_query : Loi se ghi
	 * @return int :ID duoc them vao cuoi cung.
	 */
	function db_execute($query, $file_line_query = "")
	{
	  $start_time = microtime_float();
		$this->query = $query;
		$dbinit = new db_init();
		$this->links = @mysql_pconnect($dbinit->server, $dbinit->username, $dbinit->passworddb);
		@mysql_select_db($dbinit->database);

		@mysql_query("SET NAMES 'utf8'");
		@mysql_query($query);

		$total = @mysql_affected_rows();

		//neu ket qua khong thanh cong và khong phai là insert ignore
		if ($total < 0 && strpos($query, "IGNORE") === false)
		{

			$error = @mysql_error($this->links);
			@mysql_close($this->links);

			$dbinit->log($dbinit->ipstore_dir . "error_sql.cfn", $file_line_query . " " . $error . "\n" . $query);
		}

		$last_id = 0;
		$this->result = @mysql_query("select LAST_INSERT_ID() as last_id", $this->links);

		if ($row = @mysql_fetch_array($this->result))
		{
			$last_id = $row["last_id"];
		}

		@mysql_close($this->links);

		//ghi query ra log de kiem tra
		$dbinit->debug_query($query, $file_line_query);
		//huy bien
		unset($dbinit);
      $end_tine = microtime_float();
		if (class_exists('MySQLStore'))
		{
			$backtrace = debug_backtrace();
			//Log query
			MySQLStore::$query[] = array(
				'query' => $query,
				'time' => $end_tine - $start_time,
				'module' => module()->name,
				'backtrace' => $backtrace);
		}
		return $last_id;
	}
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
?>