<?php

/**
 * Class Popup xử lý thông tin của các popup
 */

class Popup{
    function __construct($pop_id){
        $pop_id = intval($pop_id);
        $sql = "SELECT * FROM popup WHERE pop_id = ".$pop_id." LIMIT 0,1";
        $db_query = new db_query($sql, __FILE__.__LINE__, 'USE_SLAVE');

        if($popup = mysql_fetch_assoc($db_query->result)){
            foreach($popup as $f => $v){
                $this->$f = $v;
            }

            $sql = "SELECT * FROM popup_website WHERE pow_pop_id = ".$pop_id." AND pow_status = 1";
            $wids = array();
            $db_query = new db_query($sql, __FILE__.__LINE__, 'USE_SLAVE');
            while($item = mysql_fetch_assoc($db_query->result)){
                $wids[$item['pow_web_id']] = $item['pow_web_id'];
            }

            $this->websites = array();
            if(!empty($wids)){
                $sql = "SELECT * FROM websites WHERE web_id IN (".implode(',', $wids).") AND web_popup = 1 LIMIT 0,1000";
                $wids = array();
                $db_query = new db_query($sql, __FILE__.__LINE__, 'USE_SLAVE');
                while($item = mysql_fetch_assoc($db_query->result)){
                    if($item['web_logo'] != ''){
                        $item['web_logo'] = "/pictures/web_logo/".$item['web_logo'];
                    }else{
                        $item['web_logo'] = "/pictures/web_logo/myad_gray_logo.png";
                    }
                    $this->websites[$item['web_id']] = $item;
                }

            }
        }
        unset($db_query);
    }



    function get($field){
        return $this->$field;
    }

    function set($field, $value){
        $this->$field = $value;
    }

    function edit_permission(){
        global $myuser;

        if($this->pop_user_id == $myuser->u_id){
            return true;
        }
        return false;
    }
}