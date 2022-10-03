<?
//Tao ra cau query de search
class generate_quicksearch{
	var $keyword;
	var $keyword_reject;
	var $min_character 				= 1; //quy uoc so ky tu nho nhat
	var $max_keyword 					= 5; //quy ước số keyword tối đa tìm kiếm
	var $quote_space					=	' +';//các ký tự cách biệt giữa các từ khóa cẩn bẻ thường chỉ có mỗi dấu space
	var $list_field					=	'';
	var $max_keyword_length 		= 100;
	var $min_fulltext_character 	= 4;
	var $array_keyword 				= array();
	var $array_keyword_reject 		= array();
	var $sql_keyword 					= " AND ";
	var $sql_keyword_reject 		= " AND ";
	var $array_keword_show			=	array();// hien thi cac tu khoa khi duoc tach ra
	var $array_field_point			=	array();	//array chứa tên trường và điểm tương ứng
	
	
	function generate_quicksearch($keyword,$list_field,$keyword_reject='',$type_and_or=0){
		if($list_field=='') return ;
		//Loại bỏ ' để chống sql injection
		$keyword 					= str_replace('\"','"',$keyword);
		$this->keyword 			= str_replace("\'","'",$keyword);
		$this->keyword 			= str_replace("'","''",$this->keyword);
		//$this->keyword				= RemoveSign($this->keyword);
		$this->keyword 			= mb_strtolower($this->keyword,"UTF-8");
		
		$this->keyword_reject 	= str_replace("\'","'",$keyword_reject);
		$this->keyword_reject 	= str_replace("'","''",$this->keyword_reject);
		$this->type_and_or 		= $type_and_or;
		$this->list_field			= $list_field;
		
		if (strlen($this->keyword) > $this->max_keyword_length) $this->keyword = substr($this->keyword,0,$this->max_keyword_length);
		
		$j=-1;
		preg_match_all('/' . preg_quote('"') .'(.*?)' . preg_quote('"') .'/is', $this->keyword,$quote);
		
		//nếu tồn tại từ khóa trong ngoặc kép
		if(isset($quote[0][0])){
			if(isset($quote[1][0])){
				for($i=0;$i<count($quote[1]);$i++){
					if (strlen(trim($quote[1][$i])) > $this->min_character){
						$j++;
						$this->array_keyword[$j][0]=trim($quote[1][$i]);
						
						if (strpos($this->array_keyword[$j][0]," ")===false && mb_strlen($this->array_keyword[$j][0],"utf-8") >= $this->min_fulltext_character && strpos($this->array_keyword[$j][0], "-")===false){
							$this->array_keyword[$j][1]="F";
						}
						//Nếu không kiều thường kiểu LIKE
						else{
							$this->array_keyword[$j][1]="L";
						}
					}
					
					if ($j >= $this->max_keyword) break;
				}//end for
			}
			$this->keyword=str_replace($quote[0],'',$this->keyword);
		}
		
		if ($j <= $this->max_keyword){
			$array_temp = preg_split('|[' . preg_quote($this->quote_space) . ']|Ui', $this->keyword);
			for($i=0;$i<count($array_temp);$i++){
				if (strlen(trim($array_temp[$i])) > $this->min_character){
					$j++;
					//gán từ khóa
					$this->array_keyword[$j][0]=trim($array_temp[$i]);
					if (mb_strlen($this->array_keyword[$j][0],"utf-8") >= $this->min_fulltext_character && !is_numeric($this->array_keyword[$j][0]) && strpos($this->array_keyword[$j][0], "-")===false){
						$this->array_keyword[$j][1]="F";
					}
					else{
						$this->array_keyword[$j][1]="L";
					}
					
					if ($j >= $this->max_keyword) break;
					
				}//end if
				
			}//end for
		}//if ($j <= $this->max_keyword)
		/* kết thúc phần xử lý keyword ---------------------------------------------------------------------------------------------------------------------*/
		
		
		/* xử lý keyword_reject (từ khóa loại đi )---------------------------------------------------------------------------------------------------------------------*/
		//Nếu độ dài của keyword_reject quá $max_keyword_length thì cắt bớt
		if (strlen($this->keyword_reject) > $this->max_keyword_length) $this->keyword_reject = substr($this->keyword_reject,0,$this->max_keyword_length);
		//bẻ dấu cách và ký tư phân biệt giữa các từ khóa
		$array_temp = preg_split('|[' . preg_quote($this->quote_space) . ']|Ui', $this->keyword_reject);
		$j=-1;
			for ($i=0;$i<count($array_temp);$i++){
				//Lay từng từ khóa một
				if (strlen(trim($array_temp[$i])) > $this->min_character){
					$j++;
					$this->array_keyword_reject[$j]=trim($array_temp[$i]);
					if ($j >= $this->max_keyword) break;
				}
			}
			
			/*
			--- kết thúc xử lý reject keyword -----
			*/		
			
		
		
		//print_r($this->array_keyword);
		//Tạo query cho từ khóa tìm kiếm
		for ($i=0;$i<count($this->array_keyword);$i++){
				
				//echo $this->array_keyword[$i][1] . "<br>";
				//Sử dụng Full text search
				if($this->array_keyword[$i][1] == "F"){
				
					$this->sql_keyword .= "MATCH(" . $this->list_field . ") AGAINST ('" . $this->array_keyword[$i][0] . "*' IN BOOLEAN MODE)";
				
				}else{
				//Sử dụng LIKE
				
					$this->sql_keyword .= $this->list_field . " LIKE '%" . $this->array_keyword[$i][0] . "%'";
				
				}
				
				if($i<count($this->array_keyword)-1) 	$this->sql_keyword .= " AND ";	
				
		}
		//echo $this->sql_keyword;
		if(count($this->array_keyword)==0) $this->sql_keyword = "";
			
		
		// Loại bỏ keyword
		for ($i=0;$i<count($this->array_keyword_reject);$i++){
			//những từ khóa loại
			$this->sql_keyword_reject .= $this->list_field . " NOT LIKE '%" . $this->removeQuote($this->array_keyword_reject[$i]) . "%' AND ";
			
		}
		$this->sql_keyword_reject .= "1 ";
	}//end function
	
	
	function removeQuote($temp){
			$temp = str_replace("\'", "'", $temp);
			$temp = str_replace("'", "''", $temp);
			return $temp;
	}
	
	/*
	hàm tính điểm
	arrayField : array chứa các trường tính điểm
	*/
	
	function generate_point($arrayField = array()){
		
		$sql_return = '0';
		
		
		foreach($arrayField as $field=>$point){
			
			for ($i=0;$i<count($this->array_keyword);$i++){
			
				$sql_return .= " + IF(" . $field . " LIKE '" . $this->array_keyword[$i][0] . "%', " . $point . ", 0) + IF(" . $field . " LIKE '%" . $this->array_keyword[$i][0] . "%', " . $point . ", 0)";
			
			}
			
			
		}
		
		return $sql_return;
		
	}
	
}//end class
/*
//chạy thử
$keyword='Nokia N900 32GB';
$keyword_reject='sdfdsfds';
$list_field='cla_search';
$mykey=new  generate_quicksearch($keyword,$list_field);
echo $mykey->sql_keyword;
//*/
?>