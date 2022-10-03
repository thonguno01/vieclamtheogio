<?
/**
 * Class LinkAdv
 */

class LinkAdv
{
   private  $user_id    =  0;
   private  $is_publisher  =  true;
   private  $cond_list  =  "";
   private  $join_list  =  "";
   private  $time_today;
   private  $check_money   =  false;
   private  $is_admin      =  false;
   private  $field_list =  "*";
   //QUERY DEBUG
   private  $query_list =  "";
   
   // Hằng số trạng thái
   const    LINK_ALL       =  0; // Tất cả link
   // Theo thời gian
   const    LINK_RUNNING   =  1; // Đang chạy
   const    LINK_STOPPED   =  2; // Đã dừng
   const    LINK_WILL_RUN  =  4; // Chưa chạy
   
   // Theo active 
   const    LINK_NOACTIVE  =  8; // Người dùng chưa duyệt
   const    LINK_ACTIVE    =  16; // Người dùng đã duyệt
   const    LINK_ADMIN_NOACTIVE  =  32; // Admin chưa duyệt
   const    LINK_ADMIN_ACTIVE    =  64;// Admin đã duyệt  
   const    LINK_ADMIN_UNACTIVE  =  128; // Admin không duyệt   
   const    LINK_ADMIN_BLOCKED   =  256; // Admin khóa
  
   // Theo chi phí
   const    LINK_LIMIT_MONEY  =  512; // Tài khoản hết tiền
   const    LINK_LIMIT_TOTAL  =  1024; // Quá tổng chi phí
   const    LINK_LIMIT_DAY    =  2048; // Quá giới hạn tiêu trong ngày
   
   
   // ADMIN Status
   static   $admin_status  =  array(
      0  => 'Chưa duyệt',
      1  => 'Đã duyệt',
      2  => 'Không duyệt',
      3  => 'Khóa' 
   );
   // LIMIT
   const    LIMIT_LIST     =  10;
   public   $array_status  =  array();
   public   $array_click   =  array();
   public   $link_id       =  array();
   public   $limit_list    =  0;
   
   // DATA 
   public   $data_link_publisher    =  array();
   public   $data_publisher_link    =  array();
   
   function __construct($user_id = 0,$is_publisher = true)
   {
      $user_id =  intval($user_id);
      if($user_id > 0)
      {
         $this->user_id =  $user_id;
         if(!$is_publisher)
            $this->setConditionList(" AND link_user_id = " . $user_id);
      }
      
      $this->is_publisher  =  $is_publisher;
      // Time Today
      $this->time_today =  strtotime("Today");
      
      // Generate array status
      $this->array_status  =  self::generateArrayStatus();
      
      // Genarate array click
      $this->array_click   =  self::generateArrayClick();
   }
   /**
    * Hàm set admin
    */
   function setAdmin()
   {
      $this->is_admin   =  true;
      return $this;
   }
   /**
    * Hàm set link_id
    */
   function setLinkId($link_id)
   {
      if(is_array($link_id))
      {
         foreach($link_id as $id)
         {
            if(!in_array($id,$this->link_id))
               $this->link_id[]  =  $id;
         }
      }
      else
      {
         $link_id =  intval($link_id);
            if(!in_array($link_id,$this->link_id))
               $this->link_id[]  =  $link_id;
      }
      
      return $this;
   }
   /**
    * Hàm set field list
    */
   function setFieldList($field)
   {
      $this->field_list =  $field;
      return $this;
   }
   /**
    * Hàm join link_publisher
    */
   function setJoinPublisher(){
      $this->join_list  .=  " INNER JOIN link_publisher ON ( link_id = lp_link_id )";
      if($this->is_publisher && $this->user_id > 0)
      {
         $this->setConditionList(" AND lp_publisher_id = " . $this->user_id);
      }
      return $this;
   }
   /**
    * Hàm join user
    */
   function setJoinUser(){
      $this->join_list  .=  " INNER JOIN users1 ON ( link_user_id = use_id )";
      return $this;
   }
   /**
    * Hàm join user_money
    */
   function setJoinUserMoney(){
      $this->join_list  .= " INNER JOIN ads_user_money ON ( link_user_id = um_user_id )";
      return $this;
   }
   /**
    * Hàm gán condition
    */
   function setConditionList($cond)
   {
      if($cond != "")
      {
         $this->cond_list  .= " " . $cond;
      }
      return $this;
   }
   
