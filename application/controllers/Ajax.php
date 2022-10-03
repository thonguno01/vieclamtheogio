<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
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
    public function getDistrict()
    {
        $cit_id = $this->input->get('cit_id');
        $v_district = $this->Models->select_where_and('cit_id,cit_name', 'city2', ['cit_parent' => $cit_id, 'cit_parent>' => 0]);

        echo json_encode($v_district->result_array());
    }

    public function getJob()
    {
        $cat_id = $this->input->get('cat_id');
        $v_job = $this->Models->select_where_and('tag_id,tag_name', 'category_tag', ['tag_parent' => $cat_id, 'tag_parent>' => 0]);

        echo json_encode($v_job->result_array());
    }

    public function logout()
    {
        setcookie('UserId', '', time() - 86400, '/');
        setcookie('Name', '', time() - 86400, '/');
        setcookie('email', '', time() - 86400, '/');
        setcookie('Type', '', time() - 86400, '/');
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /");
    }
    public function login()
    {
        $email = $this->input->post('email');
        $pass = md5($this->input->post('pass'));
        $type = $this->input->post('type');
        if ($type == 4) {
            $select = 'ntd_authentic,ntd_company,ntd_id,ntd_avatar,ntd_create_time,ntd_email,update_diem_time,ntd_han_diem,ntd_diem';
            $condition = ['ntd_password' => $pass, 'ntd_email' => $email];
            $infor = $this->Models->select_where_and($select, 'user_ntd', $condition);

            if ($infor->num_rows() == 1) {
                $infor = $infor->row_array();
                // set session
                $_SESSION["ntd_id"] = $infor['ntd_id'];
                $_SESSION["ntd_email"] = $infor['ntd_email'];
                $_SESSION["ntd_name"] = $infor['ntd_company'];
                if ($infor['ntd_authentic'] == 1) {
                    // set cookie
                    setcookie('UserId', $infor['ntd_id'], time() + 86400, '/');
                    setcookie('Name', $infor['ntd_company'], time() + 86400, '/');
                    setcookie('email', $email, time() + 86400, '/');
                    setcookie('Type', $type, time() + 86400, '/');
                    setcookie('point_exp', ($infor['ntd_han_diem'] > 0) ? $infor['ntd_han_diem'] : time(), time() + 86400, '/');
                    $cre_time = $infor['ntd_create_time'];
                    $path = '/upload/ntd/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time) . '/' . $infor['ntd_avatar'];
                    setcookie('avatar', $path, time() + 86400, '/');
                    // check diem free
                    $time_max = strtotime(date('d-m-Y', $infor['update_diem_time'])) + 24 * 60 * 60 - 1;
                    if ($time_max <= time()) {
                        $data_update = [
                            "update_diem_time" => time(),
                            "ntd_diem" => 5,
                        ];
                        $update = $this->Models->update_data('user_ntd', $data_update, array('ntd_id' => $infor['ntd_id']));
                        setcookie('point', 5, time() + 86400, '/');
                        setcookie('point_exp', strtotime(date('d-m-Y', time())) + 24 * 60 * 60 - 1, time() + 86400, '/');
                    } else {
                        setcookie('point', $infor['ntd_diem'], time() + 86400, '/');
                        setcookie('point_exp', $time_max, time() + 86400, '/');
                    }
                    echo json_encode(['status' => 1, 'message' => '']);
                } else {
                    echo json_encode(['status' => 0, 'message' => 'Tài khoản chưa kích hoạt. Vui lòng kích hoạt tài khoản.']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Tài khoản hoặc mật khẩu không đúng.']);
            }
        } elseif ($type == 3) {
            $n_dky_email = $this->Models->select_where_and('date_refresh,number_refresh,uv_authentic ,uv_name,uv_id ,uv_avatar, uv_createtime ', 'user_uv', 'uv_pass="' . $pass . '" AND uv_email="' . $email . '"')->result_array();

            if (count($n_dky_email) == 1) {
                $_SESSION["uv_id"] = $n_dky_email[0]['uv_id'];
                $_SESSION["uv_email"] = $email;
                $_SESSION["uv_name"] = $n_dky_email[0]['uv_name'];
                if ($n_dky_email[0]['uv_authentic'] == 1) {
                    $date_refresh = $n_dky_email[0]['date_refresh'];
                    $data_update = [
                        "date_refresh" => intval(time()),
                    ];
                    $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $n_dky_email[0]['uv_id']));
                    if (date('Y', $date_refresh) < date('Y')) {
                        $data_update = [
                            // "date_refresh" => intval(time()),
                            "number_refresh" => 5,
                        ];
                        $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $n_dky_email[0]['uv_id']));
                    } else {
                        if (date('m', $date_refresh) < date('m')) {
                            $data_update = [
                                // "date_refresh" => intval(time()),
                                "number_refresh" => 5,
                            ];
                            $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $n_dky_email[0]['uv_id']));
                        }
                    }
                    // set cookie
                    setcookie('UserId', $n_dky_email[0]['uv_id'], time() + 86400, '/');
                    setcookie('Name', $n_dky_email[0]['uv_name'], time() + 86400, '/');
                    setcookie('email', $email, time() + 86400, '/');
                    setcookie('Type', $type, time() + 86400, '/');
                    $cre_time = $n_dky_email[0]['uv_createtime'];
                    $path = '/upload/uv/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time) . '/' . $n_dky_email[0]['uv_avatar'];
                    setcookie('avatar', $path, time() + 86400, '/');
                    echo json_encode(['status' => 1, 'message' => '']);
                } else {
                    echo json_encode(['status' => 0, 'message' => 'Tài khoản chưa kích hoạt. Vui lòng kích hoạt tài khoản.']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Tài khoản hoặc mật khẩu không đúng.']);
            }
        }
    }

    //Email xác thực nhà tuyển dụng

    public function email_ntd()
    {
        $ntd_email = $this->input->post('email');
        $result = $this->Models->select_where_and('ntd_id,ntd_email', 'user_ntd', ['ntd_email' => $ntd_email]);
        echo json_encode($result->result_array());
    }
    public function alias_ntd()
    {
        $ntd_name = $this->input->post('ntd_name');
        $ntd_alias = vn_str_filter($ntd_name);
        $condition = ['ntd_alias' => $ntd_alias];
        $result = $this->Models->select_where_and('ntd_email', 'user_ntd', $condition);
        echo json_encode($result->result_array());
    }



    public function dang_ky_ntd()
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
        );

        $result = $this->Models->insert_data('user_ntd', $data);
        $_SESSION["ntd_id"] = $result;
        $_SESSION["ntd_email"] = $ntd_email;
        $_SESSION["ntd_name"] = $ntd_name;
        if ($result > 0) {
            $this->Models->delete_data('user_ntd_error', 'ntd_email = "' . $ntd_email . '" OR ntd_phone = "' . $ntd_number . '"');
            $send_mail = $this->globals->send_mail_xt(base_url() . '/EmailTemplate/Email_Xacthuc.htm', $ntd_email, $ntd_name, $result, $code, 'Xác thực đăng ký nhà tuyển dụng', 4);

            if ($send_mail == true) {
                $data = array('kq' => true, 'msg' => 'Đăng ký thành công');
                $condition = [
                    'ntd_email' => $ntd_email,
                    'ntd_phone' => $ntd_number,
                ];
            } else {
                $data = array('kq' => false, 'msg' => 'Đăng ký không thành công');
            }
        } else {
            $data = ['kq' => false, 'msg' => 'đăng ký không thành công'];
        }
        echo json_encode($data);
    }

    public function re_send_email_ntd()
    {
        $code = rand(1000000, 9999999);
        $result = $_SESSION["ntd_id"];
        $ntd_email = $_SESSION["ntd_email"];
        $ntd_name = $_SESSION["ntd_name"];

        $data = [
            'ntd_token' => $code,
        ];
        $condition = [
            'ntd_id' => $result,
            'ntd_email' => $ntd_email,
        ];
        $xacthuc = $this->Models->update_where_and($data, 'user_ntd', $condition);

        $send_mail = $this->globals->send_mail_xt(base_url() . 'EmailTemplate/Email_Xacthuc.htm', $ntd_email, $ntd_name, $result, $code, 'Xác thực đăng ký nhà tuyển dụng', 4);
        if ($send_mail == true) {
            $data = array('kq' => true, 'msg' => 'Đã gửi lại email xác thực.');
        } else {
            $data = array('kq' => false, 'msg' => 'Gửi lại email thất bại');
        }
        echo json_encode($data);
    }

    //Email xác thực ứng viên

    public function email_uv()
    {
        $n_dky_email = $this->input->post('n_dky_email');
        $result = $this->Ajax_model->check_email_uv($n_dky_email);
        echo json_encode($result);
    }

    public function dang_ky_uv()
    {
        $n_dky_name = $this->input->post('n_dky_name');
        $n_dky_email = $this->input->post('n_dky_email');
        $n_dky_pwd = $this->input->post('n_dky_pwd');
        $n_city = $this->input->post('n_city');
        $n_qh = $this->input->post('n_qh');
        $n_addr = $this->input->post('n_addr');
        $n_cate = $this->input->post('n_cate');
        $n_cv = $this->input->post('n_cv');
        $n_city_hope = $this->input->post('n_city_hope');
        $n_tel = $this->input->post('n_tel');
        $ca_lam = $this->input->post('ca_lam');
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

        $code = rand(1000000, 9999999);
        $data = array(
            'uv_name' => $n_dky_name,
            'uv_alias' => vn_str_filter($n_dky_name),
            'uv_email' => $n_dky_email,
            'uv_pass' => md5($n_dky_pwd),
            'uv_city' => $n_city,
            'uv_qh' => $n_qh,
            'uv_address' => $n_addr,
            'uv_cat' => $n_cate,
            'uv_vitri' => $n_cv,
            'uv_city_hope' => $n_city_hope,
            'uv_phone' => $n_tel,
            'uv_calam' => $ca_lam,
            'uv_authentic' => 0,
            'sign_up_from' => 1,
            'uv_token' => $code,
            'uv_createtime' => $cre_time,
            'uv_updatetime' => $cre_time,
            'uv_avatar' => $avatar_name,
            'date_refresh' => $cre_time,
            'number_refresh' => 5,
            'uv_found' => 1,
        );

        $result = $this->Models->insert_data('user_uv', $data);
        $_SESSION["uv_id"] = $result;
        $_SESSION["uv_email"] = $n_dky_email;
        $_SESSION["uv_name"] = $n_dky_name;

        // echo $result ;
        if ($result > 0) {
            $this->Models->delete_data('user_uv_error', 'uv_email = "' . $n_dky_email . '" OR uv_phone = "' . $n_tel . '"');
            $send_mail = $this->globals->send_mail_xt(base_url() . 'EmailTemplate/Email_Xacthuc.htm', $n_dky_email, $n_dky_name, $result, $code, 'Xác thực đăng ký ứng viên', 3);

            // $data = array('kq' => true, 'msg' => 'Đăng ký thành công');
            if ($send_mail == true) {
                $data = array('kq' => true, 'msg' => 'Đăng ký thành công');
            } else {
                $data = array('kq' => false, 'msg' => 'Đăng ký không thành công');
            }
        } else {
            $data = ['kq' => false, 'msg' => 'đăng ký không thành công'];
        }
        echo json_encode($data);
    }

    public function re_send_email_uv()
    {
        $code = rand(1000000, 9999999);
        $result = $_SESSION["uv_id"];
        $n_dky_email = $_SESSION["uv_email"];
        $n_dky_name = $_SESSION["uv_name"];

        $data = [
            'uv_token' => $code,
        ];
        $condition = [
            'uv_id' => $result,
            'uv_email' => $n_dky_email,
        ];
        $xacthuc = $this->Models->update_where_and($data, 'user_uv', $condition);

        $send_mail = $this->globals->send_mail_xt(base_url() . 'EmailTemplate/Email_Xacthuc.htm', $n_dky_email, $n_dky_name, $result, $code, 'Xác thực đăng ký ứng viên', 3);
    }


    ////////////Ứng Viên//////////////////



    //thông tin cơ bản ứng viên
    public function thong_tin_co_ban()
    {
        $n_name = $this->input->post('n_name');
        $n_sex = $this->input->post('n_sex');
        $n_mary = $this->input->post('n_mary');
        $_dob = $this->input->post('n_dob');
        $n_city = $this->input->post('n_city');
        $n_qh = $this->input->post('n_qh');
        $n_addr = $this->input->post('n_addr');
        $n_tel = $this->input->post('n_tel');
        $cre_time = explode('/', $_COOKIE['avatar']);
        // var_dump($cre_time);
        $path = 'upload/uv/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];
        // echo $path; die();
        if (isset($_FILES['avatar']) && $_FILES['avatar'] != null) {
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['avatar']['name']);
            $avatar_name = 'avatar_' . time() . '.' . $temp[1];
            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);
        } else {
            $avatar_name = $cre_time[6];
        }
        $code = rand(1000000, 9999999);
        $data = array(
            'uv_name' => $n_name,
            'uv_sex' => $n_sex,
            'uv_mary' => $n_mary,
            'uv_dob' => strtotime($_dob),
            'uv_city' => $n_city,
            'uv_qh' => $n_qh,
            'uv_address' => $n_addr,
            'uv_phone' => $n_tel,
            'uv_token' => $code,
            'uv_avatar' => $avatar_name,
        );

        $id = $_COOKIE['UserId'];

        $condition = ['uv_id' => $id];
        $result = $this->Models->update_where_and($data, 'user_uv', $condition);

        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
            setcookie('avatar', '/' . $path . '/' . $avatar_name, time() + 86400, '/');
        }
    }

    //công việc mong muốn
    public function cong_viec_mong_muon()
    {
        $n_lcv = $this->input->post('n_lcv');
        $n_cvct = $this->input->post('n_cvct');
        $n_htlv = $this->input->post('n_htlv');
        $n_lhlv = $this->input->post('n_lhlv');
        $n_city = $this->input->post('n_city');
        $n_ht_luong = $this->input->post('n_ht_luong');
        $n_luong = $this->input->post('n_luong');
        $n_httl = $this->input->post('n_httl');
        $ca_lam = $this->input->post('ca_lam');
        $data = array(
            'uv_cat' => $n_lcv,
            'uv_vitri' => $n_cvct,
            'uv_hinh_thuc' => $n_htlv,
            'uv_loai_hinh' => $n_lhlv,
            'uv_city_hope' => $n_city,
            'uv_luong_1' => $n_ht_luong,
            'uv_luong_2' => $n_luong,
            'uv_luong_3' => $n_httl,
            'uv_calam' => $ca_lam,
            // 'uv_cat' => $n_lcv,
        );

        $id = $_COOKIE['UserId'];

        $condition = ['uv_id' => $id];
        $result = $this->Models->update_where_and($data, 'user_uv', $condition);

        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
        }
    }

    //Giới thiệu chung ứng viên
    public function gioi_thieu_chung_uv()
    {
        $n_gtc_text = $this->input->post('n_gtc_text');
        $data = array('uv_gtc' => $n_gtc_text);
        $id = $_COOKIE['UserId'];
        $condition = ['uv_id' => $id];
        $result = $this->Models->update_where_and($data, 'user_uv', $condition);

        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
        }
    }

    //Kinh nghiệm làm việc
    public function kinh_nghiem_lam_viec()
    {
        $n_name = $this->input->post('n_name');
        $vt_id = $this->input->post('vt_id');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $mota = $this->input->post('mota');
        $id_knlv = $this->input->post('id_knlv');
        $id = $_COOKIE['UserId'];
        $data = array(
            'com_name' => $n_name,
            'vi_tri' => $vt_id,
            'date_from' => strtotime($start),
            'date_to' => strtotime($end),
            'mo_ta' => $mota,
            'id_uv' => $id,
        );
        $condition = ['id_knlv' => $id_knlv];
        if ($id_knlv == 0) {
            $result = $this->Models->insert_data('uv_knlv', $data);
        } else {
            $result = $this->Models->update_where_and($data, 'uv_knlv', $condition);
        }
    }

    public function xoa_kng()
    {
        $id_knlv = $this->input->post('id_knlv');
        $condition = ['id_knlv' => $id_knlv];
        $result = $this->Models->delete_data('uv_knlv', $condition);
    }


    //Đổi mật khẩu
    public function check_old_pass()
    {
        $uv_pass = md5($this->input->post('uv_pass'));
        $select = 'uv_pass';
        $id = $_COOKIE['UserId'];
        $condition = ['uv_id' => $id, 'uv_pass' => $uv_pass];
        $result = $this->Models->select_where_and($select, 'user_uv', $condition);
        echo json_encode($result->result_array());
    }

    public function doi_mat_khau_ung_vien()
    {
        $n_new_pass = $this->input->post('n_new_pass');
        $data = [
            'uv_pass' => md5($n_new_pass),
        ];
        $id = $_COOKIE['UserId'];
        $condition = ['uv_id' => $id];
        $change_pass = $this->Models->update_where_and($data, 'user_uv', $condition);
        $result = ['kq' => $change_pass];
        echo json_encode($result);
    }

    //Email quên mật khẩu nhà tuyển dụng

    public function email_reset_pass_ntd()
    {
        $code = rand(1000000, 9999999);
        $send_email = $this->input->post('send_email');
        $condition = ['ntd_email' => $send_email];
        $mail = $this->Models->select_where_and('ntd_id,ntd_company,ntd_email', 'user_ntd', $condition);
        $infor_ntd = $mail->row_array();
        if ($mail->num_rows() > 0) {
            $send_mail = $this->globals->send_mail_dmk(base_url() . 'EmailTemplate/Access_change_pass.htm', $send_email, $infor_ntd['ntd_company'], $infor_ntd['ntd_id'], $code, 'Đổi mật khẩu', 4);
            if ($send_mail == true) {
                $_SESSION["ntd_id"] = $infor_ntd['ntd_id'];
                $_SESSION["ntd_email"] = $send_email;
                $_SESSION["ntd_name"] = $infor_ntd['ntd_company'];
                $data = array('kq' => true, 'msg' => 'Gửi yêu cầu thành công');
            } else {
                $data = array('kq' => false, 'msg' => 'Gửi yêu cầu không thành công');
            }
        } else {
            $data = ['kq' => false, 'msg' => 'Gửi yêu cầu không thành công'];
        }
        echo json_encode($data);
    }

    public function re_send_email_reset_pass_ntd()
    {
        $code = rand(1000000, 9999999);
        $result = $_SESSION["ntd_id"];
        $ntd_email = $_SESSION["ntd_email"];
        $ntd_name = $_SESSION["ntd_name"];

        $data = [
            'ntd_token' => $code,
        ];
        $condition = [
            'ntd_id' => $result,
            'ntd_email' => $ntd_email,
        ];
        $dmk = $this->Models->update_where_and($data, 'user_ntd', $condition);


        $send_mail = $this->globals->send_mail_dmk(base_url() . 'EmailTemplate/Access_change_pass.htm', $ntd_email, $ntd_name, $result, $code, 'Đổi mật khẩu ', 4);
        if ($send_mail == true) {
            $data = array('kq' => true, 'msg' => 'Đã gửi lại email xác thực.');
        } else {
            $data = array('kq' => false, 'msg' => 'Gửi lại email thất bại');
        }
        echo json_encode($data);
    }

    //Email quên mật khẩu ứng viên

    public function email_reset_pass_uv()
    {
        $code = rand(1000000, 9999999);
        $send_email = $this->input->post('send_email');
        $result = $this->Models->select_where_and('uv_id, uv_name', 'user_uv', 'uv_email= "' . $send_email . '"');
        // $select = 'uv_email';
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $id = $result['uv_id'];
            $uv_name = $result['uv_name'];
            $_SESSION["uv_id"] = $id;
            $_SESSION["uv_email"] = $send_email;
            $_SESSION["uv_name"] = $uv_name;
            //update token
            $data = [
                'uv_token' => $code,
            ];
            $condition = [
                'uv_id' => $id,
                'uv_email' => $send_email,
            ];
            $dmk = $this->Models->update_where_and($data, 'user_uv', $condition);

            $send_mail = $this->globals->send_mail_dmk(base_url() . 'EmailTemplate/Access_change_pass.htm', $send_email, $uv_name, $id, $code, 'Đổi mật khẩu', 3);
            if ($send_mail == true) {
                $data = array('kq' => true, 'msg' => 'Gửi yêu cầu thành công');
            } else {
                $data = array('kq' => false, 'msg' => 'Gửi yêu cầu không thành công');
            }
        } else {
            $data = ['kq' => false, 'msg' => 'Gửi yêu cầu không thành công'];
        }
        echo json_encode($data);
    }

    public function re_send_email_reset_pass_uv()
    {
        $code = rand(1000000, 9999999);
        $result = $_SESSION["uv_id"];
        $n_dky_email = $_SESSION["uv_email"];
        $n_dky_name = $_SESSION["uv_name"];
        // update token
        $data = [
            'uv_token' => $code,
        ];
        $condition = [
            'uv_id' => $result,
            'uv_email' => $n_dky_email,
        ];
        $dmk = $this->Models->update_where_and($data, 'user_uv', $condition);
        // gửi mail
        $send_mail = $this->globals->send_mail_dmk(base_url() . 'EmailTemplate/Access_change_pass.htm', $n_dky_email, $n_dky_name, $result, $code, 'Đổi mật khẩu ', 3);
        if ($send_mail == true) {
            $data = array('kq' => true, 'msg' => 'Gửi yêu cầu thành công');
        } else {
            $data = array('kq' => false, 'msg' => 'Gửi yêu cầu không thành công');
        }
        echo json_encode($data);
    }


    //đổi mật khẩu - quên mật khẩu
    public function change_pass()
    {
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $new_password = $this->input->post('new_password');

        $result = ['kq' => false, 'msg' => "Đổi mật khẩu ko thành công."];
        if ($type == 1) {
            $data = [
                'uv_pass' => md5($new_password),
            ];
            $condition = [
                'uv_id' => $id,
            ];
            $change_pass_uv = $this->Models->update_where_and($data, 'user_uv', $condition);
            if ($change_pass_uv) {
                $result = ['kq' => true, 'msg' => "Đổi mật khẩu thành công."];
            }
        } else if ($type == 2) {
            $data = [
                'ntd_password' => md5($new_password),
            ];
            $condition = [
                'ntd_id' => $id,
            ];
            $change_pass_ntd = $this->Models->update_where_and($data, 'user_ntd', $condition);
            if ($change_pass_ntd) {
                $result = ['kq' => true, 'msg' => "Đổi mật khẩu thành công."];
            }
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        // header('location:/doi-mat-khau-thanh-cong');n  
    }


    /////////////////Nhà Tuyển Dụng//////////////


    public function tieu_de_alias_sua()
    {
        $new_title = $this->input->post('new_title');
        $new_alias = vn_str_filter($new_title);
        $new_id = $this->input->post('new_id');

        $select = 'new_title, new_user_id';
        $condition = [
            'new_id !=' => $new_id,
            'new_alias' => $new_alias,
            'new_user_id' => $_COOKIE['UserId'],
        ];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }
    public function tieu_de_alias()
    {
        $new_title = $this->input->post('new_title');
        $new_alias = vn_str_filter($new_title);

        $select = 'new_title, new_user_id';
        $condition = [
            'new_alias' => $new_alias,
            'new_user_id' => $_COOKIE['UserId'],
        ];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }

    public function type_cong_viec()
    {
        $new_type_congviec = $this->input->post('new_type_congviec');
        $select = 'new_cat,new_user_id';
        $condition = [
            'new_cat' => $new_type_congviec,
            'new_user_id' => $_COOKIE['UserId'],
        ];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }

    public function chi_tiet_cong_viec()
    {

        $new_chitiet = $this->input->post('new_chitiet');
        $n_qh = $this->input->post('n_qh');
        $user_id = $_COOKIE['UserId'];

        $select = 'new_tag , new_user_id';
        $condition = ['new_tag' => $new_chitiet, 'new_qh' => $n_qh, 'new_user_id' => $user_id];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }
    public function chi_tiet_cong_viec_sua()
    {
        $new_id = $this->input->post('new_id');
        $new_chitiet = $this->input->post('new_chitiet');
        $n_qh = $this->input->post('n_qh');
        $user_id = $_COOKIE['UserId'];

        $select = 'new_tag , new_user_id';
        $condition = ['new_id !=' => $new_id, 'new_tag' => $new_chitiet, 'new_qh' => $n_qh, 'new_user_id' => $user_id];
        $result = $this->Models->select_where_and($select, 'new', $condition);
        echo json_encode($result->result_array());
    }


    public function dang_tin_moi()
    {
        $new_type_cong_viec = $this->input->post('n_type_congviec');
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
        $new_user_id = $_COOKIE['UserId'];

        $data = array(
            'new_cat' => $new_type_cong_viec,
            'new_title' => $ntd_tieude,
            'new_tag' => $chi_tiet_cv,
            'new_alias' => $new_alias,
            'new_user_id' => $new_user_id,
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
        $result = ['kq' => false, 'data' => ''];
        $d1 = strtotime('today midnight');
        $d2 = $d1 + 86400;
        $condition = [
            'new_user_id' => $new_user_id,
            'new_create_time >' => $d1,
            'new_create_time <' => $d2
        ];
        $check_time_new_24 = $this->Models->select_sql('new', '*', $condition, null, null, null, null, null, 1);
        if (count($check_time_new_24) < 24) {
            $id_new_last = $this->Models->select_sql('new', 'Max(new_id) AS id_new', ['new_user_id' => $new_user_id], null, null, null, null, null, 0);

            $qr_new_last = $this->Models->select_sql('new', '*', ['new_id' => $id_new_last['id_new']], null, null, null, null, null, 0);
            if ($cre_time - $qr_new_last['new_create_time'] >= 1) {
                // var_dump($data);
                // die();
                $qr = $this->Models->insert_data('new', $data);
                $result = ['kq' => true, 'msg' => ""];
            } else {
                $result = ['kq' => false, 'type' => 1, 'msg' => "Bạn vừa mới đăng tin, đợi 10 phút sau để đăng tin tiếp."];
            }
        } else {
            $result = ['kq' => false, 'type' => 2, 'msg' => "Bạn đã đăng 24 tin trong ngày hôm này."];
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }


    //Thông tin cơ bản nhà tuyển dụng
    public function thong_tin_co_ban_ntd()
    {
        $ntd_phone = $this->input->post('ntd_phone');
        $ntd_masothue = $this->input->post('ntd_masothue');
        $ntd_company = $this->input->post('ntd_company');
        $ntd_city = $this->input->post('ntd_city');
        $ntd_qh = $this->input->post('ntd_qh');
        $ntd_address = $this->input->post('ntd_address');
        $ntd_zalo = $this->input->post('ntd_zalo');
        $ntd_skype = $this->input->post('ntd_skype');
        $cre_time = explode('/', $_COOKIE['avatar']);
        $path = 'upload/ntd/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];
        if (isset($_FILES['avatar']) && $_FILES['avatar'] != null) {
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['avatar']['name']);
            $avatar_name = 'avatar_' . time() . '.' . $temp[1];
            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);
        } else {
            $avatar_name = $cre_time[6];
        }
        if (isset($_FILES['background']) && $_FILES['background'] != null) {
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['background']['name']);
            $background_name = 'background_' . time() . '.' . $temp[1];
            move_uploaded_file($_FILES['background']['tmp_name'], $path . '/' . $background_name);
        } else {
            $background_name = $cre_time[6];
        }
        $code = rand(1000000, 9999999);
        $data = array(
            'ntd_avatar' => $avatar_name,
            'ntd_cover_background' => $background_name,
            'ntd_company' => $ntd_company,
            // 'ntd_alias' => create_slug($ntd_company),
            'ntd_city' => $ntd_city,
            'ntd_quanhuyen' => $ntd_qh,
            'ntd_address' => $ntd_address,
            'ntd_phone' => $ntd_phone,
            'ntd_msthue' => $ntd_masothue,
            'ntd_zalo' => $ntd_zalo,
            'ntd_skype' => $ntd_skype,
            'ntd_token' => $code,
        );
        $id = $_COOKIE['UserId'];
        $condition = ['ntd_id' => $id];
        $result = $this->Models->update_where_and($data, 'user_ntd', $condition);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
            setcookie('avatar', '/' . $path . '/' . $avatar_name, time() + 86400, '/');
        }
    }

    public function gioi_thieu_chung_ntd()
    {
        $gtc = $this->input->post('gtc');
        $csptnl = $this->input->post('csptnl');
        $chtt = $this->input->post('chtt');
        $salary = $this->input->post('salary');
        $cre_time = explode('/', $_COOKIE['avatar']);
        $path = 'upload/ntd/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];
        $data = array(
            'ntd_gioi_thieu' => $gtc,
            'ntd_csptnl' => $csptnl,
            'ntd_chtt' => $chtt,
            'ntd_salary_award' => $salary,
        );
        if (isset($_FILES['img1']) && $_FILES['img1'] != null) {
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['img1']['name']);
            $img1 = 'img1_' . time() . '.' . $temp[1];
            move_uploaded_file($_FILES['img1']['tmp_name'], $path . '/' . $img1);
            $data = $data + ['ntd_img_1' => $img1];
        }
        if (isset($_FILES['img2']) && $_FILES['img2'] != null) {
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['img2']['name']);
            $img2 = 'img2_' . time() . '.' . $temp[1];
            move_uploaded_file($_FILES['img2']['tmp_name'], $path . '/' . $img2);
            $data = $data + ['ntd_img_2' => $img2];
        }
        if (isset($_FILES['img3']) && $_FILES['img3'] != null) {
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $temp = explode('.', $_FILES['img3']['name']);
            $img3 = 'img3_' . time() . '.' . $temp[1];
            move_uploaded_file($_FILES['img3']['tmp_name'], $path . '/' . $img3);
            $data = $data + ['ntd_img_3' => $img3];
        }
        $id = $_COOKIE['UserId'];
        $condition = ['ntd_id' => $id];
        $result = $this->Models->update_where_and($data, 'user_ntd', $condition);
        if ($result > 0) {
            echo json_encode(array('kq' => true, 'msg' => 'Cập nhật thông tin thành công'));
        }
    }

    public function check_pass_ntd()
    {
        $ntd_pass = md5($this->input->post('ntd_pass'));
        $select = 'ntd_password';
        $id = $_COOKIE['UserId'];
        $condition = ['ntd_id' => $id, 'ntd_password' => $ntd_pass];
        $result = $this->Models->select_where_and($select, 'user_ntd', $condition);
        echo json_encode($result->result_array());
    }

    public function doi_mat_khau_ntd()
    {
        $n_new_pass = $this->input->post('n_new_pass');
        $data = [
            'ntd_password' => md5($n_new_pass),
        ];
        $id = $_COOKIE['UserId'];
        $condition = ['ntd_id' => $id];
        $change_pass = $this->Models->update_where_and($data, 'user_ntd', $condition);
        $result = ['kq' => $change_pass];
        echo json_encode($result);
    }

    //ajax sửa tin
    public function chinh_sua_tin()
    {
        $info_new = $this->input->post();
        $data_update_new = array(
            'new_cat'             =>         $info_new['n_type_congviec'],
            'new_title'         =>         $info_new['ntd_tieude'],
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

    //search ứng viên
    public function search_uv()
    {
        $city = $this->input->post('city');
        $cities = list_city();
        $keyword = trim($this->input->post('keyword'));

        $hinhthuc = $this->input->post('hinhthuc');
        $loailv = $this->input->post('loailv');
        $gioitinh = $this->input->post('gioitinh');
        $honnhan = $this->input->post('honnhan');
        $luong = $this->input->post('luong');
        $check_tag = $this->Models->select_sql('category', 'cat_id,cat_name,cat_alias', ['cat_alias' => vn_str_filter($keyword)], null, null, null, null, null, 0);
        // var_dump($check_tag);
        if ($hinhthuc != 0 || $loailv != 0 || $gioitinh != 0 || $honnhan != 0 || $luong != 0 || ($keyword != '' && $check_tag == NULL)) {
            $url = '/ung-vien-theo-gio?keyword=' . preg_replace('/\s+/', '-', $keyword);
            if ($city != 0) {
                $url = $url . '&diadiem=' . $city;
            }
            if ($hinhthuc != 0) {
                $url = $url . '&hinhthuc=' . $hinhthuc;
            }
            if ($loailv != 0) {
                $url = $url . '&loailv=' . $loailv;
            }
            if ($gioitinh != 0) {
                $url = $url . '&gioitinh=' . $gioitinh;
            }
            if ($honnhan != 0) {
                $url = $url . '&honnhan=' . $honnhan;
            }
            if ($luong != 0) {
                $url = $url . '&luong=' . $luong;
            }
        } else {
            if ($keyword == "" && $city == 0) {
                $url = "/ung-vien-theo-gio";
            } else if ($keyword != "" && $city == 0) {
                $url = "/ung-vien-" . $check_tag['cat_alias'] . "-theo-gio-k" . $check_tag['cat_id'] . "t0.html";
            } else if ($keyword == "" && $city != 0) {
                $cityName = vn_str_filter($cities[$city]["cit_name"]);
                $url = "/ung-vien-theo-gio-tai-" . $cityName . "-k0t" . $city . ".html";
            } else if ($keyword != "" && $city != 0) {
                $cityName = vn_str_filter($cities[$city]["cit_name"]);
                $url = "/ung-vien-" . $check_tag['cat_alias'] . "-theo-gio-tai-" . $cityName . "-k" . $check_tag['cat_id'] . "t" . $city . ".html";
            }
        }
        $data = array('kq' => true, 'url' => $url);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    // lưu, bỏ lưu ứng viên
    public function save_uv()
    {
        $id_uv = $this->input->post('id_uv');
        $create_date = intval(time());

        $check_save_uv   =  $this->Models->select_sql('save_uv', '*', array('id_ntd' => $_COOKIE['UserId'], 'id_uv' => $id_uv), null, null, null, null, null, 0);
        if ($check_save_uv == NULL) {
            $data = array(
                'id_ntd' => $_COOKIE['UserId'],
                'id_uv' => $id_uv,
                'create_date' => $create_date,
            );
            $insert = $this->Models->insert_data('save_uv', $data);
            $dataNoti = array(
                'type' => 1, // thông báo của uv
                'id_uv' => $id_uv,
                'id_ntd' => $_COOKIE['UserId'],
                'id_new' => 0,
                'status' => 1, //1: ntd lưu uv, 2: ntd xem tt uv, 3: uv lưu tin, 4:uv ut tin 
                'create_date' => $create_date,
            );
            $insertNoti = $this->Models->insert_data('notification', $dataNoti);
        } else {
            $condition = ['id_ntd' => $_COOKIE['UserId'], 'id_uv' => $id_uv];
            $delete = $this->Models->delete_data('save_uv', $condition);
        }
    }
    //cập nhật trạng thái ứng viên ứng tuyển
    public function update_stt_apply()
    {
        $id_ut = $this->input->post('id_ut');
        $stt_ut = $this->input->post('stt_ut');
        $update_date = intval(time());

        $data_update = [
            "status" => $stt_ut,
            "update_date" => $update_date,
        ];
        $update = $this->Models->update_data('apply_new', $data_update, array('id' => $id_ut));
    }
    // tạo url tìm kiếm vl
    public function search_job()
    {
        $findkey = $this->input->post('findkey');
        $httl   = $this->input->post('httl');
        $hv     = $this->input->post('hv');
        $gt     = $this->input->post('gt');
        $cb     = $this->input->post('cb');
        $knlv   = $this->input->post('knlv');
        $lhlv   = $this->input->post('lhlv');
        $htlv   = $this->input->post('htlv');
        $nn_id  = $this->input->post('nn_id');
        $cit_id = $this->input->post('cit_id');
        $url = '';
        $findkey = trim($findkey);
        $list_tag = list_category_tag();
        $key_alias = vn_str_filter($findkey);
        $tag_id = array_search($key_alias, array_column($list_tag, 'tag_alias', 'tag_id'));
        if (
            $httl > 0 || $hv > 0 || $gt > 0 || $cb > 0 || $knlv > 0 || $lhlv > 0 || $htlv > 0 ||
            (trim($findkey) != '' && $tag_id == '') || (trim($findkey) != '' && $tag_id > 0 && $nn_id > 0)
        ) {
            // link xấu
            $url = '/tim-viec-lam.html?key=' . $findkey;
            if ($nn_id > 0) {
                $url = $url . '&nn=' . $nn_id;
            }
            if ($cit_id > 63) {
                $url = $url . '&qh=' . $cit_id;
                $qh = get_district($cit_id);
                $city = $qh['cit_parent'];
            } else if ($cit_id > 0) {
                $url = $url . '&tt=' . $cit_id;
            }
            if ($httl > 0) {
                $url = $url . '&htl=' . $httl;
            }
            if ($hv > 0) {
                $url = $url . '&hv=' . $hv;
            }
            if ($gt > 0) {
                $url = $url . '&gt=' . $gt;
            }
            if ($cb > 0) {
                $url = $url . '&cb=' . $cb;
            }
            if ($knlv > 0) {
                $url = $url . '&kn=' . $knlv;
            }
            if ($lhlv > 0) {
                $url = $url . '&lh=' . $lhlv;
            }
            if ($htlv > 0) {
                $url = $url . '&ht=' . $htlv;
            }
        } else {
            // link đẹp
            if (trim($findkey) != '') {
                // có findkey là tag && ko có nn (findkey là tag && có nn -> link xấu ở phía trên)
                $alias_tag = $key_alias;
                $url = '/tim-viec-lam-' . $alias_tag . '-theo-gio-';
                if ($cit_id > 63) {
                    $qh = get_district($cit_id);
                    $alias_qh = vn_str_filter($qh['cit_name']);
                    $city = $qh['cit_parent'];
                    $url = $url . 'tai-' . $alias_qh . '-tg' . $tag_id . 'qh' . $cit_id . '.html';
                } else if ($cit_id > 0) {
                    $alias_tt = vn_str_filter(get_city($cit_id));
                    $url = $url . 'tai-' . $alias_tt . '-tg' . $tag_id . 'tt' . $cit_id . '.html';
                } else {
                    $url = $url . 'tg' . $tag_id . 'tt0.html';
                }
            } else {
                // ko có findkey
                $url = '/tim-viec-lam-';
                if ($nn_id > 0) {
                    $list_cate = list_category();
                    $alias_nn = $list_cate[$nn_id]['cat_alias'];
                    $url = $url . $alias_nn . '-';
                } else {
                }
                $url = $url . 'theo-gio-';
                if ($cit_id > 63) {
                    $qh = get_district($cit_id);
                    $alias_qh = vn_str_filter($qh['cit_name']);
                    $city = $qh['cit_parent'];
                    $url = $url . 'tai-' . $alias_qh . '-nn' . $nn_id . 'qh' . $cit_id . '.html';
                } else if ($cit_id > 0) {
                    $alias_tt = vn_str_filter(get_city($cit_id));
                    $url = $url . 'tai-' . $alias_tt . '-nn' . $nn_id . 'tt' . $cit_id . '.html';
                } else {
                    $url = $url . 'nn' . $nn_id . 'tt0.html';
                }
                if ($nn_id == 0 && $cit_id == 0) {
                    $url = 'tim-viec-lam.html';
                }
            }
        }
        echo json_encode(['url' => $url]);
    }
    //Xem thông tin ứng viên
    public function ntd_see_uv()
    {
        $id_ntd = $_COOKIE['UserId'];
        $id_uv = $this->input->post('id_uv');
        $create_date = intval(time());
        $result = $this->Models->select_data('*', 'user_uv', [], ['uv_id' => $id_uv], '', '', '');

        $check_see_uv   =  $this->Models->select_sql('see_uv', '*', array('id_ntd' => $id_ntd, 'id_uv' => $id_uv), null, null, null, null, null, 0);
        if ($check_see_uv == null) {
            $data_insert = [
                'id_ntd' => $id_ntd,
                'id_uv' => $id_uv,
                "status" => 0,
                "create_date" => $create_date,
            ];
            $insert = $this->Models->insert_data('see_uv', $data_insert);
            $dataNoti = array(
                'type' => 1, // thông báo của uv
                'id_uv' => $id_uv,
                'id_ntd' => $id_ntd,
                'id_new' => 0,
                'status' => 2, //1: ntd lưu uv, 2: ntd mở tt uv, 3: uv lưu tin, 4:uv ut tin ,  5 : ntd đã xem 
                'create_date' => $create_date,
            );
            $insertNoti = $this->Models->insert_data('notification', $dataNoti);

            $delete = array(
                'type' => 3, // thông báo của uv
                'id_uv' => $id_uv,
                'id_ntd' => $id_ntd,
                'id_new' => 0,
                'status' => 5, //1: ntd lưu uv, 2: ntd mở tt uv, 3: uv lưu tin, 4:uv ut tin ,  5 : ntd đã xem 

            );
            $insertNoti =  $this->Models->delete_data('notification', $delete);


            // giảm điểm
            if (isset($_COOKIE['point'])) {
                $point = $_COOKIE['point'] - 1;
                setcookie('point', $point, time() + 86400, '/');
            }
            $update = $this->Models->inc_data('user_ntd', ['ntd_diem' => 'ntd_diem-1'], ['ntd_id' => $id_ntd]);

            $info_uv   =  $this->Models->select_sql('see_uv', 'see_uv.*, user_uv.uv_email, user_uv.uv_phone', array('see_uv.id' => $insert), null, array('user_uv' => 'see_uv.id_uv = user_uv.uv_id'), null, null, null, 0);
            $data = array('kq' => true, 'uv_phone' => $info_uv['uv_phone'], 'uv_email' => $info_uv['uv_email']);
            $send_mail = $this->globals->send_mail_see_uv(base_url() . '/EmailTemplate/Email_tb_ntd_da_xem.html', $_COOKIE['email'], $_COOKIE['Name'], $result->row_array()['uv_email'], $result->row_array()['uv_name'], 'Thông báo từ vieclamtheogio');
        } else {
            $data = array('kq' => false);
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    // lưu tin, bỏ lưu tin
    public function save_new()
    {
        $id_ntd = $this->input->post('id_ntd');
        $id_new = $this->input->post('id_new');
        $create_date = intval(time());

        $check_save_new   =  $this->Models->select_sql('save_new', '*', array('id_uv' => $_COOKIE['UserId'], 'id_new' => $id_new), null, null, null, null, null, 0);

        if ($check_save_new == null) {
            $data = array(
                'id_uv' => $_COOKIE['UserId'],
                'id_ntd' => $id_ntd,
                'id_new' => $id_new,
                'create_date' => $create_date,
            );
            $insert = $this->Models->insert_data('save_new', $data);
            $dataNoti = array(
                'type' => 2, // thông báo của ntd
                'id_uv' => $_COOKIE['UserId'],
                'id_ntd' => $id_ntd,
                'id_new' => $id_new,
                'status' => 3, //1: ntd lưu uv, 2: ntd xem tt uv, 3: uv lưu tin, 4:uv ut tin 
                'create_date' => $create_date,
            );
            $insertNoti = $this->Models->insert_data('notification', $dataNoti);
        } else {
            $condition = ['id_uv' => $_COOKIE['UserId'], 'id_new' => $id_new];
            $delete = $this->Models->delete_data('save_new', $condition);
        }
    }
    //xóa tin đã ứng tuyển
    public function del_new_applied()
    {
        $id_apply = $this->input->post('id_apply');

        $condition = ['id' => $id_apply];
        $delete = $this->Models->delete_data('apply_new', $condition);
    }
    //ứng tuyển
    public function apply_new()
    {
        $ds_ca_1 = $this->input->post('ds_ca_1');
        $ds_ca_2 = $this->input->post('ds_ca_2');
        $ds_ca_3 = $this->input->post('ds_ca_3');
        $id_new = $this->input->post('id_new');
        $id_ntd = $this->input->post('id_ntd');
        $id_user = $this->input->post('id_user');
        $note_ntd = $this->input->post('note_ntd');
        // insert bảng ứng tuyển
        $data = array(
            'id_uv' => $id_user,
            'id_ntd' => $id_ntd,
            'id_new' => $id_new,
            'calamviec' => $ds_ca_1,
            'lichlamviec' => $ds_ca_2,
            'giolam' => $ds_ca_3,
            'status' => 0,
            'note' => $note_ntd,
            'create_date' => time(),
            'update_date' => time(),
        );
        $result_1 = $this->Models->insert_data('apply_new', $data);
        // insert bảnh thông báo
        $data = array(
            'type' => 2,
            'id_uv' => $id_user,
            'id_ntd' => $id_ntd,
            'id_new' => $id_new,
            'status' => 4,
            'create_date' => time(),
        );
        $result_2 = $this->Models->insert_data('notification', $data);
        // tăng số lượt ứng tuyển
        $update = $this->Models->inc_data('new', ['so_uv_ungtuyen' => 'so_uv_ungtuyen+1'], ['new_id' => $id_new]);
        echo json_encode(['id_ut' => $result_1, 'id_tb' => $result_2, 'inc' => $update]);
    }
    // xóa tất cả thông báo
    public function del_all_notify()
    {
        $user = $_COOKIE['UserId'];

        if ($_COOKIE['Type'] == 3) {
            $condition = ['id_uv' => $user, 'type' => 1];
        } else if ($_COOKIE['Type'] == 4) {
            $condition = ['id_ntd' => $user, 'type' => 2];
        }
        $delete = $this->Models->delete_data('notification', $condition);
    }
    //Làm mới hồ sơ ứng viên
    public function lammoi_hsuv()
    {
        $id_uv = $this->input->post('id_uv');
        if ($id_uv != 0) {
            $get_uv = $this->Models->select_sql('user_uv', 'date_refresh,number_refresh', array('uv_id' => $id_uv), null, null, null, null, null, 0);
            if ($get_uv['number_refresh'] == 0) {
                $result = ['kq' => false];
            } else {
                $date = intval(time());
                $data_update = [
                    "date_refresh" => $date,
                    'number_refresh' => $get_uv['number_refresh'] - 1
                ];
                $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $id_uv));

                $result = ['kq' => true];
            }
            echo json_encode($result);
        }
    }
    //bật tắt cho phép ntd tìm kiếm uv
    public function ntd_found_uv()
    {
        $id_uv = $this->input->post('id_uv');
        $get_uv = $this->Models->select_sql('user_uv', 'uv_found', array('uv_id' => $id_uv), null, null, null, null, null, 0);
        if ($get_uv['uv_found'] == 0) {
            $data_update = ["uv_found" => 1];
        } else if ($get_uv['uv_found'] == 1) {
            $data_update = ["uv_found" => 0];
        }
        $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $id_uv));
    }
    //Làm mới tin đăng
    public function refresh_new()
    {
        $id_new = $this->input->post('id_new');
        $date = intval(time());

        $get_new = $this->Models->select_sql('new', 'date_refresh,number_refresh,new_user_id', array('new_id' => $id_new), null, null, null, null, null, 0);
        $data_update = [
            "date_refresh" => $date,
            'number_refresh' => $get_new['number_refresh'] + 1
        ];
        $update = $this->Models->update_data('new', $data_update, array('new_id' => $id_new));
    }
    //xóa tin đã đăng
    public function delete_new()
    {
        $id_new = $this->input->post('id_new');
        $result = $this->Models->delete_data('new', ['new_id' => $id_new]);
    }
    public function ntd_del_uvtdl()
    {
        $id_uv_del_uvtdl = $this->input->post('id_uv');
        $id_ntd_del_uvtdl = $this->input->post('id_ntd');
        $result = $this->Models->delete_data(' see_uv', ['id_ntd' => $id_ntd_del_uvtdl, 'id_uv' => $id_uv_del_uvtdl]);
    }
    //uv đăng ký lỗi
    public function dang_ky_uv_loi()
    {
        $post_data = $this->input->post();
        $condition = 'uv_email = "' . $post_data['uv_email'] . '" OR uv_phone = "' . $post_data['uv_phone'] . '"';
        $result = $this->Models->select_data('id', 'user_uv_error', [], $condition, '', '', '');
        if ($result->num_rows() > 0) {
            // update
            $update = $this->Models->update_data('user_uv_error', $post_data, $condition);
            echo json_encode(['kq' => $update]);
        } else {
            // add
            $result = $this->Models->insert_data('user_uv_error', $post_data);
            if ($result > 0) {
                echo json_encode(['kq' => true]);
            } else {
                echo json_encode(['kq' => false]);
            }
        }
    }
    //ntd đăng ký lỗi
    public function ntd_loi()
    {
        $post_data = $this->input->post();
        $condition = 'ntd_email = "' . $post_data['ntd_email'] . '" OR ntd_phone = "' . $post_data['ntd_phone'] . '"';
        $result = $this->Models->select_data('id', 'user_ntd_error', [], $condition, '', '', '');
        if ($result->num_rows() > 0) {
            // update
            $update = $this->Models->update_data('user_ntd_error', $post_data, $condition);
            echo json_encode(['kq' => $update]);
        } else {
            // add
            $result = $this->Models->insert_data('user_ntd_error', $post_data);
            if ($result > 0) {
                echo json_encode(['kq' => true]);
            } else {
                echo json_encode(['kq' => false]);
            }
        }
    }
    public function lamMoiTin()
    {
        $id_ntd = $_COOKIE['UserId'];
        $id_new = $this->input->post('id');
        $update = $this->Models->update_data('new', ['new_updated_time' => getdate()[0]], ['new_id' => $id_new]);
        if (isset($_COOKIE['point'])) {
            $point = $_COOKIE['point'] - 1;
            setcookie('point', $point, time() + 86400, '/');
        }
        $update = $this->Models->inc_data('user_ntd', ['ntd_diem' => 'ntd_diem-1'], ['ntd_id' => $id_ntd]);
    }
}
