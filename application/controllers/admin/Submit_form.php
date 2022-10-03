<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submit_form extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Models');
        $this->load->model('Ajax_model');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('func_helper');
        $this->load->library('session');
        $this->load->library('Globals');
        $this->load->helper(['array', 'url', 'form', 'number']);
    }

    public function login()
    {

        $admin_user = $this->input->post('admin_user');
        $password = md5($this->input->post('password'));
        $select = 'id,username,password,name';
        $condition = ['username' => $admin_user, 'password' => $password];
        $infor = $this->Models->select_where_and($select, 'tbl_admin', $condition);
        if ($infor->num_rows() == 1) {
            $infor = $infor->row_array();
            // set session
            // set cookie
            setcookie('adminId', $infor['id'], time() + 86400, '/');
            setcookie('adminName', $infor['name'], time() + 86400, '/');
            setcookie('username', $infor['username'], time() + 86400, '/');
            echo json_encode(['status' => 1, 'message' => '']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Tài khoản hoặc mật khẩu không đúng.']);
        }
    }

    public function admin_check_pass()
    {
        $password_old = $_POST['password_old'];
        $select = 'id,password';
        $id = $_COOKIE['adminId'];

        $condition = [
            'id' => $id,
            'password' => md5($password_old),
        ];
        $result = $this->Models->select_where_and($select, 'tbl_admin', $condition);
        if ($result->num_rows() > 0) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function admin_change_pass()
    {
        $password = $this->input->post('password');
        $data = [
            'password' => md5($password),
        ];
        $id = $_COOKIE['adminId'];
        $condition = ['id' => $id];
        $change_pass = $this->Models->update_where_and($data, 'tbl_admin', $condition);
        $result = ['kq' => $change_pass];
        echo json_encode($result);
    }

    //////////////////////////////////////////////
    ///////////////// Ứng viên //////////////////
    ////////////////////////////////////////////

    //Quản lí tài khoản ứng viên
    public function candidate_add()
    {
        $n_dky_name = $this->input->post('n_dky_name');
        $n_dky_email = $this->input->post('n_dky_email');
        $n_dky_pwd = $this->input->post('n_dky_pwd');
        $n_city = $this->input->post('n_city');
        $n_qh = $this->input->post('n_qh');
        $n_addr = $this->input->post('n_addr');
        $n_cate = $this->input->post('n_cate');
        if (count($n_cate) > 1) {
            $n_cate = implode(',', $n_cate);
        }
        $n_cv = $this->input->post('n_cv');
        $n_city_hope = $this->input->post('n_city_hope');
        if (count($n_city_hope) > 1) {
            $n_city_hope = implode(',', $n_city_hope);
        }
        $n_tel = $this->input->post('n_tel');
        $ca_lam = $this->input->post('ca_lam');
        if (count($ca_lam) > 1) {
            $ca_lam = implode(',', $ca_lam);
        }
        $cre_time = intval(time());
        if (isset($_FILES['avatar']) && $_FILES['avatar'] != null) {
            $path = 'upload/uv/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['avatar']['name']);
            $avatar_name = 'avatar_' . $cre_time . '.' . $temp[1];
            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);
        } else {
            $avatar_name = '';
        }
        $status = $this->input->post('status');

        $code = rand(1000000, 9999999);
        $data = array(
            'uv_name' => $n_dky_name,
            'uv_alias' => vn_str_filter($n_dky_name),
            'uv_email' => $n_dky_email,
            'uv_pass' => md5($n_dky_pwd),
            'uv_phone' => $n_tel,
            'uv_authentic' => $status,
            'uv_createtime' => $cre_time,
            'uv_updatetime' => $cre_time,
            'uv_avatar' => $avatar_name,
            'uv_city' => $n_city,
            'uv_qh' => $n_qh,
            'uv_address' => $n_addr,
            'uv_cat' => $n_cate,
            'uv_vitri' => $n_cv,
            'sign_up_from' => 1,
            'uv_city_hope' => $n_city_hope,
        );

        $result = $this->Models->insert_data('user_uv', $data);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Thêm thông tin thành công'));
        }
    }

    public function candidate_edit()
    {
        $n_name = $this->input->post('n_name');
        $n_tel = $this->input->post('n_tel');
        $status = $this->input->post('status');
        $id = $this->input->post('id_candidate');

        $n_city = $this->input->post('n_city');
        $n_qh = $this->input->post('n_qh');
        $n_addr = $this->input->post('n_addr');
        $n_cate = $this->input->post('n_cate');
        if (count($n_cate) > 1) {
            $n_cate = implode(',', $n_cate);
        }
        $n_cv = $this->input->post('n_cv');
        $n_city_hope = $this->input->post('n_city_hope');
        if (count($n_city_hope) > 1) {
            $n_city_hope = implode(',', $n_city_hope);
        }

        $data = array(
            'uv_name' => $n_name,
            'uv_alias' => vn_str_filter($n_name),
            'uv_authentic' => $status,
            'uv_phone' => $n_tel,
            'uv_city' => $n_city,
            'uv_qh' => $n_qh,
            'uv_address' => $n_addr,
            'uv_cat' => $n_cate,
            'uv_vitri' => $n_cv,
            'uv_city_hope' => $n_city_hope,
        );
        $condition = ['uv_id' => $id];
        $result = $this->Models->update_where_and($data, 'user_uv', $condition);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
        }
    }

    //////////////////////////////////////////////
    ////////////////Nhà tuyển dụng///////////////
    ////////////////////////////////////////////

    //module thêm nhà tuyển dụng
    public function employer_add()
    {
        $ntd_email = $this->input->post('ntd_email');
        $ntd_number = $this->input->post('ntd_number');
        $ntd_password = $this->input->post('ntd_password');
        $n_city = $this->input->post('n_city');
        $n_qh = $this->input->post('n_qh');
        $ntd_address = $this->input->post('ntd_address');
        $ntd_name = $this->input->post('ntd_name');
        $cre_time = intval(time());
        if (isset($_FILES['avatar']) && $_FILES['avatar'] != null) {
            $path = 'upload/ntd/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['avatar']['name']);
            $avatar_name = 'avatar_' . $cre_time . '.' . $temp[1];

            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);
        } else {
            $avatar_name = '';
        }
        $status = $this->input->post('status');
        $code = rand(1000000, 9999999);
        $ntd_alias = vn_str_filter($ntd_name);
        $data = array(
            'ntd_email' => $ntd_email,
            'ntd_phone' => $ntd_number,
            'ntd_password' => md5($ntd_password),
            'ntd_city' => $n_city,
            'ntd_quanhuyen' => $n_qh,
            'ntd_address' => $ntd_address,
            'ntd_company' => $ntd_name,
            'ntd_alias' => $ntd_alias,
            'ntd_authentic' => 0,
            'ntd_sign_up_from' => 1,
            'ntd_token' => $code,
            'ntd_create_time' => $cre_time,
            'ntd_update_time' => $cre_time,
            'ntd_avatar' => $avatar_name,
            'ntd_authentic' => $status,
        );

        $result = $this->Models->insert_data('user_ntd', $data);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Thêm thông tin thành công'));
        }
    }
    //kết thúc  module thêm nhà tuyển dụng

    //module sửa nhà tuyển dụng
    public function employer_edit()
    {
        $ntd_company = $this->input->post('ntd_company');
        $ntd_phone = $this->input->post('ntd_phone');
        $id = $this->input->post('id_employer');
        $ntd_city = $this->input->post('ntd_city');
        $ntd_qh = $this->input->post('ntd_qh');
        $ntd_masothue = $this->input->post('ntd_masothue');
        $ntd_address = $this->input->post('ntd_address');
        $status = $this->input->post('status');

        $data = array(
            'ntd_company' => $ntd_company,
            'ntd_authentic' => $status,
            'ntd_phone' => $ntd_phone,
            'ntd_city' => $ntd_city,
            'ntd_quanhuyen' => $ntd_qh,
            'ntd_address' => $ntd_address,
            'ntd_msthue' => $ntd_masothue
        );
        $condition = ['ntd_id' => $id];
        $result = $this->Models->update_where_and($data, 'user_ntd', $condition);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
        }
    }
    //kết thúc

    //////////////////////////////////////
    ////////////////Admin/////////////////
    /////////////////////////////////////
    public function email_admin()
    {
        $email_admin = $this->input->post('email_admin');
        $select = 'email';
        $condition = ['email' => $email_admin];
        $result = $this->Models->select_where_and($select, 'tbl_admin', $condition);
        echo json_encode($result->result_array());
    }

    public function username_admin()
    {
        $username_admin = $this->input->post('username_admin');
        $select = 'username';
        $condition = ['username' => $username_admin];
        $result = $this->Models->select_where_and($select, 'tbl_admin', $condition);
        echo json_encode($result->result_array());
    }

    public function add_admin()
    {
        $email_admin = $this->input->post('email_admin');
        $username_admin = $this->input->post('username_admin');
        $cre_time = intval(time());
        if (isset($_FILES['avatar']) && $_FILES['avatar'] != null) {
            $path = 'upload/admin/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['avatar']['name']);
            $avatar_name = 'avatar_' . $cre_time . '.' . $temp[1];

            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);
        } else {
            $avatar_name = '';
        }
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');
        $data = array(
            'name' => $name,
            'password' => md5($password),
            'phone' => $phone,
            'image' => $avatar_name,
            'create_date' => $cre_time,
            'is_admin' => 0,
        );
        $result = $this->Models->insert_data('tbl_admin', $data);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Thêm thông tin thành công'));
        }
    }

    public function edit_admin()
    {
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');
        $id = $this->input->post('id_admin');
        $data = array(
            'name' => $name,
            'password' => md5($password),
            'phone' => $phone,
            'is_admin' => 0,
        );
        $condition = ['id' => $id];
        $result = $this->Models->update_where_and($data, 'tbl_admin', $condition);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
        }
    }
    /////////////////////

    /////////Thêm ngành nghề//
    public function check_cat_name()
    {
        $cat_name = $this->input->post('cat_name');
        $cat_alias = vn_str_filter($cat_name);
        $select = 'cat_name, cat_alias';
        $condition = [
            'cat_alias' => $cat_alias,
        ];
        $result = $this->Models->select_where_and($select, 'category', $condition);
        echo json_encode($result->result_array());
    }

    public function add_job()
    {
        $cat_name = $this->input->post('cat_name');
        $title_cat = $this->input->post('title_cat');
        $key_cat = $this->input->post('key_cat');
        $content_cat = $this->input->post('content_cat');
        $title_suggest = $this->input->post('title_suggest');
        $content_suggest = $this->input->post('content_suggest');
        $cre_time = time();

        $data = array(
            'cat_name' => $cat_name,
            'cat_alias' => vn_str_filter($cat_name),
            'meta_title' => $title_cat,
            'meta_key' => $key_cat,
            'meta_description' => $content_cat,
            'title_suggest' => $title_suggest,
            'content_suggest' => $content_suggest,
            'created_at' => $cre_time,
        );

        $result = $this->Models->insert_data('category', $data);
        echo json_encode(array('kq' => true, 'msg' => 'Thêm thông tin thành công'));
    }

    public function edit_job()
    {
        $title_cat = $this->input->post('title_cat');
        $key_cat = $this->input->post('key_cat');
        $content_cat = $this->input->post('content_cat');
        $title_suggest = $this->input->post('title_suggest');
        $content_suggest = $this->input->post('content_suggest');
        $id = $this->input->post('id_category');
        $cre_time = time();

        $data = array(
            'meta_title' => $title_cat,
            'meta_key' => $key_cat,
            'meta_description' => $content_cat,
            'title_suggest' => $title_suggest,
            'content_suggest' => $content_suggest,
            'updated_at' => $cre_time,
        );

        $condition = ['cat_id' => $id];
        $result = $this->Models->update_where_and($data, 'category', $condition);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
        }
    }



    ////// đăng tin mới/////////////
    public function tieu_de_alias()
    {
        $new_title = $this->input->post('new_title');
        $new_alias = vn_str_filter($new_title);
        $id_user = $this->input->post('id_user');

        $select = 'new_title, new_user_id';
        $condition = [
            'new_alias' => $new_alias,
            'new_user_id' => $id_user,
        ];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }

    public function tieu_de_alias_sua()
    {
        $new_title = $this->input->post('new_title');
        $new_alias = vn_str_filter($new_title);
        $new_id = $this->input->post('new_id');
        $id_user = $this->input->post('id_user');
        $select = 'new_title, new_user_id';
        $condition = [
            'new_id !=' => $new_id,
            'new_alias' => $new_alias,
            'new_user_id' => $id_user,
        ];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }

    public function chi_tiet_cong_viec()
    {

        $new_chitiet = $this->input->post('new_chitiet');
        $n_qh = $this->input->post('n_qh');
        $id_user = $this->input->post('id_user');

        $select = 'new_tag , new_user_id';
        $condition = ['new_tag' => $new_chitiet, 'new_qh' => $n_qh, 'new_user_id' => $id_user];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }

    public function chi_tiet_cong_viec_sua()
    {
        $new_id = $this->input->post('new_id');
        $new_chitiet = $this->input->post('new_chitiet');
        $n_qh = $this->input->post('n_qh');
        $id_user = $this->input->post('id_user');

        $select = 'new_tag , new_user_id';
        $condition = ['new_id !=' => $new_id, 'new_tag' => $new_chitiet, 'new_qh' => $n_qh, 'new_user_id' => $id_user];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }


    public function add_new()
    {
        $new_type_cong_viec = $this->input->post('n_type_congviec');
        $id_user = $this->input->post('id_user');
        $ntd_tieude = $this->input->post('ntd_tieude');
        $new_alias = vn_str_filter($ntd_tieude);
        $chi_tiet_cv = $this->input->post('chi_tiet_cv');
        $new_age = $this->input->post('ntd_age');
        $new_sex = $this->input->post('n_sex');
        $new_level = $this->input->post('n_level');
        $new_hoc_van = $this->input->post('n_hoc_van');
        $new_exp_work = $this->input->post('n_exp_work');
        $new_way_pay = $this->input->post('n_way_pay');
        $new_type_working = $this->input->post('n_type_working');
        $new_way_working = $this->input->post('n_way_working');
        $cre_time = time();
        $new_date = $this->input->post('ntd_date');
        $luong1 = $this->input->post('luong1');
        $muc_luong = $this->input->post('muc_luong');
        $luong3 = $this->input->post('luong3');
        $work_at_com  = $this->input->post('new_at_com');
        $city_work = $this->input->post('city_work');
        $qh_work = $this->input->post('qh_work');
        $address_work = $this->input->post('address_work');
        $gio_lam = $this->input->post('gio_lam');
        $gio_ve = $this->input->post('gio_ve');
        $ngay_lam_viec = $this->input->post('ngay_lam_viec');
        $new_mtcv = $this->input->post('ntd_mtcv');
        $new_yccv = $this->input->post('ntd_yccv');
        $new_quyen = $this->input->post('ntd_qldh');
        $new_no_calam = $this->input->post('calam');
        $data = array(
            'new_cat' => $new_type_cong_viec,
            'new_title' => $ntd_tieude,
            'new_tag' => $chi_tiet_cv,
            'new_alias' => $new_alias,
            'new_user_id' => $id_user,
            'new_age' => $new_age,
            'new_sex' => $new_sex,
            'new_cap_bac' => $new_level,
            'new_hoc_van' => $new_hoc_van,
            'new_knlv' => $new_exp_work,
            'new_httl' => $new_way_pay,
            'new_loai_hinh' => $new_type_working,
            'new_hinh_thuc' => $new_way_working,
            'new_create_time' => $cre_time,
            'new_updated_time' => $cre_time,
            'new_han_nop' => strtotime($new_date),
            'new_luong_1' => $luong1,
            'new_luong_2' => $muc_luong,
            'new_luong_3' => $luong3,
            'new_at_com' => $work_at_com,
            'new_city' => $city_work,
            'new_qh' => $qh_work,
            'new_address' => $address_work,
            'new_quyen' => $new_quyen,
            // 'new_ds_calam'=> $ngay_lam_viec,
            'new_mota' => $new_mtcv,
            'new_yeu_cau' => $new_yccv,

            'new_no_calam' => $new_no_calam,
            'new_ca_start' => $gio_lam,
            'new_ca_end' => $gio_ve,
            'new_t2' => $this->input->post('new_t2'),
            'new_t3' => $this->input->post('new_t3'),
            'new_t4' => $this->input->post('new_t4'),
            'new_t5' => $this->input->post('new_t5'),
            'new_t6' => $this->input->post('new_t6'),
            'new_t7' => $this->input->post('new_t7'),
            'new_cn' => $this->input->post('new_cn'),
        );
        $result = $this->Models->insert_data('new', $data);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Thêm thông tin thành công'));
        }
    }

    public function edit_new()
    {
        $info_new = $this->input->post();
        $data_update_new = array(
            'new_cat'             =>         $info_new['n_type_congviec'],
            'new_title'         =>         $info_new['ntd_tieude'],
            'new_user_id'       =>      $info_new['id_user'],
            'new_tag'            =>         $info_new['chi_tiet_cv'],
            'new_age'             =>         $info_new['ntd_age'],
            'new_sex'             =>         $info_new['n_sex'],
            'new_cap_bac'        =>         $info_new['n_level'],
            'new_hoc_van'         =>         $info_new['n_hoc_van'],
            'new_knlv'             =>         $info_new['n_exp_work'],
            'new_httl'            =>         $info_new['n_way_pay'],
            'new_loai_hinh'     =>         $info_new['n_type_working'],
            'new_hinh_thuc'     =>         $info_new['n_way_working'],
            'new_updated_time'    =>        time(),
            'new_han_nop'        =>         strtotime($info_new['ntd_date']),
            'new_luong_1'        =>         $info_new['luong1'],
            'new_luong_2'        =>        $info_new['muc_luong'],
            'new_luong_3'        =>        $info_new['luong3'],
            'new_at_com'        =>         $info_new['new_at_com'],
            'new_city'            =>         $info_new['city_work'],
            'new_qh'            =>         $info_new['qh_work'],
            'new_address'        =>         $info_new['address_work'],
            'new_quyen'            =>         $info_new['ntd_qldh'],
            // 'new_ds_calam'=> $ngay_lam_viec,
            'new_mota'            =>         $info_new['ntd_mtcv'],
            'new_yeu_cau'        =>        $info_new['ntd_yccv'],

            'new_no_calam'        =>         $info_new['no_ca_lam'],
            'new_ca_start'        =>         $info_new['gio_lam'],
            'new_ca_end'        =>         $info_new['gio_ve'],
            'new_t2'            =>         $info_new['t2'],
            'new_t3'            =>         $info_new['t3'],
            'new_t4'            =>         $info_new['t4'],
            'new_t5'            =>         $info_new['t5'],
            'new_t6'            =>         $info_new['t6'],
            'new_t7'            =>         $info_new['t7'],
            'new_cn'            =>         $info_new['cn'],
        );
        $condition = array('new_id' => $info_new['new_id']);
        $change_pass = $this->Models->update_where_and($data_update_new, 'new', $condition);
        if ($change_pass) {
            $data = array('kq' => true);
        } else {
            $data = array('kq' => false);
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    public function add_edit_tag()
    {
        $post = $this->input->post();
        // var_dump($post);
        if (isset($post['tag_id']) && $post['tag_id'] > 0) {
            // edit
            $post['updated_at'] = time();
            $post['meta_title'] = $post['tag_des'];
            $condition = ['tag_id' => $post['tag_id']];
            unset($post['tag_id']);
            $result = $this->Models->update_where_and($post, 'category_tag', $condition);
            if ($result) {
                echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thành công'));
            } else {
                echo json_encode(array('kq' => false, 'msg' => 'Cập nhật không thành công'));
            }
        } else {
            // add
            $post['created_at'] = time();
            $post['updated_at'] = time();
            $post['meta_title'] = $post['tag_des'];
            $post['tag_alias'] = vn_str_filter($post['tag_name']);
            unset($post['tag_id']);
            $result = $this->Models->insert_data('category_tag', $post);
            if ($result > 0) {
                echo json_encode(array('kq' => true, 'msg' => 'Thêm mới thành công'));
            } else {
                echo json_encode(array('kq' => false, 'msg' => 'Thêm mới không thành công'));
            }
        }
    }
    public function add_edit_cate()
    {
        $post = $this->input->post();
        // var_dump($post);
        if (isset($post['cat_id']) && $post['cat_id'] > 0) {
            // edit
            $post['updated_at'] = time();
            $condition = ['cat_id' => $post['cat_id']];
            unset($post['cat_id']);
            $result = $this->Models->update_where_and($post, 'category', $condition);
            // echo json_encode(['kq' => $result]);
        } else {
            // echo json_encode(['kq' => false]);
        }
        header("Location:/admin/job_list");
    }
    public function add_edit_city()
    {
        $post = $this->input->post();
        // var_dump($post);
        if (isset($post['cit_id']) && $post['cit_id'] > 0) {
            // edit
            $post['updated_at'] = time();
            $condition = ['cit_id' => $post['cit_id']];
            $cit_id = $post['cit_id'];
            unset($post['cit_id']);
            $result = $this->Models->update_where_and($post, 'city', $condition);
        }
        if ($cit_id <= 63) {
            header("Location: /admin/city_list");
        } else {
            header("Location: /admin/district_list");
        }
    }
    public function check_tag_alias()
    {
        $tag_name = $this->input->post('tag_name');
        $tag_alias = vn_str_filter($tag_name);
        $cate_have_tag = $this->input->post('cate_have_tag');

        $select = 'tag_parent,tag_alias';
        $condition = [
            'tag_alias' => $tag_alias,
            'tag_parent' => $cate_have_tag,
        ];
        $result = $this->Models->select_where_and($select, 'category_tag', $condition);
        echo json_encode($result->result_array());
    }
    public function check_cate_city()
    {
        $post = $this->input->post();
        $data_check = $this->Models->select_where_and('id', 'city_category', $post)->num_rows();
        if ($data_check > 0) {
            echo json_encode(['kq' => false, 'msg' => 'Đã có bài viết tại tỉnh thành ngành nghề này, bạn muốn chỉnh sửa bài viết?']);
        } else {
            echo json_encode(['kq' => true, 'msg' => 'Chưa có bài viết']);
        }
    }

    public function add_edit_cate_city()
    {
        $post = $this->input->post();
        if (trim($post['content']) == '') {
            $this->session->set_flashdata('content', 'Không được bỏ trống nội dung');
            redirect($_SERVER['HTTP_REFERER']);
        };
        if (isset($post['id']) && $post['id'] > 0) {
            // edit
            $post['updated_at'] = time();
            $condition = ['id' => $post['id']];
            unset($post['id']);
            unset($post['tag_id']);
            unset($post['cat_id']);
            unset($post['cit_id']);
            $result = $this->Models->update_where_and($post, 'city_category', $condition);
            if ($result == true) {
                header("Location: /admin/list_job_city");
            } else {
                echo 'Cập nhập không thành công';
            }
        } else {
            // add
            $post['updated_at'] = time();
            $post['created_at'] = time();
            unset($post['id']);
            unset($post['tag_id']);
            $result = $this->Models->insert_data('city_category', $post);
            if ($result > 0) {
                header("Location: /admin/list_job_city");
            } else {
                echo 'Thêm mới không thành công';
            }
        }
    }
    public function add_edit_tag_city()
    {
        $post = $this->input->post();
        var_dump($post);

        if (isset($post['id']) && $post['id'] > 0) {
            // edit
            $post['updated_at'] = time();
            $condition = ['id' => $post['id']];
            unset($post['id']);
            unset($post['tag_id']);
            unset($post['cat_id']);
            unset($post['cit_id']);
            $result = $this->Models->update_where_and($post, 'city_category', $condition);
            if ($result == true) {
                header("Location: /admin/list_tag_city");
            } else {
                echo 'Cập nhập không thành công';
            }
        } else {
            // add
            $post['updated_at'] = time();
            $post['created_at'] = time();
            unset($post['id']);
            unset($post['cat_id']);
            $result = $this->Models->insert_data('city_category', $post);
            if ($result > 0) {
                header("Location: /admin/list_tag_city");
            } else {
                echo 'Thêm mới không thành công';
            }
        }
    }
}
