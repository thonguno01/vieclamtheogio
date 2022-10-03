<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// việc làm
$route['default_controller'] = 'home'; // trang chủ
$route['(:any)-nn(:num)tt(:num).html(/:num)?'] = 'home/List_job_nn/$1/$2/$3'; // tìm kiếm vl link đẹp nn tt
$route['(:any)-nn(:num)qh(:num).html(/:num)?'] = 'home/List_job_nn/$1/$2/$3'; // tìm kiếm vl link đẹp nn qh
$route['(:any)-tg(:num)tt(:num).html(/:num)?'] = 'home/List_job_tag/$1/$2/$3'; // tìm kiếm vl link đẹp tag tt
$route['(:any)-tg(:num)qh(:num).html(/:num)?'] = 'home/List_job_tag/$1/$2/$3'; // tìm kiếm vl link đẹp tag qh
$route['tim-viec-lam.html(/:num)?']            = 'home/List_job_key'; // tìm kiếm vl link xấu 

// ứng viên
$route['ung-vien-theo-gio(/:num)?'] = 'home/trang_ung_vien'; // trang ứng viên
$route['(:any)-k(:num)t(:num).html(/:num)?'] = 'home/List_uv_nn/$1/$2/$3'; // tìm kiếm uv 
// chi tiết
$route['(:any)-job(:num).html?']    = 'home/Detail_job/$1/$2'; // chi tiết tin tuyển dụng
$route['(:any)-ntd(:num).html?']    = 'home/Detail_ntd/$1/$2'; // chi tiết ntd
$route['(:any)-uv(:num).html?']     = 'home/Detail_uv/$1/$2'; // chi tiết uv
$route['(:any)-chinh-sua-tin(:num).html?']           = 'ntd/company/chinh_sua_tin/$1/$2'; // tin đã đăng
// đăng ký
$route['dang-ky.html']                  = 'Prev_login/signup'; // chọn luồng đăng ký
$route['dang-ky-nha-tuyen-dung.html']   = 'Prev_login/dky_ntd'; // đăng ký tk ntd
$route['dang-ky-ung-vien.html']         = 'Prev_login/dky_uv'; // đăng ký tk uv
$route['gui-mail-xac-thuc-tai-khoan-nha-tuyen-dung'] = 'Prev_login/gui_mail_xac_thuc_ntd'; // gửi email xác thực tk ntd
$route['gui-mail-xac-thuc-tai-khoan-ung-vien']      = 'Prev_login/gui_mail_xac_thuc_uv'; // gửi email xác thực tk uv
$route['xac-thuc-tai-khoan-nha-tuyen-dung&email=(:any)&id=(:num)&code=(:num)']  = 'Prev_login/dky_ntd_success/$1/$2/$3'; // xác thực tk ntd
$route['xac-thuc-tai-khoan-ung-vien&email=(:any)&id=(:num)&code=(:num)']        = 'Prev_login/dky_uv_success/$1/$2/$3'; // xác thực tk uv
// đăng nhập 
$route['dang-nhap.html']                = 'Prev_login/login'; // chọn luồng đăng nhập
$route['dang-nhap-ung-vien.html']       = 'Prev_login/login_uv'; // đăng nhập tk uv
$route['dang-nhap-nha-tuyen-dung.html'] = 'Prev_login/login_epl'; // đăng nhập tk ntd
// menu qly tk uv
$route['quan-ly-chung-ung-vien']    = 'ungvien/candidate/quan_ly_chung'; // quản lý chung uv
$route['thong-tin-co-ban-uv']       = 'ungvien/candidate/thong_tin_co_ban'; // quản lý hồ sơ 1 (thông tin cơ bản)
$route['cong-viec-mong-muon']       = 'ungvien/candidate/cong_viec_mong_muon'; // quản lý hồ sơ 2 (công việc mong muốn)
$route['gioi-thieu-chung-uv']       = 'ungvien/candidate/gioi_thieu_chung'; // quản lý hồ sơ 3 (giới thiệu chung)
$route['kinh-nghiem-lam-viec']      = 'ungvien/candidate/kinh_nghiem_lam_viec'; // quản lý hồ sơ 4 (kinh nghiệm làm việc)
$route['viec-lam-da-ung-tuyen(/:num)?']     = 'ungvien/candidate/viec_lam_da_ung_tuyen'; // việc làm đã ứng tuyển
$route['viec-lam-da-luu(/:num)?']           = 'ungvien/candidate/viec_lam_da_luu'; // việc làm đã lưu
$route['nha-tuyen-dung-xem-ho-so(/:num)?']  = 'ungvien/candidate/ntd_xem_ho_so'; // ntd đã xem hồ sơ
$route['doi-mat-khau-ung-vien']     = 'ungvien/candidate/doi_mat_khau'; // đổi mk
// menu quản lý tk ntd
$route['quan-ly-chung-ntd']     = 'ntd/company/quan_ly_chung'; // quản lý chung ntd
$route['dang-tin']              = 'ntd/company/dang_tin_moi'; // đăng tin mới
$route['tin-da-dang(/:num)?']           = 'ntd/company/tin_da_dang'; // tin đã đăng
$route['ung-vien-ung-tuyen(/:num)?']    = 'ntd/company/ung_vien_ung_tuyen'; // ql hs uv (uv ứng tuyển)
$route['ung-vien-da-luu(/:num)?']       = 'ntd/company/ung_vien_da_luu'; // ql hs uv (uv đã lưu)
$route['thong-tin-co-ban-ntd']  = 'ntd/company/thong_tin_co_ban'; // tk ntd (thông tin cơ bản)
$route['ung-vien-tu-diem-loc']  = 'ntd/company/ung_vien_tu_diem_loc'; // tk ntd (ứng viên từ điểm lọc)
$route['gioi-thieu-chung-ntd']  = 'ntd/company/gioi_thieu_chung'; // tk ntd (giới thiệu chung)
$route['doi-mat-khau-ntd']      = 'ntd/company/doi_mat_khau'; // đổi mk
// quên mật khẩu
$route['quen-mat-khau-ntd.html']                = 'Prev_login/forget_pwd_ntd'; // quên mật khẩu
$route['quen-mat-khau-uv.html']                 = 'Prev_login/forget_pwd_uv'; // quên mật khẩu
$route['gui-email-quen-mat-khau-nha-tuyen-dung'] = 'Prev_login/forget_pwd_send_mail_ntd'; // quên mk email
$route['gui-email-quen-mat-khau-ung-vien']      = 'Prev_login/forget_pwd_send_mail_uv'; // quên mk email
$route['doi-mat-khau-quen-mat-khau-ntd&email=(:any)&id=(:num)&code=(:num)'] = 'Prev_login/forget_pwd_change_pwd_ntd/$1/$2/$3'; // đặt mk mới
$route['doi-mat-khau-quen-mat-khau-uv&email=(:any)&id=(:num)&code=(:num)']  = 'Prev_login/forget_pwd_change_pwd_uv/$1/$2/$3'; // đặt mk mới
$route['doi-mat-khau-thanh-cong']   = 'Prev_login/forget_pwd_success'; // đổi mk thành công
// ajax
$route['login'] = 'ajax/login'; // đăng nhập
$route['logout'] = 'ajax/logout'; // đăng xuất
// orther
$route['404_override']  = 'home/page_404'; // 404
$route['page-404']      = 'home/page_404'; // 404
$route['translate_uri_dashes'] = FALSE;
// chưa có
$route['lien-he']           = 'home/lien_he'; // liên hệ bên vl 123 không có anh tuấn bảo để text đi đã
// Admin
$route['admin'] = 'admin/Admin/index';
$route['admin/logout'] = 'admin/Admin/logout';
$route['admin/home'] = 'admin/Admin/home';
$route['admin/list_admin(/:num)?'] = 'admin/Admin/admin_list';
$route['admin/add_admin'] = 'admin/Admin/admin_add';
$route['admin/edit_account/(:num)'] = 'admin/Admin/admin_edit/$1';
$route['admin/change_pass'] = 'admin/Admin/admin_change_pass';
//Account candidate
$route['admin/candidate/list(/:num)?'] = 'admin/Admin/candidate_list';
$route['admin/candidate/add'] = 'admin/Admin/candidate_add';
$route['admin/candidate/edit/(:num)'] = 'admin/Admin/candidate_edit/$1';
$route['admin/candidate_error(/:num)?'] = 'admin/Admin/candidate_error';
//Acount employer
$route['admin/employer/list(/:num)?'] = 'admin/Admin/employer_list';
$route['admin/employer/add'] = 'admin/Admin/employer_add';
$route['admin/employer/edit/(:num)'] = 'admin/Admin/employer_edit/$1';
$route['admin/employer_out_date(/:num)?'] = 'admin/Admin/employer_out_date';
$route['admin/employer_not_new(/:num)?'] = 'admin/Admin/employer_not_new';
$route['admin/employer_error(/:num)?'] = 'admin/Admin/employer_error';
//tỉnh thành 
$route['admin/city_list(/:num)?'] = 'admin/Admin/city_list';
$route['admin/edit_city/(:num)?'] = 'admin/Admin/edit_city/$1';
$route['admin/district_list(/:num)?'] = 'admin/Admin/district_list';
//tin tuyển dụng
$route['admin/new_list(/:num)?'] = 'admin/Admin/new_list';
$route['admin/add_new'] = 'admin/Admin/new_add';
$route['admin/edit_new/(:num)'] = 'admin/Admin/new_edit/$1';
//Ngành nghề job_list
$route['admin/job_list(/:num)?'] = 'admin/Admin/cate_list';
$route['admin/edit_job/(:num)?'] = 'admin/Admin/edit_cate/$1';
//Ngành nghề tỉnh thành
$route['admin/list_job_city(/:num)?'] = 'admin/Admin/list_job_city';
//Tag
$route['admin/list_tag(/:num)?'] = 'admin/Admin/list_tag';
$route['admin/add_tag'] = 'admin/Admin/edit_tag';
$route['admin/edit_tag/(:num)'] = 'admin/Admin/edit_tag/$1';
// nn-tt list_job_city|add_job_city
$route['admin/list_job_city(/:num)?']       = 'admin/Admin/list_job_city';
$route['admin/add_job_city']                = 'admin/Admin/edit_cate_city';
$route['admin/edit_job_city/(:num)/(:num)'] = 'admin/Admin/edit_cate_city/$1/$2';
// tag-tt list_tag_city|add_tag_city
$route['admin/list_tag_city(/:num)?']   = 'admin/Admin/list_tag_city';
$route['admin/add_tag_city']            = 'admin/Admin/edit_tag_city';
$route['admin/edit_tag_city/(:num)']    = 'admin/Admin/edit_tag_city/$1';