   /**
    * Hàm gán điều kiện
    */
   function setActiveCondition($type)
   {
      // Nếu là tất cả
      if($type == 0)
         return $this;
      
      $cond =  "";
      if($type & self::LINK_RUNNING)
         $cond .=  " AND link_start <= " . $this->time_today . " AND link_end >= " . $this->time_today;
      
      if($type & self::LINK_STOPPED)
         $cond .=  " AND link_end <= " . $this->time_today;
      
      if($type & self::LINK_WILL_RUN)
         $cond .=  " AND link_start > " . $this->time_today;
         
      if($type & self::LINK_ACTIVE)
         $cond .=  " AND link_active = 1 ";
      
      if($type & self::LINK_NOACTIVE)
         $cond .=  " AND link_active = 0";
         
      if($type & self::LINK_ADMIN_NOACTIVE)
         $cond .=  " AND link_admin_status = 0";
         
      if($type & self::LINK_ADMIN_ACTIVE)
         $cond .=  " AND link_admin_status = 1";
      
      if($type & self::LINK_ADMIN_UNACTIVE)
         $cond .=  " AND link_admin_status = 2";
      
      if($type & self::LINK_ADMIN_BLOCKED)
         $cond .=  " AND link_admin_status = 3";
      
      if($this->check_money)
      {
         if($type & self::LINK_LIMIT_MONEY)
            $cond .=  " AND um_money > link_money_click ";
      }   

      $this->setConditionList($cond);
      return $this;
   }
   /**
    * Hàm set status lấy ra 
    */
   function setStatusCondition($type,$check_money = false)
   {
      $this->check_money   =  $check_money;
      if($check_money)
      {
         $this->setJoinUserMoney();
      }
      return $this->setActiveCondition($type);
   }
   /**
    * Hàm generate array_status
    * @param type
    * 0  :  Tất cả các loại status
    * 1  :  Status cơ bản
    */
   static function generateArrayStatus($type = 0)
   {  
      $array_status  =  array(
         self::LINK_ALL       => 'Tất cả',
         (self::LINK_RUNNING + self::LINK_ACTIVE + self::LINK_ADMIN_ACTIVE)   => 'Đang chạy',
         self::LINK_STOPPED   => 'Đã dừng',
         (self::LINK_RUNNING + self::LINK_NOACTIVE)  => 'Đang dừng',
         self::LINK_WILL_RUN  => 'Chưa bắt đầu'
      );
      if($type == 0)
      {
         $array_status_advance   =  array(
            self::LINK_RUNNING         => 'Đang chạy',
            self::LINK_ADMIN_BLOCKED   => 'Admin khóa',
            self::LINK_ADMIN_NOACTIVE  => 'Admin chưa duyệt',
            self::LINK_ADMIN_UNACTIVE  => 'Admin không duyệt',
            self::LINK_NOACTIVE        => 'Tạm ngưng',
            self::LINK_LIMIT_TOTAL     => 'Quá tổng chi phí',
            self::LINK_LIMIT_DAY       => 'Quá giới hạn ngày',
            self::LINK_LIMIT_MONEY     => 'Tài khoản hết tiền'
         );
         $array_status  =  $array_status + $array_status_advance;
      }
      return $array_status;
   }
   /**
    * Hàm format status
    */
   function formatStatus(&$row)
   {
      $row['status'] =  0;
      // Đang trong thời gian chạy
      if($row['link_start'] <= $this->time_today && $row['link_end'] >= $this->time_today)
         $row['status'] += self::LINK_RUNNING;
         
      // Đã kết thúc
      if($row['link_end'] < $this->time_today)
         $row['status'] += self::LINK_STOPPED;
      
      // Chưa bắt đầu   
      if($row['link_start'] > $this->time_today)
         $row['status'] += self::LINK_WILL_RUN;
      
      // Người dùng active
      if($row['link_active'] == 1)
         $row['status'] += self::LINK_ACTIVE;
        
      // Người dùng chưa active
      if($row['link_active'] == 0)
         $row['status'] += self::LINK_NOACTIVE;
      
      // ADMIN chưa duyệt
      if($row['link_admin_status'] == 0)
         $row['status'] += self::LINK_ADMIN_NOACTIVE;
      
      // ADMIN đã duyệt
      if($row['link_admin_status'] == 1)
         $row['status'] += self::LINK_ADMIN_ACTIVE;
      
      // ADMIN không duyệt
      if($row['link_admin_status'] == 2)
         $row['status'] += self::LINK_ADMIN_UNACTIVE;
      
      // ADMIN khóa
      if($row['link_admin_status'] == 3)
         $row['status'] += self::LINK_ADMIN_BLOCKED;
      
      // Kiểm tra tiền click
      if($this->check_money)
      {
         if($row['link_money_click'] > $row['um_money'])
            $row['status'] += self::LINK_LIMIT_MONEY;
      } 
      // Nếu đang chạy thì kiểm tra các điều kiện chi phí
      if($row['status'] & (self::LINK_RUNNING + self::LINK_ACTIVE + self::LINK_ADMIN_ACTIVE) && isset($row['check_money']))
      {
         // Tổng chi phí
         if($row['total_money'] >= $row['link_total_money'])
            $row['status'] += self::LINK_LIMIT_TOTAL;
            
         // Giới hạn tiêu trong ngày
         if($row['total_money_day'] >= $row['link_max_money_day'])
            $row['status'] += self::LINK_LIMIT_DAY;
      }
      
      $this->formatStatusToString($row);
   }
   /**
    * Hàm format status ra string
    */
   function formatStatusToString(&$row)
   {
      $row['status_string']   =  array();
      foreach($this->array_status as $status_int => $status_string)
      {
         if($row['status'] & $status_int)
            $row['status_string'][$status_int] =  $status_string;
      }
      if(empty($row['status_string']))
         $row['status_string'][$row['status']]  =  'Chưa xác định';
   }
   /**
    * Hàm genarate bước giá click
    */
   static function generateArrayClick()
   {
      $min_click  =  100;
      $max_click  =  2000;
      $step       =  100;
      $array_click   =  array();
      for($i = $min_click ; $i <= $max_click ; $i+=$step)
      {
         $array_click[$i]  =  format_number($i) . ' VNĐ';
      }
      
      return $array_click;
   }
   /**
    * Hàm lấy count theo điều kiện
    */
   function getTotalList()
   {
      $total   =  0;
      $cond_id =  "";
      if(!empty($this->link_id))
      {
         $cond_id .= " AND link_id IN (" . implode(",",$this->link_id) . ")";
      }
      $sql  =  "SELECT
                  COUNT(*) as count
                  FROM
                     link 
                  " . $this->join_list . "
                  WHERE 
                     1 " . $this->cond_list . $cond_id;
      $db_count   =  new db_count($sql);
      $total      =  $db_count->total;
      unset($db_count);
      return $total;
   }
   /**
    * Hàm get list link
    */
   function getLink($order = "",$page = 1,$limit = self::LIMIT_LIST,$group_by = "")
   {
      $data =  array();
      
      // Check order
      if($order != "")
         $order      =  "ORDER BY " . $order;
      
      // Check group by
      if($group_by != "")
         $group_by   =  "GROUP BY " . $group_by;
         
      // Check page LIMIT
      $page    =  intval($page);
      $limit   =  intval($limit);
      $page    =  ($page <= 0) ? 1 : $page;
      $limit   =  ($limit <= 0) ? 1 : $limit;
      $this->limit_list =  $limit;
      // Check link_id
      $cond_id =  "";
      if(!empty($this->link_id))
      {
         $cond_id .= " AND link_id IN (" . implode(",",$this->link_id) . ")";
      }
      
      // List spent 
      $list_spent =  array();
      
      $sql  =  "SELECT 
                     " . $this->field_list . " 
                     FROM 
                        link 
                     " . $this->join_list . "
                     WHERE
                        1 " . $this->cond_list . $cond_id . "
                     " . $group_by . $order . "
                     LIMIT " . (($page - 1) * $limit) . "," . $limit;
      $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
      while($row  =  mysql_fetch_assoc($db_query->result))
      {
         // Time to String
         $row['start_date']   =  date("d/m/Y",$row['link_start']);
         $row['end_date']     =  date("d/m/Y",$row['link_end']);
         
         // Cut Link
         $row['link_cut']     =  self::cut_link($row['link_url']);
         
         // Format money click
         $row['money_click']  =  format_number($row['link_money_click']);
         $row['link_total_money_format']     =  format_number($row['link_total_money']);  
         $row['link_max_money_day_format']   =  format_number($row['link_max_money_day']);
         // Format status
         $this->formatStatus($row);
         $data[$row['link_id']]  =  $row;
         
         $num_table  =  $row['link_id'] % 100;
         if(isset($list_spent[$num_table]))
            $list_spent[$num_table] =  array();
         $list_spent[$num_table][]  =  $row['link_id'];
      }
      // Gán vào để debug 
      $this->query_list =  $db_query->query;
      unset($db_query);
      
      // Kiểm tra nếu có điều kiện check tiền 
      if($this->check_money)
      {
         foreach($list_spent as $num_table => $list_id)
         {
            foreach($this->getLinkSpent($list_id) as $link_id => $data_money)
            {
               $data[$link_id]   =  array_merge($data[$link_id],$data_money);
               $this->formatStatus($data[$link_id]);
            }
         }
      }
      return $data;
   }
   /**
    * Hàm lấy tiền tiêu 
    */
   function getLinkSpent($id,$detail = false,$cond = false,$page = false,$limit = false)
   {
      $data          =  array();
      $list_table    =  array();
      if(!is_array($id))
      {
         $id   =  array(intval($id));
      }
      // Gộp link_id vào nhóm 100
      foreach($id as $link_id)
      {
         $num_table  =  $link_id % 100;
         $table_name =  'link_user_spent_' . $num_table;
         if(!in_array($table_name,$list_table))
            $list_table[$table_name]   =  array();
         $list_table[$table_name][]    =  intval($link_id);
         
         // Khởi tạo data cho từng link
         $data[$link_id] =  array(
                  'total_money_pub' => 0,
                  'total_money'     => 0,
                  'total_click'     => 0,
                  'total_money_day' => 0,
                  'total_click_day' => 0,
                  'check_money'     => true,
                  'data_day'        => array(),
                  'data_detail'     => array()
               );
      }
      // Gán thêm điều kiện
      $cond_string   =  "";
      $cond_limit    =  "";
      if($cond)
      {
         $cond_string   =  strval($cond);
      }
      if($page && $limit)
      {
         $page    =  intval($page);
         $limit   =  intval($limit);
         $cond_limit =  " LIMIT " . (($page - 1) * $limit) . "," . $limit;
      }
      // Nếu là admin thì thống kê hết
      $field_money   =  'lus_money';
      $groupby       =  '';
      $field         =  '  lus_link_id,
                           SUM(lus_money) as lus_money,
                           SUM(lus_pub_money) as lus_pub_money,
                           COUNT(*) as total_click';
      if(!$this->is_admin)
      {
         if($this->is_publisher)
         {
            $cond_string  .=  " AND lus_publisher_id = " . $this->user_id;
            $field_money   =  'lus_pub_money';
            $groupby       =  ",lus_publisher_id";
         }
         else
         {
            $cond_string  .= " AND lus_user_id = " . $this->user_id;
            $field_money   =  'lus_money';
            $groupby       =  ",lus_user_id";
         }
      }
      
      if(!$detail)
      {
         $field      =  $field . ",FROM_UNIXTIME(lus_time, '%m/%d/%Y') as date";
         $groupby    =  " GROUP BY lus_link_id,date" . $groupby;
      }
      else
      {
         $field      =  "*," . $field;
      }
      // Select 
      foreach($list_table as $table_name => $list_id)
      {
         $sql  =  "SELECT 
                     " . $field  . "
                     FROM 
                        " . $table_name . "
                     WHERE
                        lus_link_id IN (" . implode(",",$list_id) . ") " . $cond_string . "
                        " . $groupby . "
                     ORDER BY 
                        lus_time DESC
                     " . $cond_limit;      
         $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
         while($row  =  mysql_fetch_assoc($db_query->result))
         {  
            // Tính tổng
            $data[$row['lus_link_id']]['total_money']       += $row['lus_money'];
            $data[$row['lus_link_id']]['total_money_pub']   += $row['lus_pub_money'];
            $data[$row['lus_link_id']]['total_click']       += $row['total_click'];
            
            // Tính ngày hôm nay 
            if($row['date'] == date('m/d/Y'))
            {
               $data[$row['lus_link_id']]['total_money_day'] += $row['lus_money'];
               $data[$row['lus_link_id']]['total_click_day'] += $row['total_click'];
            } 
            
            // Data theo từng ngày
            if(!isset($data[$row['lus_link_id']]['data_day'][$row['date']]))
               $data[$row['lus_link_id']]['data_day'][$row['date']]   =  array(
                  'click'  => 0,
                  'money'  => 0
               );
            $data[$row['lus_link_id']]['data_day'][$row['date']]['click']  =  $row['total_click'];   
            $data[$row['lus_link_id']]['data_day'][$row['date']]['money']  += $row[$field_money];
            
            // Data detail
            if($detail)
            {
               $data[$row['lus_link_id']]['data_detail'][$row['lus_id']]  =  $row;
            }
         }
         unset($db_query);
      }
      
      return $data;
   }
   /**
    * Hàm get link publisher
    */
   function getLinkPublisher($link_id = false, $user_id = 0 , $cond = "" ,$page = 1, $limit = false)
   {
      $data       =  array();
      $condition  =  "";
      if($link_id)
      {
         $this->setLinkId($link_id);
      }
      
      if(!empty($this->link_id))
      {
         $condition  .= " AND lp_link_id IN (" . implode(",",$this->link_id) . ")";
      }
      
      $condition_limit  =  "";
      if($limit && intval($limit) > 0)
      {
         $condition_limit  .= " LIMIT " . (($page - 1) * $limit) . "," . $limit;
      }
      // Set điều kiện nếu có user id
      if($this->is_publisher && $user_id > 0)
         $cond .= " AND lp_publisher_id = " .$user_id;
         
      $sql  =  "SELECT 
                  *
                  FROM
                     link_publisher
                  WHERE
                     1 " . $condition . $cond . $condition_limit;
      $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
      while($row  =  mysql_fetch_assoc($db_query->result))
      {
         if(!isset($this->data_link_publisher[$row['lp_link_id']]))
            $this->data_link_publisher[$row['lp_link_id']]  =  array();
         $this->data_link_publisher[$row['lp_link_id']][$row['lp_publisher_id']] =  $row;
         
         if(!isset($this->data_publisher_link[$row['lp_publisher_id']]))
            $this->data_publisher_link[$row['lp_publisher_id']]  =  array();
         $this->data_publisher_link[$row['lp_publisher_id']][$row['lp_link_id']] =  $row;
      }
      unset($db_query);
      
      return $this;
   }
   /**
    * Hàm get list trình duyệt
    */
   static function getBrowser(){
      $data =  array();
      $sql  =  "SELECT 
                  *
                  FROM
                     browsers";
      $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
      while($row  =  mysql_fetch_assoc($db_query->result))
      {
         $data[$row['bro_id']]   =  $row['bro_name'];
      }
      unset($db_query);
      return $data;
   }
   /**
    * Hàm generate link cho publisher
    */
   function generateLinkPublisher()
   {
      $data       =  array();
      $array_id   =  array();
      
      if($this->user_id > 0 && !empty($this->link_id) && $this->is_publisher)
      {
         // SELECT xem đã có chưa 
         $this->getLinkPublisher($this->link_id,$this->user_id);
         foreach($this->link_id as $key => $link_id)
         {
            if(isset($this->data_publisher_link[$this->user_id][$link_id]))
               $data[$link_id]   =  $this->data_publisher_link[$this->user_id][$link_id]['lp_generate_url'];
            else
               $array_id[]       =  $link_id;
         }
         // Tạo link nếu chưa có
         if(!empty($array_id))
         {
            foreach($array_id as $id)
            {
               $link_generate    =  $this->generateCodeUrl();
               $sql_insert       =  "INSERT IGNORE INTO 
                                          link_publisher(lp_link_id,lp_publisher_id,lp_generate_url,lp_time) 
                                          VALUES (" . $id . ","  . $this->user_id . ",'" . $link_generate . "'," . time() . ")";
               $db_insert        =  new db_execute($sql_insert,__FILE__.__LINE__);
               if($db_insert->total > 0)
               {
                  $data[$id]     =  $link_generate;
               }
               unset($db_insert);
            }
         }
      }
      return $data;
   }
   /**
    * Hàm generate code link
    */
   function generateCodeUrl()
   {
      $array_code =  array();
      // 0 - 9
      for($i = 48;$i <= 57;$i++)
      {
         $array_code[]  =  $i;
      }
      // A - Z
      for($i = 65;$i <= 90;$i++)
      {
         $array_code[]  =  $i;
      }
      // a - z
      for($i = 97;$i <= 122;$i++)
      {
         $array_code[]  =  $i;
      }
      $return_code =  "";
      for($i = 1; $i <= 3 ;$i++)
      {
         foreach(array_rand($array_code,2) as $code)
         {
            $return_code .= chr($array_code[$code]);
         }
      }
      
      // Check database đã có chưa
      $sql  =  "SELECT COUNT(*) as count FROM link_publisher WHERE lp_generate_url = '" . $return_code . "'";
      $db_count   =  new db_count($sql);
      if($db_count->total > 0)
         $return_code   =  $this->generateCodeUrl();
      unset($db_count);
        
      return $return_code;
   }
   /**
    * Hàm debug query
    */
   function debug_query()
   {
      echo '<pre>';
      var_dump($this->query_list);
      echo '</pre>';   
   }
   
   function __destruct()
   {
      
   }
   /**
    * Hàm rút gọn link hiện thị ...
    */
   static function cut_link($str,$length = 50)
   {
      $total_length  =  strlen($str);
      if($total_length > $length + 3)
      {
         $str  =  substr($str,0,$length / 2) . '...' . substr($str,$total_length - $length / 2,$length / 2);
      }
      
      return $str;
   }
}

?>