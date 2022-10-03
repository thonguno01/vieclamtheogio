<?
//Class gọi các options của từng xe
class create_options
{
    var $arrayOptiondata = array();
    var $arrayDX         = array();
    var $arraydfn        = array();
    //Function lấy dữ liệu từ bảng options
    function getOptions($idloaixe,$group)
    {
        $idloaixe = (int)$idloaixe;
        $group    = (int)$group;
        $db_qr = new db_query("SELECT *
                               FROM options
                               WHERE otp_cat_id = ".$idloaixe."
                               AND otp_group = ".$group."
                               AND otp_active = 1
                               ORDER BY otp_order ASC");
        While($row = mysql_fetch_assoc($db_qr->result))
        {
            //Mảng options name và type
            $arrayOptiondata[$row["otp_type"]][] = $row["otp_name"];
        }
        return $arrayOptiondata;
    }
    //Function lấy html từ dữ liệu
    function getHtmlOptions($idloaixe,$group)
    {
        $arraydfn = $this-> getOptions($idloaixe,$group);
        $i = 0;
        $html = '';
        foreach($arraydfn as $type => $item)
        {
            foreach($item as $key=>$value){
                $namekt = "kythuat".$i++;
                $valop = getValue($namekt,'str',"POST","");
                $html .= "<div class='rowright'>";
                $html .= "<label class='lbcheckbox' for='cbExtendInfo1'>".$value."</label>";
                $html .= "<input class='inputtooltips' name='".$namekt."' tabindex='".$idloaixe."' value='".$valop."' title='VD: V8' type='text'>";
                $html .= "</div>";               
            }
        }
        return $html;
    }
    function getHtmlTiennghi($idloaixe,$group)
    {
        $arraydfn = $this-> getOptions($idloaixe,$group);
        $i = 0;
        $html = '';
        foreach($arraydfn as $type => $item)
        {
            foreach($item as $key=>$value){
                $html .= "<div class='inforow'>";
                $html .= "<input type='checkbox' name='cbExtendInfo' value='".$idloaixe."'>";
                $html .= "<label class='lbcheckbox' for='cbExtendInfo9'>".$value."</label>";
                $html .= "</div>";               
            }
        }
        return $html;
    }
}
?>