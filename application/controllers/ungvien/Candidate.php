<?php 
class Candidate extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Models');  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('func_helper');
        // $this->load->library('session');
		
    }
    public function listCanidate()
    {
        $data["content"] = "ungvien/candidate/list_candidate";
        $this->load->view("ungvien/candidate/template");
    }
    
    public function quan_ly_chung()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type']==3){
            // uv_sex,uv_mary,uv_dob,uv_city,uv_qh,uv_address,uv_phone,uv_avatar
            $select = 'uv_sex,uv_mary,uv_dob,uv_city,uv_qh,uv_address,uv_phone,uv_avatar';
            $infor = $this->Models->select_where_and($select,'user_uv',['uv_id' => $_COOKIE['UserId']])->row_array();
            $count = 0;
            foreach ($infor as $key => $value) {
                if ((is_numeric($value) && $value > 0) || (!is_numeric($value) && $value != '')){
                    $count++;
                }
            }
            if (count($infor) > 0){
                $data['percent1'] = floor(100*$count/count($infor));
            }else{
                $data['percent1'] = 0;
            }
            // uv_cat,uv_vitri,uv_city_hope,uv_calam,uv_hinh_thuc,uv_loai_hinh,uv_luong_1,uv_luong_2,uv_luong_3
            $select = 'uv_cat,uv_vitri,uv_city_hope,uv_calam,uv_hinh_thuc,uv_loai_hinh,uv_luong_1';
            $infor = $this->Models->select_where_and($select,'user_uv',['uv_id' => $_COOKIE['UserId']])->row_array();
            $count = 0;
            foreach ($infor as $key => $value) {
                if ((is_numeric($value) && $value != 0) || (!is_numeric($value) && $value != '')){
                    $count++;
                }
            }
            if (count($infor) > 0){
                $data['percent2'] = floor(100*$count/count($infor));
            }else{
                $data['percent2'] = 0;
            }
            // uv_gtc
            $select = 'uv_gtc';
            $infor = $this->Models->select_where_and($select,'user_uv',['uv_id' => $_COOKIE['UserId']])->row_array();
            $count = 0;
            foreach ($infor as $key => $value) {
                if ((is_numeric($value) && $value > 0) || (!is_numeric($value) && $value != '')){
                    $count++;
                }
            }
            if (count($infor) > 0){
                $data['percent3'] = floor(100*$count/count($infor));
            }else{
                $data['percent3'] = 0;
            }
            // 'uv_knlv' com_name,vi_tri,date_from,date_to,mo_ta
            $select = 'com_name,vi_tri,date_from,date_to,mo_ta';
            $infor = $this->Models->select_where_and($select,'uv_knlv',['id_uv' => $_COOKIE['UserId']])->result_array();
            $count = 0;
            foreach ($infor as $kn) {
                foreach ($kn as $key => $value) {
                    if ((is_numeric($value) && $value > 0) || (!is_numeric($value) && $value != '')){
                        $count++;
                    }
                }
            }
            if (count($infor) > 0){
                $data['percent4'] = floor(100*$count/(5*count($infor)));
            }else{
                $data['percent4'] = 0;
            }
            // vl đã lưu
            $save_new = $this->Models->select_where_and('id_new','save_new',['id_uv' => $_COOKIE['UserId']])->result_array();
            $data['save_new'] = count($save_new);
            // vl đã ut
            $apply_new = $this->Models->select_where_and('id_new','apply_new',['id_uv' => $_COOKIE['UserId']])->result_array();
            $data['apply_new'] = count($apply_new);
            // ntd xem hồ sơ
            $ntd_xemhoso = $this->Models->select_where_and('id_ntd','see_uv',['id_uv' => $_COOKIE['UserId']])->result_array();
            $data['ntd_xemhoso'] = count($ntd_xemhoso);
            // header
            $data['userid'] = 21;
            // sidebar
            $data['sidebar'] = 10;
            $data["content"] = "ungvien/candidate/quan_ly_chung";
            $data['css'] = array('includes/side_bar_ql_uv','ungvien/quan_ly_chung');
            $data['js'] = array('includes/side_bar_ql_uv','ungvien/quan_ly_chung');
            $this->load->view("template",$data, FALSE);
        }else{
            header("Location: /");
        }
    }

    public function thong_tin_co_ban()
    {
// uv_sex,uv_mary,uv_dob,uv_city,uv_qh,uv_address,uv_phone,uv_avatar,uv_cat,uv_vitri,uv_city_hope,uv_calam,uv_hinh_thuc,uv_loai_hinh,uv_luong_1,uv_luong_2,uv_luong_3,uv_gtc,uv_authentic,sign_up_from,uv_createtime,uv_updatetime,uv_token,uv_found
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type']==3){
            $select = 'uv_avatar,uv_sex,uv_mary,uv_dob,uv_city,uv_qh,uv_address,uv_phone';
            $condition = ['uv_id'=>$_COOKIE['UserId']];
            $infor = $this->Models->select_where_and($select, 'user_uv', $condition);
            if ($infor->num_rows() == 1){
                $infor = $infor->row_array();
                $data['infor'] = $infor;
                // sidebar
                $data['sidebar'] = 21;
                $data["content"] = "ungvien/candidate/thong_tin_co_ban";
                $data['css'] = array('includes/side_bar_ql_uv','includes/tab_bar_ql_uv','ungvien/thong_tin_co_ban');
                $data['js'] = array('includes/side_bar_ql_uv','ungvien/quan_ly_chung');
                $this->load->view("template",$data, FALSE);
            }else{
                header("Location: /");
            }
        }else{
            header("Location: /");
        }
    }

    public function cong_viec_mong_muon()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type']==3){
            $select = 'uv_cat,uv_hinh_thuc,uv_loai_hinh,uv_vitri,uv_luong_1,uv_luong_2,uv_luong_3,uv_city_hope,uv_calam';
            $condition = ['uv_id'=>$_COOKIE['UserId']];
            $infor = $this->Models->select_where_and($select, 'user_uv', $condition);
            if ($infor->num_rows() == 1){
                $infor = $infor->row_array();
                $data['infor'] = $infor;
                // sidebar
                $data['sidebar'] = 22;
                $data["content"] = "ungvien/candidate/cong_viec_mong_muon";
                $data['css'] = array('includes/side_bar_ql_uv','includes/tab_bar_ql_uv','ungvien/cong_viec_mong_muon');
                $data['js'] = array('includes/side_bar_ql_uv','ungvien/cong_viec_mong_muon');
                $this->load->view("template",$data, FALSE);
            }else {
                header("Location: /"); 
            }
        }else {
            header("Location: /");
        }
    }

    public function gioi_thieu_chung()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type']==3){
            $select = 'uv_gtc';
            $condition = ['uv_id'=>$_COOKIE['UserId']];
            $infor = $this->Models->select_where_and($select, 'user_uv', $condition);
            if ($infor->num_rows() == 1){
                $infor = $infor->row_array();
                $data['infor'] = $infor;
                // sidebar
                $data['sidebar'] = 23;
                $data["content"] = "ungvien/candidate/gioi_thieu_chung";
                $data['css'] = array('includes/side_bar_ql_uv','includes/tab_bar_ql_uv','ungvien/gioi_thieu_chung');
                $data['js'] = array('includes/side_bar_ql_uv','ungvien/gioi_thieu_chung');
                $this->load->view("template",$data, FALSE);
            }else {
                header("Location: /"); 
            }
        }else {
            header("Location: /");
        }
        
       
    }
    public function kinh_nghiem_lam_viec()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type']==3){
            $select = 'id_knlv,id_uv,com_name,vi_tri,date_from,date_to,mo_ta';
            $condition = ['id_uv'=>$_COOKIE['UserId']];
            $infor = $this->Models->select_where_and($select, 'uv_knlv', $condition);
            $infor = $infor->result_array();
            $data['infor'] = $infor;
    
            // sidebar
            $data['sidebar'] = 24;
            $data["content"] = "ungvien/candidate/kinh_nghiem_lam_viec";
            $data['css'] = array('includes/side_bar_ql_uv','includes/tab_bar_ql_uv','ungvien/kinh_nghiem_lam_viec','includes/warning_delete');
            $data['js'] = array('includes/side_bar_ql_uv','ungvien/kinh_nghiem_lam_viec','includes/warning_delete');
            $this->load->view("template",$data, FALSE);
        }else {
            header("Location: /");
    }
    }
    public function viec_lam_da_ung_tuyen()
    {
        $page = $this->uri->segment(2);
        if ($page == 0 || $page == ''){
            $page = 1;
        }
        $perpage = 8;
        $start = $perpage*($page-1);
        $data['start_row'] = $start;

        $select = 'a.id,a.status, a.id_ntd,a.id_uv,a.id_new,a.create_date, a.note,a.calamviec,a.lichlamviec,a.giolam, n.new_title,n.new_alias,n.new_cat,n.new_no_calam,n.new_ca_start,n.new_ca_end,n.new_t2,n.new_t3,n.new_t4,n.new_t5,n.new_t6,n.new_t7,n.new_cn,n.new_luong_1,n.new_luong_2,n.new_luong_3, ntd.ntd_alias, ntd.ntd_company,n.new_han_nop';
        $join = array('new n'=> 'a.id_new = n.new_id','user_ntd ntd' =>'a.id_ntd = ntd.ntd_id');
        $new_applied = $this->Models->select_sql('apply_new a',$select,array('a.id_uv'=> $_COOKIE['UserId']),null,$join,array('a.id'=>'DESC'), $perpage,$start,1);
        $data['new_applied'] = $new_applied;

        $infor_p = $this->Models->select_sql('apply_new a',$select,array('a.id_uv'=> $_COOKIE['UserId']),null,$join,array('a.id'=>'DESC'), null,null,1);
        $total = count($infor_p);
        pagination('/viec-lam-da-ung-tuyen', $total , $perpage);
        // header
        $data['userid'] = 21;
        // sidebar
        $data['sidebar'] = 30;
        $data["content"] = "ungvien/candidate/viec_lam_da_ung_tuyen";
    	$data['css'] = array('includes/side_bar_ql_uv','ungvien/viec_lam_da_ung_tuyen','includes/warning_delete');
    	$data['js'] = array('includes/side_bar_ql_uv','ungvien/viec_lam_da_ung_tuyen','includes/warning_delete');
        $this->load->view("template",$data, FALSE);
    }
    public function viec_lam_da_luu()
    {
        $page = $this->uri->segment(2);
        if ($page == 0 || $page == ''){
            $page = 1;
        }
        $perpage = 8;
        $start = $perpage*($page-1);
        $data['start_row'] = $start;

        $select = 's.id, s.id_ntd,s.id_new,s.id_uv,s.create_date, n.new_title,n.new_alias,n.new_cat,n.new_no_calam,n.new_ca_start,n.new_ca_end,n.new_t2,n.new_t3,n.new_t4,n.new_t5,n.new_t6,n.new_t7,n.new_cn,n.new_luong_1,n.new_luong_2,n.new_luong_3, ntd.ntd_alias, ntd.ntd_company';
        $join = array('new n'=> 's.id_new = n.new_id','user_ntd ntd' =>'s.id_ntd = ntd.ntd_id');
        $new_saved = $this->Models->select_sql('save_new s',$select,array('s.id_uv'=> $_COOKIE['UserId']),null,$join,array('s.id'=>'DESC'), $perpage,$start,1);
        $data['new_saved'] = $new_saved;

        $infor_p = $this->Models->select_sql('save_new s',$select,array('s.id_uv'=> $_COOKIE['UserId']),null,$join,array('s.id'=>'DESC'), null,null,1);
        $total = count($infor_p);
        pagination('/viec-lam-da-luu', $total , $perpage);
        // header
        $data['userid'] = 21;
        // sidebar
        $data['sidebar'] = 40;
        $data["content"] = "ungvien/candidate/viec_lam_da_luu";
    	$data['css'] = array('includes/side_bar_ql_uv','ungvien/viec_lam_da_luu','includes/warning_delete');
    	$data['js'] = array('includes/side_bar_ql_uv','ungvien/viec_lam_da_luu','includes/warning_delete');
        $this->load->view("template",$data, FALSE);
    }
    public function ntd_xem_ho_so()
    {
        $page = $this->uri->segment(2);
        if ($page == 0 || $page == ''){
            $page = 1;
        }
        $perpage = 8;
        $start = $perpage*($page-1);
        $data['start_row'] = $start;

        $select = 's.id, s.id_ntd,s.id_uv,s.create_date,ntd.ntd_alias, ntd.ntd_company';
        $join = array('user_ntd ntd' =>'s.id_ntd = ntd.ntd_id');
        $ntd_xemhoso = $this->Models->select_sql('see_uv s',$select,array('s.id_uv'=> $_COOKIE['UserId']),null,$join,array('s.id'=>'DESC'), $perpage,$start,1);
        $data['ntd_xemhoso'] = $ntd_xemhoso;

        $infor_p = $this->Models->select_sql('see_uv s',$select,array('s.id_uv'=> $_COOKIE['UserId']),null,$join,array('s.id'=>'DESC'), null,null,1);
        $total = count($infor_p);
        pagination('/nha-tuyen-dung-xem-ho-so', $total , $perpage);
        // header
        $data['userid'] = 21;
        // sidebar
        $data['sidebar'] = 50;
        $data["content"] = "ungvien/candidate/ntd_xem_ho_so";
    	$data['css'] = array('includes/side_bar_ql_uv','ungvien/ntd_xem_ho_so');
    	$data['js'] = array('includes/side_bar_ql_uv','ungvien/quan_ly_chung');
        $this->load->view("template",$data, FALSE);
    }
    public function doi_mat_khau()
    {
        // header
        $data['userid'] = 21;
        // sidebar
        $data['sidebar'] = 60;
        $data["content"] = "ungvien/candidate/doi_mat_khau";
    	$data['css'] = array('includes/side_bar_ql_uv','ungvien/doi_mat_khau','includes/popup_doimk_thanhcong');
    	$data['js'] = array('includes/side_bar_ql_uv','ungvien/doi_mat_khau');
        $this->load->view("template",$data, FALSE);
    }
}
