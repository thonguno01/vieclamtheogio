<?php
class company extends CI_Controller
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function quan_ly_chung()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $count_refesh_new = $this->Models->select_data('sum(number_refresh) as total_view_new', 'new', [], array('new_user_id' => $_COOKIE['UserId']), '', '', '');
            $data['count_refesh_new'] = $count_refesh_new->row_array();

            $join = array('user_uv u' => 'a.id_uv = u.uv_id', 'new n' => 'a.id_new = n.new_id');
            $data['uv_apllied'] = $this->Models->select_sql('apply_new a', 'a.id, u.uv_id', array('a.id_ntd' => $_COOKIE['UserId']), null, $join, array('a.id' => 'DESC'), null, null, 1);

            $data['uv_saved'] = $this->Models->select_sql('save_uv s', 's.id,u.uv_id', array('s.id_ntd' => $_COOKIE['UserId']), null, array('user_uv u' => 's.id_uv = u.uv_id'), array('s.id' => 'DESC'), null, null, 1);
            $data['uv_tdl'] =  $this->Models->select_sql('see_uv', 'see_uv.*, user_uv.uv_email, user_uv.uv_phone', array('see_uv.id_ntd' => $_COOKIE['UserId']), null, array('user_uv' => 'see_uv.id_uv = user_uv.uv_id'), null, null, null, 1);


            $date = strtotime(date("d-m-Y"));
            $date_start = strtotime('today midnight');
            $date_end = $date_start + 2 * 86400;
            $new = $this->Models->select_sql('new', 'new_id, new_han_nop,new_create_time', array('new_user_id' => $_COOKIE['UserId']), null, null, null, null, null, 1);
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

            $data['count_new_hethan'] = $count_hethan;
            $data['count_new_conhan'] = $count_conhan;
            $data['count_new_saphethan'] = $count_saphethan;
            $data['count_new_day'] = $count_new_day;

            // header 
            $data['userid'] = 21;
            // sidebar
            $data['sidebar'] = 10;

            $data['content'] = 'nhatuyendung/quan_ly_chung';
            $data['css'] = ['ntd/quan_ly_chung', 'ntd/side_bar_ql_ntd'];
            $data['js'] = ['includes/side_bar_ql_ntd'];
            $this->load->view('template', $data, FALSE);
        } else {
            header("Location: /");
        }
    }

    public function dang_tin_moi()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $select = 'cat_id,cat_name';
            $condition = '';
            $order_by = '';
            $join = [];
            $start = '';
            $perpage = '';
            $infor = $this->Models->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);
            $data['cate'] = $infor->result_array();

            $select = 'ntd_quanhuyen,ntd_city,cit_name';
            $condition = ['ntd_id' => $_COOKIE['UserId']];
            $order_by = '';
            $start = '';
            $perpage = '';
            $join = [['table' => 'city2', 'on' => 'cit_id = ntd_quanhuyen']];
            $ntd_infor = $this->Models->select_data($select, 'user_ntd', $join, $condition, $order_by, $start, $perpage);
            $data['ntd_infor'] = $ntd_infor->row_array();



            // $select = 'new_id,new_alias, new_cat , new_qh ,new_user_id';
            // $id = $_COOKIE['UserId'];
            // $condition = [ 'new_user_id' => $id];
            // $order_by = '';
            // $join = [];
            // $start = '';
            // $perpage ='';
            // $new = $this->Models->select_data($select, 'new', $join, $condition, $order_by,$start, $perpage);
            // $data['new'] = $new->result_array();

            $select = 'tag_id,tag_alias,tag_name,tag_parent';
            $condition = '';
            $order_by = '';
            $join = [];
            $start = '';
            $perpage = '';
            $descv = $this->Models->select_data($select, 'category_tag', $join, $condition, $order_by, $start, $perpage);
            $data['descv'] = $descv->result_array();

            $select = 'new_id,new_alias,new_title,new_alias,new_user_id,new_age,new_sex,new_cap_bac,new_hoc_van,new_knlv,new_httl,new_loai_hinh,new_hinh_thuc,new_han_nop,new_luong_1,new_luong_2,new_luong_3,new_at_com,new_city,new_qh,new_address,new_no_calam,new_ca_start,new_ca_end,new_mota,new_yeu_cau,new_quyen';
            $condition = ['new_user_id' => $_COOKIE['UserId']];
            $order_by = '';
            $join = [];
            $start = '';
            $perpage = '';
            $new_tin = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage);
            $new_tin = $new_tin->result_array();
            $data['new_tin'] = $new_tin;


            // sidebar
            $data['sidebar'] = 20;

            $data['content'] = 'nhatuyendung/dang_tin_moi';
            $data['css'] = ['ntd/dang_tin_moi', 'ntd/side_bar_ql_ntd', 'includes/dang_tin_thanh_cong'];
            $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/dang_tin_moi'];
            $this->load->view('template', $data, FALSE);
        } else {
            header("Location: /");
        }
    }

    public function tin_da_dang()
    {
        $page = $this->uri->segment(2);
        if ($page == 0 || $page == '') {
            $page = 1;
        }
        $perpage = 8;
        $start = $perpage * ($page - 1);

        $select = 'new_id,new_alias,new_title,new_alias,new_user_id,new_age,new_sex,new_cap_bac,new_hoc_van,new_knlv,new_httl,new_loai_hinh,new_hinh_thuc,new_han_nop,new_luong_1,new_luong_2,new_luong_3,new_at_com,new_create_time,new_city,new_qh,new_address,new_no_calam,new_ca_start,new_ca_end,new_mota,new_yeu_cau,new_quyen,so_uv_ungtuyen,view_new';
        $new_upload = $this->Models->select_data($select, 'new', [], ['new_user_id' => $_COOKIE['UserId']], 'new_updated_time DESC', $start, $perpage);
        $new_upload = $new_upload->result_array();
        $data['new_upload'] = $new_upload;

        $new = $this->Models->select_data($select, 'new', [], ['new_user_id' => $_COOKIE['UserId']], 'new_updated_time DESC', '', '');
        $total = $new->num_rows();
        pagination('/tin-da-dang', $total, $perpage);
        // xuất exel
        $excel = $this->input->post('excel_tin_da_dang');
        if (isset($excel)) {
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=tin_da_dang.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo '<table border="1px solid black">';
            echo '<tr>';
            echo '<td><strong> ID </strong></td>';
            echo '<td><strong>Tiêu đề </strong></td>';
            echo '<td><strong> Số ứng viên <br> ứng tuyển </strong></td>';
            echo '<td><strong>Lượt xem</strong></td>';
            echo '<td><strong> Trạng thái</strong></td>';
            echo '<td><strong> Ngày đăng</strong></td>';
            echo '<td><strong> Hạn nộp</strong></td>';
            foreach ($new_upload as $value) {
                $so_uv_ungtuyen = '';
                $view = '';
                if ($value['so_uv_ungtuyen'] != 0) {
                    $so_uv_ungtuyen = $value['so_uv_ungtuyen'];
                } else {
                    $so_uv_ungtuyen = "Chưa có";
                }
                if ($value['view_new'] != 0) {
                    $view = $value['view_new'];
                } else {
                    $view = "Chưa có";
                }
                echo '<table border="1px solid black">';
                echo '<tr>';
                echo '<td>' .  $value['new_id'] . '</td>';
                echo '<td>' .  $value['new_title']  . '</td>';
                echo '<td>' .  $so_uv_ungtuyen  . '</td>';
                echo '<td>' .  $view  . '</td>';
                echo '<td>Đã đăng</td>';
                echo '<td>' .  date('d-m-Y', $value['new_create_time'])   . '</td>';
                echo '<td>' .  date('d-m-Y', $value['new_han_nop'])   . '</td>';
                echo '<td>' . date("H:i:s  Y-m-d") . '</td>';
            }
            echo '</tr>';

            echo '</table>';
            exit();
        }
        // header
        $data['userid'] = 21;
        // sidebar
        $data['sidebar'] = 30;

        $data['content'] = 'nhatuyendung/tin_da_dang';
        $data['css'] = ['ntd/tin_da_dang', 'ntd/side_bar_ql_ntd', 'includes/warning_delete'];
        $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/tin_da_dang', 'includes/warning_delete'];
        $this->load->view('template', $data, FALSE);
    }

    public function chinh_sua_tin($alias, $id)
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $infor = $this->Models->select_data('cat_id,cat_name', 'category', [], '', '', '', '');
            $data['cate'] = $infor->result_array();

            $select = 'ntd_quanhuyen,ntd_city,cit_name';
            $condition = ['ntd_id' => $_COOKIE['UserId']];
            $order_by = '';
            $start = '';
            $perpage = '';
            $join = [['table' => 'city2', 'on' => 'cit_id = ntd_quanhuyen']];
            $ntd_infor = $this->Models->select_data($select, 'user_ntd', $join, $condition, $order_by, $start, $perpage);
            $data['ntd_infor'] = $ntd_infor->row_array();

            $select = 'new_id,new_cat,new_alias,new_tag,new_title,new_alias,new_user_id,new_age,new_sex,new_cap_bac,new_hoc_van,new_knlv,new_httl,new_loai_hinh,new_hinh_thuc,new_han_nop,new_luong_1,new_luong_2,new_luong_3,new_at_com,new_city,new_qh,new_address,new_no_calam,new_ca_start,new_ca_end,new_t2,new_t3,new_t4,new_t5,  new_t6,new_t7,new_cn,new_mota,new_yeu_cau,new_quyen';
            $condition = [
                'new_id' => $id,
                'new_user_id' => $_COOKIE['UserId']
            ];
            $order_by = '';
            $join = [];
            $start = '';
            $perpage = '';
            $new_tin = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage);
            $new_tin = $new_tin->row_array();
            $data['new_tin'] = $new_tin;
            $infor_ctcv = $this->Models->select_data('*', 'category_tag', [], ['tag_parent' => $new_tin['new_cat']], '', '', '');
            $data['ctcv'] = $infor_ctcv->result_array();

            $data['content'] = 'nhatuyendung/chinh_sua_tin';
            $data['css'] = ['ntd/chinh_sua_tin', 'ntd/side_bar_ql_ntd', 'includes/dang_tin_thanh_cong'];
            $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/chinh_sua_tin'];
            $this->load->view('template', $data, FALSE);
        } else {
            header("Location: /");
        }
    }

    public function ung_vien_ung_tuyen()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $page = $this->uri->segment(2);
            if ($page == 0 || $page == '') {
                $page = 1;
            }
            $perpage = 8;
            $start = $perpage * ($page - 1);
            $data['start_row'] = $start;

            $stt = $this->input->get('stt');

            if (isset($stt)) {
                // die();
                $data['status_ut'] = $stt;
                $condition = array('a.id_ntd' => $_COOKIE['UserId'], 'a.status' => $stt);
            } else {
                $condition = array('a.id_ntd' => $_COOKIE['UserId']);
            }

            $select = 'a.id,a.status, a.id_ntd,a.id_uv,a.id_new,a.create_date, a.note,a.calamviec,a.lichlamviec,a.giolam, u.uv_id,u.uv_email, u.uv_name, u.uv_address,u.uv_phone,u.uv_alias,n.new_id,n.new_title,n.new_alias';
            $join = array('user_uv u' => 'a.id_uv = u.uv_id', 'new n' => 'a.id_new = n.new_id');
            $uv_apllied = $this->Models->select_sql('apply_new a', $select, $condition, null, $join, array('a.id' => 'DESC'), $perpage, $start, 1);
            $data['uv_apllied'] = $uv_apllied;

            $infor_p = $this->Models->select_sql('apply_new a', $select, $condition, null, $join, array('a.id' => 'DESC'), null, null, 1);
            $total = count($infor_p);
            pagination('/ung-vien-ung-tuyen', $total, $perpage);

            // xuất excel
            $excel = $this->input->post('excel_uv_apply');
            $calam = [];
            if (isset($excel)) {
                foreach ($infor_p as $list) {
                    if ($list['status'] == 0) {
                        $ketqua = 'Trạng thái';
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
                            $calam[] = 'Ca ' . $arr_calam[$i] . ':&nbsp;' . $arr_giolam[$i] . '<br/>' . $arr_ngaylam[$i];
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
                echo '<meta charset="UTF-8">';
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=SaveUngVien.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo '<table border="1px solid black">';
                echo '<tr>';
                echo '<td><strong> STT </strong></td>';
                echo '<td><strong> Tên ứng viên </strong></td>';
                echo '<td><strong> Vị trí ứng  </strong></td>';
                echo '<td><strong> Địa chỉ</strong></td>';
                echo '<td><strong> Email & SĐT </strong></td>';
                echo '<td><strong> Ngày nộp </strong></td>';
                echo '<td><strong> Lịch làm </strong></td>';
                echo '<td><strong> Ghi chú </strong></td>';
                echo '<td><strong> Kết quả </strong></td>';
                foreach ($array as $key => $value) {
                    echo '<table border="1px solid black">';
                    echo '<tr>';
                    echo '<td>' . ++$key . '</td>';
                    echo '<td>' . $value['ten_uv'] . '</td>';
                    echo '<td>' . $value['vt_ut'] . '</td>';
                    echo '<td>' . $value['diachi'] . '</td>';
                    echo '<td>' . $value['sdt'] . '<br/>' . $value['email'] . '</td>  ';
                    echo '<td>' . $value['ngaynop'] . '</td>';
                    echo '<td>' . $value['calam'] . '</td>';
                    echo '<td>' . $value['ghichu'] . '</td>';
                    echo '<td>' . $value['ketqua'] . '</td>';
                }
                echo '</tr>';
                echo '</table>';
                exit();
            }

            $data['userid'] = 21;
            $data['sidebar'] = 41;

            $data['content'] = 'nhatuyendung/ung_vien_ung_tuyen';
            $data['css'] = ['ntd/ung_vien_ung_tuyen', 'ntd/side_bar_ql_ntd', 'includes/warning_delete'];
            $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/ung_vien_ung_tuyen', 'includes/warning_delete'];
            $this->load->view('template', $data, FALSE);
        } else {
            header("Location: /");
        }
    }

    public function ung_vien_da_luu()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $page = $this->uri->segment(2);
            if ($page == 0 || $page == '') {
                $page = 1;
            }
            $perpage = 8;
            $start = $perpage * ($page - 1);
            $data['start_row'] = $start;

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
            $uv_saved = $this->Models->select_sql('save_uv s', $select, array('s.id_ntd' => $_COOKIE['UserId']), null, array('user_uv u' => 's.id_uv = u.uv_id'), array('s.id' => 'DESC'), $perpage, $start, 1);
            $data['uv_saved'] = $uv_saved;
            $category = $this->Models->select_data('cat_id,cat_name,cat_alias', 'category', [], '', '', '', '');
            $data['category'] = $category->result_array();

            $infor_p = $this->Models->select_sql('save_uv s', $select, array('s.id_ntd' => $_COOKIE['UserId']), null, array('user_uv u' => 's.id_uv = u.uv_id'), array('s.id' => 'DESC'), null, null, 1);
            $total = count($infor_p);
            pagination('/ung-vien-da-luu', $total, $perpage);

            // xuất excel
            $excel = $this->input->post('btn_excel_save_uv');
            $arr_cat = [];
            if (isset($excel)) {
                foreach ($infor_p as $list) {
                    $uv_cat = explode(',', $list['uv_cat']);
                    foreach ($category->result_array() as $cat_value) {
                        if (in_array($cat_value['cat_id'], $uv_cat) == true) {
                            $arr_cat[] = $cat_value['cat_name'];
                        }
                    }
                    $luong = get_luong($list['uv_luong_1'], $list['uv_luong_2'], $list['uv_luong_1']);
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
                echo '<meta charset="UTF-8">';
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=SaveUngVien.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo '<table border="1px solid black">';
                echo '<tr>';
                echo '<td><strong> STT </strong></td>';
                echo '<td><strong> Tên ứng viên </strong></td>';
                echo '<td><strong> Loại công việc </strong></td>';
                echo '<td><strong> Địa chỉ</strong></td>';
                echo '<td><strong> Ngày lưu</strong></td>';
                echo '<td><strong> Email & SĐT </strong></td>';
                echo '<td><strong> Mức lương mong muốn </strong></td>';
                foreach ($array as $key => $value) {
                    echo '<table border="1px solid black">';
                    echo '<tr>';
                    echo '<td>' . ++$key . '</td>';
                    echo '<td>' . $value['ten_uv'] . '</td>';
                    echo '<td>' . $value['loaicv'] . '</td>';
                    echo '<td>' . $value['diachi'] . '</td>';
                    echo '<td>' . $value['ngayluu'] . '</td>';
                    echo '<td>' . $value['sdt'] . '<br/>' . $value['email'] . '</td>  ';
                    echo '<td>' . $value['luong'] . '</td>';
                }
                echo '</tr>';
                echo '</table>';
                exit();
            }


            $data['userid'] = 21;
            $data['sidebar'] = 42;
            $data['content'] = 'nhatuyendung/ung_vien_da_luu';
            $data['css'] = ['ntd/ung_vien_da_luu', 'ntd/side_bar_ql_ntd', 'includes/warning_delete'];
            $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/ung_vien_da_luu', 'includes/warning_delete'];
            $this->load->view('template', $data, FALSE);
        } else {
            header("Location: /");
        }
    }
    public function ung_vien_tu_diem_loc()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $page = $this->uri->segment(2);
            if ($page == 0 || $page == '') {
                $page = 1;
            }
            $perpage = 8;
            $start = $perpage * ($page - 1);
            $data['start_row'] = $start;
            $check_see_uv   =  $this->Models->interJoinPaginate('see_uv', 'id_uv', 'user_uv', 'uv_id', $perpage, $start, ['see_uv.id_ntd' => $_COOKIE['UserId']], 'see_uv.id_uv');
            $total = count($check_see_uv);
            pagination('/ung-vien-tu-diem-loc', $total, $perpage);
            $data['see_uv'] = $check_see_uv;
            $category = $this->Models->select_data('cat_id,cat_name,cat_alias', 'category', [], '', '', '', '');
            $data['category'] = $category->result_array();
            $excel = $this->input->post('btn_excel_ung_vien_tu_diem_loc');
            $arr_cat = [];
            if (isset($excel)) {
                foreach ($check_see_uv as $list) {
                    $uv_cat = explode(',', $list['uv_cat']);
                    foreach ($category->result_array() as $cat_value) {
                        if (in_array($cat_value['cat_id'], $uv_cat) == true) {
                            $arr_cat[] = $cat_value['cat_name'];
                        }
                    }
                    $luong = get_luong($list['uv_luong_1'], $list['uv_luong_2'], $list['uv_luong_1']);
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
                echo '<meta charset="UTF-8">';
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=SaveUngVien.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo '<table border="1px solid black">';
                echo '<tr>';
                echo '<td><strong> STT </strong></td>';
                echo '<td><strong> Tên ứng viên </strong></td>';
                echo '<td><strong> Loại công việc </strong></td>';
                echo '<td><strong> Địa chỉ</strong></td>';
                echo '<td><strong> Ngày lưu</strong></td>';
                echo '<td><strong> Email & SĐT </strong></td>';
                echo '<td><strong> Mức lương mong muốn </strong></td>';
                foreach ($array as $key => $value) {
                    echo '<table border="1px solid black">';
                    echo '<tr>';
                    echo '<td>' . ++$key . '</td>';
                    echo '<td>' . $value['ten_uv'] . '</td>';
                    echo '<td>' . $value['loaicv'] . '</td>';
                    echo '<td>' . $value['diachi'] . '</td>';
                    echo '<td>' . $value['ngayluu'] . '</td>';
                    echo '<td>' . $value['sdt'] . '<br/>' . $value['email'] . '</td>  ';
                    echo '<td>' . $value['luong'] . '</td>';
                }
                echo '</tr>';
                echo '</table>';
                exit();
            }

            $data['userid'] = 21;
            $data['sidebar'] = 42;
            $data['content'] = 'nhatuyendung/ung_vien_tu_diem_loc';
            $data['css'] = ['ntd/ung_vien_da_luu', 'ntd/side_bar_ql_ntd', 'includes/warning_delete'];
            $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/ung_vien_tu_diem_loc', 'includes/warning_delete'];
            $this->load->view('template', $data, FALSE);
        }
    }
    public function thong_tin_co_ban()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $select = 'ntd_avatar,ntd_cover_background,ntd_company,ntd_email,ntd_phone,ntd_city,ntd_quanhuyen,ntd_msthue,ntd_address,ntd_zalo,ntd_skype,ntd_create_time';
            $condition = ['ntd_id' => $_COOKIE['UserId']];
            $infor = $this->Models->select_where_and($select, 'user_ntd', $condition);
            if ($infor->num_rows() == 1) {
                $infor = $infor->row_array();
                $data['infor'] = $infor;
                // sidebar
                $data['sidebar'] = 51;
                $data['content'] = 'nhatuyendung/thong_tin_co_ban';
                $data['css'] = ['ntd/thong_tin_co_ban', 'ntd/side_bar_ql_ntd'];
                $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/thong_tin_co_ban'];
                $this->load->view('template', $data, FALSE);
            } else {
                header("Location: /");
            }
        } else {
            header("Location: /");
        }
    }

    public function gioi_thieu_chung()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            $select = 'ntd_gioi_thieu,ntd_img_1,ntd_img_2,ntd_img_3,ntd_csptnl,ntd_chtt,ntd_salary_award,ntd_create_time';
            $condition = ['ntd_id' => $_COOKIE['UserId']];
            $infor = $this->Models->select_where_and($select, 'user_ntd', $condition);
            if ($infor->num_rows() == 1) {
                $infor = $infor->row_array();
                $data['infor'] = $infor;
                // sidebar
                $data['sidebar'] = 52;
                $data['content'] = 'nhatuyendung/gioi_thieu_chung';
                $data['css'] = ['ntd/gioi_thieu_chung', 'ntd/side_bar_ql_ntd'];
                $data['js'] = ['includes/side_bar_ql_ntd', 'nhatuyendung/gioi_thieu_chung'];
                $this->load->view('template', $data, FALSE);
            } else {
                header("Location: /");
            }
        } else {
            header("Location: /");
        }
    }

    public function doi_mat_khau()
    {
        if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
            // header
            $data['userid'] = 21;
            // sidebar
            $data['sidebar'] = 60;
            $data['content'] = 'nhatuyendung/doi_mat_khau';
            $data['css'] = array('ntd/doi_mat_khau', 'ntd/side_bar_ql_ntd', 'includes/popup_doimk_thanhcong');
            $data['js'] = array('includes/side_bar_ql_ntd', 'nhatuyendung/doi_mat_khau');
            $this->load->view('template', $data, FALSE);
        } else {
            header("Location: /");
        }
    }
}
