<?
/**
 * Class Notify
 * - Lấy thông báo
 * - Gửi thông báo cho user
 */

class Notify{
   
   private  $user_id    = array();   
   private  $send_all   = 0;
   
   CONST    TABLE =  'notify_user';
   CONST    TABLE_STATUS   =  'notify_user_status';   
   CONST    LIMIT =  10;
   
   function __construct($user_id = 0){
      if(is_array($user_id) && !empty($user_id))
         $this->user_id    =  $user_id;
      else
         $this->user_id[]  =  $user_id;
      
      $this->user_id    =  array_map("intval",$this->user_id);
      if($user_id == 0 || empty($user_id)){
         $this->set_all();
      }
   }
   
   function __destruct(){
      
   }
   /**
    * Set gửi toàn bộ user
    */
   function set_all(){
      $this->send_all   =  1;
   }
   
   /**
    * Hàm gửi thông báo cho user
    */
   function send_notify($content,$admin_id,$active = 1,$time = 0){
      if($content == '')
         return false;
      if($time == 0)
         $time =  time();
      $sql  =  "INSERT INTO 
                  " . self::TABLE . " (
                  not_content
                  ,not_admin_id
                  ,not_time
                  ,not_send_all
                  ,not_active
                  ) VALUES (
                  '" . replaceMQ($content)."'
                  ,"  . intval($admin_id) . "
                  ,"  . intval($time) ."
                  ,"  . $this->send_all ." 
                  ,"  . intval($active). " )";
      $db_insert  =  new db_execute_return();
      $not_id     =  $db_insert->db_execute($sql,__FILE__.__LINE__);
      if($this->send_all == 0){
         $this->insert_status($not_id);
      }
      unset($db_insert);

      return true;
   }
   /**
    * Hàm sửa thông báo
    */
   function update_notify($not_id,$content,$admin_id,$active = 1){
      if($content == '' || $not_id <= 0)
         return false;
      $sql  =  "  UPDATE 
                     " . self::TABLE . "
                  SET
                     not_content = " . replaceMQ($content) . "
                     ,not_admin_id = " . intval($admin_id) . "
                     ,not_send_all = " . $this->send_all . "
                     ,not_active = " . intval($active) ."
                  WHERE
                     not_id = " . intval($not_id); 
      $db_update  =  new db_execute($sql,__FILE__.__LINE__);
      if($this->send_all == 0){
         $this->check_update($not_id);
      }
      return $db_update->total; 
   }
   /**
    * Hàm check status update
    */
   function check_update($not_id){
      // Lấy user nhận thông báo cũ
      $sql  =  "SELECT * FROM notify_user_status WHERE nou_noti_id = " . intval($not_id);
      $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
      $arr_user   =  array();
      while($row  =  mysql_fetch_assoc($db_query->result)){
         $arr_user[] =  $row['nou_user_id'];
      }
      unset($db_query);
      
      $this->user_id   =  array_diff($this->user_id,$arr_user);
      foreach($this->user_id as $user_id){
         $this->insert_status($not_id);
      }
   }
   /**
    * Hàm insert trạng thái thông báo
    */
   function insert_status($not_id,$status = 0){
      $sql  =  "INSERT INTO 
                  " . self::TABLE_STATUS . " (
                  nou_user_id
                  ,nou_noti_id
                  ,nou_status
                  ) VALUES ";
      $value   =  array();
      foreach($this->user_id as $user_id){
         $value[]    =  "(
                     " . $user_id ."
                     ,". intval($not_id)."
                     ,". intval($status)."
                     )";
      }
      if(!empty($value)){
         $sql  .= implode(",",$value);
         $db_insert  =  new db_execute($sql,__FILE__.__LINE__);
         unset($db_insert);
      }
   }
   /**
    * Hàm update trạng thái thông báo
    */
   function update_status($not_id,$status = 0){
      $sql  =  "UPDATE 
                  " . self::TABLE_STATUS ." 
               SET 
                  nou_status = " . intval($status) . " 
               WHERE 
                  nou_user_id IN ( " . implode(",",$this->user_id) . " )
                  AND nou_noti_id = " . intval($not_id);
      $db_update  =  new db_execute($sql,__FILE__.__LINE__);
      unset($db_update);
   }
   /**
    * Hàm lấy số thông báo chưa đọc
    */
   function count_unread_notify(){
      $unread     =  0;
      $arr_read   =  array();
      // hết tin nhắn thuộc user
      $sql  =  "  SELECT
                     nou_noti_id,nou_status
                  FROM 
                     " . self::TABLE_STATUS . "
                  WHERE
                     nou_user_id = " . $this->user_id[0];
      $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
      while($row  =  mysql_fetch_assoc($db_query->result)){
         if($row['nou_status'] == 0)
            $unread++;
         else
            $arr_read[] =  $row['nou_noti_id'];
      }
      unset($db_query);
      
      // Count tổng tin nhắn
      $sql  =  "  SELECT 
                     COUNT(not_id) as count 
                  FROM 
                     " . self::TABLE . "
                  WHERE
                     not_active = 1
                     AND not_send_all = 1
                     " . ((!empty($arr_read)) ? "AND not_id NOT IN (" . implode(",",$arr_read) . ")" : "");
      $db_count   =  new db_count($sql);
      $unread     +=  $db_count->total;
      unset($db_count);
      return $unread;
   }
   /**
    * Hàm lấy thông báo cho user
    */
   function get_notify_user($page = 1){
      $arr_return =  array();
      $id_status  =  array();
      // Select trong bảng status
      $sql  =  "  SELECT 
                     nou_noti_id,nou_status
                  FROM
                     " . self::TABLE_STATUS . "
                  WHERE
                     nou_user_id = " . $this->user_id[0];

      $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
      while($row  =  mysql_fetch_assoc($db_query->result)){
         $id_status[$row['nou_noti_id']]   =  $row['nou_status'];
      }
      unset($db_query);
      //debug($id_status);
      $cond =  (!empty($id_status)) ?  " OR not_id IN (" . implode(",",array_keys($id_status)) . ")" : "";
      // SELECT lấy thông báo
      $sql  =  "  SELECT
                     *
                  FROM 
                     notify_user
                  WHERE
                     not_active = 1
                     AND 
                     (not_send_all = 1 " . $cond . ")
                  ORDER BY
                     not_time DESC
                  LIMIT 
                     " . intval($page - 1)*self::LIMIT . "," . (self::LIMIT + count($id_status))  ."
                     ";
      $db_query   =  new db_query($sql,__FILE__.__LINE__,"USE_SLAVE");
      $i =  0;
      while($row  =  mysql_fetch_assoc($db_query->result)){
         $i++;
         if($i > self::LIMIT)
            break;
         $row['not_unread']   =  0;
         if(isset($id_status[$row['not_id']]) && $id_status[$row['not_id']] == 0){
            $row['not_unread']   =  1;
            $this->update_status($row['not_id'],1);
         }else{
            if(!isset($id_status[$row['not_id']])){
               $row['not_unread']   =  1;
               $this->insert_status($row['not_id'],1);
            }
         }
         $arr_return[$row['not_id']]   =  $row;
      }
      unset($db_query);
      
      return $arr_return;
   }
   
   /**
    * Lấy thông báo cho trang tổng quan
    */
   public function get_overview_notify($page_no = 1, $limit = 10)
   {
      $sql = 'SELECT 
   *
FROM ' . self::TABLE . ' 
INNER JOIN '.self::TABLE_STATUS.' ON nou_noti_id = not_id
WHERE
   nou_user_id IN ('.implode(',',$this->user_id).')
   OR not_send_all = 1
GROUP BY not_id, nou_noti_id
ORDER BY
   not_time DESC
LIMIT
   ' . intval($page_no - 1)*$limit . ',' . $limit . '';
   
      $notify_db = new db_query($sql, __FILE__.__LINE__, 'USE_SLAVE');
      $notify = $notify_db->result_array();
      return $notify;
   }
}
?>