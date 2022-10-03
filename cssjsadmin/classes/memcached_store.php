<?
define('MEMCACHED_SERVER', '192.168.1.142');
define('MEMCACHED_PORT', '11211');
//Class memcached
class memcached_store{
	var $memcache;
	var $connect_successful = false;
	
	//Khởi tạo hàm
	function memcached_store(){
		//Nếu MEMCACHED_SERVER là none thì return luôn
		if (MEMCACHED_SERVER == "none" || $_SERVER['SERVER_NAME'] == "localhost"){
			return;
		}
		
		$this->memcache = new Memcache;
		
		//Bẻ ra nhiều server
		$array_memcached = explode(",", MEMCACHED_SERVER);
		
		//Loop để add memcached server
		foreach ($array_memcached as $m_key => $m_value){
			$link_connect = @$this->memcache->addServer(trim($m_value), MEMCACHED_PORT, true);
		}
		
		//Nếu kết nối thành công thì cho biến connect_successful là true
		if ($link_connect){
			$this->connect_successful = true;
		}
	}
	
	//get key
	function get($key){
		if ($this->connect_successful) return @$this->memcache->get($key);
		else return NULL;
	}	

	//set key, value, mặc định timeout là 3600s (1h)
	function set($key, $value, $timeout = 30){
		if ($this->connect_successful) return @$this->memcache->set($key, $value, 0, $timeout);
		else return NULL;
	}
	//set key, value, mặc định timeout là 3600s (1h)
	function delete($key){
		//Bẻ ra nhiều server
		$array_memcached = explode(",", MEMCACHED_SERVER);
		
		//Loop để add memcached server
		foreach ($array_memcached as $m_key => $m_value){
			$memcache = new Memcache;
			$link_connect = $memcache->addServer(trim($m_value), MEMCACHED_PORT, false);
			if ($link_connect){
				$memcache->delete($key);
				$memcache->close();	
			} 
			unset($memcache);
		}
	}

	//get getStats
	function getExtendedStats(){
		if ($this->connect_successful) return $this->memcache->getExtendedStats();
		else return NULL;
	}	


}
?>