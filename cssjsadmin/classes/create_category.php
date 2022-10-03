<?
//class tạo bảng category theo website
class create_table_category{
	
	//tạo array chứa các trường trong bảng category type => 1:int, 0: string
	var	$arrayField		=	array("cat_id" 			=> array("info" => "int(11) NOT NULL AUTO_INCREMENT", "type" => 1),
											"cat_name"  		=> array("info" => "varchar(255) DEFAULT NULL", "type" => 0),
											"cat_parent_id" 	=> array("info" => "int(11) DEFAULT 0", "index" => 1, "type" => 1),
											"cat_has_child"  	=> array("info" => "int(11) DEFAULT 0", "index" => 1, "type" => 1),
											"cat_active"  		=> array("info" => "tinyint(1) DEFAULT 0", "index" => 1, "type" => 1),
											"cat_order"  		=> array("info" => "int(11) DEFAULT 0", "index" => 1, "type" => 1),
											);
	//khai báo biến lỗi
	var	$error			=	"";
	var	$total_import	=	0;	
	
	/**
	 * Ham tao bang category
	 */
 	function create_table($website_id){
 		
 		$website_id		=	intval($website_id);
 		//nếu trường hợp web_id truyền vào bé hơn 1 thì return và báo lỗi
 		if($website_id < 1){
 			$this->error 	.= "Website ID truyền vào lỗi";
 			return;
 		}
 		
 		//khai báo biến sql để thực thi lệnh tạo bảng
 		$sql_create		=	"CREATE TABLE IF NOT EXISTS `categories_website_" . $website_id . "` (";
 		
 		$i	=	0;
 		//bắt đầu lặp array trường để tạo ra cấu trúc query tạo bảng
 		foreach($this->arrayField as $field => $type){
 			$i++;
 			//gép vào query tạo bảng
 			$sql_create	.= $field . " " . $type["info"];
 			
 			//nếu chưa đến trường cuối cùng thì thêm dấu phẩy và xuống dòng
 			if($i < count($this->arrayField)){
 				$sql_create	.=	  "," . chr(13);
 			}
 			
 		}//end foreach
 		
 		//nếu set trường khóa thì thêm key vào
		$sql_create		.=	", PRIMARY KEY (`cat_id`)";
 		
 		//bắt đầu lặp lại để đánh index cho những trường được khai báo
 		foreach($this->arrayField as $field => $type){
			
			//lấy giá trị khai báo xem có đánh index hay không
			$index		=	isset($type["index"]) ? intval($type["index"]) : 0;
			
			//nếu có đánh index
			if($index == 1){
	 			//gép vào query tạo bảng
	 			$sql_create	.= ", KEY " . $field . " (" . $field . ")";
 			}
 			
 			
 		}//end foreach
 		
 		//đóng lệnh tạo query
 		$sql_create		.= ")  ENGINE=MyISAM  DEFAULT CHARSET=utf8";
 		
 		//bắt đầu thực thi query
 		$db_ex	=	new db_execute($sql_create);
 		unset($db_ex);
 		
 		//optimize table
 		$db_ex	=	new db_execute("OPTIMIZE TABLE categories_website_" . $website_id . "");
 		unset($db_ex);
 		
 		//tiếp đến tạo bảng ads category
 		$db_ex	=	new db_execute("CREATE TABLE IF NOT EXISTS `advertising_category_" . $website_id . "` (
											  `adc_category_id` int(11) NOT NULL DEFAULT '0',
											  `adc_advertising_id` int(11) NOT NULL DEFAULT '0',
											  PRIMARY KEY (`adc_category_id`,`adc_advertising_id`)
											) ENGINE=MyISAM DEFAULT CHARSET=latin1");
 		unset($db_ex);
 		
 		return;
 		
 	}
 	
 	/**
 	 * Ham import du lieu từ file data json 
 	 */
	function import($filename, $webstie_id){
		
		$webstie_id	=	intval($webstie_id);
		if($webstie_id < 1){
			return "Bạn chưa chọn website";
		}
		
		//lấy json data từ file dữ liệu import vào
		$json_data	=	@file_get_contents($filename);
		//echo $json_data;
		if($json_data === false){
			//echo $filename . "<hr>";
			//echo $json_data;
			return "Không lấy được đữ liệu";
		}
		
		//decode json để chuyển sang array insert vào database
		$json_data	=	json_decode($json_data, true);
		
		//khai báo array chứa data query để ghép lại dang batch insert
		$arrayQuery	=	array();
		
		//nếu trường hợp decode thành công
		if($json_data != null){
			
			//lặp array để gán vào array query
			$i	=	0;
			foreach($json_data as $key => $row){
				$i++;
				
				//mở query
				$arrayQuery[$i]	=	"(";
					
					$j	=	0;
					//bắt đầu gán query vào array
					foreach($this->arrayField as $field => $arr){
						
						$j++;
						
						//nếu tồn tại trong row thì mới gán vào query không thì return và báo lỗi luôn
						if(isset($row[$field])){
							
							switch($arr["type"]){
								
								//nếu là kiểu string
								case 0:
									//bắt đầu gán vào query
									$arrayQuery[$i]	.=	"'" . replaceMQ($row[$field]) . "'";
								break;
								
								//nếu là kiểu int
								case 1:
									$arrayQuery[$i]	.=	intval($row[$field]);
								break;
								
							} //end switch
							
							//nếu chưa phải trường cuối cùng thì vẫn thêm dấu phẩy
							if($j < count($this->arrayField)){
								
									$arrayQuery[$i]	.=	",";
								
							} //end if
							
						}else{
							
							return 'Lỗi không tồn tại trường ' . $field;
							
						}
						
					} //end foreach arrayField
				
				//đóng query
				$arrayQuery[$i]	.=	")";
				
			}//end foreach
			
			//sau khi lặp xong vòng lặp query thì ghép arrayQuery lai thành query để insert vào
			$sqlValue	=	(count($arrayQuery) > 0) ? implode(",", $arrayQuery) : "";
			
			//hủy biến arrayQuery
			unset($arrayQuery);
			
			//nếu query khác rỗng thì bắt đầu ghép thành query hoàn chỉnh
			$sqlExecute	=	"INSERT IGNORE INTO categories_website_" . $webstie_id . "(";
			
			$i	=	0;
			//lặp để ghép tên trường vào
			foreach($this->arrayField as $field => $arr){
				
				$i++;
				$sqlExecute	.= $field;
				
				if($i < count($this->arrayField)){
					
					$sqlExecute	.= ",";
					
				}
				
				
			} //end foreach
			
		 	//ghép tiếp nội dung vào
		 	$sqlExecute	.=	") VALUES" . $sqlValue;
			
			//xóa hết dữ liệu cũ  để import
			$db_ex	=	new db_execute("TRUNCATE TABLE categories_website_" . $webstie_id);
			unset($db_ex);
			
			//bắt đầu thực thị query insert vào database
			$db_ex					=	new db_execute($sqlExecute);
			$this->total_import	=	$db_ex->total;
			unset($db_ex);
			
			return '';
			
		}else{
			return "Lỗi chuỗi json không đúng định dạng";
		} //end if
		
	}
 	
} //end class

/*
require_once("database.php");
require_once("../functions/functions.php");
$myCategory = new create_table_category();
$myCategory->create_table(1);
echo $myCategory->import("../log/sql.cfn", 1);
//*/
?>