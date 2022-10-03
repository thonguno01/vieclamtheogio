<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prev_login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Models');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('func_helper');
        // $this->load->library('session');
    }
    public function signup()
    {
        $data['css'] = [
            'includes/login'
        ];
        $data['content'] = 'prev_login/signup';
        $this->load->view('template', $data);
    }
    public function login()
    {
        $data['css'] = [
            'includes/login'
        ];
        $data['content'] = 'prev_login/login';
        $this->load->view('template', $data);
    }
    public function login_epl()
    {
        $data['css'] = ['includes/login_epl'];
        $data['js'] = ['includes/login'];
        $data['content'] = 'prev_login/login_epl';
        $this->load->view('template', $data);
    }
    public function login_uv()
    {
        $data['content'] = '/prev_login/login_uv';
        $data['css'] = array('includes/login_uv');
        $data['js'] = array('includes/login_uv');
        $this->load->view('template', $data, FALSE);
    }
    public function dky_uv()
    {
        $data['css'] = ['includes/dang_ky_uv'];
        $data['js'] = ['includes/dang_ky_uv'];
        $data['content'] = 'prev_login/dang_ky_uv';
        $this->load->view('template', $data);
    }
    public function dky_ntd()
    {
        $data['content'] = 'nhatuyendung/dangky_ntd';
        $data['css'] = array('includes/dangky_ntd');
        $data['js'] = array('includes/dangky_ntd');

        $this->load->view('template', $data, FALSE);
    }
    public function gui_mail_xac_thuc_uv()
    {
        $data['content'] = 'prev_login/xac_thuc';
        $data['css'] = array('includes/xac_thuc');
        $data['js'] = array('includes/xac_thuc_uv');

        $this->load->view('template', $data, FALSE);
    }

    public function dky_uv_success($email, $id, $code)
    {
        $select = " uv_id";
        $condition = [
            'uv_email' => $email,
            'uv_id' => $id,
            'uv_token' => $code,
            'uv_authentic' => 0,
        ];
        $result = $this->Models->select_where_and($select, 'user_uv', $condition);
        if (count($result->result_array()) == 1) {
            $n_dky_email = $this->Models->select_where_and('date_refresh,number_refresh,uv_authentic ,uv_name,uv_id ,uv_avatar, uv_createtime ', 'user_uv', $condition)->row_array();
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
                    setcookie('Type', 3, time() + 86400, '/');
                    $cre_time = $n_dky_email[0]['uv_createtime'];
                    $path = '/upload/uv/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time) . '/' . $n_dky_email[0]['uv_avatar'];
                    setcookie('avatar', $path, time() + 86400, '/');
                }
            }
            $data = [
                'uv_authentic' => 1
            ];
            $result = $this->Models->update_where_and($data, 'user_uv', $condition);
            if ($result == true) {
                header("Location: /quan-ly-chung-ung-vien");
            } else {
                echo 'Xác thực không thành công';
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /page-404");
            }
        } else {
            echo 'Link không tồn tại';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /");
        }
        $data['content'] = 'prev_login/dky_success';
        $data['css'] = array('includes/dky_success');

        $this->load->view('template', $data, FALSE);
    }

    public function gui_mail_xac_thuc_ntd()
    {
        $data['content'] = 'prev_login/xac_thuc';
        $data['css'] = array('includes/xac_thuc');
        $data['js'] = array('includes/xac_thuc_ntd');

        $this->load->view('template', $data, FALSE);
    }


    public function dky_ntd_success($email, $id, $code)
    {
        $select = 'ntd_id';
        $condition = [
            'ntd_email' => $email,
            'ntd_id' => $id,
            'ntd_token' => $code,
            'ntd_authentic' => 0,
        ];
        // var_dump($condition);
        // die;
        // $condition = 'ntd_email = "'.$email.'" AND ntd_id = '.$id.' AND ntd_token = '.$code;
        $result = $this->Models->select_where_and($select, 'user_ntd', $condition);
        if (count($result->result_array()) == 1) {
            $condition1 = ['ntd_email' => $email];
            $infor = $this->Models->select_where_and('*', 'user_ntd', $condition1);
            $infor = $infor->row_array();
            $time_max = strtotime(date('d-m-Y', $infor['update_diem_time'])) + 24 * 60 * 60 - 1;
            setcookie('UserId', $infor['ntd_id'], time() + 86400, '/');
            setcookie('Name', $infor['ntd_company'], time() + 86400, '/');
            setcookie('email', $email, time() + 86400, '/');
            setcookie('Type', 4, time() + 86400, '/');
            setcookie('point_exp', ($infor['ntd_han_diem'] > 0) ? $infor['ntd_han_diem'] : time(), time() + 86400, '/');
            $cre_time = $infor['ntd_create_time'];
            $path = '/upload/ntd/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time) . '/' . $infor['ntd_avatar'];
            setcookie('avatar', $path, time() + 86400, '/');
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
            $data = [
                'ntd_authentic' => 1
            ];
            $result = $this->Models->update_where_and($data, 'user_ntd', $condition);
            // die();  
            if ($result == true) {
                header("Location: /quan-ly-chung-ntd");
            } else {
                echo 'xác thực ko thành công';
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /page-404");
            }
        } else {
            echo 'link ko tồn tại';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /quan-ly-chung-ntd");
        }
        $data['content'] = 'prev_login/dky_success';
        $data['css'] = array('includes/dky_success');

        $this->load->view('template', $data, FALSE);
    }

    public function forget_pwd_ntd()
    {

        $data['content'] = 'prev_login/forget_pwd';
        $data['css'] = array('includes/forget_pwd');
        $data['js'] = array('includes/forget_pwd_ntd', 'jquery.form');

        $this->load->view('template', $data, FALSE);
    }

    public function forget_pwd_uv()
    {

        $data['content'] = 'prev_login/forget_pwd';
        $data['css'] = array('includes/forget_pwd');
        $data['js'] = array('includes/forget_pwd_uv', 'jquery.form');

        $this->load->view('template', $data, FALSE);
    }

    public function forget_pwd_send_mail_ntd()
    {
        $data['content'] = 'prev_login/forget_pwd_send_mail';
        $data['css'] = array('includes/forget_pwd_send_mail');
        $data['js'] = array('includes/forget_pwd_send_mail_ntd');

        $this->load->view('template', $data, FALSE);
    }

    public function forget_pwd_send_mail_uv()
    {
        $data['content'] = 'prev_login/forget_pwd_send_mail';
        $data['css'] = array('includes/forget_pwd_send_mail');
        $data['js'] = array('includes/forget_pwd_send_mail_uv');

        $this->load->view('template', $data, FALSE);
    }

    public function forget_pwd_change_pwd_ntd($email, $id, $code)
    {
        $data['type'] = 2; // 1 là uv, 2 là ntd
        $data['id'] = $id;
        $data['content'] = 'prev_login/forget_pwd_change_pwd';
        $data['css'] = array('includes/forget_pwd_change_pwd');
        $data['js'] = array('includes/forget_pwd_change_pwd', 'jquery.form');

        $this->load->view('template', $data, FALSE);
    }

    public function forget_pwd_change_pwd_uv($email, $id, $code)
    {
        $data['type'] = 1; // 1 là uv, 2 là ntd
        $data['id'] = $id;
        $data['content'] = 'prev_login/forget_pwd_change_pwd';
        $data['css'] = array('includes/forget_pwd_change_pwd');
        $data['js'] = array('includes/forget_pwd_change_pwd', 'jquery.form');

        $this->load->view('template', $data, FALSE);
    }

    public function forget_pwd_success()
    {
        $data['content'] = 'prev_login/forget_pwd_success';
        $data['css'] = array('includes/forget_pwd_success');

        $this->load->view('template', $data, FALSE);
    }
}
