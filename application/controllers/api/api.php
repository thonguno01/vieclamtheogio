<?php
require_once "jwt/JWT.php";


use \Firebase\JWT\JWT;

defined('BASEPATH') or exit('No direct script access allowed');
class api extends CI_Controller
{
    protected $secretKey = '@api-vieclamtheogio-vieclam123';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Models');
        $this->load->model('Ajax_model');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('Globals');
        $this->load->helper('func_helper');
        $this->load->helper(array('url', 'form'));
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    // Xây dựng hàm xử lý chung
    public function success($msg, $data)
    {
        $result = [
            'result'  => true,
            'message' => $msg,
            'data'    => $data,
        ];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function set_error($code, $msg, $data = [])
    {
        $result = [
            'result'  => false,
            'code'    => $code,
            'message' => $msg,
        ];
        if (!empty($data)) {
            $result['data'] = $data;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['authorization'])) {
            //Nginx or fast CGI
            $headers = trim($_SERVER["authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public function getTokens()
    {
        $authorizationHeader = $this->getAuthorizationHeader();
        if ($authorizationHeader == null) {
            header('HTTP/1.0 401 Unauthorized');
            header('Content-Type: application/json; charset=utf-8');
            $this->set_error(401, "No authorization header sent.");
            exit();
        }

        $authorizationHeader = str_replace('bearer ', '', $authorizationHeader);
        $token               = str_replace('Bearer ', '', $authorizationHeader);
        $decoded_token       = null;
        try {
            $decoded_token = JWT::decode($token, $this->secretKey, array('HS256'));

            if ($decoded_token->data == null) {
                header('HTTP/1.0 401 Unauthorized');
                header('Content-Type: application/json; charset=utf-8');
                $this->set_error(401, "Data token unregconized.");
                exit();
            }
        } catch (Exception $e) {
            header('HTTP/1.0 401 Unauthorized');
            header('Content-Type: application/json; charset=utf-8');
            $this->set_error(401, $e->getMessage());
            exit();
        }

        return $decoded_token;
    }

    public function checkNull($array)
    {
        if (is_array($array)) {
            foreach ($array as $item) {
                if ($item == '') {
                    return false;
                }
            }
            return true;
        }
    }

    public function getAllData($method, $data = [])
    {
        $lists = [];
        if ($method == 'post') {
            foreach ($data as $item) {
                $lists[$item] = $this->input->post($item);
            }
        } else {
            foreach ($data as $item) {
                $lists[$item] = $this->input->get($item);
            }
        }
        return $lists;
    }
    public function checkUploadImgNTD($token, $name_input, $size)
    {
        $flag = true;
        $avt = ($token == '') ? '' : $token->data->avatar;
        $cre_time = explode('/', ($avt));
        $path = 'upload/ntd/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];
        $avatar_name = $cre_time[6];
        $avata_error =  "";
        if (isset($_FILES[$name_input]) && $_FILES[$name_input]['name'] != '') {
            $check_er = true;
            $file_parts = explode('.', $_FILES[$name_input]['name']);
            $file_ext = strtolower(end($file_parts));
            $expensions = array("jpeg", "jpg", "png", 'jfif', 'gif');
            if (in_array($file_ext, $expensions) === false) {
                $check_er = false;
                $flag = false;
                $avata_error = "Chỉ hỗ trợ upload file JPEG , GIF , JFIF hoặc PNG.";
            }
            if ($_FILES[$name_input]["size"] > $size) {
                $check_er = false;
                $flag = false;
                $avata_error =  "Dung lượng ảnh quá " . $size / 1000000 . 'MB';
            }
            if ($check_er == true) {
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }
                $temp = explode('.', $_FILES[$name_input]['name']);
                $avatar_name = $name_input . '_' . time() . '.' . $temp[1];
                // 
            }
        }
        return ['avartar_name' => $avatar_name, 'avatar_error' => $avata_error, 'flag' => $flag];
    }
    public function checkUploadImgNTD1($name_input, $size)
    {
        $flag = true;
        $cre_time = intval(time());
        $path = 'upload/ntd/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
        $avatar_name = '';
        $avata_error =  "";
        if (isset($_FILES[$name_input]) && $_FILES[$name_input]['name'] != '') {
            $check_er = true;
            $file_parts = explode('.', $_FILES[$name_input]['name']);
            $file_ext = strtolower(end($file_parts));
            $expensions = array("jpeg", "jpg", "png", 'jfif', 'gif');
            if (in_array($file_ext, $expensions) === false) {
                $check_er = false;
                $flag = false;
                $avata_error = "Chỉ hỗ trợ upload file JPEG , GIF , JFIF hoặc PNG.";
            }
            if ($_FILES[$name_input]["size"] > $size) {
                $check_er = false;
                $flag = false;
                $avata_error =  "Dung lượng ảnh quá " . $size / 1000000 . 'MB';
            }
            if ($check_er == true) {
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }
                $temp = explode('.', $_FILES[$name_input]['name']);
                $avatar_name = $name_input . '_' . time() . '.' . $temp[1];
                // 
            }
        }
        return ['avartar_name' => $avatar_name, 'avatar_error' => $avata_error, 'flag' => $flag];
    }
    // Kết thúc xây dựng hàm chung

    // Hàm lấy thông tin chung
    // danh sách tỉnh thành 
    public function list_city()
    {
        $id = $this->getAllData('get', ['city']);
        if (!$this->checkNull($id)) {
            $id = 0;
        } else {
            $id = $id['city'];
        }
        $data = $this->Models->select_data('cit_id, cit_name', 'city2', [], [
            'cit_parent' => $id,
        ])->result();
        $message = ($id == 0) ? "Danh sách tỉnh thành" : "Danh sách quận huyện theo tỉnh thành";
        $this->success($message, $data);
    }
    // danh sách nghành nghề 
    public function list_category()
    {
        $id = $this->getAllData('get', ['category']);
        $id = $this->checkNull($id) ? $id['category'] : 0;
        $condition = ($id != 0) ? ['cat_id' => $id] : [];
        $select = 'cat_id,cat_name,cat_alias';
        $table = 'category';
        $querry = $this->Models->select_where_and($select, $table, $condition)->result_array();
        foreach ($querry as $value) {
            $arr[] = $value;
        }
        $data      = $arr;
        // var_dump($data);
        $message   = "Danh sách ngành nghề";
        $this->success($message, $data);
    }
    // danh sách tag 
    public function  list_category_tag()
    {
        $id = $this->getAllData('get', ['tag']);
        $id = $this->checkNull($id) ? $id['tag'] : 0;
        $select = 'tag_id,tag_name,tag_parent,tag_alias';
        $table = 'category_tag';
        $condition = ($id != 0) ? ['tag_id' => $id] : [];
        $querry = $this->Models->select_where_and($select, $table, $condition)->result_array();
        foreach ($querry as $value) {
            $arr[] = $value;
        }
        $data      = $arr;
        $message   = "Danh sách Tag";
        $this->success($message, $data);
    }
    // danh sách trang thái ứng tuyển 
    public function stt_ut()
    {
        $htlv =  [
            0 => ['key' => 0, 'value' => 'Đã nộp'],
            1 => ['key' => 1, 'value' => 'Đến phỏng vấn'],
            2 => ['key' => 2, 'value' => 'Hồ sơ đạt yêu cầu'],
            3 => ['key' => 3, 'value' => 'Hồ sơ không đạt yêu cầu'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $id = $htlv;
        } else {
            $id = $htlv[$id['index']];
        }
        $this->success('Danh sách Hình thức làm việc ', $id);
    }

    //    danh sách hình thức việc làm
    public function hinh_thuc_viec_lam()
    {
        $htlv =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Làm việc tại công ty'],
            2 => ['key' => 2, 'value' => 'Làm việc online (Remote)'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $id = $htlv;
        } else {
            $id = $htlv[$id['index']];
        }
        $this->success('Danh sách Hình thức làm việc ', $id);
    }
    public function hinh_thuc_tra_luong()
    {
        $htlv =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Trả lương theo giờ'],
            2 => ['key' => 2, 'value' => 'Trả lương theo tuần'],
            3 => ['key' => 3, 'value' => 'Trả lương theo ngày'],
            4 => ['key' => 4, 'value' => 'Trả lương theo tháng'],
            5 => ['key' => 5, 'value' => 'Trả lương theo dự án'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $id = $htlv;
        } else {
            $id = $htlv[$id['index']];
        }
        $this->success('Danh sách Hình thức làm việc ', $id);
    }
    // danh sách loại hình làm việc
    public function loai_hinh_lam_viec()
    {

        $arr =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Bán thời gian'],
            2 => ['key' => 2, 'value' => 'Toàn thời gian'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $arr = $arr;
        } else {
            $arr = $arr[$id['index']];
        }
        $this->success('Danh sách Loại hình làm việc ', $arr);
    }
    // ds giới tính
    public function sex()
    {
        $arr =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Nam'],
            2 => ['key' => 2, 'value' => 'Nữ'],
            3 => ['key' => 3, 'value' => 'Không yêu cầu'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $arr = $arr;
        } else {
            $arr = $arr[$id['index']];
        }
        $this->success('Danh sách  giới tính  ', $arr);
    }
    // ds tình trạng hôn nhân 
    public function tinh_trang_hon_nhan()
    {
        $arr =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Độc thân'],
            2 => ['key' => 2, 'value' => 'Kết hôn'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $arr = $arr;
        } else {
            $arr = $arr[$id['index']];
        }
        $this->success('Danh sách Tình trạng hôn nhân  ', $arr);
    }
    // ds hình thức trả lương  
    public function kieu_tra_luong()
    {
        $arr =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Cố định'],
            2 => ['key' => 2, 'value' => 'Ước lượng'],
            3 => ['key' => 3, 'value' => 'Thỏa thuận'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $arr = $arr;
        } else {
            $arr = $arr[$id['index']];
        }
        $this->success('Danh sách Tình trạng hôn nhân  ', $arr);
    }
    // vị trí cấp bậc 
    public function cap_bac()
    {
        $arr =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Mới tốt nghiệp'],
            2 => ['key' => 2, 'value' => 'Thực tập sinh'],
            3 => ['key' => 3, 'value' => 'Nhân viên'],
            4 => ['key' => 4, 'value' => 'Trưởng nhóm'],
            5 => ['key' => 5, 'value' => 'Trưởng phòng'],
            6 => ['key' => 6, 'value' => 'Giám đốc và cấp cao hơn'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $arr = $arr;
        } else {
            $arr = $arr[$id['index']];
        }
        $this->success('Danh sách Cấp bậc', $arr);
    }
    // ds học vấn
    public function hoc_van()
    {
        $arr =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Không yêu cầu'],
            2 => ['key' => 2, 'value' => 'Đại học'],
            3 => ['key' => 3, 'value' => 'Cao đẳng'],
            4 => ['key' => 4, 'value' => 'Phổ thông'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $arr = $arr;
        } else {
            $arr = $arr[$id['index']];
        }
        $this->success('Danh sách Học vấn ', $arr);
    }
    public function kinh_nghiem()
    {
        $arr =  [
            0 => ['key' => 0, 'value' => 'Tất cả '],
            1 => ['key' => 1, 'value' => 'Không yêu cầu'],
            2 => ['key' => 2, 'value' => 'Dưới 1 năm'],
            3 => ['key' => 3, 'value' => '1-2 năm'],
            4 => ['key' => 4, 'value' => 'Trên 20 năm'],
        ];
        $id = $this->getAllData('get', ['index']);
        if (!$this->checkNull($id)) {
            $arr = $arr;
        } else {
            $arr = $arr[$id['index']];
        }
        $this->success('Danh sách Kinh nghiệm làm việc', $arr);
    }
    // hàm lấy mỗi id
    public function getId()
    {
        $input_post = ['id'];
        $data_post = $this->getAllData('post', $input_post);
        $dataToken['data'] = [
            'id' => $data_post['id'],
        ];
        $token = JWT::encode($dataToken, $this->secretKey, 'HS256');
        $this->success('Bạn lấy id thành công', ['token_id' => $token]);
    }

    public function get_luong($uv_luong_1, $uv_luong_2, $uv_luong_3)
    {
        if ($uv_luong_1 == 1) {
            $luong = get_htl($uv_luong_1) . ' - ' . $uv_luong_2 . 'đ' . '/' . get_ml($uv_luong_3);
        } else if ($uv_luong_1 == 2) {
            $arr_price = explode('-', $uv_luong_2);
            $price_start = $arr_price[0];
            $price_end = $arr_price[1];
            $luong = get_htl($uv_luong_1) . ' - ' . $price_start . ' - ' . $price_end . 'đ' . '/' . get_ml($uv_luong_3);
        } else if ($uv_luong_1 == 3 || $uv_luong_1 == 0) {
            $luong = 'Thỏa thuận';
        }
        return $luong;
    }
    // Kết thúc xây dựng hàm lấy thông tin chung

    // đăng nhập 3 là ứng viên 4 là nhà tuyển dụng 
    public function login()
    {
        $data_post = ['email', 'password', 'type'];
        $list = $this->getAllData('post', $data_post);
        if ($this->checkNull($list)) {
            if ($list['type'] == 4) {
                $select = 'ntd_authentic,ntd_company,ntd_id,ntd_avatar,ntd_create_time,ntd_email,update_diem_time,ntd_han_diem,ntd_diem';
                $condition = ['ntd_password' => md5($list['password']), 'ntd_email' => $list['email']];
                $infor = $this->Models->select_where_and($select, 'user_ntd', $condition);
                if ($infor->num_rows() == 1) {
                    $infor =  $infor->row_array();
                    if ($infor['ntd_authentic'] == 1) {
                        $cre_time = $infor['ntd_create_time'];
                        $path = '/upload/ntd/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time) . '/' . $infor['ntd_avatar'];
                        $time_max = strtotime(date('d-m-Y', $infor['update_diem_time'])) + 24 * 60 * 60 - 1;
                        if ($time_max <= time()) {
                            $data_update = [
                                "update_diem_time" => time(),
                                "ntd_diem" => 5,
                            ];
                            $update = $this->Models->update_data('user_ntd', $data_update, array('ntd_id' => $infor['ntd_id']));

                            $point = 5;
                            $point_exp =  strtotime(date('d-m-Y', time())) + 24 * 60 * 60 - 1;
                        } else {
                            $point =  $infor['ntd_diem'];
                            $point_exp =  $time_max;
                        }
                        $dataToken['data'] = [
                            'UserId' => $infor['ntd_id'],
                            'Name' => $infor['ntd_company'],
                            'email' => $list['email'],
                            'Type' => $list['type'],
                            'avatar' => $path,
                            'expired' => time() + 86400,
                            'point' => $point,
                            'point_exp' => $point_exp,
                        ];
                        $token = JWT::encode($dataToken, $this->secretKey, 'HS256');
                        $data_emp  = [
                            'token'      => $token,
                            'type_login' => $list['type'],
                            'UserId' => $infor['ntd_id'],
                            'Name' => $infor['ntd_company'],
                            'email' => $list['email'],
                            'Type' => $list['type'],
                            'avatar' => $path,
                        ];
                        $this->success('Đăng nhập thành công', $data_emp);
                    } else {
                        $data_emp = ['ntd_email' => $infor['ntd_email'], 'redirect' => 'chuyển đến page xác thực mã otp'];
                        $this->success('Tài khoản của quý khách chưa được xác thực ! Vui lòng vào gmail để xác thực', $data_emp);
                    }
                } else {
                    $this->set_error(200, 'Email hoặc mật khẩu bạn nhập chưa đúng');
                }
            } else {
                $n_dky_email = $this->Models->select_where_and('date_refresh,uv_email,number_refresh,uv_authentic ,uv_name,uv_id ,uv_avatar, uv_createtime ', 'user_uv', 'uv_pass="' . md5($list['password']) . '" AND uv_email="' . $list['email'] . '"')->result_array();
                if (count($n_dky_email) == 1) {
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
                        $cre_time = $n_dky_email[0]['uv_createtime'];
                        $path = '/upload/uv/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time) . '/' . $n_dky_email[0]['uv_avatar'];

                        $dataToken['data'] = [
                            'UserId' => $n_dky_email[0]['uv_id'],
                            'Name' =>  $n_dky_email[0]['uv_name'],
                            'email' => $list['email'],
                            'Type' => $list['type'],
                            'avatar' => $path,
                            'expired' => time() + 86400,
                        ];
                        $token = JWT::encode($dataToken, $this->secretKey, 'HS256');
                        $data_emp  = [
                            'token'      => $token,
                            'UserId' => $n_dky_email[0]['uv_id'],
                            'Name' =>  $n_dky_email[0]['uv_name'],
                            'email' => $list['email'],
                            'Type' => $list['type'],
                            'avatar' => $path,
                        ];
                        $this->success('Đăng nhập thành công', $data_emp);
                    } else {
                        $data_emp = [
                            'uv_email' => $list['email'],
                            'redirect' => 'chuyển đến page xác thực mã otp',
                        ];
                        $this->success('Tài khoản của quý khách chưa được xác thực ! Vui lòng vào gmail để xác thực', $data_emp);
                    }
                } else {
                    $this->set_error(200, 'Email hoặc mật khẩu bạn nhập chưa đúng');
                }
            }
        } else {
            $this->set_error(200, 'Chưa nhập đủ thông tin');
        }
    }
    //==================Luồng công ty=============
    public function dangky_ntd()
    {
        $this->load->library('form_validation');
        $data_post = [
            'ntd_name', 'ntd_password', 'ntd_re_password', 'ntd_email', 'ntd_number', 'n_city', 'n_qh', 'ntd_address',
        ];
        $flag = true;
        $list = $this->getAllData('post', $data_post);
        // tên công ty
        $ntd_alias = vn_str_filter($list['ntd_name']);
        $condition = ['ntd_alias' => $ntd_alias];
        $result = $this->Models->select_where_and('ntd_email', 'user_ntd', $condition)->result_array();
        if (trim($list['ntd_name']) == '') {
            $flag = false;
            $flag_name = false;
            $name_error = 'Tên công ty không được bỏ trống';
        } else if (count($result) > 0) {
            $flag_name = false;
            $flag = false;
            $name_error = 'Tên công ty đã tồn tại trên hệ thống.';
        } else {
            $flag_name = true;
            $name_error = '';
        }
        // mật khẩu 
        $partten_pass = "/^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/";
        if (trim($list['ntd_password']) == '') {
            $flag = false;
            $pass_error = 'Mật khẩu không được bỏ trống';
        } else if (!preg_match($partten_pass, $list['ntd_password'])) {
            $flag = false;
            $pass_error = 'Mật khẩu tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách';
        } else {
            $pass_error = '';
        }
        if (trim($list['ntd_re_password']) == '') {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không được bỏ trống';
        } else if ($list['ntd_re_password'] != $list['ntd_password']) {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không trùng với mật khẩu ';
        } else {
            $re_pass_error = '';
        }
        // email 
        $checkEmail = $this->Ajax_model->check_email_ntd($list['ntd_email']);
        $regex_email = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12}+\.)(.[a-zA-Z]{2,12})+$/";
        if (trim($list['ntd_email']) == '') {
            $flag = false;
            $flag_mail = false;
            $email_error = 'Email không được bỏ trống';
        } else if (!preg_match($regex_email, $list['ntd_email'])) {
            $flag = false;
            $flag_mail = false;
            $email_error = 'Email chưa đúng định dạng';
        } elseif (count($checkEmail) > 0) {
            $flag = false;
            $flag_mail = false;
            $email_error = 'Email đã tồn tại trên hệ thống';
        } else {
            $flag_mail = true;
            $email_error = '';
        }
        // số điện thoại 
        $regex_tel = "/^((84|\+84|0)+[0-9]{9,14})$/";
        if (trim($list['ntd_number']) == '') {
            $flag = false;
            $flag_phone = false;
            $phone_error = 'Số điện thoại không được bỏ trống';
        } else if (!preg_match($regex_tel, $list['ntd_number'])) {
            $flag_phone = false;
            $flag = false;
            $phone_error = 'Số điện thoại chưa đúng định dạng';
        } else {
            $flag_phone = true;
            $phone_error = '';
        }
        // tỉnh thành 
        if ($list['n_city'] == '') {
            $flag = false;
            $city_error = 'Tỉnh thành không được bỏ trống';
        } else {
            $city_error = '';
        }
        if ($list['n_qh'] == '') {
            $flag = false;
            $district_error = 'Quận huyện không được bỏ trống';
        } else {
            $district_error = '';
        }
        if ($list['ntd_address'] == '') {
            $flag = false;
            $address_error = 'Địa chỉ cụ thể không được bỏ trống';
        } else {
            $address_error = '';
        }
        // check ảnh đại diện 
        $cre_time = intval(time());
        $path = 'upload/ntd/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
        $check1 = $this->checkUploadImgNTD1('avatar', 8000000);
        if ($check1['flag'] == false) {
            $flag = false;
            $avatar_error = $check1['avatar_error'];
        } else {
            $avatar_error = '';
        }
        if ($flag_mail == true  && $flag_phone == true) {
            $data_ntd_error = [
                'ntd_email' => $list['ntd_email'],
                'ntd_company' => $list['ntd_name'],
                'ntd_phone' => $list['ntd_number'],
            ];
            $condition = 'ntd_email = "' . $list['ntd_email'] . '" OR ntd_phone = "' . $list['ntd_number'] . '"';
            $result_nt_error = $this->Models->select_data('id', 'user_ntd_error', [], $condition, '', '', '');
            if ($result_nt_error->num_rows() > 0) {
                $update = $this->Models->update_data('user_ntd_error', $data_ntd_error, $condition);
            } else {
                // add
                $result_nt_error = $this->Models->insert_data('user_ntd_error', $data_ntd_error);
            }
        }
        $avatar_name = $check1['avartar_name'];
        if ($flag == false) {
            $data_ntd_error = [
                'name_error' => $name_error,
                'pass_error' => $pass_error,
                're_pass_error' => $re_pass_error,
                'email_error' => $email_error,
                'phone_error' => $phone_error,
                'district_error' => $district_error,
                'city_error' => $city_error,
                'address_error' => $address_error,
                'avatar_error' => $avatar_error,
            ];
            $this->set_error('error_form', 'Form bạn điền chưa đúng định dạng ', $data_ntd_error);
        } else {
            $cre_time = intval(time());
            $path = 'upload/ntd/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);


            $code = rand(100000, 999999);
            $ntd_alias = vn_str_filter($list['ntd_name']);
            $data = array(
                'ntd_email' => $list['ntd_email'],
                'ntd_phone' => $list['ntd_number'],
                'ntd_password' => md5($list['ntd_password']),
                'ntd_city' => $list['n_city'],
                'ntd_quanhuyen' => $list['n_qh'],
                'ntd_address' => $list['ntd_address'],
                'ntd_company' => $list['ntd_name'],
                'ntd_alias' => $ntd_alias,
                'ntd_authentic' => 0,
                'ntd_sign_up_from' => 2,
                'ntd_token' => $code,
                'ntd_create_time' => $cre_time,
                'ntd_update_time' => $cre_time,
                'ntd_avatar' => $avatar_name,
            );
            $result = $this->Models->insert_data('user_ntd', $data);
            $dataToken_dk_ntd['data'] = [
                'ntd_email' => $list['ntd_email'],
                'ntd_name' => $list['ntd_name'],
                'ntd_phone' => $list['ntd_number'],
                'expired' => time() + 86400,
            ];
            $token = JWT::encode($dataToken_dk_ntd, $this->secretKey, 'HS256');
            if ($result > 0) {
                $this->Models->delete_data('user_ntd_error', 'ntd_email = "' . $list['ntd_email'] . '" OR ntd_phone = "' . $list['ntd_number'] . '"');
                $send_mail = $this->globals->send_mail_xt_Otp_app(base_url() . 'EmailTemplate/Email_Xacthuc_OTP_App.html', $list['ntd_email'], $list['ntd_name'], $code, 'Xác thực đăng ký nhà tuyển dụng', 4, 'Xác thực tài khoản');

                if ($send_mail == true) {
                    $data = array('kq' => true, 'msg' => 'Đăng ký thành công');
                    $data_emp = [
                        'ntd_email' => $list['ntd_email'],
                        'ntd_phone' => $list['ntd_number'],
                        'token_dki_ntd' => $token,
                    ];
                    $this->success('Tài khoản quý khách đã đăng kí thành công  ! Vui lòng vào gmail để lấy mã xác thực OTP', $data_emp);
                } else {
                    $this->set_error('200', 'Đăng kí không thành công ');
                }
            } else {
                $this->set_error('200', 'Đăng kí không thành công ');
            }
        }
    }
    // xác thực nhà tuyển dụng 
    public function xac_thuc_otp()
    {
        $data_post = ['ntd_xt_otp'];
        $list = $this->getAllData('post', $data_post);
        $token = $this->getTokens();
        $email_xt_ntd = $token->data->ntd_email;
        $code = $this->Models->select_where_and('ntd_token ,ntd_authentic', 'user_ntd', ['ntd_email' => $email_xt_ntd])->row_array();
        if ($code["ntd_token"] == trim($list['ntd_xt_otp'])) {
            // if($code['ntd_authentic'])
            $up = $this->Models->update_data('user_ntd', ['ntd_authentic' => 1], array('ntd_email' => $email_xt_ntd));
            $data_emp = [
                'redirect' => 'Chuyển về trang quản lí  ntd',
            ];
            $this->success('Xác thực thành công mã otp', $data_emp);
        } else {
            $this->success('Mã xác thực nhập vào chưa đúng !Quý khách vui lòng  nhập lại .', ['redirect' => '']);
        }
    }
    // Quyên mật khẩu nhà tuyển dụng 
    public function forgot_pass_ntd()
    {
        $flag = true;
        $data_post = ['email_forgot'];
        $list = $this->getAllData('post', $data_post);
        $checkEmail = $this->Models->select_where_and('ntd_email,ntd_company', 'user_ntd', ['ntd_email' => $list['email_forgot']])->row_array();
        $regex_email = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12}+\.)(.[a-zA-Z]{2,12})+$/";
        if (trim($list['email_forgot']) == '') {
            $flag = false;
            $email_error = 'Email không được bỏ trống';
        } else if (!preg_match($regex_email, $list['email_forgot'])) {
            $flag = false;
            $email_error = 'Email chưa đúng định dạng';
        } elseif ($checkEmail ==  null) {
            $flag = false;
            $email_error = 'Email không tồn tại trên hệ thống';
        } else {
            $email_error = '';
        }
        if ($flag == false) {
            $this->set_error('error_form', $email_error);
        } else {
            $code = rand(100000, 999999);
            $update = $this->Models->update_data('user_ntd', ['ntd_token' => $code], array('ntd_email' => $list['email_forgot']));
            $send_mail = $this->globals->send_mail_xt_Otp_app(base_url() . 'EmailTemplate/Email_Xacthuc_OTP_App.html', $list['email_forgot'], $checkEmail['ntd_company'], $code, 'Quyên mật khẩu nhà tuyển dụng', 4, 'Quyên mật khẩu nhà tuyển dụng');
            if ($send_mail == true) {
                $dataToken_forgot_ntd['data'] = [
                    'forgot_email' =>  $list['email_forgot'],
                ];
                $token = JWT::encode($dataToken_forgot_ntd, $this->secretKey, 'HS256');
                $this->success('Mã xác thực đã được gửi! Quý khách vui lòng vào gmail để lấy mã xác thực', ['token_forgot_nrd' =>  $token]);
            } else {
                $this->set_error('error_mail', 'Email của bạn chưa đúng!');
            }
        }
    }
    //check mã otp khi quyên mật khẩu 
    public function change_pass_chek_otp_ntd()
    {
        $token = $this->getTokens();
        $data_post = ['otp_forgot'];
        $list = $this->getAllData('post', $data_post);
        $email = $token->data->forgot_email;
        $code = $this->Models->select_where_and('ntd_token ,ntd_authentic', 'user_ntd', ['ntd_email' => $email])->row_array();
        if ($code["ntd_token"] == trim($list['otp_forgot'])) {
            $dataToken_forgot_ntd['data'] = [
                'forgot_otp_email' =>  $email,
            ];
            $token = JWT::encode($dataToken_forgot_ntd, $this->secretKey, 'HS256');
            $data_emp = [
                'redirect' => 'Chuyển đến trang đổi mật khẩu mới',
                'token_forgot_otp' => $token,
            ];
            $this->success('Mã xác thực đúng ', $data_emp);
        } else {
            $this->set_error('error_form', 'Mã xác thực nhập vào chưa đúng !Quý khách vui lòng  nhập lại .');
        }
    }
    // đổi mật khẩu mới từ quyên mật khẩu 
    public function change_pass_ntd()
    {
        $token = $this->getTokens();
        $email = $token->data->forgot_otp_email;
        $flag = true;
        $data_post = ['new_pass', 'new_repass'];
        $list = $this->getAllData('post', $data_post);
        $new_pass = $list['new_pass'];
        $new_repass = $list['new_repass'];
        $partten_pass = "/^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/";
        if (trim($new_pass) == '') {
            $flag = false;
            $pass_error = 'Mật khẩu không được bỏ trống';
        } else if (!preg_match($partten_pass, $new_pass)) {
            $flag = false;
            $pass_error = 'Mật khẩu tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách';
        } else {
            $pass_error = '';
        }
        if (trim($new_repass) == '') {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không được bỏ trống';
        } else if ($new_repass != $new_pass) {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không trùng với mật khẩu ';
        } else {
            $re_pass_error = '';
        }
        if ($flag == false) {
            $data_error = [
                'new_pass' => $pass_error,
                'new_repass' => $re_pass_error,
            ];
            $this->set_error('error_form', $data_error);
        } else {
            $this->Models->update_data('user_ntd', ['ntd_password' => md5($new_pass)], array('ntd_email' => $email));
            $this->success('Đổi mật khẩu thành công', ['redirect' =>  'chuyển về trang đăng nhập nhà tuyển dụng']);
        }
    }
    // =========================Quản Lý Chung Nhà Tuyển Dụng=============================================
    // Quản lí chung 
    public function quan_ly_chung()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $count_refesh_new = $this->Models->select_data('sum(number_refresh) as total_view_new', 'new', [], array('new_user_id' => $token->data->UserId), '', '', '')->row_array();

            $join = array('user_uv u' => 'a.id_uv = u.uv_id', 'new n' => 'a.id_new = n.new_id');
            $uv_apllied = $this->Models->select_sql('apply_new a', 'a.id, u.uv_id', array('a.id_ntd' =>  $token->data->UserId), null, $join, array('a.id' => 'DESC'), null, null, 1);
            $uv_saved = $this->Models->select_sql('save_uv s', 's.id,u.uv_id', array('s.id_ntd' => $token->data->UserId), null, array('user_uv u' => 's.id_uv = u.uv_id'), array('s.id' => 'DESC'), null, null, 1);
            $uv_tdl =  $this->Models->select_sql('see_uv', 'see_uv.*, user_uv.uv_email, user_uv.uv_phone', array('see_uv.id_ntd' => $token->data->UserId), null, array('user_uv' => 'see_uv.id_uv = user_uv.uv_id'), null, null, null, 1);


            $date = strtotime(date("d-m-Y"));
            $date_start = strtotime('today midnight');
            $date_end = $date_start + 2 * 86400;
            $new = $this->Models->select_sql('new', 'new_id, new_han_nop,new_create_time', array('new_user_id' => $token->data->UserId), null, null, null, null, null, 1);
            $count_hethan = 0;
            $count_conhan = 0;
            $count_saphethan = 0;
            $count_new_day = 0;
            foreach ($new as $key => $value) {
                $new_han_nop = $value['new_han_nop'];
                $new_create_time = $value['new_create_time'];
                if ($new_han_nop < $date) {
                    $count_hethan += 1;
                } else {
                    $count_conhan += 1;
                }
                if ($date_start <= $new_han_nop && $new_han_nop <= $date_end) {
                    $count_saphethan += 1;
                }
                if ($date_start < $new_create_time && $new_create_time < $date_end) {
                    $count_new_day += 1;
                }
            }
            $data = [
                'name_ntd' =>  $token->data->Name,
                'avatar' =>  $token->data->avatar,
                'email' =>  $token->data->email,
                'uv_saved' => count($uv_saved),
                'uv_apllied' => count($uv_apllied),
                'uv_tdl' => count($uv_tdl),
                'count_new_hethan' =>   $count_hethan,
                'count_new_conhan' =>   $count_conhan,
                'count_new_saphethan' =>   $count_saphethan,
                'count_new_day' =>   $count_new_day,
            ];
            $this->success('quản lý chung ', $data);
        } else {
            $this->set_error('isLogin', 'Yêu cầu bạn cần đăng nhập để vào được quản lí chung ');
        }
    }

    // đổi mật khẩu 
    public function qlc_ntd_change_pass()
    {
        $flag = true;
        $data_post = ['old_pass', 'new_pass', 'new_repass'];
        $list = $this->getAllData('post', $data_post);
        $oldPass = $list['old_pass'];
        $newPass = $list['new_pass'];
        $newRePass = $list['new_repass'];
        $token = $this->getTokens();
        $email = $token->data->email;
        $condition = ['ntd_email' => $email, 'ntd_password' => md5($oldPass)];
        $result = $this->Models->select_where_and('ntd_password', 'user_ntd', $condition)->row_array();
        $partten_pass = "/^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/";
        if ($oldPass == '') {
            $flag = false;
            $error_old_pass = 'Mật khẩu hiện tại không được bỏ trống';
        } elseif ($result == null) {
            $flag = false;
            $error_old_pass = 'Mật khẩu hiện tại nhập vào không chính xác ';
        } else {
            $error_old_pass = '';
        }

        if ($newPass == '') {
            $flag = false;
            $error_new_pass = 'Mật khẩu mới không được bỏ trống';
        } else if (!preg_match($partten_pass, $newPass)) {
            $flag = false;
            $error_new_pass = 'Mật khẩu tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách';
        } else {
            $error_new_pass = '';
        }

        if (trim($newRePass) == '') {
            $flag = false;
            $error_new_repass = 'Nhập lại mật khẩu không được bỏ trống';
        } else if ($newRePass != $newPass) {
            $flag = false;
            $error_new_repass = 'Nhập lại mật khẩu không trùng với mật khẩu ';
        } else {
            $error_new_repass = '';
        }
        if ($flag == false) {
            $data_error = [
                'old_pass' => $error_old_pass,
                'new_pass' => $error_new_pass,
                'new_repass' => $error_new_repass,
            ];
            $this->set_error('error_form', $data_error);
        } else {
            $data = [
                'ntd_password' => md5($newPass),
            ];
            $condition = ['ntd_email' => $email];
            $change_pass = $this->Models->update_where_and($data, 'user_ntd', $condition);
            $this->success('Bạn đã đổi mật khẩu thành công ', []);
        }
    }
    // Tài khoản nhà tuyển dụng - thông tin cơ bản 
    // lấy thông tin nhà tuyển dụng 
    public function get_thong_tin_ntd()
    {
        $token = $this->getTokens();
        $email = $token->data->email;
        $result = $this->Models->select_where_and('*', 'user_ntd', ['ntd_email' => $email])->row_array();
        $this->success('Thôn tin nhà tuyển dụng ', $result);
    }
    // cập nhật thông tin cơ bản nhà tuyển dụng
    public function thong_tin_co_ban_ntd()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {

            $flag = true;
            $token = $this->getTokens();
            $email = $token->data->email;
            $data_post = ['ntd_name', 'ntd_number', 'n_city', 'n_qh', 'ntd_address', 'mst', 'zalo', 'skype', 'avatar', 'background'];
            $list = $this->getAllData('post', $data_post);
            // name ntd
            $ntd_name = $list['ntd_name'];
            $ntd_alias = vn_str_filter($list['ntd_name']);
            $condition = ['ntd_alias' => $ntd_alias];
            $result = $this->Models->select_where_and('ntd_email', 'user_ntd', $condition)->result_array();

            if (trim($list['ntd_name']) == '') {
                $flag = false;
                $name_error = 'Tên công ty không được bỏ trống';
            } else if (count($result) > 0) {
                $flag = false;
                $name_error = 'Tên công ty đã tồn tại trên hệ thống.';
            } else {
                $name_error = '';
            }
            // số điện thoại 
            $regex_tel = "/^((84|\+84|0)+[0-9]{9,14})$/";
            if (trim($list['ntd_number']) == '') {
                $flag = false;
                $phone_error = 'Số điện thoại không được bỏ trống';
            } else if (!preg_match($regex_tel, $list['ntd_number'])) {
                $flag = false;
                $phone_error = 'Số điện thoại chưa đúng định dạng';
            } else {
                $phone_error = '';
            }
            // tỉnh thành và quận huyện
            if ($list['n_city'] == '') {
                $flag = false;
                $city_error = 'Tỉnh thành không được bỏ trống';
            } else {
                $city_error = '';
            }
            if ($list['n_qh'] == '') {
                $flag = false;
                $district_error = 'Quận huyện không được bỏ trống';
            } else {
                $district_error = '';
            }
            // Địa chỉ cụ thể 
            if ($list['ntd_address'] == '') {
                $flag = false;
                $address_error = 'Địa chỉ cụ thể không được bỏ trống';
            } else {
                $address_error = '';
            }
            // mã số thuế 
            $regex_mst = "/^-?\d+$/";
            $mst = $list['mst'];
            if ($mst != '') {
                if (strlen($mst) == 10) {
                    if (!preg_match($regex_mst, $mst)) {
                        $flag = false;
                        $mst_error = 'Mã số thuế phải là số ';
                    } else {
                        $mst_error = '';
                    }
                } elseif (strlen($mst) == 13) {
                    if (!preg_match($regex_mst, $mst)) {
                        $flag = false;
                        $mst_error = 'Mã số thuế phải là số ';
                    } else {
                        $mst_error = '';
                    }
                } else {
                    $flag = false;
                    $mst_error = 'Mã số thuế gồm 10 hoặc 13 kí tự số  ';
                }
            } else {
                $mst_error = '';
            }

            // zalo va skype
            $regex_zalo = "/^((84|\+84|0)+[0-9]{9,14})$/";
            if (trim($list['zalo']) == '') {
                $flag = false;
                $zalo_error = 'Số điện thoại Zalo không được bỏ trống.';
            } elseif (!preg_match($regex_zalo, $list['zalo'])) {
                $flag = false;
                $zalo_error = 'Số điện thoại Zalo chưa đúng định dạng.';
            } else {
                $zalo_error = '';
            }
            $regex_skype = "/^((84|\+84|0)+[0-9]{9,14})$/";
            if (trim($list['skype']) == '') {
                $flag = false;
                $skype_error = 'Số điện thoại Skype không được bỏ trống.';
            } elseif (!preg_match($regex_skype, $list['skype'])) {
                $flag = false;
                $skype_error = 'Số điện thoại Skype chưa đúng định dạng.';
            } else {
                $skype_error = '';
            }
            // upload ảnh 
            $cre_time = explode('/', $token->data->avatar);
            $path = 'upload/ntd/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];
            if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] != '') {
                $check_er = true;
                $file_parts = explode('.', $_FILES['avatar']['name']);
                $file_ext = strtolower(end($file_parts));
                $expensions = array("jpeg", "jpg", "png", 'jfif', 'gif');
                if (in_array($file_ext, $expensions) === false) {
                    $check_er = false;
                    $flag = false;
                    $avata_error = "Chỉ hỗ trợ upload file JPEG hoặc PNG.";
                }
                if ($_FILES["avatar"]["size"] > 800000) {
                    $check_er = false;
                    $flag = false;
                    $avata_error =  "Dung lượng ảnh quá 8MB.";
                }
                if ($check_er == true) {
                    $avata_error =  "";
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $temp = explode('.', $_FILES['avatar']['name']);
                    $avatar_name = 'avatar_' . time() . '.' . $temp[1];
                    // 
                }
            } else {
                $avatar_name = $cre_time[6];
            }
            if (isset($_FILES['background']) && $_FILES['background']['name'] != '') {
                $check_er = true;
                $file_parts = explode('.', $_FILES['background']['name']);
                $file_ext = strtolower(end($file_parts));
                $expensions = array("jpeg", "jpg", "png", 'jfif', 'gif');
                if (in_array($file_ext, $expensions) === false) {
                    $check_er = false;
                    $flag = false;
                    $bg_error = "Chỉ hỗ trợ upload file JPEG hoặc PNG.";
                }
                if ($_FILES["background"]["size"] > 800000) {
                    $check_er = false;
                    $flag = false;
                    $bg_error =  "Dung lượng ảnh quá 8MB.";
                }
                if ($check_er == true) {
                    $bg_error =  "";
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $temp = explode('.', $_FILES['background']['name']);
                    $background_name = 'avatar_' . time() . '.' . $temp[1];
                    // 
                }
            } else {
                $background_name = $cre_time[6];
            }

            if ($flag == false) {
                $data_ntd_error = [
                    'name_error' => $name_error,
                    'phone_error' => $phone_error,
                    'district_error' => $district_error,
                    'city_error' => $city_error,
                    'address_error' => $address_error,
                    'mst_error' => $mst_error,
                    'zalo_error' => $zalo_error,
                    'skype_error' => $skype_error,
                    'avata_error' => $avata_error,
                    'bg_error' => $bg_error,
                ];
                $this->set_error('error_form', $data_ntd_error);
            } else {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);
                move_uploaded_file($_FILES['background']['tmp_name'], $path . '/' . $background_name);
                $code = rand(100000, 999999);
                $data = array(
                    'ntd_avatar' => $avatar_name,
                    'ntd_cover_background' => $background_name,
                    'ntd_company' => $list['ntd_name'],
                    'ntd_alias' => create_slug($list['ntd_name']),
                    'ntd_city' => $list['n_city'],
                    'ntd_quanhuyen' => $list['n_qh'],
                    'ntd_address' => $list['ntd_address'],
                    'ntd_phone' => $list['ntd_number'],
                    'ntd_msthue' => $list['mst'],
                    'ntd_zalo' => $list['zalo'],
                    'ntd_skype' => $list['skype'],
                    'ntd_token' => $code,
                );
                $condition = ['ntd_email' => $email];
                $result = $this->Models->update_where_and($data, 'user_ntd', $condition);
                if ($result > 0) {
                    $this->success('Cập nhật thông tin thành công', []);
                }
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập để sử dụng chứ năng này ');
        }
    }
    // Tài khoản nhà tuyển dụng - giới thiệu chung 
    public function gioi_thieu_chung_ntd()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $data_post = [
                'gtc', 'csptnl', 'chtt', 'salary', 'img1', 'img2', 'img3',
            ];
            $list =  $this->getAllData('post', $data_post);
            $flag = true;
            if (trim($list['gtc']) == '') {
                $flag = false;
                $gtc_error = 'Giới thiệu chung không được bỏ trống';
            } else {
                $gtc_error = '';
            }
            if (trim($list['csptnl']) == '') {
                $flag = false;
                $csptnl_error = 'Chính sách phát triển nhân lực chung không được bỏ trống';
            } else {
                $csptnl_error = '';
            }
            if (trim($list['chtt']) == '') {
                $flag = false;
                $chtt_error = 'Cơ hội thăng tiến không được bỏ trống';
            } else {
                $chtt_error = '';
            }
            if (trim($list['salary']) == '') {
                $flag = false;
                $salary_error = 'Lương, Thưởng, Lợi nhuận chung không được bỏ trống';
            } else {
                $salary_error = '';
            }
            // $check_img1 = $this->checkUploadImg($token, 'img1', 800000);

            $flag = true;
            $cre_time = explode('/', $token->data->avatar);
            $path = 'upload/ntd/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];
            $check1 = $this->checkUploadImgNTD($token, 'img1', 8000000);
            $check2 = $this->checkUploadImgNTD($token, 'img2', 8000000);
            $check3 = $this->checkUploadImgNTD($token, 'img3', 8000000);
            if ($check1['flag'] == false) {
                $flag = false;
                $img1_error = $check1['avatar_error'];
            } else {
                $img1_error = '';
            }
            if ($check2['flag'] == false) {
                $flag = false;
                $img2_error = $check2['avatar_error'];
            } else {
                $img2_error = '';
            }
            if ($check3['flag'] == false) {
                $flag = false;
                $img3_error = $check3['avatar_error'];
            } else {
                $img3_error = '';
            }
            $img1_name = $check1['avartar_name'];
            $img2_name = $check2['avartar_name'];
            $img3_name = $check3['avartar_name'];
            if ($flag == false) {
                $data_ntd_error = [
                    'gtc_error' => $gtc_error,
                    'csptnl_error' => $csptnl_error,
                    'chtt_error' => $chtt_error,
                    'salary_error' => $salary_error,
                    'img1_error' => $img1_error,
                    'img2_error' => $img2_error,
                    'img3_error' => $img3_error,
                ];
                $this->set_error('error_form', $data_ntd_error);
            } else {
                move_uploaded_file($_FILES['img1']['tmp_name'], $path . '/' . $img1_name);
                move_uploaded_file($_FILES['img2']['tmp_name'], $path . '/' . $img2_name);
                move_uploaded_file($_FILES['img3']['tmp_name'], $path . '/' . $img3_name);
                $data = [
                    'ntd_gioi_thieu' => $list['gtc'],
                    'ntd_csptnl' => $list['csptnl'],
                    'ntd_chtt' => $list['chtt'],
                    'ntd_salary_award' => $list['salary'],
                    'ntd_img_1' => $img1_name,
                    'ntd_img_2' => $img2_name,
                    'ntd_img_3' =>  $img3_name
                ];
                $condition = ['ntd_id' => $token->data->email];
                $result = $this->Models->update_where_and($data, 'user_ntd', $condition);
                if ($result > 0) {
                    $this->success('Cập nhật thông tin thành công', []);
                }
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập để sử dụng chứ năng này ');
        }
    }
    // Quản lí hồ sơ ứng viên 
    // ứng viên đã lưu - lấy danh sách 
    public function ung_vien_da_luu_ntd()
    {
        $token = $this->getTokens();

        if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
            $input_post = ['pagination', 'limit'];
            $data_post = $this->getAllData('post', $input_post);
            $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
            if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
                $pagination = 1;
            } else {
                $pagination = $data_post['pagination'];
            }
            $start = ($pagination - 1) * $limit;

            $select = 's.id,s.id_ntd,s.id_uv,s.create_date,u.uv_id,u.uv_name,u.uv_address,u.uv_luong_1,u.uv_luong_2,u.uv_luong_3,u.uv_cat,u.uv_alias,
            CASE 
                WHEN EXISTS (SELECT id FROM apply_new as a WHERE a.id_ntd=s.id_ntd AND a.id_uv=s.id_uv) THEN u.uv_phone 
                WHEN EXISTS (SELECT id FROM see_uv as b WHERE b.id_ntd=s.id_ntd AND b.id_uv=s.id_uv AND b.create_date > ' . (time() - 86400) . ') THEN u.uv_phone 
                ELSE "SĐT bị ẩn" 
            END AS uv_phone,
            CASE 
                WHEN EXISTS (SELECT id FROM apply_new as a WHERE a.id_ntd=s.id_ntd AND a.id_uv=s.id_uv) THEN u.uv_email
                WHEN EXISTS (SELECT id FROM see_uv as b WHERE b.id_ntd=s.id_ntd AND b.id_uv=s.id_uv AND b.create_date > ' . (time() - 86400) . ') THEN u.uv_email
                ELSE "Email bị ẩn" 
            END AS uv_email';
            $category = $this->Models->select_data('cat_id,cat_name,cat_alias', 'category', [], '', '', '', '');
            $uv_saved = $this->Models->select_sql('save_uv s', $select, array('s.id_ntd' => $token->data->UserId), null, array('user_uv u' => 's.id_uv = u.uv_id'), array('s.id' => 'DESC'),  $limit, $start, 1);
            // tổng ứng viên đã lưu
            $infor_p = $this->Models->select_sql('save_uv s', $select, array('s.id_ntd' => $token->data->UserId), null, array('user_uv u' => 's.id_uv = u.uv_id'), array('s.id' => 'DESC'), null, null, 1);
            $total = count($infor_p);
            foreach ($uv_saved as $key => $list) {
                $uv_cat = explode(',', $list['uv_cat']);
                $text_cat = '';
                foreach ($category->result_array() as $cat_value) {
                    if (in_array($cat_value['cat_id'], $uv_cat) == true) {
                        $text_cat .= $cat_value['cat_name'] . ' , ';
                    }
                    $uv_saved[$key]['uv_cat'] = $text_cat;
                }
            }
            $data_emp = [
                'total_uv_save' => $total,
                'number_uv_in_one_page' => $limit,
                'so_trang_hien_tai' => $start,
                'uv_saved' => $uv_saved
            ];
            $this->success("Danh sách ứng viên đã lưu", $data_emp);
        } else {
            $this->set_error('isLogin', 'Chuyển về trang đăng nhập or trang chủ');
        }
    }
    // xóa ứng viên đã lưu
    public function delete_uv_saved()
    {
        $token = $this->getTokens();;
        // die;
        $condition = ['id' => $token->data->id];
        $delete = $this->Models->delete_data('save_uv', $condition);
        $this->success("Bạn đã xóa thành công 1 ứng viên đã lưu", []);
    }
    // xuất exel ứng viên đã lưu
    public function exel_ung_vien_da_luu()
    {
        $token1 = $this->getAllData('get', ['token']);
        if ($this->checkNull($token1)) {
            error_reporting(0);
            include 'application/libraries/PHPExcel/IOFactory.php';
            $token = JWT::decode($token1['token'], $this->secretKey, array('HS256'));
            if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
                $data_get = $this->getAllData('get', ['stt']);
                $stt = $data_get['stt'];
                if (isset($stt)) {
                    $data['status_ut'] = $stt;
                    $condition = array('a.id_ntd' => $token->data->UserId, 'a.status' => $stt);
                } else {
                    $condition = array('a.id_ntd' => $token->data->UserId);
                }

                $select = 's.id,s.id_ntd,s.id_uv,s.create_date,u.uv_id,u.uv_name,u.uv_address,u.uv_luong_1,u.uv_luong_2,u.uv_luong_3,u.uv_cat,u.uv_alias,
                CASE 
                    WHEN EXISTS (SELECT id FROM apply_new as a WHERE a.id_ntd=s.id_ntd AND a.id_uv=s.id_uv) THEN u.uv_phone 
                    WHEN EXISTS (SELECT id FROM see_uv as b WHERE b.id_ntd=s.id_ntd AND b.id_uv=s.id_uv AND b.create_date > ' . (time() - 86400) . ') THEN u.uv_phone 
                    ELSE "SĐT bị ẩn" 
                END AS uv_phone,
                CASE 
                    WHEN EXISTS (SELECT id FROM apply_new as a WHERE a.id_ntd=s.id_ntd AND a.id_uv=s.id_uv) THEN u.uv_email
                    WHEN EXISTS (SELECT id FROM see_uv as b WHERE b.id_ntd=s.id_ntd AND b.id_uv=s.id_uv AND b.create_date > ' . (time() - 86400) . ') THEN u.uv_email
                    ELSE "Email bị ẩn" 
                END AS uv_email';
                $infor_p = $this->Models->select_sql('save_uv s', $select, array('s.id_ntd' => $token->data->UserId), null, array('user_uv u' => 's.id_uv = u.uv_id'), array('s.id' => 'DESC'), null, null, 1);
                $category = $this->Models->select_data('cat_id,cat_name,cat_alias', 'category', [], '', '', '', '');
                foreach ($infor_p as $list) {
                    $uv_cat = explode(',', $list['uv_cat']);
                    foreach ($category->result_array() as $cat_value) {
                        if (in_array($cat_value['cat_id'], $uv_cat) == true) {
                            $arr_cat[] = $cat_value['cat_name'];
                        }
                    }
                    $luong = $this->get_luong($list['uv_luong_1'], $list['uv_luong_2'], $list['uv_luong_1']);
                    $array[] = [
                        'ten_uv' => $list['uv_name'],
                        'loaicv' => implode(", ", $arr_cat),
                        'diachi'  => $list['uv_address'],
                        'ngayluu'  => date('d/m/Y', $list['create_date']),
                        'sdt'  => $list['uv_phone'],
                        'email'  => $list['uv_email'],
                        'luong' => $luong,
                    ];
                    unset($arr_cat);
                }
                $objPHPExcel = new PHPExcel();
                $fileType = 'Excel2007';
                $fileName = 'DS_UngVienDaLuu.xlsx';
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', "STT")
                    ->setCellValue('B1', "Tên ứng viên")
                    ->setCellValue('C1', "Loại công việc")
                    ->setCellValue('D1', " Địa chỉ")
                    ->setCellValue('E1', "Ngày lưu")
                    ->setCellValue('F1', "SĐT & Email   ")
                    ->setCellValue('G1', " Mức lương mong muốn");
                $i = 2;
                $j = 1;
                foreach ($array as $key => $value) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A" . $i, $j++)
                        ->setCellValue("B" . $i, $value['ten_uv'])
                        ->setCellValue("C" . $i,  $value['loaicv'])
                        ->setCellValue("D" . $i, $value['diachi'])
                        ->setCellValue("E" . $i, $value['ngayluu'])
                        ->setCellValue("F" . $i,  $value['sdt'] . ' - ' . $value['email'])
                        ->setCellValue("G" . $i, $value['luong']);
                    $i++;
                }
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
                // Tiến hành ghi file
                ob_end_clean();
                $full_path = 'data_User.xlsx'; //duong dan file
                $objWriter->save($full_path);
                header('Content-type: application/vnd.ms-excel');
                header("Content-Disposition: attachment; filename=$fileName");
                $objWriter->save('php://output');
                $this->success("Xuất exel ứng viên đã lưu thành công ", []);
            } else {
                $this->set_error('isLogin', 'Chuyển về trang đăng nhập or trang chủ');
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập để sử dụng chứ năng này ');
        }
    }
    // Xuất exel ứng viên ứng tuyển 
    public function exel_ung_vien_ung_tuyen_ntd()
    {
        $token1 = $this->getAllData('get', ['token']);
        if ($this->checkNull($token1)) {
            error_reporting(0);
            include 'application/libraries/PHPExcel/IOFactory.php';
            $token = JWT::decode($token1['token'], $this->secretKey, array('HS256'));
            if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
                $select = 'a.id,a.status, a.id_ntd,a.id_uv,a.id_new,a.create_date, a.note,a.calamviec,a.lichlamviec,a.giolam, u.uv_id,u.uv_email, u.uv_name, u.uv_address,u.uv_phone,u.uv_alias,n.new_id,n.new_title,n.new_alias';
                $join = array('user_uv u' => 'a.id_uv = u.uv_id', 'new n' => 'a.id_new = n.new_id');
                $condition = array('a.id_ntd' => $token->data->UserId);
                $uv_apllied = $this->Models->select_sql('apply_new a', $select, $condition, null, $join, array('a.id' => 'DESC'),  null, null, 1);
                $calam = [];
                foreach ($uv_apllied as $list) {
                    $ketqua = '';
                    if ($list['status'] == 0) {
                        $ketqua = 'Đã nộp';
                    } else if ($list['status'] == 1) {
                        $ketqua = 'Đến phỏng vấn';
                    } else if ($list['status'] == 2) {
                        $ketqua = 'Hồ sơ đạt yêu cầu';
                    } else if ($list['status'] == 3) {
                        $ketqua = 'Hồ sơ không đạt yêu cầu';
                    }
                    $arr_calam = explode(",", $list['calamviec']);
                    $arr_giolam = explode(",", $list['giolam']);
                    $arr_ngaylam = explode("/", $list['lichlamviec']);
                    $so_ca = count($arr_calam);

                    for ($i = 0; $i < $so_ca; $i++) {
                        if ($arr_calam[$i] != 0) {
                            $calam[] = 'Ca ' . $arr_calam[$i] . ':&nbsp;' . $arr_giolam[$i] . ' - ' . $arr_ngaylam[$i];
                        } else {
                            $calam[] = 'Thỏa thuận';
                        }
                    }
                    $array[] = [
                        'ten_uv' => $list['uv_name'],
                        'vt_ut' => $list['new_title'],
                        'diachi'  => $list['uv_address'],
                        'sdt'  => $list['uv_phone'],
                        'email'  => $list['uv_email'],
                        'ngaynop'  => date('d/m/Y', $list['create_date']),
                        'ghichu' => $list['note'],
                        'ketqua' => $ketqua,
                        'calam' => implode(", ", $calam),
                    ];
                    unset($calam);
                }
                $objPHPExcel = new PHPExcel();
                $fileType = 'Excel2007';
                $fileName = 'DS_UngVienUngTuyen.xlsx';
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', "STT")
                    ->setCellValue('B1', "Tên ứng viên")
                    ->setCellValue('C1', "Vị trí ứng ")
                    ->setCellValue('D1', " Địa chỉ")
                    ->setCellValue('E1', "Email & SĐT  ")
                    ->setCellValue('F1', "Ngày nộp")
                    ->setCellValue('G1', " Lịch làm")
                    ->setCellValue('H1', "Ghi chú")
                    ->setCellValue('K1', "Kết quả");
                $i = 2;
                $j = 1;
                foreach ($array as $key => $value) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A" . $i, $j++)
                        ->setCellValue("B" . $i, $value['ten_uv'])
                        ->setCellValue("C" . $i,   $value['vt_ut'])
                        ->setCellValue("D" . $i,  $value['diachi'])
                        ->setCellValue("E" . $i, $value['sdt'] . ' - ' . $value['email'])
                        ->setCellValue("F" . $i,  $value['ngaynop'])
                        ->setCellValue("G" . $i,  $value['calam'])
                        ->setCellValue("H" . $i, $value['ghichu'])
                        ->setCellValue("K" . $i, $value['ketqua']);
                    $i++;
                }
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
                // Tiến hành ghi file
                ob_end_clean();
                $full_path = 'data_User_Ut.xlsx'; //duong dan file
                $objWriter->save($full_path);
                header('Content-type: application/vnd.ms-excel');
                header("Content-Disposition: attachment; filename=$fileName");
                $objWriter->save('php://output');
                $this->success("Xuất exel ứng viên đã lưu thành công ", []);
            } else {
                $this->set_error('isLogin', 'Bạn đăng nhập chưa phải ở vị trí nhà tuyển dụng ');
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập để sử dụng chứ năng này ');
        }
    }
    // ứng viên ứng tuyển 
    public function ung_vien_ung_tuyen_ntd()
    {
        $token = $this->getTokens();
        if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
            $input_post = ['pagination', 'limit'];
            $data_post = $this->getAllData('post', $input_post);
            $data_get = $this->getAllData('get', ['stt']);
            $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
            if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
                $pagination = 1;
            } else {
                $pagination = $data_post['pagination'];
            }
            $stt = $data_get['stt'];
            $start = ($pagination - 1) * $limit;
            if (isset($stt)) {
                $data['status_ut'] = $stt;
                $condition = array('a.id_ntd' => $token->data->UserId, 'a.status' => $stt);
            } else {
                $condition = array('a.id_ntd' => $token->data->UserId);
            }

            $select = 'a.id,a.status, a.id_ntd,a.id_uv,a.id_new,a.create_date, a.note,a.calamviec,a.lichlamviec,a.giolam, u.uv_id,u.uv_email, u.uv_name, u.uv_address,u.uv_phone,u.uv_alias,n.new_id,n.new_title,n.new_alias';
            $join = array('user_uv u' => 'a.id_uv = u.uv_id', 'new n' => 'a.id_new = n.new_id');
            $uv_apllied = $this->Models->select_sql('apply_new a', $select, $condition, null, $join, array('a.id' => 'DESC'),  $limit, $start, 1);
            $infor_p = $this->Models->select_sql('apply_new a', $select, $condition, null, $join, array('a.id' => 'DESC'), null, null, 1);
            $total = count($infor_p);
            $data_emp = [
                'total_uv_save' => $total,
                'number_uv_in_one_page' => $limit,
                'so_trang_hien_tai' => $start,
                'uv_ung_tuyen' => $uv_apllied,
            ];
            $this->success("Danh sách ứng viên ứng tuyển ", $data_emp);
        } else {
            $this->set_error('isLogin', 'Chuyển về trang đăng nhập or trang chủ');
        }
    }
    // page ứng viên ứng tuyển - form select search
    public function select_search_uv_ut()
    {
        $array = [
            '-1' => 'Tất cả',
            '0' => 'Đã nộp',
            '1' => 'Đến phỏng vấn',
            '2' => 'Hồ sơ đạt yêu cầu',
            '3' => 'Hồ sơ không đạt yêu cầu',
        ];
        $this->success('form lọc theo select ', $array);
    }
    // form select cập nhật trạng thái ứng tuyển 
    public function select_update_uv_ut()
    {
        $array = [
            '0' => 'đã nộp',
            '1' => 'Đến phỏng vấn',
            '2' => 'Hồ sơ đạt yêu cầu',
            '3' => 'Hồ sơ không đạt yêu cầu',
        ];
        $this->success('form update theo select ', $array);
    }
    // lấy trạng thái khi mà ứng tuyển 
    public function get_stt_uv_ut()
    {
    }
    // cập nhật trạng thái ứng tuyển của nhà tuyển dụng 
    public function update_stt_apply()
    {
        $token = $this->getTokens();
        if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
            $input_post = ['id_ut', 'stt_ut'];
            $data_post = $this->getAllData('post', $input_post);
            $id_ut =  $data_post['id_ut'];
            $stt_ut = $data_post['stt_ut'];
            $dataToken['data'] = [
                'id_ut' => $data_post['id_ut'],
                'stt_ut' => $data_post['stt_ut'],
                'id_ntd' => $token->data->UserId,
            ];
            $update_date = intval(time());
            $data_update = [
                "status" => $stt_ut,
                "update_date" => $update_date,
            ];
            $update = $this->Models->update_data('apply_new', $data_update, array('id' => $id_ut));
            $this->success('Bạn đã cập nhật thành công 1 ứng viên ứng tuyển ', []);
        } else {
            $this->set_error('isLogin', 'Chuyển về trang đăng nhập or trang chủ');
        }
    }
    //=== ứng viên từ điểm lọc ===
    public function ung_vien_tu_diem_loc()
    {
        $token = $this->getTokens();
        if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
            $input_post = ['pagination', 'limit'];
            $data_post = $this->getAllData('post', $input_post);
            $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
            if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
                $pagination = 1;
            } else {
                $pagination = $data_post['pagination'];
            }
            $start = ($pagination - 1) * $limit;
            $check_see_uv   =  $this->Models->interJoinPaginate('see_uv', 'id_uv', 'user_uv', 'uv_id', $limit, $start, ['see_uv.id_ntd' => $token->data->UserId], 'see_uv.id_uv');
            $category = $this->Models->select_data('cat_id,cat_name,cat_alias', 'category', [], '', '', '', '');
            $total = count($check_see_uv);
            foreach ($check_see_uv as $key => $list) {
                $uv_cat = explode(',', $list['uv_cat']);
                $text_cat = '';
                foreach ($category->result_array() as $cat_value) {
                    if (in_array($cat_value['cat_id'], $uv_cat) == true) {
                        $text_cat .= $cat_value['cat_name'] . ' , ';
                    }
                    $check_see_uv[$key]['uv_cat'] = $text_cat;
                }
            }
            $data_emp = [
                'total_uv_save' => $total,
                'number_uv_in_one_page' => $limit,
                'so_trang_hien_tai' => $start,
                'uv_tu_diem_loc' => $check_see_uv,
            ];
            $this->success("Danh sách ứng viên từ điểm lọc ", $data_emp);
        } else {
            $this->set_error('isLogin', 'Chuyển về trang đăng nhập or trang chủ');
        }
    }
    // Xóa ứng viên từ điểm lọc 
    public function del_uv_tu_diem_loc()
    {
        $input_post = ['id_uv', 'id_ntd'];
        $data_post = $this->getAllData('post', $input_post);
        $result = $this->Models->delete_data('see_uv', ['id_ntd' => $data_post['id_ntd'], 'id_uv' => $data_post['id_uv']]);
        $this->success('Bạn đã xóa thành công 1 ứng viên từ điểm lọc', []);
    }
    //Chi tiết ứng viên 
    public function detail_uv()
    {
        // truyền token có chưa id ứng viên -> lấy thông tin ứng viên 
        $token = $this->getTokens();
        $input_post = ['id_uv'];
        $data_post = $this->getAllData('post', $input_post);
        $id_uv = $data_post['id_uv'];
        if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
            $id_ntd = $token->data->UserId;
            $create_date = intval(time());
            $dataNoti = array(
                'type' => 3, // 3 là không thông báo cho ai 
                'id_uv' => $id_uv,
                'id_ntd' => $id_ntd,
                'id_new' => 0,
                'status' => 5, //1: ntd lưu uv, 2: ntd mở tt uv, 3: uv lưu tin, 4:uv ut tin ,  5 : ntd đã xem 
            );
            $result = $this->Models->select_data('*', 'notification', [], $dataNoti, '', '', '');
            if ($result->num_rows() == null) {
                $dataNoti = array(
                    'type' => 3, // 3 là không thông báo cho ai 
                    'id_uv' => $id_uv,
                    'id_ntd' => $id_ntd,
                    'id_new' => 0,
                    'status' => 5, //1: ntd lưu uv, 2: ntd mở tt uv, 3: uv lưu tin, 4:uv ut tin ,  5 : ntd đã xem 
                    'create_date' => $create_date
                );
                $insertNoti = $this->Models->insert_data('notification', $dataNoti);
            }
        }
        $select = 'uv_id,uv_name,uv_avatar,uv_vitri,uv_sex,uv_dob,uv_email,uv_address,uv_city_hope,uv_cat,uv_loai_hinh,uv_hinh_thuc,uv_luong_1,uv_mary,uv_gtc,uv_calam,uv_createtime,date_refresh,uv_view';
        $condition = ['uv_id' => $id_uv];
        $join = [];
        $order_by = '';
        $start = '';
        $perpage = '';

        $infor = $this->Models->select_data($select, 'user_uv', $join, $condition, $order_by, $start, $perpage);
        $infor = $infor->result_array();
        if (count($infor) > 0) {
            $select = 'cat_id,cat_name,cat_alias';
            $condition = '';
            $category = $this->Models->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);

            $select = 'com_name,vi_tri,date_from,date_to,mo_ta';
            $condition = ['id_uv' => $id_uv];
            $work_infor = $this->Models->select_data($select, 'uv_knlv', $join, $condition, $order_by, $start, $perpage);
            $work_infor = $work_infor->result_array();
            $data['work_exp'] = $work_infor;
            $select = 'uv_id,uv_name,uv_city,uv_cat,uv_avatar,uv_createtime,uv_alias';
            $cat_tn = explode(',', $infor[0]['uv_cat']);
            $cat_tn = $cat_tn[0];
            $data['cat_tn'] = $cat_tn;
            $condition = 'FIND_IN_SET(' . $cat_tn . ',uv_cat) > 0';

            $uvtiemnang = $this->Models->select_data($select, 'user_uv', $join, $condition, $order_by, 0, 7);
            $uvtiemnang = $uvtiemnang->result_array();

            foreach ($infor as $key => $list) {
                $uv_cat = explode(',', $list['uv_cat']);
                $text_cat = '';
                foreach ($category->result_array() as $cat_value) {
                    if (in_array($cat_value['cat_id'], $uv_cat) == true) {
                        $text_cat .= $cat_value['cat_name'] . ' , ';
                    }
                    $infor[$key]['uv_cat'] = $text_cat;
                }
            }
            foreach ($uvtiemnang as $key => $list) {
                $uv_cat = explode(',', $list['uv_cat']);
                $text_cat = '';
                foreach ($category->result_array() as $cat_value) {
                    if (in_array($cat_value['cat_id'], $uv_cat) == true) {
                        $text_cat .= $cat_value['cat_name'] . ' , ';
                    }
                    $uvtiemnang[$key]['uv_cat'] = $text_cat;
                }
            }
            if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
                $data['check_save_uv']   =  $this->Models->select_sql('save_uv', '*', array('id_ntd' => $token->data->UserId, 'id_uv' => $id_uv), null, null, null, null, null, 0);
                $data['check_see_uv']   =  $this->Models->select_sql('see_uv', 'see_uv.*, user_uv.uv_email, user_uv.uv_phone', array('see_uv.id_ntd' => $token->data->UserId, 'see_uv.id_uv' => $id_uv), null, array('user_uv' => 'see_uv.id_uv = user_uv.uv_id'), null, null, null, 0);
            }
            $data['uv_time_nang'] = $uvtiemnang;
            $data['infor'] = $infor;
            $this->success('Chi tiết người tuyển dụng ', $data);
        } else {
            $this->set_error('3xx', 'Không có ứng viên nào ');
        }
    }
    // mở thông tin chi tiết ứng viên 
    public function ntd_see_uv()
    {
        $token = $this->getTokens();
        if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {
            $input_post = ['id_uv'];
            $data_post = $this->getAllData('post', $input_post);
            $id_uv = $data_post['id_uv'];
            $id_ntd = $token->data->UserId;
            $create_date = intval(time());
            $uv =  $this->Models->select_where_and('ntd_diem', 'user_ntd', ['ntd_id' => $id_ntd])->row_array();
            if ($uv['ntd_diem'] < 1) {
                $this->set_error('not point', 'Bạn không đủ điểm để thực hiện yêu cầu này !!');
            } else {
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
                    $time_open_hso =  $this->Models->select_where_and('create_date', 'see_uv', ['id' => $insert])->row_array();
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
                    $update = $this->Models->inc_data('user_ntd', ['ntd_diem' => 'ntd_diem-1'], ['ntd_id' => $id_ntd]);

                    $info_uv   =  $this->Models->select_sql('see_uv', 'see_uv.*, user_uv.uv_email, user_uv.uv_phone', array('see_uv.id' => $insert), null, array('user_uv' => 'see_uv.id_uv = user_uv.uv_id'), null, null, null, 0);
                    $data = array('kq' => true, 'uv_phone' => $info_uv['uv_phone'], 'uv_email' => $info_uv['uv_email']);
                    $send_mail = $this->globals->send_mail_see_uv(base_url() . '/EmailTemplate/Email_tb_ntd_da_xem.html', $token->data->email, $token->data->Name, $result->row_array()['uv_email'], $result->row_array()['uv_name'], 'Thông báo từ vieclamtheogio');
                    $this->success('Bạn đã mở hồ sơ thành công của 1 ứng viên ', ['six_month' => $time_open_hso['create_date'] + 15552000]);
                } else {
                    $this->set_error('point', 'Bạn đã mở ứng viên này rồi !');
                }
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập dưới nhà tuyển dụng để sử dụng chức năng này !');
        }
    }
    // đăng tin bước 1
    public function dang_tin()
    {
        $check_auth = $this->getAuthorizationHeader();
        $token = $this->getTokens();
        if ($check_auth != null) {
            $flag = true;
            $input_post = ['tieu_de', 'type_job', 'chi_tiet_cv', 'age', 'sex', 'cb', 'hvtt', 'knlv', 'httl', 'lhlv', 'htlv', 'time_end', 'money_luong', 'co_dinh', 'uocluong1', 'uocluong2', 'ml', 'work_add_cty', 'city', 'qh', 'address'];
            $list = $this->getAllData('post', $input_post);
            if (trim($list['tieu_de']) == '') {
                $flag = false;
                $tieude_error = 'Tiêu đề không được bỏ trống';
            } elseif (checkStrInStr($list['tieu_de']) == 0) {
                $flag = false;
                $tieude_error = 'Tiêu đề tin tuyển dụng KHÔNG chứa các nội dung như: Tuyển gấp, hot, cần gấp, lương cao...';
            } else {
                $tieude_error = '';
            }
            // loại công việc 
            if (trim($list['chi_tiet_cv']) == '') {
                $flag = false;
                $chi_tiet_cv_error = 'Chi tiết công việc  không được bỏ trống';
            } else {
                $chi_tiet_cv_error = '';
            }
            // loại công việc 
            if (trim($list['type_job']) == '') {
                $flag = false;
                $type_job_error = 'Loại công việc  không được bỏ trống';
            } else {
                $type_job_error = '';
            }
            // độ tuổi 
            $regex_age = "/^([0-9]*)$/";
            if (trim($list['age']) == '') {
                $flag = false;
                $age_error = 'Độ tuổi không được bỏ trống';
            } elseif (!preg_match($regex_age, $list['age'])) {
                $flag = false;
                $age_error = 'Độ tuổi phải là kí tự số ';
            } else {
                $age_error = '';
            }
            // Giới tính 
            if (trim($list['sex']) == '') {
                $flag = false;
                $sex_error = 'Giới tính không được bỏ trống';
            } else {
                $sex_error = '';
            }
            // Cấp bậc  
            if (trim($list['cb']) == '') {
                $flag = false;
                $cb_error = 'Cấp bậc không được bỏ trống';
            } else {
                $cb_error = '';
            }
            // Học vấn tối thiểu   
            if (trim($list['hvtt']) == '') {
                $flag = false;
                $hvtt_error = 'Học vấn tối thiểu không được bỏ trống';
            } else {
                $hvtt_error = '';
            }
            // Kinh nghiệm làm việc    
            if (trim($list['knlv']) == '') {
                $flag = false;
                $knlv_error = 'Kinh nghiệm làm việc không được bỏ trống';
            } else {
                $knlv_error = '';
            }
            // hình thức trả lương
            if (trim($list['httl']) == '') {
                $flag = false;
                $httl_error = 'Hình thức trả lương không được bỏ trống';
            } else {
                $httl_error = '';
            }
            // loại hình làm việc 
            if (trim($list['lhlv']) == '') {
                $flag = false;
                $lhlv_error = 'Loại hình làm việc không được bỏ trống';
            } else {
                $lhlv_error = '';
            }
            // hình thức làm việc 
            if (trim($list['htlv']) == '') {
                $flag = false;
                $htlv_error = 'Hình thức làm việc không được bỏ trống';
            } else {
                $htlv_error = '';
            }
            // hạn nộp hồ sơ
            if (trim($list['time_end']) == '') {
                $flag = false;
                $time_end_error = 'Hạn nộp hồ sơ không được bỏ trống';
            } elseif (strtotime($list['time_end']) < getdate()[0]) {
                $flag = false;
                $time_end_error = 'Hạn nộp hồ sơ không được nhỏ hơn ngày hiện tại';
            } else {
                $time_end_error = '';
            }
            // Mức lương 
            $money_luong_error = '';
            $from_error = '';
            $to_error = '';
            $co_dinh_error = '';
            $from_to_error = '';
            if (trim($list['money_luong']) == '') {
                $flag = false;
                $money_luong_error = 'Mức lương không được bỏ trống';
            } else {
                $regex_number = "/^([0-9]*)$/";
                if ($list['money_luong'] == 1) {
                    if (trim($list['co_dinh']) == '') {
                        $flag = false;
                        $co_dinh_error = 'Lương cố định không được bỏ trống';
                    } elseif (!preg_match($regex_number, $list['co_dinh'])) {
                        $flag = false;
                        $co_dinh_error = 'Lương cố định phải là kí tự số ';
                    } elseif ($list['ml'] == '') {
                        $flag = false;
                        $co_dinh_error = 'Mức lương không được bỏ trống ';
                    }
                } elseif ($list['money_luong'] == 2) {
                    $regex_number1 = "/^([0-9]*)$/";
                    if (trim($list['uocluong1']) == '') {
                        $flag = false;
                        $from_error = 'Ước lường từ không được bỏ trống';
                    } elseif (!preg_match($regex_number1, $list['uocluong1'])) {
                        $flag = false;
                        $from_error = 'Ước lường từ phải là kí tự số ';
                    } elseif ($list['ml'] == '') {
                        $flag = false;
                        $from_error = 'Mức lương không được bỏ trống ';
                    }
                    $regex_number2 = "/^([0-9]*)$/";
                    if (trim($list['uocluong2']) == '') {
                        $flag = false;
                        $to_error = 'Ước lường đến không được bỏ trống';
                    } elseif (!preg_match($regex_number2, $list['uocluong2'])) {
                        $flag = false;
                        $to_error = 'Ước lường đến phải là kí tự số ';
                    } elseif ($list['ml'] == '') {
                        $flag = false;
                        $to_error = 'Mức lương không được bỏ trống ';
                    }
                    if ($list['uocluong1'] >= $list['uocluong2']) {
                        $flag = false;
                        $from_to_error = 'Mức lương sau phải lơn hơn mức lương trước ';
                    }
                } else {
                    $money_luong_error = '';
                }
            }
            // địa chỉ làm việc
            if ($list['work_add_cty'] == 0) {
                $work_at_com = 0;
            } else {
                if ($list['city'] == '') {
                    $flag = false;
                    $city_error = 'Bạn không được bỏ trống tỉnh thành ';
                } else {
                    $city_error = '';
                }
                if ($list['qh'] == '') {
                    $flag = false;
                    $qh_error = 'Bạn không được bỏ trống quận huyện  ';
                } else {
                    $qh_error = '';
                }
                if ($list['address'] == '') {
                    $flag = false;
                    $address_error = 'Bạn không được bỏ trốngđịa chỉ cụ thể  ';
                } else {
                    $address_error = '';
                }
            }
            // 
            if ($flag == false) {
                $data_error = [
                    'tieude_error' => $tieude_error,
                    'type_job_error' => $type_job_error,
                    'chi_tiet_cv_error' => $chi_tiet_cv_error,
                    'age_error' => $age_error,
                    'sex_error' => $sex_error,
                    'cb_error' => $cb_error,
                    'hvtt_error' => $hvtt_error,
                    'knlv_error' => $knlv_error,
                    'httl_error' => $httl_error,
                    'lhlv_error' => $lhlv_error,
                    'htlv_error' => $htlv_error,
                    'time_end_error' => $time_end_error,
                    'money_luong_error' => $money_luong_error,
                    'co_dinh_error' => $co_dinh_error,
                    'from_error' => $from_error,
                    'to_error' => $to_error,
                    'from_to_error' => $from_to_error,
                    'city_error' => $city_error,
                    'qh_error' => $qh_error,
                    'address_error' => $address_error,
                ];
                $this->set_error('error_form', 'Form bạn điền chưa đúng định dạng ', $data_error);
            } else {
                $new_luong_2 = 0;
                if ($list['money_luong'] == 3) {
                    $new_luong_3 = 0;
                } elseif ($list['money_luong'] == 2) {
                    $new_luong_3 = $list['ml'];
                    $new_luong_2 = $list['uocluong1'] . '-' . $list['uocluong2'];
                } elseif ($list['money_luong'] == 1) {
                    $new_luong_3 = $list['ml'];
                    $new_luong_2 = $list['co_dinh'];
                }
                if ($list['work_add_cty'] == 0) {
                    $work_at_com = $list['qh'];
                } else {
                    $work_at_com = 0;
                }
                $data = array(
                    'new_cat' => $list['type_job'],
                    'new_title' =>  $list['tieu_de'],
                    'new_tag' => $list['chi_tiet_cv'],
                    'new_alias' => vn_str_filter($list['tieu_de']),
                    'new_user_id' => $token->data->UserId,
                    'new_age' => $list['age'],
                    'new_sex' => $list['sex'],
                    'new_cap_bac' => $list['cb'],
                    'new_hoc_van' => $list['hvtt'],
                    'new_knlv' => $list['knlv'],
                    'new_httl' => $list['httl'],
                    'new_loai_hinh' => $list['lhlv'],
                    'new_hinh_thuc' => $list['htlv'],
                    'new_create_time' => time(),
                    'new_updated_time' => time(),
                    'new_han_nop' => strtotime($list['time_end']),
                    'new_luong_1' => $list['money_luong'],
                    'new_luong_2' => $new_luong_2,
                    'new_luong_3' => $new_luong_3,
                    'new_at_com' => $work_at_com,
                    'new_city'  => $list['city'],
                    'new_qh' =>  $list['qh'],
                    'new_address' =>  $list['address'],
                );
                $insert = $this->Models->insert_data('new', $data);
                $dataToken['data'] = [
                    'id_new' => $insert,
                ];
                $token = JWT::encode($dataToken, $this->secretKey, 'HS256');
                $this->success('dang ki thành công', ['token' => $token]);
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập dưới nhà tuyển dụng để sử dụng chức năng này !');
        }
    }
    public function dang_tin_buoc_2()
    {
        $check_token_buoc_1  =  $this->getAuthorizationHeader();
        if ($check_token_buoc_1 != null) {
            $flag = true;
            $token = $this->getTokens();
            $id_new = $token->data->id_new;
            $input = ['new_no_calam', 'new_ca_start',  'new_ca_end', 'new_t2', 'new_t3', 'new_t4', 'new_t5', 'new_t6', 'new_t7', 'new_cn',];
            $data_post = $this->getAllData('post', $input);
            if ($data_post['new_no_calam'] == '') {
                $flag = false;
                $new_no_calam_error = 'Lịch làm việc không bỏ trống ';
            } else {
                $new_no_calam_error = '';

                if ($data_post['new_no_calam'] == 1) {
                    if (($data_post['new_ca_start'] == '' ||  $data_post['new_ca_end'] == '') || ($data_post['new_t2'] == '' && $data_post['new_t3'] == '' && $data_post['new_t4'] == '' && $data_post['new_t5'] == '' && $data_post['new_t6'] == '' && $data_post['new_t7'] == '' && $data_post['new_cn'] == '')) {
                        $flag = false;
                        $calam_error = 'Ca làm việc không bỏ trống ';
                    } else {
                        $calam_error = '';
                    }
                }
            }

            if ($flag == false) {
                $data_error = [
                    'new_no_calam_error' => $new_no_calam_error,
                    'calam_error' => $calam_error,
                ];
                $this->set_error('error_form', 'Form bạn điền chưa đúng định dạng', $data_error);
            } else {
                if ($data_post['new_no_calam'] == 0) {
                    $new_no_calam = 0;
                    $new_ca_start = 0;
                    $new_ca_end = 0;
                    $new_t2 = 0;
                    $new_t3 = 0;
                    $new_t4 = 0;
                    $new_t5 = 0;
                    $new_t6 = 0;
                    $new_t7 = 0;
                    $new_cn = 0;
                } else {
                    $new_no_calam = 1;
                    $new_ca_start = $data_post['new_ca_start'];
                    $new_ca_end = $data_post['new_ca_end'];
                    $new_t2 =  $data_post['new_t2'];
                    $new_t3 =  $data_post['new_t3'];
                    $new_t4 =  $data_post['new_t4'];
                    $new_t5 =  $data_post['new_t5'];
                    $new_t6 =  $data_post['new_t6'];
                    $new_t7 =  $data_post['new_t7'];
                    $new_cn =  $data_post['new_cn'];
                }
                $data = array(
                    'new_no_calam' => $new_no_calam,
                    'new_ca_start' => $new_ca_start,
                    'new_ca_end' => $new_ca_end,
                    'new_t2' => ($new_t2 == '') ? 0 : $new_t2,
                    'new_t3' => ($new_t3 == '') ? 0 : $new_t3,
                    'new_t4' => ($new_t4 == '') ? 0 : $new_t4,
                    'new_t5' => ($new_t5 == '') ? 0 : $new_t5,
                    'new_t6' => ($new_t6 == '') ? 0 : $new_t6,
                    'new_t7' => ($new_t7 == '') ? 0 : $new_t7,
                    'new_cn' => ($new_cn == '') ? 0 : $new_cn,
                );
                $dataToken['data'] = [
                    'id_new' =>  $id_new,
                ];
                $token = JWT::encode($dataToken, $this->secretKey, 'HS256');

                $this->Models->update_data('new', $data, ['new_id' => $id_new]);
                $this->success('Bạn đã hoàn thành đăng tin bước 2 ', ['token_buoc_2' => $token]);
            }
        } else {
            $this->set_error('not Page', 'Bạn chưa hoàn thành bước 1!');
        }
    }
    // đăng tin bước 3 
    public function dang_tin_buoc_3()
    {
        $check_token = $this->getAuthorizationHeader();
        $array =  array('_', "-", ">", ":", ",", " ", ".", "!", "[", "]", "(", ")", "?", "{", "}", "%", "&", "#", "$", "=", "+", "-", "<", ">", ";", "@", "\\",  "|", "/");

        if ($check_token != null) {
            $token = $this->getTokens();
            $id_new = $token->data->id_new;
            $input = ['mtcv', 'yccv', 'qldh'];
            $data_post = $this->getAllData('post', $input);
            $flag = true;
            //  mô tả công việc 
            if (trim($data_post['mtcv']) == '') {
                $flag = false;
                $mtcv_error = 'Bạn không được bỏ trống mô tả công việc';
            } elseif (strlen($data_post['mtcv']) < 50) {
                $flag = false;
                $mtcv_error = 'Mô tả công việc phải lớn hơn 50 kí tự ';
            } else {
                $mtcv_error = '';
            }
            // yêu cầu công việc 
            if (trim($data_post['yccv']) == '') {
                $flag = false;
                $yccv_error = 'Bạn không được bỏ trống yêu cầu công việc ';
            } elseif (strlen($data_post['yccv']) < 50) {
                $flag = false;
                $yccv_error = 'Mô tả công việc phải lớn hơn 50 kí tự ';
            } elseif (trim($data_post['mtcv']) == trim($data_post['yccv'])) {
                $flag = false;
                $yccv_error = 'Bạn không được nhập yêu cầu công việc trùng với mô tả công việc  ';
            } else {
                $yccv_error = '';
            }
            // Quyền lợi được hưởng 
            if (trim($data_post['qldh']) == '') {
                $flag = false;
                $qldh_error = 'Bạn không được bỏ trống quyền lợi được hưởng';
            } elseif (strlen($data_post['qldh']) < 50) {
                $flag = false;
                $qldh_error = 'Mô tả công việc phải lớn hơn 50 kí tự ';
            } elseif (trim($data_post['qldh']) == trim($data_post['yccv'])) {
                $flag = false;
                $qldh_error = 'Bạn không được nhập  quyền lợi được hưởng trùng với yêu cầu công việc ';
            } elseif (trim($data_post['qldh']) == trim($data_post['mtcv'])) {
                $flag = false;
                $qldh_error = 'Bạn không được nhập  quyền lợi được hưởng trùng với mô tả công việc  ';
            } else {
                $qldh_error = '';
            }
            // submit

            if ($flag == false) {

                $data_error = [
                    'mtccv_error' => $mtcv_error,
                    'yccv_error' => $yccv_error,
                    'qldh_error' => $qldh_error,
                ];
                $this->set_error('error_form', 'Form không đúng định dạng', $data_error);
            } else {
                $data_update = [
                    'new_mota' => $data_post['mtcv'],
                    'new_yeu_cau' => $data_post['yccv'],
                    'new_quyen' => $data_post['qldh'],
                ];
                $this->Models->update_data('new', $data_update, ['new_id' => $id_new]);
                $this->success('Bạn đã đăng tin thành công ', ['redirect' => 'Chuyển đến tin đã đăng']);
            }
        } else {
            $this->set_error('not Page', 'Bạn chưa hoàn thành bước 2!');
        }
    }
    // danh sách tin đã đăng 
    public function list_new_post()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['pagination', 'limit'];
            $data_post = $this->getAllData('post', $input_post);
            $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
            if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
                $pagination = 1;
            } else {
                $pagination = $data_post['pagination'];
            }
            $start = ($pagination - 1) * $limit;
            $select = 'new_id,new_alias,new_title,new_alias,new_user_id,new_age,new_sex,new_cap_bac,new_hoc_van,new_knlv,new_httl,new_loai_hinh,new_hinh_thuc,new_han_nop,new_luong_1,new_luong_2,new_luong_3,new_at_com,new_create_time,new_city,new_qh,new_address,new_no_calam,new_ca_start,new_ca_end,new_mota,new_yeu_cau,new_quyen,so_uv_ungtuyen,view_new';
            $new_upload = $this->Models->select_data($select, 'new', [], ['new_user_id' => $token->data->UserId], 'new_updated_time DESC', $start, $limit)->result();
            $new = $this->Models->select_data($select, 'new', [], ['new_user_id' => $token->data->UserId], 'new_updated_time DESC', '', '');
            $total = $new->num_rows();
            $data_emp = [
                'total_uv_save' => $total,
                'number_uv_in_one_page' => $limit,
                'so_trang_hien_tai' => $start,
                'new_upload' => $new_upload,
            ];
            $this->success('Danh sách tin đã đăng ', $data_emp);
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập mới xem được danh sách tin đã đăng ');
        }
    }
    // Xóa tin đã đăng 
    public function del_new_post()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $input_post = ['id_new'];
            $data_post = $this->getAllData('post', $input_post);
            $this->Models->delete_data('new', ['new_id' => $data_post['id_new']]);
            $this->success('Bạn đã xóa thành công 1 tin đã đăng ', ['redirect' => 'chuyển về màn tin đã đăng']);
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập mới sử dụng được chức năng này ');
        }
    }
    // làm mới tin đã đăng 
    public function new_refresh()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['id_new'];
            $data_post = $this->getAllData('post', $input_post);
            $id_ntd = $token->data->UserId;
            $id_new = $data_post['id_new'];
            $new = $this->Models->select_where_and('ntd_diem', 'user_ntd', ['ntd_id' => $id_ntd])->row_array();
            if ($new['ntd_diem'] < 1) {
                $this->set_error('notPoint', 'Bạn không đủ điểm để làm mới tin đã đăng');
            } else {
                $this->Models->update_data('new', ['new_updated_time' => getdate()[0]], ['new_id' => $id_new]);
                $this->Models->inc_data('user_ntd', ['ntd_diem' => 'ntd_diem-1'], ['ntd_id' => $id_ntd]);
                $this->success('Bạn đã làm mới thành công 1 tin và đã mất 1 điểm ', ['redirect' => 'chuyển về màn tin đã đăng']);
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập mới sử dụng được chức năng này ');
        }
    }
    // Lấy dữ liệu của 1 bài viết 
    public function detail_new()
    {
        $input_get = ['id_new'];
        $data_get = $this->getAllData('post', $input_get);
        $new = $this->Models->select_where_and('*', 'new', ['new_id' => $data_get['id_new']])->row_array();
        // var_dump($data_get['id_new']);
        if ($new == null) {
            $this->set_error('404', 'Không có bài viết nào trên hệ thống ');
        } else {
            $this->success('Chi tiêt bài viết ', ['detail' => $new]);
        }
    }
    // sửa tin đẵ đăng 
    public function edit_new()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $flag = true;
            $input_get = ['id_new'];
            $data_get = $this->getAllData('get', $input_get);

            $input_post = ['tieu_de', 'type_job', 'chi_tiet_cv', 'age', 'sex', 'cb', 'hvtt', 'knlv', 'httl', 'lhlv', 'htlv', 'time_end', 'money_luong', 'co_dinh', 'uocluong1', 'uocluong2', 'ml', 'work_add_cty', 'city', 'qh', 'address', 'new_no_calam', 'new_ca_start',  'new_ca_end', 'new_t2', 'new_t3', 'new_t4', 'new_t5', 'new_t6', 'new_t7', 'new_cn', 'mtcv', 'yccv', 'qldh'];
            $list = $this->getAllData('post', $input_post);
            if (trim($list['tieu_de']) == '') {
                $flag = false;
                $tieude_error = 'Tiêu đề không được bỏ trống';
            } elseif (checkStrInStr($list['tieu_de']) == 0) {
                $flag = false;
                $tieude_error = 'Tiêu đề tin tuyển dụng KHÔNG chứa các nội dung như: Tuyển gấp, hot, cần gấp, lương cao...';
            } else {
                $tieude_error = '';
            }
            // loại công việc 
            if (trim($list['chi_tiet_cv']) == '') {
                $flag = false;
                $chi_tiet_cv_error = 'Chi tiết công việc  không được bỏ trống';
            } else {
                $chi_tiet_cv_error = '';
            }
            // loại công việc 
            if (trim($list['type_job']) == '') {
                $flag = false;
                $type_job_error = 'Loại công việc  không được bỏ trống';
            } else {
                $type_job_error = '';
            }
            // độ tuổi 
            $regex_age = "/^([0-9]*)$/";
            if (trim($list['age']) == '') {
                $flag = false;
                $age_error = 'Độ tuổi không được bỏ trống';
            } elseif (!preg_match($regex_age, $list['age'])) {
                $flag = false;
                $age_error = 'Độ tuổi phải là kí tự số ';
            } else {
                $age_error = '';
            }
            // Giới tính 
            if (trim($list['sex']) == '') {
                $flag = false;
                $sex_error = 'Giới tính không được bỏ trống';
            } else {
                $sex_error = '';
            }
            // Cấp bậc  
            if (trim($list['cb']) == '') {
                $flag = false;
                $cb_error = 'Cấp bậc không được bỏ trống';
            } else {
                $cb_error = '';
            }
            // Học vấn tối thiểu   
            if (trim($list['hvtt']) == '') {
                $flag = false;
                $hvtt_error = 'Học vấn tối thiểu không được bỏ trống';
            } else {
                $hvtt_error = '';
            }
            // Kinh nghiệm làm việc    
            if (trim($list['knlv']) == '') {
                $flag = false;
                $knlv_error = 'Kinh nghiệm làm việc không được bỏ trống';
            } else {
                $knlv_error = '';
            }
            // hình thức trả lương
            if (trim($list['httl']) == '') {
                $flag = false;
                $httl_error = 'Hình thức trả lương không được bỏ trống';
            } else {
                $httl_error = '';
            }
            // loại hình làm việc 
            if (trim($list['lhlv']) == '') {
                $flag = false;
                $lhlv_error = 'Loại hình làm việc không được bỏ trống';
            } else {
                $lhlv_error = '';
            }
            // hình thức làm việc 
            if (trim($list['htlv']) == '') {
                $flag = false;
                $htlv_error = 'Hình thức làm việc không được bỏ trống';
            } else {
                $htlv_error = '';
            }
            // hạn nộp hồ sơ
            if (trim($list['time_end']) == '') {
                $flag = false;
                $time_end_error = 'Hạn nộp hồ sơ không được bỏ trống';
            } elseif (strtotime($list['time_end']) < getdate()[0]) {
                $flag = false;
                $time_end_error = 'Hạn nộp hồ sơ không được nhỏ hơn ngày hiện tại';
            } else {
                $time_end_error = '';
            }
            // Mức lương 
            $money_luong_error = '';
            $from_error = '';
            $to_error = '';
            $co_dinh_error = '';
            $from_to_error = '';
            if (trim($list['money_luong']) == '') {
                $flag = false;
                $money_luong_error = 'Mức lương không được bỏ trống';
            } else {
                $regex_number = "/^([0-9]*)$/";
                if ($list['money_luong'] == 1) {
                    if (trim($list['co_dinh']) == '') {
                        $flag = false;
                        $co_dinh_error = 'Lương cố định không được bỏ trống';
                    } elseif (!preg_match($regex_number, $list['co_dinh'])) {
                        $flag = false;
                        $co_dinh_error = 'Lương cố định phải là kí tự số ';
                    } elseif ($list['ml'] == '') {
                        $flag = false;
                        $co_dinh_error = 'Mức lương không được bỏ trống ';
                    }
                } elseif ($list['money_luong'] == 2) {
                    $regex_number1 = "/^([0-9]*)$/";
                    if (trim($list['uocluong1']) == '') {
                        $flag = false;
                        $from_error = 'Ước lường từ không được bỏ trống';
                    } elseif (!preg_match($regex_number1, $list['uocluong1'])) {
                        $flag = false;
                        $from_error = 'Ước lường từ phải là kí tự số ';
                    } elseif ($list['ml'] == '') {
                        $flag = false;
                        $from_error = 'Mức lương không được bỏ trống ';
                    }
                    $regex_number2 = "/^([0-9]*)$/";
                    if (trim($list['uocluong2']) == '') {
                        $flag = false;
                        $to_error = 'Ước lường đến không được bỏ trống';
                    } elseif (!preg_match($regex_number2, $list['uocluong2'])) {
                        $flag = false;
                        $to_error = 'Ước lường đến phải là kí tự số ';
                    } elseif ($list['ml'] == '') {
                        $flag = false;
                        $to_error = 'Mức lương không được bỏ trống ';
                    }
                    if ($list['uocluong1'] >= $list['uocluong2']) {
                        $flag = false;
                        $from_to_error = 'Mức lương sau phải lơn hơn mức lương trước ';
                    }
                } else {
                    $money_luong_error = '';
                }
            }
            // địa chỉ làm việc
            if ($list['work_add_cty'] == 0) {
                $work_at_com = 0;
            } else {
                if ($list['city'] == '') {
                    $flag = false;
                    $city_error = 'Bạn không được bỏ trống tỉnh thành ';
                } else {
                    $city_error = '';
                }
                if ($list['qh'] == '') {
                    $flag = false;
                    $qh_error = 'Bạn không được bỏ trống quận huyện  ';
                } else {
                    $qh_error = '';
                }
                if ($list['address'] == '') {
                    $flag = false;
                    $address_error = 'Bạn không được bỏ trốngđịa chỉ cụ thể  ';
                } else {
                    $address_error = '';
                }
            }
            // bước 2 
            if ($list['new_no_calam'] == '') {
                $flag = false;
                $new_no_calam_error = 'Lịch làm việc không bỏ trống ';
            } else {
                $new_no_calam_error = '';

                if ($list['new_no_calam'] == 1) {
                    if (($list['new_ca_start'] == '' ||  $list['new_ca_end'] == '') || ($list['new_t2'] == '' && $list['new_t3'] == '' && $list['new_t4'] == '' && $list['new_t5'] == '' && $list['new_t6'] == '' && $list['new_t7'] == '' && $list['new_cn'] == '')) {
                        $flag = false;
                        $calam_error = 'Ca làm việc không bỏ trống ';
                    } else {
                        $calam_error = '';
                    }
                }
            }
            // Bước 3
            if (trim($list['mtcv']) == '') {
                $flag = false;
                $mtcv_error = 'Bạn không được bỏ trống mô tả công việc';
            } elseif (strlen($list['mtcv']) < 50) {
                $flag = false;
                $mtcv_error = 'Mô tả công việc phải lớn hơn 50 kí tự ';
            } else {
                $mtcv_error = '';
            }
            // yêu cầu công việc 
            if (trim($list['yccv']) == '') {
                $flag = false;
                $yccv_error = 'Bạn không được bỏ trống yêu cầu công việc ';
            } elseif (strlen($list['yccv']) < 50) {
                $flag = false;
                $yccv_error = 'Mô tả công việc phải lớn hơn 50 kí tự ';
            } elseif (trim($list['mtcv']) == trim($list['yccv'])) {
                $flag = false;
                $yccv_error = 'Bạn không được nhập yêu cầu công việc trùng với mô tả công việc  ';
            } else {
                $yccv_error = '';
            }
            // Quyền lợi được hưởng 
            if (trim($list['qldh']) == '') {
                $flag = false;
                $qldh_error = 'Bạn không được bỏ trống quyền lợi được hưởng';
            } elseif (strlen($list['qldh']) < 50) {
                $flag = false;
                $qldh_error = 'Mô tả công việc phải lớn hơn 50 kí tự ';
            } elseif (trim($list['qldh']) == trim($list['yccv'])) {
                $flag = false;
                $qldh_error = 'Bạn không được nhập  quyền lợi được hưởng trùng với yêu cầu công việc ';
            } elseif (trim($list['qldh']) == trim($list['mtcv'])) {
                $flag = false;
                $qldh_error = 'Bạn không được nhập  quyền lợi được hưởng trùng với mô tả công việc  ';
            } else {
                $qldh_error = '';
            }
            // submit
            if ($flag == false) {
                $data_error = [
                    'tieude_error' => $tieude_error,
                    'type_job_error' => $type_job_error,
                    'chi_tiet_cv_error' => $chi_tiet_cv_error,
                    'age_error' => $age_error,
                    'sex_error' => $sex_error,
                    'cb_error' => $cb_error,
                    'hvtt_error' => $hvtt_error,
                    'knlv_error' => $knlv_error,
                    'httl_error' => $httl_error,
                    'lhlv_error' => $lhlv_error,
                    'htlv_error' => $htlv_error,
                    'time_end_error' => $time_end_error,
                    'money_luong_error' => $money_luong_error,
                    'co_dinh_error' => $co_dinh_error,
                    'from_error' => $from_error,
                    'to_error' => $to_error,
                    'from_to_error' => $from_to_error,
                    'city_error' => $city_error,
                    'qh_error' => $qh_error,
                    'address_error' => $address_error,
                    'new_no_calam_error' => $new_no_calam_error,
                    'calam_error' => $calam_error,
                    'mtccv_error' => $mtcv_error,
                    'yccv_error' => $yccv_error,
                    'qldh_error' => $qldh_error,
                ];
                $this->set_error('error_form', 'Bạn phải điền đúng form', $data_error);
            } else {
                $new_luong_2 = 0;
                if ($list['money_luong'] == 3) {
                    $new_luong_3 = 0;
                } elseif ($list['money_luong'] == 2) {
                    $new_luong_3 = $list['ml'];
                    $new_luong_2 = $list['uocluong1'] . '-' . $list['uocluong2'];
                } elseif ($list['money_luong'] == 1) {
                    $new_luong_3 = $list['ml'];
                    $new_luong_2 = $list['co_dinh'];
                }
                if ($list['work_add_cty'] == 0) {
                    $work_at_com = $list['qh'];
                } else {
                    $work_at_com = 0;
                }
                if ($list['new_no_calam'] == 0) {
                    $new_no_calam = 0;
                    $new_ca_start = 0;
                    $new_ca_end = 0;
                    $new_t2 = 0;
                    $new_t3 = 0;
                    $new_t4 = 0;
                    $new_t5 = 0;
                    $new_t6 = 0;
                    $new_t7 = 0;
                    $new_cn = 0;
                } else {
                    $new_no_calam = 1;
                    $new_ca_start = $list['new_ca_start'];
                    $new_ca_end = $list['new_ca_end'];
                    $new_t2 =  $list['new_t2'];
                    $new_t3 =  $list['new_t3'];
                    $new_t4 =  $list['new_t4'];
                    $new_t5 =  $list['new_t5'];
                    $new_t6 =  $list['new_t6'];
                    $new_t7 =  $list['new_t7'];
                    $new_cn =  $list['new_cn'];
                }
                $data_edit = array(
                    'new_cat' => $list['type_job'],
                    'new_title' =>  $list['tieu_de'],
                    'new_tag' => $list['chi_tiet_cv'],
                    'new_alias' => vn_str_filter($list['tieu_de']),
                    'new_user_id' => $token->data->UserId,
                    'new_age' => $list['age'],
                    'new_sex' => $list['sex'],
                    'new_cap_bac' => $list['cb'],
                    'new_hoc_van' => $list['hvtt'],
                    'new_knlv' => $list['knlv'],
                    'new_httl' => $list['httl'],
                    'new_loai_hinh' => $list['lhlv'],
                    'new_hinh_thuc' => $list['htlv'],
                    'new_create_time' => time(),
                    'new_updated_time' => time(),
                    'new_han_nop' => strtotime($list['time_end']),
                    'new_luong_1' => $list['money_luong'],
                    'new_luong_2' => $new_luong_2,
                    'new_luong_3' => $new_luong_3,
                    'new_at_com' => $work_at_com,
                    'new_city'  => $list['city'],
                    'new_qh' =>  $list['qh'],
                    'new_address' =>  $list['address'],
                    'new_no_calam' => $new_no_calam,
                    'new_ca_start' => $new_ca_start,
                    'new_ca_end' => $new_ca_end,
                    'new_t2' => ($new_t2 == '') ? 0 : $new_t2,
                    'new_t3' => ($new_t3 == '') ? 0 : $new_t3,
                    'new_t4' => ($new_t4 == '') ? 0 : $new_t4,
                    'new_t5' => ($new_t5 == '') ? 0 : $new_t5,
                    'new_t6' => ($new_t6 == '') ? 0 : $new_t6,
                    'new_t7' => ($new_t7 == '') ? 0 : $new_t7,
                    'new_cn' => ($new_cn == '') ? 0 : $new_cn,
                    'new_mota' => $list['mtcv'],
                    'new_yeu_cau' => $list['yccv'],
                    'new_quyen' => $list['qldh'],
                );
                $this->Models->update_data('new', $data_edit, ['new_id' => $data_get['id_new']]);
                $this->success('Bạn đã sửa tin thành công ', ['redirect' => 'danh sách tin đã đăng ']);
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập mới sử dụng được chức năng này ');
        }
    }
    public function tim_kiem_ntd()
    {
        $input_post = ['keyword', 'city', 'hinhthuc', 'loailv', 'gioitinh', 'honnhan', 'luong'];
        $search_post = $this->getAllData('post', $input_post);
        $keyword = trim($search_post['keyword']);;
        $hinhthuc = $search_post['hinhthuc'];
        $loailv = $search_post['loailv'];
        $gioitinh = $search_post['gioitinh'];
        $honnhan = $search_post['honnhan'];
        $luong = $search_post['luong'];
        $city = $search_post['city'];
        $check_tag = $this->Models->select_sql('category', 'cat_id,cat_name,cat_alias', ['cat_alias' => vn_str_filter($keyword)], null, null, null, null, null, 0);
        $search_uv = [];
        if ($hinhthuc != 0 || $loailv != 0 || $gioitinh != 0 || $honnhan != 0 || $luong != 0 || ($keyword != '' && $check_tag == NULL)) {
            if ($hinhthuc != 0) {
                $search_uv['hinhthuc'] = $hinhthuc;
            }
            if ($loailv != 0) {
                $search_uv['loailv'] = $loailv;
            }
            if ($gioitinh != 0) {
                $search_uv['gioitinh'] = $gioitinh;
            }
            if ($honnhan != 0) {
                $search_uv['honnhan'] = $honnhan;
            }
            if ($luong != 0) {
                $search_uv['luong'] = $luong;
            }
        };
        $arr_search['uv_found'] = 1;
        if (array_key_exists("hinhthuc", $search_uv)) {
            $arr_search['uv_hinh_thuc'] = $search_uv['hinhthuc'];
        }
        if (array_key_exists("loailv", $search_uv)) {
            $arr_search['uv_loai_hinh'] = $search_uv['loailv'];
        }
        if (array_key_exists("gioitinh", $search_uv)) {
            $arr_search['uv_sex'] = $search_uv['gioitinh'];
        }
        if (array_key_exists("honnhan", $search_uv)) {
            $arr_search['uv_mary'] = $search_uv['honnhan'];
        }
        if (array_key_exists("luong", $search_uv)) {
            $arr_search['uv_luong_1'] = $search_uv['luong'];
        }
        if ($city != 0) {
            $arr_search['uv_city'] = $city;
        }
        if ($keyword != '') {
            $like_key = str_replace('-', '%', vn_str_filter(preg_replace('/[-\s]+/', ' ', $keyword)));
            $like = [['col' => 'uv_vitri ', 'val' => $like_key]];
        } else {
            $like = NULL;
        }
        $input_post = ['pagination', 'limit'];
        $data_post = $this->getAllData('post', $input_post);
        $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
        if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
            $pagination = 1;
        } else {
            $pagination = $data_post['pagination'];
        }
        $start = ($pagination - 1) * $limit;
        $select = 'uv_id,uv_name,uv_city,uv_cat,uv_loai_hinh,uv_hinh_thuc,uv_vitri,uv_cat,uv_luong_1,uv_createtime,uv_avatar,uv_alias';

        $infor = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, $like, null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), '', '', 1);
        if (count($infor) == 0) {
            if (isset($keyword)) {
                $like_key = str_replace('-', '%', vn_str_filter(preg_replace('/[-\s]+/', ' ', $keyword)));
                $like = [['col' => 'uv_name', 'val' => $like_key]];
            } else {
                $like = null;
            }
            $infor = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, $like, null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), '', '', 1);
        }
        $categoties = list_category();
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $id_ntd = $token->data->UserId;
        }
        foreach ($infor as $k => $value) {
            // echo $value['uv_id'] . '-' . $id_ntd . "<br>";
            if (isset($id_ntd)) {
                $count = $this->Models->select_sql('save_uv', '*', array('id_ntd' => $id_ntd, 'id_uv' => $value['uv_id']), null, null, null, null, null, 1);
                $infor[$k]['check_save'] =  (count($count) == 1) ? true : false;
            }
            $text_cat = '';
            $cat = explode(',', $value['uv_cat']);
            $cate = '';
            foreach ($categoties as $v) {
                if (in_array($v['cat_id'], $cat)) {
                    $text_cat .= $v['cat_name'] . ' , ';
                }
            }
            if ($infor[$k]['uv_avatar'] == '') {
                $infor[$k]['uv_avatar'] = 'https://vieclamtheogio.vieclam123.vn/images/n_ava_logo.png';
            } else {
                $infor[$k]['uv_avatar'] = 'https://vieclamtheogio.vieclam123.vn/upload/uv/' . date('Y', $infor[$k]['uv_createtime']) . '/' . date('m', $infor[$k]['uv_createtime']) . '/' . date('d', $infor[$k]['uv_createtime']) . '/' . $infor[$k]['uv_avatar'];
            }
            $infor[$k]['uv_cat'] = $text_cat;
        }
        // var_dump($text_cat);
        $this->success('Danh sách các ứng viên', $infor);
    }
    // Trang chủ 
    public function trang_chu_ntd()
    {
        $arr_search['uv_found'] = 1;
        $input_post = ['pagination', 'limit'];
        $data_post = $this->getAllData('post', $input_post);
        $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
        if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
            $pagination = 1;
        } else {
            $pagination = $data_post['pagination'];
        }
        $start = ($pagination - 1) * $limit;
        $select = 'uv_id,uv_name,uv_city,uv_cat,uv_loai_hinh,uv_hinh_thuc,uv_vitri,uv_cat,uv_luong_1,uv_createtime,uv_avatar,uv_alias';

        $infor = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, '', null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), $limit, $start, 1);

        $categoties = list_category();
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $id_ntd = $token->data->UserId;
        }
        // var_dump($infor['1']['uv_createtime']);
        // die;
        foreach ($infor as $k => $value) {
            // echo $value['uv_id'] . '-' . $id_ntd . "<br>";
            if (isset($id_ntd)) {
                $count = $this->Models->select_sql('save_uv', '*', array('id_ntd' => $id_ntd, 'id_uv' => $value['uv_id']), null, null, null, null, null, 1);
                $infor[$k]['check_save'] =  (count($count) == 1) ? true : false;
            }
            $text_cat = '';
            $cat = explode(',', $value['uv_cat']);
            $cate = '';
            foreach ($categoties as $v) {
                if (in_array($v['cat_id'], $cat)) {
                    $text_cat .= $v['cat_name'] . ' , ';
                }
            }
            if ($infor[$k]['uv_avatar'] == '') {
                $infor[$k]['uv_avatar'] = 'https://vieclamtheogio.vieclam123.vn/images/n_ava_logo.png';
            } else {
                $infor[$k]['uv_avatar'] = 'https://vieclamtheogio.vieclam123.vn/upload/uv/' . date('Y', $infor[$k]['uv_createtime']) . '/' . date('m', $infor[$k]['uv_createtime']) . '/' . date('d', $infor[$k]['uv_createtime']) . '/' . $infor[$k]['uv_avatar'];
            }
            $infor[$k]['uv_cat'] = $text_cat;
        }
        $data_emp = [
            'total' => count($this->Models->select_sql_like_and('user_uv', $select, $arr_search, '', null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), '', '', 1)),
            'number_item_in_one_page' => $limit,
            'so_trang_hien_tai' => ($start == 0) ? 1 : $start,
            'list' => $infor
        ];
        $this->success('Danh sách các ứng viên', $data_emp);
    }
    // lưu ứng viên
    public function uv_saved()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            if (isset($token->data->UserId) && isset($token->data->Type) && $token->data->Type == 4) {

                $data_get = $this->getAllData('get', ['id_uv']);
                $id_uv = $data_get['id_uv'];
                $create_date = intval(time());

                $check_save_uv   =  $this->Models->select_sql('save_uv', '*', array('id_ntd' => $token->data->UserId, 'id_uv' => $id_uv), null, null, null, null, null, 0);
                if ($check_save_uv == NULL) {
                    $data = array(
                        'id_ntd' => $token->data->UserId,
                        'id_uv' => $id_uv,
                        'create_date' => $create_date,
                    );
                    $insert = $this->Models->insert_data('save_uv', $data);
                    $dataNoti = array(
                        'type' => 1, // thông báo của uv
                        'id_uv' => $id_uv,
                        'id_ntd' => $token->data->UserId,
                        'id_new' => 0,
                        'status' => 1, //1: ntd lưu uv, 2: ntd xem tt uv, 3: uv lưu tin, 4:uv ut tin 
                        'create_date' => $create_date,
                    );
                    $insertNoti = $this->Models->insert_data('notification', $dataNoti);
                    $this->success('Bạn đã lưu thành công 1 ứng viên ', []);
                } else {
                    $condition = ['id_ntd' => $token->data->UserId, 'id_uv' => $id_uv];
                    $delete = $this->Models->delete_data('save_uv', $condition);
                    $this->success('Bạn đã xóa thành công 1 ứng viên ', []);
                }
            } else {
                $this->set_error('isLogin', 'Bạn phải đăng nhập dưới nhà tuyển dụng mới sử dụng được chức năng này ');
            }
        } else {
            $this->set_error('isLogin', 'Bạn phải đăng nhập mới sử dụng được chức năng này ');
        }
    }







    //==============UNG VIEN==============

    // đăng kí cho ứng viên 
    public function dangky_uv()
    {
        $data_post = [
            'uv_name', 'uv_email', 'uv_password', 'uv_repassword',  'uv_number', 'n_city', 'n_qh', 'uv_address', 'uv_cat', 'uv_vitri', 'uv_city_hope', 'uv_calam'
        ];
        $flag = true;
        $list = $this->getAllData('post', $data_post);
        // họ và tên 
        if (trim($list['uv_name']) == '') {
            $flag = false;
            $name_error = 'Họ và tên không được bỏ trống';
        } else {
            $name_error = '';
        }
        // email
        $checkEmail = $this->Ajax_model->check_email_uv($list['uv_email']);
        $regex_email = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12}+\.)(.[a-zA-Z]{2,12})+$/";
        if (trim($list['uv_email']) == '') {
            $flag = false;
            $flag_mail = false;
            $email_error = 'Email không được bỏ trống';
        } else if (!preg_match($regex_email, $list['uv_email'])) {
            $flag = false;
            $flag_mail = false;
            $email_error = 'Email chưa đúng định dạng';
        } elseif (count($checkEmail) > 0) {
            $flag = false;
            $flag_mail = false;
            $email_error = 'Email đã tồn tại trên hệ thống';
        } else {
            $flag_mail = true;
            $email_error = '';
        }
        // mật khẩu 
        $regex_pass = "/^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/";
        if (trim($list['uv_password']) == '') {
            $flag = false;
            $pass_error = 'Mật khẩu không được bỏ trống';
        } else if (!preg_match($regex_pass, $list['uv_password'])) {
            $flag = false;
            $pass_error = 'Mật khẩu tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách';
        } else {
            $pass_error = '';
        }
        // nhập lại mật khẩu
        if (trim($list['uv_repassword']) == '') {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không được bỏ trống';
        } else if ($list['uv_repassword'] != $list['uv_password']) {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không trùng với mật khẩu ';
        } else {
            $re_pass_error = '';
        }
        // số điện thoại 
        $regex_tel = "/^((84|\+84|0)+[0-9]{9,14})$/";
        if (trim($list['uv_number']) == '') {
            $flag = false;
            $flag_phone = false;
            $phone_error = 'Số điện thoại không được bỏ trống';
        } else if (!preg_match($regex_tel, $list['uv_number'])) {
            $flag_phone = false;
            $flag = false;
            $phone_error = 'Số điện thoại chưa đúng định dạng';
        } else {
            $flag_phone = true;
            $phone_error = '';
        }
        // đăng kí ứng viên lỗi 
        if ($flag_phone ==  true && $flag_mail == true) {
            $post_data = [
                'uv_email' => $list['uv_email'],
                'uv_phone' => $list['uv_number'],
                'uv_name' => $list['uv_name'],
            ];
            $condition = 'uv_email = "' .  $list['uv_email'] . '" OR uv_phone = "' . $list['uv_number'] . '"';
            $result = $this->Models->select_data('id', 'user_uv_error', [], $condition, '', '', '');
            if ($result->num_rows() > 0) {
                // update
                $update = $this->Models->update_data('user_uv_error', $post_data, $condition);
            } else {
                // add
                $result = $this->Models->insert_data('user_uv_error', $post_data);
            }
        }
        // tỉnh thành 
        if ($list['n_city'] == '') {
            $flag = false;
            $city_error = 'Tỉnh thành không được bỏ trống';
        } else {
            $city_error = '';
        }
        // quân huyện 
        if ($list['n_qh'] == '') {
            $flag = false;
            $district_error = 'Quận huyện không được bỏ trống';
        } else {
            $district_error = '';
        }
        // địa chỉ cụ thể
        if ($list['uv_address'] == '') {
            $flag = false;
            $address_error = 'Địa chỉ cụ thể không được bỏ trống';
        } else {
            $address_error = '';
        }
        // Loại công việc 
        if ($list['uv_cat'] == '') {
            $flag = false;
            $type_job_error = 'Loại công việc không được bỏ trống';
        } elseif (count(explode(',', substr($list['uv_cat'], 0, -1))) > 5) {
            $flag = false;
            $type_job_error = 'Loại công việc  không được nhập quá 5 loại ';
        } else {
            $type_job_error = '';
        }
        // Công việc cụ thể muốn ứng tuyển 
        if ($list['uv_vitri'] == '') {
            $flag = false;
            $uv_vitri_error = 'Loại công việc không được bỏ trống';
        } else {
            $uv_vitri_error = '';
        }
        // Nơi làm việc mong muốn

        if ($list['uv_city_hope'] == '') {
            $flag = false;
            $uv_citY_hop_error = 'Nơi làm việc mong muốn không được bỏ trống';
        } elseif (count(explode(',', substr($list['uv_city_hope'], 0, -1))) > 3) {
            $flag = false;
            $uv_citY_hop_error = 'Nơi làm việc mong muốn không được nhập quá 3 loại ';
        } else {
            $uv_citY_hop_error = '';
        }
        // Ca làm 
        if ($list['uv_calam'] == '') {
            $flag = false;
            $uv_calam_error = 'Ca làm không được bỏ trống';
        } else {
            $uv_calam_error = '';
        }
        $cre_time = intval(time());
        $path = 'upload/uv/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
        $check1 = $this->checkUploadImgNTD1('avatar', 8000000);
        if ($check1['flag'] == false) {
            $flag = false;
            $avatar_error = $check1['avatar_error'];
        } else {
            $avatar_error = '';
        }

        $avatar_name = $check1['avartar_name'];
        if ($flag == false) {
            $data_error = [
                'uv_name' => ucwords($name_error),
                'uv_email' => $email_error,
                'uv_password' => $pass_error,
                'uv_repassword' => $re_pass_error,
                'uv_number' => $phone_error,
                'n_city' => $city_error,
                'n_qh' => $district_error,
                'uv_address' => $address_error,
                'uv_cat' => $type_job_error,
                'uv_vitri' => $uv_vitri_error,
                'uv_city_hope' => $uv_citY_hop_error,
                'uv_calam' => $uv_calam_error,
                'avatar_error' => $avatar_error,
            ];
            $this->set_error('error_form', 'Form bạn điền chưa đúng định dạng', $data_error);
        } else {
            $cre_time = intval(time());
            $path = 'upload/uv/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time);
            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);

            $data_post = [
                'uv_name', 'uv_email', 'uv_password', 'uv_repassword',  'uv_number', 'uv_vitri', '', 'uv_calam'
            ];
            $code = rand(100000, 999999);
            $data = array(
                'uv_name' => $list['uv_name'],
                'uv_alias' => vn_str_filter($list['uv_name']),
                'uv_email' => $list['uv_email'],
                'uv_pass' => md5($list['uv_password']),
                'uv_city' => $list['n_city'],
                'uv_qh' =>  $list['n_qh'],
                'uv_address' => $list['uv_address'],
                'uv_cat' => $list['uv_cat'],
                'uv_vitri' => $list['uv_vitri'],
                'uv_city_hope' => $list['uv_city_hope'],
                'uv_phone' => $list['uv_number'],
                'uv_calam' => $list['uv_calam'],
                'uv_authentic' => 0,
                'sign_up_from' => 2,
                'uv_token' => $code,
                'uv_createtime' => $cre_time,
                'uv_updatetime' => $cre_time,
                'uv_avatar' => $avatar_name,
                'date_refresh' => $cre_time,
                'number_refresh' => 5,
                'uv_found' => 1,
            );
            $result = $this->Models->insert_data('user_uv', $data);
            $dataToken_dk_uv['data'] = [
                'uv_email' => $list['uv_email'],
                'uv_id' => $result,
                'uv_name' => $list['uv_name'],
                'expired' => time() + 86400,
            ];
            $token = JWT::encode($dataToken_dk_uv, $this->secretKey, 'HS256');
            if ($result > 0) {
                $this->Models->delete_data('user_uv_error', 'uv_email = "' . $list['uv_email'] . '" OR uv_phone = "' . $list['uv_number'] . '"');
                $send_mail = $this->globals->send_mail_xt_Otp_app(base_url() . 'EmailTemplate/Email_Xacthuc_OTP_App.html', $list['uv_email'], $list['uv_name'], $code, 'Xác thực đăng ký ứng viên', 3, 'Xác thực tài khoản');
                if ($send_mail == true) {
                    $data_emp = [
                        'ntd_email' => $list['uv_email'],
                        'token_dki_uv' => $token,
                    ];
                    $this->success('Tài khoản quý khách đã đăng kí thành công  ! Vui lòng vào gmail để lấy mã xác thực OTP', $data_emp);
                } else {
                    $data = array('kq' => false, 'msg' => 'Đăng ký không thành công');
                }
            } else {
                $data = ['kq' => false, 'msg' => 'đăng ký không thành công'];
            }
        }
    }
    public function xac_thuc_uv()
    {
        $token = $this->getTokens();
        $email_uv = $token->data->uv_email;
        $data_post = ['uv_xt_otp'];
        $list = $this->getAllData('post', $data_post);
        $code = $this->Models->select_where_and('uv_token ,uv_authentic', 'user_uv', ['uv_email' => $email_uv])->row_array();
        if ($code["uv_token"] == trim($list['uv_xt_otp'])) {
            $condition = [
                'uv_email' => $email_uv,
            ];
            $n_dky_email = $this->Models->select_where_and('date_refresh,number_refresh,uv_authentic ,uv_name,uv_id ,uv_avatar, uv_createtime ', 'user_uv', $condition)->row_array();
            $date_refresh = $n_dky_email['date_refresh'];
            $data_update = [
                "date_refresh" => intval(time()),
            ];
            $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $n_dky_email['uv_id']));
            if (date('Y', $date_refresh) < date('Y')) {
                $data_update = [
                    // "date_refresh" => intval(time()),
                    "number_refresh" => 5,
                ];
                $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $n_dky_email['uv_id']));
            } else {
                if (date('m', $date_refresh) < date('m')) {
                    $data_update = [
                        // "date_refresh" => intval(time()),
                        "number_refresh" => 5,
                    ];
                    $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $n_dky_email['uv_id']));
                }
            }
            $cre_time = $n_dky_email['uv_createtime'];
            $path = '/upload/uv/' . date('Y', $cre_time) . '/' . date('m', $cre_time) . '/' . date('d', $cre_time) . '/' . $n_dky_email['uv_avatar'];

            $dataToken['data'] = [
                'UserId' => $n_dky_email['uv_id'],
                'Name' =>  $n_dky_email['uv_name'],
                'email' => $email_uv,
                'Type' => 3,
                'avatar' => $path,
                'expired' => time() + 86400,
            ];
            $token = JWT::encode($dataToken, $this->secretKey, 'HS256');

            $up = $this->Models->update_data('user_uv', ['uv_authentic' => 1], array('uv_email' => $email_uv));
            $data_emp = [
                'redirect' => 'Chuyển về trang quản lí chung ứng viên',
                'token'      => $token,
            ];
            $this->success('Xác thực thành công mã otp', $data_emp);
        } else {
            $this->success('Mã xác thực nhập vào chưa đúng !Quý khách vui lòng  nhập lại .', ['redirect' => '']);
        }
    }
    // quyên mật khẩu 
    public function forgot_email_uv()
    {
        $flag = true;
        $data_post = ['email_forgot'];
        $list = $this->getAllData('post', $data_post);
        $checkEmail = $this->Models->select_where_and('uv_email,uv_name', 'user_uv', ['uv_email' => $list['email_forgot']])->row_array();

        $regex_email = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12}+\.)(.[a-zA-Z]{2,12})+$/";
        if (trim($list['email_forgot']) == '') {
            $flag = false;
            $email_error = 'Email không được bỏ trống';
        } else if (!preg_match($regex_email, $list['email_forgot'])) {
            $flag = false;
            $email_error = 'Email chưa đúng định dạng';
        } elseif ($checkEmail ==  null) {
            $flag = false;
            $email_error = 'Email không tồn tại trên hệ thống';
        } else {
            $email_error = '';
        }
        if ($flag == false) {
            $this->set_error('error_form', $email_error);
        } else {
            $code = rand(100000, 999999);
            $update = $this->Models->update_data('user_uv', ['uv_token' => $code], array('uv_email' => $list['email_forgot']));
            $send_mail = $this->globals->send_mail_xt_Otp_app(base_url() . 'EmailTemplate/Email_Xacthuc_OTP_App.html', $list['email_forgot'], $checkEmail['uv_name'], $code, 'Quyên mật khẩu Ứng Viên ', 3, 'Quyên mật khẩu Ứng Viên ');
            if ($send_mail == true) {
                $dataToken_forgot_ntd['data'] = [
                    'forgot_email' =>  $list['email_forgot'],
                ];
                $token = JWT::encode($dataToken_forgot_ntd, $this->secretKey, 'HS256');
                $this->success('Mã xác thực đã được gửi! Quý khách vui lòng vào gmail để lấy mã xác thực', ['token_forgot_nrd' =>  $token]);
            } else {
                $this->set_error('error_mail', 'Email của bạn chưa đúng!');
            }
        }
    }
    // check mã otp khi dc gửi mail 
    public function change_pass_chek_otp_uv()
    {
        $token = $this->getTokens();
        $data_post = ['otp_forgot'];
        $list = $this->getAllData('post', $data_post);
        $email = $token->data->forgot_email;
        $code = $this->Models->select_where_and('uv_token ', 'user_uv', ['uv_email' => $email])->row_array();
        if ($code["uv_token"] == trim($list['otp_forgot'])) {
            $dataToken_forgot_ntd['data'] = [
                'forgot_otp_email' =>  $email,
            ];
            $token = JWT::encode($dataToken_forgot_ntd, $this->secretKey, 'HS256');
            $data_emp = [
                'redirect' => 'Chuyển đến trang đổi mật khẩu mới',
                'token_forgot_otp' => $token,
            ];
            $this->success('Mã xác thực đúng ', $data_emp);
        } else {
            $this->set_error('error_form', 'Mã xác thực nhập vào chưa đúng !Quý khách vui lòng  nhập lại .');
        }
    }
    // Đổi mật khẩu từ quyên mật khẩu ứng viên 
    public function change_pass_uv()
    {
        $token = $this->getTokens();
        $email = $token->data->forgot_otp_email;

        $flag = true;
        $data_post = ['new_pass', 'new_repass'];
        $list = $this->getAllData('post', $data_post);
        $new_pass = $list['new_pass'];
        $new_repass = $list['new_repass'];
        $partten_pass = "/^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/";
        if (trim($new_pass) == '') {
            $flag = false;
            $pass_error = 'Mật khẩu không được bỏ trống';
        } else if (!preg_match($partten_pass, $new_pass)) {
            $flag = false;
            $pass_error = 'Mật khẩu tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách';
        } else {
            $pass_error = '';
        }
        if (trim($new_repass) == '') {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không được bỏ trống';
        } else if ($new_repass != $new_pass) {
            $flag = false;
            $re_pass_error = 'Nhập lại mật khẩu không trùng với mật khẩu ';
        } else {
            $re_pass_error = '';
        }
        if ($flag == false) {
            $data_error = [
                'new_pass' => $pass_error,
                'new_repass' => $re_pass_error,
            ];
            $this->set_error('error_form', $data_error);
        } else {
            $this->Models->update_data('user_uv', ['uv_pass' => md5($new_pass)], array('uv_email' => $email));
            $this->success('Đổi mật khẩu thành công', ['redirect' =>  'chuyển về trang đăng nhập Ứng viên']);
        }
    }
    // =--------------- Quản Lý Chung Ứng viên -----------------=
    // Quản lí chung 
    public function quan_ly_chung_uv()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login  != null) {
            $token = $this->getTokens();
            $select = 'uv_sex,uv_mary,uv_dob,uv_city,uv_qh,uv_address,uv_phone,uv_avatar';
            $infor = $this->Models->select_where_and($select, 'user_uv', ['uv_id' => $token->data->UserId])->row_array();
            $count = 0;
            foreach ($infor as $key => $value) {
                if ((is_numeric($value) && $value > 0) || (!is_numeric($value) && $value != '')) {
                    $count++;
                }
            }
            if (count($infor) > 0) {
                $percent1  = floor(100 * $count / count($infor));
            } else {
                $percent1  = 0;
            }
            $select = 'uv_cat,uv_vitri,uv_city_hope,uv_calam,uv_hinh_thuc,uv_loai_hinh,uv_luong_1';
            $infor = $this->Models->select_where_and($select, 'user_uv', ['uv_id' => $token->data->UserId])->row_array();
            $count = 0;
            foreach ($infor as $key => $value) {
                if ((is_numeric($value) && $value != 0) || (!is_numeric($value) && $value != '')) {
                    $count++;
                }
            }
            if (count($infor) > 0) {
                $percent2  = floor(100 * $count / count($infor));
            } else {
                $percent2  = 0;
            }
            $select = 'uv_gtc';
            $infor = $this->Models->select_where_and($select, 'user_uv', ['uv_id' => $token->data->UserId])->row_array();
            $count = 0;
            foreach ($infor as $key => $value) {
                if ((is_numeric($value) && $value > 0) || (!is_numeric($value) && $value != '')) {
                    $count++;
                }
            }
            if (count($infor) > 0) {
                $percent3 = floor(100 * $count / count($infor));
            } else {
                $percent3 = 0;
            }
            // kinh nghiệm làm việc 
            $select = 'com_name,vi_tri,date_from,date_to,mo_ta';
            $infor = $this->Models->select_where_and($select, 'uv_knlv', ['id_uv' => $token->data->UserId])->result_array();
            $count = 0;
            foreach ($infor as $kn) {
                foreach ($kn as $key => $value) {
                    if ((is_numeric($value) && $value > 0) || (!is_numeric($value) && $value != '')) {
                        $count++;
                    }
                }
            }
            if (count($infor) > 0) {
                $percent4 = floor(100 * $count / (5 * count($infor)));
            } else {
                $percent4 = 0;
            }
            $save_new = $this->Models->select_where_and('id_new', 'save_new', ['id_uv' => $token->data->UserId])->result_array();
            $data['save_new'] = count($save_new);
            // vl đã ut
            $apply_new = $this->Models->select_where_and('id_new', 'apply_new', ['id_uv' => $token->data->UserId])->result_array();
            $data['apply_new'] = count($apply_new);
            // ntd xem hồ sơ
            $ntd_xemhoso = $this->Models->select_where_and('id_ntd', 'see_uv', ['id_uv' => $token->data->UserId])->result_array();
            $data['ntd_xemhoso'] = count($ntd_xemhoso);
            $data = [
                'percent_thong_tin_co_ban' => $percent1,
                'percent_cv_hope' => $percent2,
                'percent_gt_chung' => $percent3,
                'percent_kinh_nghiem_lv' => $percent4,
                'apply_new' => count($apply_new),
                'save_new' => count($save_new),
                'ntd_xemhoso' => count($ntd_xemhoso)
            ];
            $this->success('Quản Lí Chung Của ứng viên', $data);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // đổi mật khẩu 
    public function qlc_uv_change_pass()
    {
        $check_login = $this->getAuthorizationHeader();
        if ($check_login  != null) {

            $flag = true;
            $data_post = ['old_pass', 'new_pass', 'new_repass'];
            $list = $this->getAllData('post', $data_post);
            $oldPass = $list['old_pass'];
            $newPass = $list['new_pass'];
            $newRePass = $list['new_repass'];
            $token = $this->getTokens();
            $email = $token->data->email;
            $condition = ['uv_email' => $email, 'uv_pass' => md5($oldPass)];
            $result = $this->Models->select_where_and('uv_pass', 'user_uv', $condition)->row_array();

            $partten_pass = "/^(?!.* )(?=.*\d)(?=.*[a-zA-Z]).{6,16}$/";
            if ($oldPass == '') {
                $flag = false;
                $error_old_pass = 'Mật khẩu hiện tại không được bỏ trống';
            } elseif ($result == null) {
                $flag = false;
                $error_old_pass = 'Mật khẩu hiện tại nhập vào không chính xác ';
            } else {
                $error_old_pass = '';
            }

            if ($newPass == '') {
                $flag = false;
                $error_new_pass = 'Mật khẩu mới không được bỏ trống';
            } else if (!preg_match($partten_pass, $newPass)) {
                $flag = false;
                $error_new_pass = 'Mật khẩu tối thiểu 6 ký tự gồm tối thiểu 1 chữ và 1 số, không chứa dấu cách';
            } else {
                $error_new_pass = '';
            }

            if (trim($newRePass) == '') {
                $flag = false;
                $error_new_repass = 'Nhập lại mật khẩu không được bỏ trống';
            } else if ($newRePass != $newPass) {
                $flag = false;
                $error_new_repass = 'Nhập lại mật khẩu không trùng với mật khẩu ';
            } else {
                $error_new_repass = '';
            }
            if ($flag == false) {
                $data_error = [
                    'old_pass' => $error_old_pass,
                    'new_pass' => $error_new_pass,
                    'new_repass' => $error_new_repass,
                ];
                $this->set_error('error_form', $data_error);
            } else {
                $data = [
                    'uv_pass' => md5($newPass),
                ];
                $condition = ['uv_email' => $email];
                $change_pass = $this->Models->update_where_and($data, 'user_uv', $condition);
                $this->success('Bạn đã đổi mật khẩu thành công ', []);
            }
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Quản lí hồ sơ - thông tin cơ bản 
    public function get_thong_tin_co_ban_uv()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $email = $token->data->email;
            $uv = $this->Models->select_where_and('uv_avatar,uv_sex,uv_mary,uv_dob,uv_city,uv_qh,uv_address,uv_phone,uv_cat,uv_hinh_thuc,uv_loai_hinh,uv_vitri,uv_luong_1,uv_luong_2,uv_luong_3,uv_city_hope,uv_calam', 'user_uv', ['uv_email' => $email])->row_array();
            $uv['uv_city'] = get_city($uv['uv_city']);
            $uv['uv_qh'] = get_district($uv['uv_qh'])['cit_name'];
            $uv['uv_mary'] = get_mary($uv['uv_mary']);
            $uv['uv_sex'] = get_sex($uv['uv_sex']);
            $uv['uv_dob'] = date('d-m-Y', $uv['uv_dob']);
            $categoties = list_category();
            $cat = explode(',', $uv['uv_cat']);
            $cate = '';
            foreach ($categoties as $value) {
                if (in_array($value['cat_id'], $cat)) {
                    $cate .= $value['cat_name'] . ' , ';
                }
            }
            $uv['uv_cat'] = $cate;
            $uv['uv_hinh_thuc'] = get_htlv($uv['uv_hinh_thuc']);
            $this->success('Thông tin cơ bản', $uv);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Cập nhật thông tin có bản 
    public function update_thong_tin_co_ban_uv()
    {
        $check_login =  $this->getAuthorizationHeader();
        $token = $this->getTokens();
        if ($check_login != null) {
            $input_post = ['avatar', 'uv_name', 'uv_sex', 'uv_date', 'uv_city', 'uv_district', 'uv_address', 'uv_phone'];
            $list = $this->getAllData('post', $input_post);
            $flag = true;
            $cre_time = explode('/', $token->data->avatar);
            $path = 'upload/uv/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];
            $check1 = $this->checkUploadImgNTD($token, 'avatar', 8000000);
            if ($check1['flag'] == false) {
                $flag = false;
                $avatar_error = $check1['avatar_error'];
            } else {
                $avatar_error = '';
            }

            if (trim($list['uv_name']) == '') {
                $flag = false;
                $name_error = 'Họ và tên không được bỏ trống';
            } else {
                $name_error = '';
            }
            if (trim($list['uv_sex']) == '') {
                $flag = false;
                $sex_error = 'Giới tính không được bỏ trống';
            } else {
                $sex_error = '';
            }
            if (trim($list['uv_date']) == '') {
                $flag = false;
                $date_error = 'Ngày sinh không được bỏ trống';
            } else {
                $date_error = '';
            }
            if (trim($list['uv_city']) == '') {
                $flag = false;
                $city_error = 'Tỉnh thành không được bỏ trống';
            } else {
                $city_error = '';
            }
            if (trim($list['uv_district']) == '') {
                $flag = false;
                $qh_error = 'Quận huyện không được bỏ trống';
            } else {
                $qh_error = '';
            }
            if (trim($list['uv_address']) == '') {
                $flag = false;
                $address_error = 'Địa chỉ cụ thể không được bỏ trống';
            } else {
                $address_error = '';
            }

            $avatar_name = $check1['avartar_name'];
            if ($flag == false) {
                $data_error = [
                    'avatar_error' => $avatar_error,
                    'name_error' => $name_error,
                    'sex_error' => $sex_error,
                    'date_error' => $date_error,
                    'city_error' => $city_error,
                    'qh_error' => $qh_error,
                    'address_error' => $address_error,
                ];
                $this->set_error('error_form', $data_error);
            } else {
                $cre_time = explode('/', $token->data->avatar);
                $path = '/upload/uv/' . $cre_time[3] . '/' . $cre_time[4] . '/' . $cre_time[5];

                move_uploaded_file($_FILES['avatar']['tmp_name'], $path . '/' . $avatar_name);
                $data = [
                    'uv_avatar' => $avatar_name,
                    'uv_name' => $list['uv_name'],
                    'uv_sex' => $list['uv_sex'],
                    'uv_dob' => strtotime($list['uv_date']),
                    'uv_city' => $list['uv_city'],
                    'uv_qh' => $list['uv_district'],
                    'uv_address' => $list['uv_address'],
                ];
                $this->Models->update_data('user_uv', $data, ['uv_email' =>  $token->data->email]);
                $this->success('Bạn cập nhật thành công thông tin cơ bản', $data);
            }
        } else {

            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Cập nhật Công việc mong muốn
    public function update_cv_mong_muon()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['uv_cat', 'uv_vitri', 'uv_city_hope', 'lhlv', 'uv_calam'];
            $list = $this->getAllData('post', $input_post);
            $flag = true;
            if ($list['uv_cat'] == '') {
                $flag = false;
                $type_job_error = 'Loại công việc không được bỏ trống';
            } elseif (count(explode(',', substr(($list['uv_cat']), 0, -1))) > 5) {
                $flag = false;
                $type_job_error = 'Loại công việc  không được nhập quá 5 loại ';
            } else {
                $type_job_error = '';
            }
            // Công việc cụ thể muốn ứng tuyển 
            if ($list['uv_vitri'] == '') {
                $flag = false;
                $uv_vitri_error = 'Loại công việc không được bỏ trống';
            } else {
                $uv_vitri_error = '';
            }
            // Nơi làm việc mong muốn

            if ($list['uv_city_hope'] == '') {
                $flag = false;
                $uv_citY_hop_error = 'Nơi làm việc mong muốn không được bỏ trống';
            } elseif (count(explode(',', substr($list['uv_city_hope'], 0, -1))) > 3) {
                $flag = false;
                $uv_citY_hop_error = 'Nơi làm việc mong muốn không được nhập quá 3 loại ';
            } else {
                $uv_citY_hop_error = '';
            }
            // Loại hình làm viecj  
            if ($list['lhlv'] == '') {
                $flag = false;
                $lhlv_error = 'Loại hình làm việc không được bỏ trống';
            } else {
                $lhlv_error = '';
            }
            // Ca làm 
            if ($list['uv_calam'] == '') {
                $flag = false;
                $uv_calam_error = 'Ca làm không được bỏ trống';
            } else {
                $uv_calam_error = '';
            }
            if ($flag == false) {
                $data_error = [
                    'type_job_error' => $type_job_error,
                    'uv_vitri_error' => $uv_vitri_error,
                    'uv_citY_hop_error' => $uv_citY_hop_error,
                    'lhlv_error' => $lhlv_error,
                    'uv_calam_error' => $uv_calam_error,
                ];
                $this->set_error('error_form', $data_error);
            } else {
                $data_update = [
                    'uv_cat' => $list['uv_cat'],
                    'uv_vitri' => $list['uv_vitri'],
                    'uv_city_hope' => $list['uv_city_hope'],
                    'uv_loai_hinh' => $list['lhlv'],
                    'uv_calam' => $list['uv_calam'],
                ];
                $this->Models->update_data('user_uv', $data_update, ['uv_email' => $token->data->email]);
                $this->success('Bạn cập nhật thành công thông tin cơ bản', $data_update);
            }
        } else {

            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // quản lí hồ sơ - giới thiệu chung 
    public function gioi_thieu_chung_uv()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $email = $token->data->email;
            $input_post = ['uv_gtc'];
            $list = $this->getAllData('post', $input_post);
            $flag = true;
            if (trim($list['uv_gtc']) == '') {
                $flag = false;
                $gtc_error = 'Loại công việc không được bỏ trống';
            } else {
                $gtc_error = '';
            }
            if ($flag == false) {
                $data_error = [
                    'gtc_error' => $gtc_error,
                ];
                $this->set_error('error_form', $data_error);
            } else {
                $data_update = [
                    'uv_gtc' => $list['uv_gtc'],
                ];
                $this->Models->update_data('user_uv', $data_update, ['uv_email' => $token->data->email]);
                $this->success('Bạn cập nhật thành công thông tin cơ bản', $data_update);
            }
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // quản lí hồ sơ - kinh nghiệm làm việc 
    public function kinh_nghiem_lam_viec()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $email = $token->data->email;
            $input_post = ['com_name', 'vi_tri', 'date_from', 'date_to', 'mo_ta', 'id_knlv'];
            $list = $this->getAllData('post', $input_post);
            $flag = true;
            if (trim($list['com_name']) == '') {
                $flag = false;
                $com_name_error = 'Tên công ty không được bỏ trống';
            } else {
                $com_name_error = '';
            }
            if (trim($list['vi_tri']) == '') {
                $flag = false;
                $vi_tri_error = 'Chức danh / Vị trí không được bỏ trống';
            } else {
                $vi_tri_error = '';
            }
            if (trim($list['date_from']) == '') {
                $flag = false;
                $date_from_error = 'Ngày bắt đầu không được bỏ trống';
            } elseif (strtotime($list['date_from']) > getdate()[0]) {
                $flag = false;
                $date_from_error = 'Ngày bắt đầu phải nhỏ hơn ngày hiện tại';
            } else {
                $date_from_error = '';
            }
            if (trim($list['date_to']) == '') {
                $flag = false;
                $date_to_error = 'Ngày kết thúc không được bỏ trống';
            } elseif (strtotime($list['date_to']) > getdate()[0]) {
                $flag = false;
                $date_to_error = 'Ngày kết thúc phải nhỏ hơn ngày hiện tại';
            } elseif (strtotime($list['date_to']) < strtotime($list['date_from'])) {
                $flag = false;
                $date_to_error = 'Ngày kết thúc phải lơn hơn ngày bắt đầu';
            } else {
                $date_to_error = '';
            }
            if (trim($list['mo_ta']) == '') {
                $flag = false;
                $mo_ta_error = 'Mô tả về bản thân không được bỏ trống';
            } else {
                $mo_ta_error = '';
            }
            if ($flag == false) {
                $data_error = [
                    'com_name_error' => $com_name_error,
                    'vi_tri_error' => $vi_tri_error,
                    'date_from_error' => $date_from_error,
                    'date_to_error' => $date_to_error,
                    'mo_ta_error' => $mo_ta_error,
                ];
                $this->set_error('error_form', $data_error);
            } else {
                $data_update = [
                    'com_name' => $list['com_name'],
                    'vi_tri' => $list['vi_tri'],
                    'date_from' => strtotime($list['date_from']),
                    'date_to' => strtotime($list['date_to']),
                    'mo_ta' => $list['mo_ta'],
                    'id_uv' => $token->data->UserId,
                ];
                if ($list['id_knlv'] == '' || $list['id_knlv'] == 0) {
                    $result = $this->Models->insert_data('uv_knlv', $data_update);
                    $this->success('Bạn thêm mới thành công 1 kinh nghiệm làm việc', $result);
                } else {
                    $result = $this->Models->update_where_and($data_update, 'uv_knlv', ['id_knlv' => $list['id_knlv']]);
                    $this->success('Bạn cập nhật thành công thông tin cơ bản', $data_update);
                }
                // $this->Models->update_data('user_uv', $data_update, ['uv_email' => $token->data->email]);
            }
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    //danh sách kinh nghiệm làm việc 
    public function list_kinh_nghiem_lam_viec()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $list = $this->getAllData('get', ['id_knlv']);
            if ($this->checkNull($list)) {
                $condition = ['id_uv' => $token->data->UserId, 'id_knlv' => $list['id_knlv']];
            } else {
                $condition = ['id_uv' => $token->data->UserId];
            }
            $select = 'id_knlv,id_uv,com_name,vi_tri,date_from,date_to,mo_ta';
            $infor = $this->Models->select_where_and($select, 'uv_knlv', $condition);
            if ($this->checkNull($list)) {
                $infor = $infor->row_array();
            } else {
                $infor = $infor->result_array();
            }
            $this->success('Danh sách kinh nghiệm làm việc', $infor);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Xóa kinh nghiệm làm việc 
    public function del_kinh_nghiem_lam_viec()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $list = $this->getAllData('post', ['id_knlv']);
            $condition = ['id_knlv' => $list['id_knlv']];
            $result = $this->Models->delete_data('uv_knlv', $condition);
            $this->success('Danh sách kinh nghiệm làm việc', ['redirect' => 'Chuyển về page kinh nghiệm làm việc ']);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Nhà tuyền dụng đã xem hồ sơ 
    public function ntd_see_hso()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['pagination', 'limit'];
            $data_post = $this->getAllData('post', $input_post);
            $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
            if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
                $pagination = 1;
            } else {
                $pagination = $data_post['pagination'];
            }
            $start = ($pagination - 1) * $limit;

            $select = 's.id, s.id_ntd,s.id_uv,s.create_date,ntd.ntd_alias, ntd.ntd_company';
            $join = array('user_ntd ntd' => 's.id_ntd = ntd.ntd_id');
            $ntd_xemhoso = $this->Models->select_sql('see_uv s', $select, array('s.id_uv' => $token->data->UserId), null, $join, array('s.id' => 'DESC'), $limit, $start, 1);

            $infor_p = $this->Models->select_sql('see_uv s', $select, array('s.id_uv' => $token->data->UserId), null, $join, array('s.id' => 'DESC'), null, null, 1);
            $total = count($infor_p);
            $data_emp = [
                'total' => $total,
                'number_item_in_one_page' => $limit,
                'so_trang_hien_tai' => ($start == 0) ? 1 : $start,
                'uv_saved' => $ntd_xemhoso
            ];
            $this->success('Danh sách Nhà tuyển dụng xem hồ sơ', $data_emp);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Việc Làm đã lưu
    public function viec_lam_da_luu()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['pagination', 'limit'];
            $data_post = $this->getAllData('post', $input_post);
            $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
            if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
                $pagination = 1;
            } else {
                $pagination = $data_post['pagination'];
            }
            $start = ($pagination - 1) * $limit;


            $select = 's.id, s.id_ntd,s.id_new,s.id_uv,s.create_date, n.new_title,n.new_alias,n.new_cat,n.new_no_calam,n.new_ca_start,n.new_ca_end,n.new_t2,n.new_t3,n.new_t4,n.new_t5,n.new_t6,n.new_t7,n.new_cn,n.new_luong_1,n.new_luong_2,n.new_luong_3, ntd.ntd_alias, ntd.ntd_company';
            $join = array('new n' => 's.id_new = n.new_id', 'user_ntd ntd' => 's.id_ntd = ntd.ntd_id');
            $new_saved = $this->Models->select_sql('save_new s', $select, array('s.id_uv' => $token->data->UserId), null, $join, array('s.id' => 'DESC'), $limit, $start, 1);

            $infor_p = $this->Models->select_sql('save_new s', $select, array('s.id_uv' => $token->data->UserId), null, $join, array('s.id' => 'DESC'), null, null, 1);
            $total = count($infor_p);
            $data_emp = [
                'total' => $total,
                'number_item_in_one_page' => $limit,
                'so_trang_hien_tai' => ($start == 0) ? 1 : $start,
                'uv_saved' => $new_saved
            ];
            $this->success('Danh sách Việc làm đã lưu', $data_emp);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // xóa việc làm đã lưu
    public function del_viec_lam_da_luu()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['id_job_save'];
            $data_post = $this->getAllData('post', $input_post);
            $this->Models->delete_data('save_new', ['id' => $data_post['id_job_save']]);
            $this->success('Bạn đã xóa thành công 1 Công việc đã lưu', []);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Danh sách việc làm ứng tuyển 
    public function viec_lam_ung_tuyen()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['pagination', 'limit'];
            $data_post = $this->getAllData('post', $input_post);
            $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
            if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
                $pagination = 1;
            } else {
                $pagination = $data_post['pagination'];
            }
            $start = ($pagination - 1) * $limit;

            $select = 'a.id,a.status, a.id_ntd,a.id_uv,a.id_new,a.create_date, a.note,a.calamviec,a.lichlamviec,a.giolam, n.new_title,n.new_alias,n.new_cat,n.new_no_calam,n.new_ca_start,n.new_ca_end,n.new_t2,n.new_t3,n.new_t4,n.new_t5,n.new_t6,n.new_t7,n.new_cn,n.new_luong_1,n.new_luong_2,n.new_luong_3, ntd.ntd_alias, ntd.ntd_company,n.new_han_nop';
            $join = array('new n' => 'a.id_new = n.new_id', 'user_ntd ntd' => 'a.id_ntd = ntd.ntd_id');
            $new_applied = $this->Models->select_sql('apply_new a', $select, array('a.id_uv' => $token->data->UserId), null, $join, array('a.id' => 'DESC'), $limit, $start, 1);

            $infor_p = $this->Models->select_sql('apply_new a', $select, array('a.id_uv' => $token->data->UserId), null, $join, array('a.id' => 'DESC'), null, null, 1);
            $total = count($infor_p);
            $data_emp = [
                'total' => $total,
                'number_item_in_one_page' => $limit,
                'so_trang_hien_tai' => ($start == 0) ? 1 : $start,
                'new_applied' => $new_applied
            ];
            $this->success('Danh sách Việc làm đã lưu', $data_emp);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // xóa việc làm ứng tuyển 
    public function del_viec_lam_ung_tuyen()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['id_job_ut'];
            $data_post = $this->getAllData('post', $input_post);
            $condition = ['id' =>   $data_post['id_job_ut']];
            $delete = $this->Models->delete_data('apply_new', $condition);
            $this->success('Bạn đã xóa thành công 1 việc làm ứng tuyển ',   []);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Trang chủ Ứng viên
    public function trang_chu_ung_vien()
    {
        $input_post = ['pagination', 'limit'];
        $data_post = $this->getAllData('post', $input_post);
        $limit = ((int)trim($data_post['limit']) == '') ? 8 : $data_post['limit'];
        if ($data_post['pagination'] == false || $data_post['pagination'] == '') {
            $pagination = 1;
        } else {
            $pagination = $data_post['pagination'];
        }
        $start = ($pagination - 1) * $limit;
        $data_get = $this->getAllData('get', ['key', 'nn', 'tt', 'qh']);
        $key = $data_get['key'];
        $nn = $data_get['nn'];
        $tt = $data_get['tt'];
        $qh = $data_get['qh'];
        $select = 'new_id,new_title,new_alias,new_httl,,new_cat,new_city,new_loai_hinh,new_hinh_thuc,new_knlv,
			new_luong_1,new_luong_2,new_luong_3,new_han_nop,
			ntd_id,ntd_avatar,ntd_create_time,ntd_alias';
        $join =
            ['user_ntd' => 'new_user_id = ntd_id'];
        $order_by = ['new_updated_time' => 'DESC'];
        $condition = [];
        $like = [];
        if ($key != '') {
            $like_key = str_replace('-', '%', vn_str_filter($key));
            $like = [['col' => 'new_title', 'val' => $like_key]];
        }
        if ($nn > 0) {
            $condition['new_cat'] = $nn;
        }
        if ($qh > 63) {
            $condition['new_qh'] = $qh;
        } elseif ($tt > 0) {
            $condition['new_city'] = $tt;
        }
        $total_job_hour = $this->Models->select_sql_like_and('new', $select, $condition, $like, $join, $order_by, '', '', 1);
        $more_job_hour = $this->Models->select_sql_like_and('new', $select, $condition, $like, $join, $order_by, $limit, $start, 1);
        $condition['new_httl'] = 3;
        $total_job_day = $this->Models->select_sql_like_and('new', $select, $condition, $like, $join, $order_by, '', '', 1);
        $more_job_day = $this->Models->select_sql_like_and('new', $select, $condition, $like, $join, $order_by, $limit, $start, 1);
        $data_emp = [
            'total_hour' => count($total_job_hour),
            'total_day' => count($total_job_day),
            'number_item_in_one_page' => $limit,
            'so_trang_hien_tai' => ($start == 0) ? 1 : $start,
            'new_hour' => $more_job_hour,
            'new_day' => $more_job_day
        ];
        $this->success('Danh sách Việc theo giờ mới nhất ', $data_emp);
    }
    // yêu thích tin tuyển dụng
    public function like_new()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['id_new_like', 'id_ntd'];
            $data_post = $this->getAllData('post', $input_post);
            $id_new = $data_post['id_new_like'];
            $id_ntd = $data_post['id_ntd'];
            $create_date = intval(time());

            $check_save_new   =  $this->Models->select_sql('save_new', '*', array('id_uv' => $token->data->UserId, 'id_new' => $id_new), null, null, null, null, null, 0);

            if ($check_save_new == null) {
                $data = array(
                    'id_uv' => $token->data->UserId,
                    'id_ntd' => $id_ntd,
                    'id_new' => $id_new,
                    'create_date' => $create_date,
                );
                $insert = $this->Models->insert_data('save_new', $data);
                $dataNoti = array(
                    'type' => 2, // thông báo của ntd
                    'id_uv' => $token->data->UserId,
                    'id_ntd' => $id_ntd,
                    'id_new' => $id_new,
                    'status' => 3, //1: ntd lưu uv, 2: ntd xem tt uv, 3: uv lưu tin, 4:uv ut tin 
                    'create_date' => $create_date,
                );
                $insertNoti = $this->Models->insert_data('notification', $dataNoti);
                $this->success('Bạn đã thêm thành công 1 việc làm yêu thích ', []);
            } else {
                $condition = ['id_uv' => $token->data->UserId, 'id_new' => $id_new];
                $delete = $this->Models->delete_data('save_new', $condition);
                $this->success('Bạn đã xóa thành công 1 việc làm yêu thích ', []);
            }
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // chi tiết tin tuyển dụng 
    public function detail_news()
    {
        $input_post = ['id_news'];
        $data_post = $this->getAllData('post', $input_post);
        // var_dump($data_post['id_news'])
        $select = 'new.*,ntd_id,ntd_avatar,ntd_create_time,ntd_company,ntd_alias';
        $condition = ['new_id' => $data_post['id_news']];
        $join = [
            [
                'table' => 'user_ntd',
                'on' => 'new_user_id = ntd_id'
            ]
        ];
        $order_by = '';
        $start = '';
        $perpage = '';
        $infor_job = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage);
        // var_dump($condition);
        if ($infor_job->num_rows() > 0) {
            $infor_job = $infor_job->row_array();
            // check ứng tuyển vs đẫ lưu 
            $check_login =  $this->getAuthorizationHeader();
            if ($check_login != null) {
                $token = $this->getTokens();
                if ((isset($token->data->Type) && $token->data->Type == 3)) {
                    $save_new = $this->Models->select_data('id', 'save_new', [], ['id_uv' => $token->data->UserId, 'id_new' => $data_post['id_news']], '', '', '')->num_rows();
                    $apply_new = $this->Models->select_data('id', 'apply_new', [], ['id_uv' => $token->data->UserId, 'id_new' => $data_post['id_news']], '', '', '')->num_rows();
                } else {
                    $save_new = 0;
                    $apply_new = 0;
                }
            } else {
                $save_new = 0;
                $apply_new = 0;
            }
            $infor_job['new_han_nop_str'] = ($infor_job['new_han_nop'] < getdate()[0]) ? 'Đã hết hạn' : 'Ứng tuyển';
            // tin tuyển dụng cùng công ty
            $id_ntd = $infor_job['ntd_id'];
            $condition = ['ntd_id' => $id_ntd];
            $order_by = 'new_updated_time DESC';
            $start = 0;
            $perpage = 3;
            $job_same_company = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage)->result_array();
            // tăng view
            $update = $this->Models->inc_data('new', ['view_new' => 'view_new+1'], ['new_id' =>  $data_post['id_news']]);
            $detail_job = [
                'check_save' => $save_new,
                'check_apply' => $apply_new,
                'detail_news' => $infor_job,
                'vl_cung_cty' => $job_same_company,
            ];
            $this->success('CHi tiết tin tuyển dụng ', $detail_job);
        } else {
            $this->set_error('301', 'Không có tin tuyển dụng nào ');
        }
    }
    // Ứng viên ứng ứng tuyển việc làm 
    public function apply_new()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $input_post = ['id_ntd', 'id_news', 'giolam', 'lichlamviec', 'calamviec', 'note'];
            $data_post = $this->getAllData('post', $input_post);
            $flag = true;
            if ($data_post['lichlamviec'] == '') {
                $flag = false;
                $lichlv_error = 'Bạn chưa chọn lịch làm việc ';
            } else {
                $lichlv_error = '';
            }
            if ($flag == false) {
                $this->set_error('error_form', $lichlv_error);
            } else {

                $data = array(
                    'id_uv' => $token->data->UserId,
                    'id_ntd' => $data_post['id_ntd'],
                    'id_new' => $data_post['id_news'],
                    'calamviec' => $data_post['calamviec'],
                    'lichlamviec' => $data_post['lichlamviec'],
                    'giolam' => $data_post['giolam'],
                    'status' => 0,
                    'note' => $data_post['note'],
                    'create_date' => time(),
                    'update_date' => time(),
                );
                $result_1 = $this->Models->insert_data('apply_new', $data);
                // insert bảnh thông báo
                $data = array(
                    'type' => 2,
                    'id_uv' => $token->data->UserId,
                    'id_ntd' => $data_post['id_ntd'],
                    'id_new' =>  $data_post['id_news'],
                    'status' => 4,
                    'create_date' => time(),
                );
                $result_2 = $this->Models->insert_data('notification', $data);
                // tăng số lượt ứng tuyển
                $update = $this->Models->inc_data('new', ['so_uv_ungtuyen' => 'so_uv_ungtuyen+1'], ['new_id' =>  $data_post['id_news']]);
                $this->success('Bạn đã ứng tuyển thành công 1 việc làm', []);
            }
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // appbar quản lí chung 
    public function thong_tin_cb()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $uv = $this->Models->select_where_and('number_refresh,uv_found', 'user_uv', ['uv_email' =>  $token->data->email])->row_array();
            $data = [
                'name' => $token->data->Name,
                'email' => $token->data->email,
                'type' => $token->data->Type,
                'refresh' => $uv['number_refresh'],
                'uv_found' => $uv['uv_found'],
            ];
            $this->success('Thông tin phần appbar', $data);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // Cập nhật trạng thái tìm kiếm 
    public function update_status_find()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            $data_post = $this->getAllData('post', ['id_uv']);
            $id_uv = $data_post['id_uv'];
            $get_uv = $this->Models->select_sql('user_uv', 'uv_found', array('uv_id' => $id_uv), null, null, null, null, null, 0);
            if ($get_uv['uv_found'] == 0) {
                $data_update = ["uv_found" => 1];
            } else if ($get_uv['uv_found'] == 1) {
                $data_update = ["uv_found" => 0];
            }
            $update = $this->Models->update_data('user_uv', $data_update, array('uv_id' => $id_uv));
            $this->success('Bạn đã cập nhật trạng thái tìm kiếm cho chính mình ', []);
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
    // page thông báo 
    public function notify()
    {
        $check_login =  $this->getAuthorizationHeader();
        if ($check_login != null) {
            $token = $this->getTokens();
            if (isset($token->data->UserId) && isset($token->data->Type)) {
                if ($token->data->Type == 3) { // ứng viên
                    $type = 1;
                    $user = 'id_uv';
                    $select = 'notification.*, user_ntd.ntd_company as name, user_ntd.ntd_alias as alias,user_ntd.ntd_create_time as createtime,user_ntd.ntd_avatar as avatar';
                    $join = array('user_ntd' => 'notification.id_ntd = user_ntd.ntd_id');
                } else if ($token->data->Type == 4) { // ntd
                    $type = 2;
                    $user = 'id_ntd';
                    $select = 'notification.*, user_uv.uv_name as name, user_uv.uv_alias as alias,new.new_title, new.new_alias,user_uv.uv_createtime as createtime,user_uv.uv_avatar as avatar ';
                    $join = array('user_uv' => 'notification.id_uv = user_uv.uv_id', 'new' => 'notification.id_new = new.new_id');
                }
                $get_noti  = $this->Models->select_sql('notification', $select, array($user => $token->data->UserId, 'type' => $type), null, $join, array('id' => 'DESC'), null, null, 1);
                $this->success('Thông báo ', $get_noti);
            } else {

                $this->set_error('not_Data', 'Không có dữ liệu cho thông báo .');
            }
        } else {
            $this->set_error('isLogin', 'Để sử dụng chức năng này , Bạn phải đăng nhập với quyền là ứng viên.');
        }
    }
}
