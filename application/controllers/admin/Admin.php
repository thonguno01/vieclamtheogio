<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Models');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('func_helper');
		$this->load->library('session');
		$this->load->library('pagination');
	}

	public function check_login()
	{
		if (!isset($_COOKIE['adminId'])) {
			header("Location: /admin");
		} else {
			return true;
		}
	}

	public function logout()
	{
		setcookie('adminId', '', time() - 86400, '/');
		header("Location: /admin/");
	}

	public function admin_change_pass()
	{
		$this->sidebar();
		$data['content'] = '/admin/change_pass';
		$data['js'] = '/cssjsadmin/dist/admin/js/change_pass.js';
		$this->load->view('admin/main', $data, FALSE);
	}

	public function index()
	{
		if (isset($_COOKIE['adminId'])) {
			header("Location: /admin/home");
		} else {
			$data['content'] = '/admin/login';
			$data['js'] = '/cssjsadmin/dist/js/login.js';
			$this->load->view('admin/login', FALSE);
		}
	}

	public function sidebar()
	{
		$select = 'mod_id,mod_name,mod_path,mod_listname,mod_order,mod_listfile';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'modules', $join, $condition, $order_by, $start, $perpage);
		$data['module'] = $infor->result_array();

		$select = 'id,username,name,phone,email,image,create_time,modify_time,is_admin';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'tbl_admin', $join, $condition, $order_by, $start, $perpage);
		$data['admin'] = $infor->row_array();

		$data['content'] = '/admin/side-bar';
		$this->load->view('admin/side-bar', $data, FALSE);
	}

	// trang chu
	public function home()
	{
		if ($this->check_login()) {
			$select = 'ntd_id,ntd_create_time';
			$start_time = strtotime(date('d-m-Y', time()));
			$condition = [
				'ntd_create_time >=' => $start_time,
			];
			$infor_ntd = $this->Models->select_where_and($select, 'user_ntd', $condition)->num_rows();


			$select = 'uv_id,uv_createtime';
			$condition = [
				'uv_createtime >=' => $start_time,
			];
			$infor_uv = $this->Models->select_where_and($select, 'user_uv', $condition)->num_rows();


			$this->sidebar();
			$data['content'] = '/admin/home';
			$data['total_ntd'] = $infor_ntd;
			$data['total_uv'] = $infor_uv;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	// ket thuc

	//////////////////////////////////////////////
	////////////////Ứng viên///////////////
	////////////////////////////////////////////


	// module quan li tai khoan ung vien 
	public function candidate_list()
	{

		if ($this->check_login()) {
			$search_uv = $this->input->get();

			$arr_search = [];
			$like = [];

			if (array_key_exists("uvid", $search_uv) && $search_uv['uvid'] != '') {
				$data['id_uv'] = trim($search_uv['uvid']);
				$like_key = trim($search_uv['uvid']);
				$like = [['col' => 'uv_id', 'val' => $like_key]];
			}

			if (array_key_exists("uvname", $search_uv) && $search_uv['uvname'] != '') {
				$data['name_uv'] = trim($search_uv['uvname']);
				$like_key = str_replace('-', '%', vn_str_filter(trim($search_uv['uvname'])));
				$like = [['col' => 'uv_name', 'val' => $like_key]];
			}


			if (array_key_exists("uvemail", $search_uv) && $search_uv['uvemail'] != '') {
				$data['email_uv'] = trim($search_uv['uvemail']);
				$like_key = str_replace('-', '%', vn_str_filter(trim($search_uv['uvemail'])));
				$like = [['col' => 'uv_email', 'val' => $like_key]];
			}

			if (array_key_exists("uvphone", $search_uv) && $search_uv['uvphone'] != '') {
				$data['phone_uv'] = trim($search_uv['uvphone']);
				$like_key = trim($search_uv['uvphone']);
				$like = [['col' => 'uv_phone', 'val' => $like_key]];
			}

			if (array_key_exists("uvdate", $search_uv) && $search_uv['uvdate'] != '') {
				$start_time = strtotime($search_uv['uvdate']);
				$end_time =  strtotime($search_uv['uvdate']) + 86400;
				$arr_search['uv_createtime >='] = $start_time;
				$arr_search['uv_createtime <='] = $end_time;
				$data['create_time_uv'] = $search_uv['uvdate'];
			}

			if (array_key_exists("uvsign_up_form", $search_uv) && $search_uv['uvsign_up_form'] != '') {
				$arr_search['sign_up_from'] = $search_uv['uvsign_up_form'];
				$data['sign_up_uv'] = $search_uv['uvsign_up_form'];
			}

			if (array_key_exists("uvstatus", $search_uv) && $search_uv['uvstatus'] != '') {
				$arr_search['uv_authentic'] = $search_uv['uvstatus'];
				$data['status_uv'] = $search_uv['uvstatus'];
			}

			$page = $this->uri->segment(4);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');
			$select = 'uv_id,uv_name,uv_alias,uv_email,uv_phone,uv_avatar,uv_authentic,uv_createtime,sign_up_from';
			$order_by = ['uv_createtime' => 'DESC'];

			$infor = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, $like, null, $order_by, $perpage, $start, 1);
			$data['list_candidate'] = $infor;

			$select = 'uv_id';
			$infor_p = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, $like, null, $order_by, null, null, 1);
			$total = count($infor_p);


			$config['base_url'] = "/admin/candidate/list/";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 4;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['page_query_string'] = false;
			$config['reuse_query_string'] = true;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/candidate/list';
			$data['js'] = '/cssjsadmin/dist/candidate/js/list.js';
			$data['css'] = '/cssjsadmin/dist/candidate/css/list.css';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//ket thuc module quan li tai khoan ung vien 


	//module thêm tài khoản ứng viên
	public function candidate_add()
	{
		$this->sidebar();
		$data['content'] = '/admin/candidate/add';
		$data['css'] = '/cssjsadmin/dist/candidate/css/add.css';
		$data['js'] = '/cssjsadmin/dist/candidate/js/add.js';
		$this->load->view('admin/main', $data, FALSE);
	}
	//ket thuc module thêm tai khoan ung vien 


	//modude sửa tài khoản ứng viên
	public function candidate_edit($id)
	{
		$select = 'uv_id,uv_name,uv_avatar,uv_email,uv_pass,uv_phone,uv_authentic,uv_createtime,uv_updatetime,uv_avatar,uv_city,uv_qh,uv_address,uv_cat,uv_vitri,uv_city_hope,uv_calam';
		$condition = ['uv_id' => $id];
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'user_uv', $join, $condition, $order_by, $start, $perpage);
		$data['info_candidate'] = $infor->row_array();

		$this->sidebar();
		$data['content'] = '/admin/candidate/edit';
		$data['css'] = '/cssjsadmin/dist/candidate/css/add.css';
		$data['js'] = '/cssjsadmin/dist/candidate/js/edit.js';
		$data['id'] = $id;
		$this->load->view('admin/main', $data, FALSE);
	}
	//ket thuc module sửa tai khoan ung vien 

	public function candidate_error()
	{
		$search_uv = $this->input->get();
		$arr_search = [];
		$like = [];

		if (array_key_exists("uvid", $search_uv) && $search_uv['uvid'] != '') {
			$data['id_uv'] = trim($search_uv['uvid']);
			$like_key = trim($search_uv['uvid']);
			$like = [['col' => 'uv_id', 'val' => $like_key]];
		}

		if (array_key_exists("uvname", $search_uv) && $search_uv['uvname'] != '') {
			$data['name_uv'] = trim($search_uv['uvname']);
			$like_key = str_replace('-', '%', vn_str_filter(trim($search_uv['uvname'])));
			$like = [['col' => 'uv_name', 'val' => $like_key]];
		}


		$select = 'id,uv_name,uv_email,uv_phone';
		$order_by = ['id' => 'DESC'];

		$page = $this->uri->segment(3);
		if ($page == 0 || $page == '') {
			$page = 1;
		}
		$perpage = 10;
		$start = $perpage * ($page - 1);

		$infor = $this->Models->select_sql_like_and('user_uv_error', $select, $arr_search, $like, null, $order_by, $perpage, $start, 1);
		$data['list_error'] = $infor;

		$select = 'id';
		$infor_p = $this->Models->select_sql_like_and('user_uv_error', $select, $arr_search, $like, null, $order_by, null, null, 1);
		$total = count($infor_p);

		$config['base_url'] = "/admin/employer_error";
		$config['total_rows'] = $total;
		$config['per_page'] = $perpage;
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;
		$config['use_page_numbers'] = true;
		$config['page_query_string'] = false;
		$config['reuse_query_string'] = true;
		$config["prefix"] = '/';
		$config['full_tag_open'] = '<div class="t_paginate_group">';
		$config['full_tag_close'] = '</div>';
		$config['first_link'] = 'Đầu';
		$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
		$config['first_tag_close'] = '</button>';
		$config['num_tag_open'] = '<button class="t_paginate_item">';
		$config['num_tag_close']    = '</button>';
		$config['last_link'] = "Cuối";
		$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
		$config['last_tag_close'] = '</button>';
		$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
		$config['prev_tag_open'] = '<button class="t_paginate_item">';
		$config['prev_tag_close'] = '</button>';
		$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
		$config['next_tag_open'] = '<button class="t_paginate_item">';
		$config['next_tag_close'] = '</button>';

		$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
		$config['cur_tag_close'] = '</button>';

		$this->pagination->initialize($config);
		$page = $this->input->get('page');

		// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
		$data['links'] = $this->pagination->create_links();


		$this->sidebar();
		$data['content'] = '/admin/candidate/list_error';
		$data['total'] = $total;
		$this->load->view('admin/main', $data, FALSE);
	}

	//////////////////////////////////////////////
	////////////////Danh sách nhà tuyển dụng///////////////
	////////////////////////////////////////////

	//module danh sách nhà tuyển dụng
	public function employer_list()
	{
		if ($this->check_login()) {

			$search_ntd = $this->input->get();

			$arr_search = [];
			$like = [];

			if (array_key_exists("ntdid", $search_ntd) && $search_ntd['ntdid'] != '') {
				$data['id_ntd'] = trim($search_ntd['ntdname']);
				$like_key = str_replace('-', '%', vn_str_filter($search_ntd['ntdid']));
				$like = [['col' => 'ntd_id', 'val' => $like_key]];
			}

			if (array_key_exists("ntdname", $search_ntd) && $search_ntd['ntdname'] != '') {
				$data['name_ntd'] = trim($search_ntd['ntdname']);
				$like_key = str_replace('-', '%', vn_str_filter($search_ntd['ntdname']));
				$like = [['col' => 'ntd_company', 'val' => $like_key]];
			}


			if (array_key_exists("ntdemail", $search_ntd) && $search_ntd['ntdemail'] != '') {
				$data['email_ntd'] = trim($search_ntd['ntdemail']);
				$like_key = str_replace('-', '%', vn_str_filter($search_ntd['ntdemail']));
				$like = [['col' => 'ntd_email', 'val' => $like_key]];
			}

			if (array_key_exists("ntdphone", $search_ntd) && $search_ntd['ntdphone'] != '') {
				$data['phone_ntd'] = trim($search_ntd['ntdphone']);
				$like_key = $search_ntd['ntdphone'];
				$like = [['col' => 'ntd_phone', 'val' => $like_key]];
			}

			if (array_key_exists("ntddate", $search_ntd) && $search_ntd['ntddate'] != '') {
				$start_time = strtotime($search_ntd['ntddate']);
				$end_time =  strtotime($search_ntd['ntddate']) + 86400;
				$arr_search['ntd_create_time >='] = $start_time;
				$arr_search['ntd_create_time <='] = $end_time;
				$data['create_time_ntd'] = $search_ntd['ntddate'];
			}

			if (array_key_exists("ntdsign_up", $search_ntd) && $search_ntd['ntdsign_up'] != '') {
				$arr_search['ntd_sign_up_from'] = $search_ntd['ntdsign_up'];
				$data['sign_up_ntd'] = $search_ntd['ntdsign_up'];
			}

			if (array_key_exists("ntdstatus", $search_ntd) && $search_ntd['ntdstatus'] != '') {
				$arr_search['ntd_authentic'] = $search_ntd['ntdstatus'];
				$data['status_ntd'] = $search_ntd['ntdstatus'];
			}

			$page = $this->uri->segment(4);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');
			$select = 'ntd_id,ntd_company,ntd_alias,ntd_email,ntd_phone,ntd_authentic,ntd_create_time,ntd_sign_up_from';
			$order_by = ['ntd_create_time' => 'DESC'];

			$infor = $this->Models->select_sql_like_and('user_ntd', $select, $arr_search, $like, null, $order_by, $perpage, $start, 1);
			$data['list_employer'] = $infor;

			$select = 'ntd_id';
			$infor_p = $this->Models->select_sql_like_and('user_ntd', $select, $arr_search, $like, null, $order_by, null, null, 1);
			$total = count($infor_p);

			$config['base_url'] = "/admin/employer/list";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 4;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['page_query_string'] = false;
			$config['reuse_query_string'] = true;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/employer/list';
			$data['js'] = '/cssjsadmin/dist/employer/js/list.js';
			$data['css'] = '/cssjsadmin/dist/employer/css/list.css';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//Kết thúc module danh sách ntd

	//module thêm mới tài khoản ntd 
	public function employer_add()
	{
		$this->sidebar();
		$data['content'] = '/admin/employer/add';
		$data['css'] = '/cssjsadmin/dist/employer/css/add.css';
		$data['js'] = '/cssjsadmin/dist/employer/js/add.js';
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module

	//module sửa tài khoản ntd 
	public function employer_edit($id)
	{
		$select = 'ntd_id,ntd_avatar,ntd_company,ntd_email,ntd_address,ntd_city,ntd_quanhuyen,ntd_phone,ntd_password	,ntd_authentic,ntd_create_time,ntd_sign_up_from';
		$condition = ['ntd_id' => $id];
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'user_ntd', $join, $condition, $order_by, $start, $perpage);
		$data['info_employer'] = $infor->row_array();

		$this->sidebar();
		$data['content'] = '/admin/employer/edit';
		$data['css'] = '/cssjsadmin/dist/employer/css/add.css';
		$data['js'] = '/cssjsadmin/dist/employer/js/edit.js';
		$data['id'] = $id;
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module sửa tài khoản ntd

	public function employer_out_date()
	{
		if ($this->check_login()) {

			$search_new = $this->input->get();
			$today_time = strtotime(date('d-m-Y', time()));

			$arr_search = [
				'new_han_nop >' => $today_time,
				'new_han_nop <' => ($today_time + 60 * 60 * 24 * 2),
			];
			$like = [];

			if (array_key_exists("newid", $search_new) && $search_new['newid'] != '') {
				$data['id_new'] = trim($search_new['newid']);
				$like_key = str_replace('-', '%', vn_str_filter($search_new['newid']));
				$like = [['col' => 'new_id', 'val' => $like_key]];
			}

			if (array_key_exists("newtitle", $search_new) && $search_new['newtitle'] != '') {
				$data['title_new'] = trim($search_new['newtitle']);
				$like_key = str_replace('-', '%', vn_str_filter($search_new['newtitle']));
				$like = [['col' => 'new_title', 'val' => $like_key]];
			}

			if (array_key_exists("newuser", $search_new) && $search_new['newuser'] != '') {
				$data['user_new'] = trim($search_new['newuser']);
				$like_key = str_replace('-', '%', vn_str_filter($search_new['newuser']));
				$like = [['col' => 'ntd_company', 'val' => $like_key]];
			}

			if (array_key_exists("newcreate", $search_new) && $search_new['newcreate'] != '') {
				$start_time = strtotime($search_new['newcreate']);
				$end_time =  strtotime($search_new['newcreate']) + 86400;
				$arr_search['new_create_time >='] = $start_time;
				$arr_search['new_create_time <='] = $end_time;
				$data['createtime_new'] = $search_new['newcreate'];
			}

			if (array_key_exists("newoutdate", $search_new) && $search_new['newoutdate'] != '') {
				$start_time = strtotime($search_new['newoutdate']);
				$end_time =  strtotime($search_new['newoutdate']) + 2 * 86400;
				$arr_search['new_han_nop >='] = $start_time;
				$arr_search['new_han_nop <='] = $end_time;
				$data['han_nop_new'] = $search_new['newoutdate'];
			}


			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'new_id,new_cat,new_tag,new_title,new_alias,new_user_id,new_create_time,new_han_nop,ntd_id,ntd_company,ntd_alias';
			$order_by = ['new_han_nop', 'desc'];
			$join = [
				'user_ntd' => 'new.new_user_id = user_ntd.ntd_id'
			];
			$infor = $this->Models->select_sql_like_and('new', $select, $arr_search, $like, $join, $order_by, $perpage, $start, 1);
			$data['list_out_date'] = $infor;

			$select = 'new_id';
			$infor_p = $this->Models->select_sql_like_and('new', $select, $arr_search, $like, $join, null, null, null, 1);
			$total = count($infor_p);

			$config['base_url'] = "/admin/employer_out_date";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['page_query_string'] = false;
			$config['reuse_query_string'] = true;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();


			$this->sidebar();
			$data['content'] = '/admin/employer/list_out_date';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//kết thúc module ntd có tín sắp hết hạn 

	//module nhà tuyển dụng chưa đăng tin
	public function employer_not_new()
	{
		if ($this->check_login()) {
			$search_new = $this->input->get();
			// $arr_search = ['new_user_id'];
			// $like = [];

			$page = $this->uri->segment(4);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);

			// $select = 'new_id,new_user_id,ntd_id,ntd_company,ntd_alias';

			$this->db->select('ntd_company,ntd_email,ntd_phone,ntd_alias,new_id, ntd_id, COUNT(new_id) AS count 
			FROM user_ntd LEFT JOIN new ON new_user_id = ntd_id 
			GROUP BY ntd_id  HAVING count = 0
			ORDER BY ntd_create_time DESC');
			$data['list_no_new'] = $this->db->get()->result_array();

			$total = count($data['list_no_new']);

			// $select = 'ntd_id';
			// $infor_p = $this->Models->select_sql_like_and('user_ntd',$select,$arr_search,$like,null,null, null,null,1);
			// $total = count($infor_p) ;

			$config['base_url'] = "/admin/employer_not_new";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 4;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['page_query_string'] = false;
			$config['reuse_query_string'] = true;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/employer/list_no_new';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//kết thúc module nhà tuyển dụng chưa đăng tin 

	//module nhà tuyển dụng đăng ký lỗi 
	public function employer_error()
	{
		if ($this->check_login()) {
			$search_ntd = $this->input->get();
			$arr_search = [];
			$like = [];
			if (array_key_exists("ntdid", $search_ntd) && $search_ntd['ntdid'] != '') {
				$data['id_ntd'] = trim($search_ntd['ntdname']);
				$like_key = str_replace('-', '%', vn_str_filter($search_ntd['ntdid']));
				$like = [['col' => 'ntd_id', 'val' => $like_key]];
			}

			if (array_key_exists("ntdname", $search_ntd) && $search_ntd['ntdname'] != '') {
				$data['name_ntd'] = trim($search_ntd['ntdname']);
				$like_key = str_replace('-', '%', vn_str_filter($search_ntd['ntdname']));
				$like = [['col' => 'ntd_company', 'val' => $like_key]];
			}

			$select = 'id,ntd_company,ntd_email,ntd_phone';
			$order_by = ['id' => 'DESC'];

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);

			$infor = $this->Models->select_sql_like_and('user_ntd_error', $select, $arr_search, $like, null, $order_by, $perpage, $start, 1);
			$data['list_error'] = $infor;

			$select = 'id';
			$infor_p = $this->Models->select_sql_like_and('user_ntd_error', $select, $arr_search, $like, null, $order_by, null, null, 1);
			$total = count($infor_p);

			$config['base_url'] = "/admin/employer_error";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 4;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['page_query_string'] = false;
			$config['reuse_query_string'] = true;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();


			$this->sidebar();
			$data['content'] = '/admin/employer/list_error';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//kết thúc module

	/////////////////////////////////////////////
	////////////////Admin///////////////
	////////////////////////////////////////////

	////module danh sách tài khoản admin
	public function admin_list()
	{
		if ($this->check_login()) {

			$search_admin = $this->input->get();

			$arr_search = ['is_admin !=' => 1];
			$like = [];

			if (array_key_exists("adminid", $search_admin) && $search_admin['adminid'] != '') {
				$data['id_admin'] = trim($search_admin['adminid']);
				$like_key = str_replace('-', '%', vn_str_filter($search_admin['adminid']));
				$like = [['col' => 'id', 'va	l' => $like_key]];
			}

			if (array_key_exists("adminusername", $search_admin) && $search_admin['adminusername'] != '') {
				$data['user_name_admin'] = trim($search_admin['adminusername']);
				$like_key = str_replace('-', '%', vn_str_filter($search_admin['adminusername']));
				$like = [['col' => 'username', 'val' => $like_key]];
			}

			if (array_key_exists("adminname", $search_admin) && $search_admin['adminname'] != '') {
				$data['name_admin'] = trim($search_uv['adminname']);
				$like_key = str_replace('-', '%', vn_str_filter($search_admin['adminname']));
				$like = [['col' => 'name', 'val' => $like_key]];
			}

			if (array_key_exists("adminemail", $search_admin) && $search_admin['adminemail'] != '') {
				$data['email_uv'] = trim($search_admin['adminemail']);
				$like_key = str_replace('-', '%', vn_str_filter($search_admin['adminemail']));
				$like = [['col' => 'email', 'val' => $like_key]];
			}

			if (array_key_exists("adminphone", $search_admin) && $search_admin['adminphone'] != '') {
				$data['phone_admin'] = trim($search_admin['adminphone']);
				$like_key = str_replace('-', '%', vn_str_filter($search_admin['adminphone']));
				$like = [['col' => 'phone', 'val' => $like_key]];
			}

			if (array_key_exists("admindate", $search_admin) && $search_admin['admindate'] != '') {
				$start_time = strtotime($search_admin['admindate']);
				$end_time =  strtotime($search_admin['admindate']) + 86400;
				$arr_search['create_date >='] = $start_time;
				$arr_search['create_date <='] = $end_time;
				$data['createtime_admin'] = $search_admin['admindate'];
			}

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'id,username,name,phone,email,image,create_date,status,is_admin';
			$order_by = '';

			$infor = $this->Models->select_sql_like_and('tbl_admin', $select, $arr_search, $like, null, $order_by, $perpage, $start, 1);
			$data['list_admin'] = $infor;

			$select = 'id';
			$infor_p = $this->Models->select_sql_like_and('tbl_admin', $select, $arr_search, $like, null, $order_by, null, null, 1);
			$total = count($infor_p);

			$config['base_url'] = "/admin/list_admin";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['page_query_string'] = false;
			$config['reuse_query_string'] = true;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/admin_list/list';
			$data['css'] = '/cssjsadmin/dist/admin/css/list.css';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	// kết thúc module danh sách admin

	//module thêm tài khoản admin 

	public function admin_add()
	{
		$this->sidebar();
		$data['content'] = '/admin/admin_list/add';
		$data['css'] = '/cssjsadmin/dist/admin/css/add.css';
		$data['js'] = '/cssjsadmin/dist/admin/js/add.js';
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc

	//module sửa tài khoản admin 
	public function admin_edit($id)
	{
		$select = 'id,username,name,phone,email,image,create_date,status,is_admin,password';
		$condition = ['id' => $id];
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'tbl_admin', $join, $condition, $order_by, $start, $perpage);
		$data['info_admin'] = $infor->row_array();

		$this->sidebar();
		$data['content'] = '/admin/admin_list/edit';
		$data['css'] = '/cssjsadmin/dist/admin/css/add.css';
		$data['js'] = '/cssjsadmin/dist/admin/js/edit.js';
		$data['id'] = $id;
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module sửa tài khoản admin

	//Module danh sách tỉnh thành và quận huyện
	public function city_list()
	{
		if ($this->check_login()) {

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'cit_id,cit_name,cit_parent';
			$condition = ['cit_parent' => 0];
			$order_by = '';
			$like['cit_name'] = $key;
			$join = [];
			$infor = $this->Models->select_sql_or('city2', $select, $condition, $like, $join, $order_by, $perpage, $start, $is_multi = 1);
			$data['list_city'] = $infor;

			$select = 'cit_id';
			$total = $this->Models->select_sql_or('city2', $select, $condition, $like, $join, $order_by, null, null, $is_multi = 1);
			$total = count($total);

			$config['base_url'] = "/admin/city_list";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['reuse_query_string'] = true;
			$config['page_query_string'] = false;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/city/city';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//chỉnh sửa tt
	public function edit_city($id = NULL)
	{
		//cit_id,cit_name,meta_title,meta_description,meta_key,content,title_suggest,content_suggest,updated_at,created_at
		$infor = $this->Models->select_data('*', 'city', [], ['cit_id' => $id], '', '', '');
		$data['infor'] = $infor->row_array();
		if ($infor->num_rows() > 0 && $id != NULL) {
			$data['id'] = $id;
		} else if ($infor->num_rows() <= 0 && $id != NULL) {
			header("Location: /admin/city_list");
		} else {
			header("Location: /admin/city_list");
		}
		$this->sidebar();
		$data['css'] = '/cssjsadmin/dist/new/css/add.css';
		$data['js'] = '/cssjsadmin/dist/category/js/cate.js';
		$data['content'] = '/admin/city/edit';
		$this->load->view('admin/main', $data, FALSE);
	}

	public function district_list()
	{
		if ($this->check_login()) {

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'cit_id,cit_name,cit_parent';
			$condition = ['cit_parent !=' => 0];
			$order_by = '';
			$like['cit_name'] = $key;
			$join = [];
			$infor = $this->Models->select_sql_or('city2', $select, $condition, $like, $join, $order_by, $perpage, $start, $is_multi = 1);
			$data['list_district'] = $infor;

			$select = 'cit_id';
			$total = $this->Models->select_sql_or('city2', $select, $condition, $like, $join, $order_by, null, null, $is_multi = 1);
			$total = count($total);

			$config['base_url'] = "/admin/district_list";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['reuse_query_string'] = true;
			$config['page_query_string'] = false;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/city/district';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//kết thúc module danh sách tỉnh thành và quận huyện

	/////////////tin tuyển dụng//////////////////

	//module danh sách
	public function new_list()
	{
		if ($this->check_login()) {

			$search_new = $this->input->get();

			$arr_search = [];
			$like = [];

			if (array_key_exists("new_id", $search_new) && $search_new['new_id'] != '') {
				$data['id_new'] = trim($search_new['new_id']);
				$like_key = str_replace('-', '%', vn_str_filter($search_new['new_id']));
				$like = [['col' => 'new_id', 'val' => $like_key]];
			}

			if (array_key_exists("new_title", $search_new) && $search_new['new_title'] != '') {
				$data['title_new'] = trim($search_new['new_title']);
				$like_key = str_replace('-', '%', vn_str_filter($search_new['new_title']));
				$like = [['col' => 'new_title', 'val' => $like_key]];
			}

			if (array_key_exists("new_user", $search_new) && $search_new['new_user'] != '') {
				$data['user_new'] = trim($search_new['new_user']);
				$like_key = str_replace('-', '%', vn_str_filter($search_new['new_user']));
				$like = [['col' => 'ntd_company', 'val' => $like_key]];
			}

			if (array_key_exists("new_date", $search_new) && $search_new['new_date'] != '') {
				$start_time = strtotime($search_new['new_date']);
				$end_time =  strtotime($search_new['new_date']) + 86400;
				$arr_search['new_create_time >='] = $start_time;
				$arr_search['new_create_time <='] = $end_time;
				$data['createtime_new'] = $search_new['new_date'];
			}

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'new_id,new_title,new_alias,new_create_time,new_user_id,ntd_id,ntd_company';
			$condition = '';
			$order_by = ['new_create_time' => 'DESC'];

			$join = [
				'user_ntd' => 'new.new_user_id = user_ntd.ntd_id'
			];
			$infor = $this->Models->select_sql_like_and('new', $select, $arr_search, $like, $join, $order_by, $perpage, $start, 1);
			$data['list_new'] = $infor;

			$select = 'new_id';
			$infor_p = $this->Models->select_sql_like_and('new', $select, $arr_search, $like, $join, $order_by, null, null, 1);
			$total = count($infor_p);



			$config['base_url'] = '/admin/new_list';
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['reuse_query_string'] = true;
			$config['page_query_string'] = false;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/new/list';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//kết thúc module danh sách

	//module thêm tin
	public function new_add()
	{
		$select = 'cat_id,cat_name';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);
		$data['cate'] = $infor->result_array();

		$select = 'ntd_id,ntd_company';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'user_ntd', $join, $condition, $order_by, $start, $perpage);
		$data['ntd'] = $infor->result_array();

		$this->sidebar();
		$data['content'] = '/admin/new/add';
		$data['css'] = '/cssjsadmin/dist/new/css/add.css';
		$data['js'] = '/cssjsadmin/dist/new/js/add.js';
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module thêm tin

	//module sửa tin
	public function new_edit($id)
	{
		$select = 'cat_id,cat_name';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);
		$data['cate'] = $infor->result_array();

		$select = 'ntd_id,ntd_company';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'user_ntd', $join, $condition, $order_by, $start, $perpage);
		$data['ntd'] = $infor->result_array();

		$select = 'new_id,new_title,new_user_id,new_cat,new_tag,new_age,new_cap_bac,new_knlv,new_loai_hinh,new_han_nop,new_tag,new_sex,new_hoc_van,new_httl,new_hinh_thuc,new_luong_1,new_luong_2,new_luong_3,new_city,new_qh,new_address,new_no_calam,new_ca_start,new_ca_end,new_t2,new_t3,new_t4,new_t5,new_t6,new_t7,new_cn,new_mota,new_yeu_cau,new_quyen';
		$condition = ['new_id' => $id];
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$new_tin = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage);
		$new_tin = $new_tin->row_array();
		$data['new_tin'] = $new_tin;


		$infor_ctcv = $this->Models->select_data('*', 'category_tag', [], ['tag_parent' => $new_tin['new_cat']], '', '', '');
		$data['ctcv'] = $infor_ctcv->result_array();

		$this->sidebar();
		$data['content'] = '/admin/new/edit';
		$data['js'] = '/cssjsadmin/dist/new/js/edit.js';
		$data['css'] = '/cssjsadmin/dist/new/css/add.css';
		$data['id'] = $id;
		$this->load->view('admin/main', $data, FALSE);
	}


	//kết thúc module sửa tin


	//module ngành nghề
	public function cate_list()
	{
		if ($this->check_login()) {

			$search_job = $this->input->get();

			$arr_search = [];
			$like = [];

			if (array_key_exists("cat_id", $search_job) && $search_job['cat_id'] != '') {
				$data['id_cat'] = trim($search_job['cat_id']);
				$like_key = str_replace('-', '%', vn_str_filter($search_job['cat_id']));
				$like = [['col' => 'cat_id', 'val' => $like_key]];
			}

			if (array_key_exists("cat_name", $search_job) && $search_job['cat_name'] != '') {
				$data['name_cat'] = trim($search_job['cat_name']);
				$like_key = str_replace('-', '%', vn_str_filter($search_job['cat_name']));
				$like = [['col' => 'cat_name', 'val' => $like_key]];
			}

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'cat_id,cat_name,cat_alias,created_at,meta_description';
			$condition = '';
			$order_by = ['cat_id' => 'DESC'];

			$infor = $this->Models->select_sql_like_and('category', $select, $arr_search, $like, null, $order_by, $perpage, $start, 1);
			$data['list_cat'] = $infor;

			$select = 'cat_id';
			$infor_p = $this->Models->select_sql_like_and('category', $select, $arr_search, $like, null, $order_by, null, null, 1);
			$total = count($infor_p);



			$config['base_url'] = "/admin/job_list";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['reuse_query_string'] = true;
			$config['page_query_string'] = false;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/job_list/list';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//chỉnh sửa nn
	public function edit_cate($cate_id = NULL)
	{
		//cat_id,cat_name,cat_alias,meta_title,meta_description,meta_key,content,title_suggest,content_suggest,cat_index,created_at,updated_at
		$infor = $this->Models->select_data('*', 'category', [], ['cat_id' => $cate_id], '', '', '');
		$data['infor'] = $infor->row_array();
		if ($infor->num_rows() > 0 && $cate_id != NULL) {
			$data['cate_id'] = $cate_id;
		} else if ($infor->num_rows() <= 0 && $cate_id != NULL) {
			header("Location: /admin/job_list");
		} else {
			header("Location: /admin/job_list");
		}
		$this->sidebar();
		$data['css'] = '/cssjsadmin/dist/new/css/add.css';
		$data['js'] = '/cssjsadmin/dist/category/js/cate.js';
		$data['content'] = '/admin/job_list/edit';
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module danh sách ngành nghề

	//module thêm ngành nghề
	public function add_job()
	{
		$this->sidebar();
		$data['css'] = '/cssjsadmin/dist/admin/css/add.css';
		$data['js'] = '/cssjsadmin/dist/job/js/job.js';
		$data['content'] = '/admin/job_list/add';
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module thêm ngành nghề

	public function edit_job($id)
	{
		$select = 'cat_id,cat_name,cat_alias,meta_description,url_tim_uv,url_tim_tintd,meta_key,content,meta_title,title_suggest,content_suggest,cat_index';
		$condition = ['cat_id' => $id];
		$join = [];
		$order_by = '';
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);
		$data['info_category'] = $infor->row_array();

		$this->sidebar();
		$data['css'] = '/cssjsadmin/dist/admin/css/add.css';
		$data['js'] = '/cssjsadmin/dist/job/js/edit.js';
		$data['content'] = '/admin/job_list/edit';
		$data['id'] = $id;
		$this->load->view('admin/main', $data, FALSE);
	}

	//module danh sách tag 
	public function list_tag()
	{
		if ($this->check_login()) {

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'tag_id,tag_parent,tag_name,category_tag.created_at';
			$condition = '';
			$order_by = ['tag_id' => 'DESC'];
			$like['tag_name'] = $key;
			$like['tag_parent'] = $key;
			$join = [];
			$infor = $this->Models->select_sql_or('category_tag', $select, $condition, $like, $join, $order_by, $perpage, $start, $is_multi = 1);
			$data['list_tag'] = $infor;

			$select = 'tag_id';
			$total = $this->Models->select_sql_or('category_tag', $select, $condition, $like, $join, $order_by, null, null, $is_multi = 1);
			$total = count($total);



			$config['base_url'] = "/admin/list_tag";
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['reuse_query_string'] = true;
			$config['page_query_string'] = false;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/tag/list';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//chỉnh sửa tag, thêm tag
	public function edit_tag($tag_id = NULL)
	{
		$infor = $this->Models->select_data('*', 'category_tag', [], ['tag_id' => $tag_id], '', '', '');
		$data['infor'] = $infor->row_array();
		if ($infor->num_rows() > 0 && $tag_id != NULL) {
			$data['tag_id'] = $tag_id;
		} else if ($infor->num_rows() <= 0 && $tag_id != NULL) {
			header("Location: /admin/add_tag");
		} else {
			$data['tag_id'] = 0;
		}
		$data['cate'] = list_category();
		$this->sidebar();
		$data['css'] = '/cssjsadmin/dist/new/css/add.css';
		$data['js'] = '/cssjsadmin/dist/tag/tag.js';
		$data['content'] = '/admin/tag/edit';
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module danh sách tag

	//module thêm tag 
	public function add_tag()
	{
		$select = 'cat_id,cat_name';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$infor = $this->Models->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);
		$data['cate'] = $infor->result_array();
		die();
		$this->sidebar();
		$data['content'] = '/admin/tag/add';
		$data['css'] = '/cssjsadmin/dist/admin/css/add.css';
		$data['js'] = '/cssjsadmin/dist/tag/js/add.js';
		$this->load->view('admin/main', $data, FALSE);
	}
	//kết thúc module thêm tag

	//Module ngành nghề tỉnh thành
	public function list_job_city()
	{
		if ($this->check_login()) {
			$search_job_city = $this->input->get();

			$arr_search = ['tag_id' => 0];
			$like = [];

			if (array_key_exists("category", $search_job_city) && $search_job_city['category'] != '') {
				$data['category'] = $search_job_city['category'];
				$arr_search['cat_id'] = $search_job_city['category'];
			}

			if (array_key_exists("city", $search_job_city) && $search_job_city['city'] != '') {
				$data['city'] = $search_job_city['city'];
				$arr_search['cit_id'] = $search_job_city['city'];
			}

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'id,cit_id,cat_id,meta_title,meta_description,meta_key,created_at';
			$condition = '';
			$order_by = ['created_at' => 'DESC'];

			$join = [
				// 'user_ntd'=>'new.new_user_id = user_ntd.ntd_id'
			];
			$infor = $this->Models->select_sql_like_and('city_category', $select, $arr_search, $like, $join, $order_by, $perpage, $start, 1);
			$data['list_cit_job'] = $infor;

			$select = 'id';
			$infor_p = $this->Models->select_sql_like_and('city_category', $select, $arr_search, $like, $join, $order_by, null, null, 1);
			$total = count($infor_p);



			$config['base_url'] = '/admin/list_job_city/';
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['reuse_query_string'] = true;
			$config['page_query_string'] = false;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/cate_city/list';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//chỉnh sửa bài viết nn tại tt
	public function edit_cate_city($cat_id = NULL, $cit_id = NULL)
	{
		$condition = [];
		$condition['cat_id'] = $cat_id;
		$condition['cit_id'] = $cit_id;
		$infor = $this->Models->select_data('*', 'city_category', [], $condition, '', '', '');
		$data['infor'] = $infor->row_array();
		if ($infor->num_rows() > 0 && ($cat_id != NULL || $cit_id != NULL)) {
			$data['cat_id'] = $cat_id;
			$data['cit_id'] = $cit_id;
		} else if ($infor->num_rows() <= 0 && ($cat_id != NULL || $cit_id != NULL)) {
			header("Location: /admin/add_job_city");
		} else {
			$data['cat_id'] = 0;
			$data['cit_id'] = 0;
		}
		$data['cate'] = list_category();
		$data['city'] = all_city();
		$this->sidebar();
		$data['css'] = '/cssjsadmin/dist/new/css/add.css';
		$data['js'] = '/cssjsadmin/dist/cate_city/edit.js';
		$data['content'] = '/admin/cate_city/edit';
		$this->load->view('admin/main', $data, FALSE);
	}

	//Module tag tỉnh thành
	public function list_tag_city()
	{
		if ($this->check_login()) {
			$search_job_city = $this->input->get();
			$arr_search['cat_id'] = 0;
			$like = [];

			if (array_key_exists("category", $search_job_city) && $search_job_city['category'] != '') {
				$data['category'] = $search_job_city['category'];
				$arr_search['tag_id'] = $search_job_city['category'];
			}

			if (array_key_exists("city", $search_job_city) && $search_job_city['city'] != '') {
				$data['city'] = $search_job_city['city'];
				$arr_search['cit_id'] = $search_job_city['city'];
			}

			$page = $this->uri->segment(3);
			if ($page == 0 || $page == '') {
				$page = 1;
			}
			$perpage = 10;
			$start = $perpage * ($page - 1);
			$key = $this->input->get('key');

			$select = 'id,cit_id,tag_id,meta_title,meta_description,meta_key,created_at';
			$condition = '';
			$order_by = '';

			$join = [
				// 'user_ntd'=>'new.new_user_id = user_ntd.ntd_id'
			];
			$infor = $this->Models->select_sql_like_and('city_category', $select, $arr_search, $like, $join, $order_by, $perpage, $start, 1);
			$data['list_cit_job'] = $infor;

			$select = 'id';
			$infor_p = $this->Models->select_sql_like_and('city_category', $select, $arr_search, $like, $join, $order_by, null, null, 1);
			$total = count($infor_p);



			$config['base_url'] = '/admin/list_tag_city/';
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = true;
			$config['reuse_query_string'] = true;
			$config['page_query_string'] = false;
			$config["prefix"] = '/';
			$config['full_tag_open'] = '<div class="t_paginate_group">';
			$config['full_tag_close'] = '</div>';
			$config['first_link'] = 'Đầu';
			$config['first_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['first_tag_close'] = '</button>';
			$config['num_tag_open'] = '<button class="t_paginate_item">';
			$config['num_tag_close']    = '</button>';
			$config['last_link'] = "Cuối";
			$config['last_tag_open'] = '<button class="t_paginate_item t_paginate_item_big">';
			$config['last_tag_close'] = '</button>';
			$config['prev_link'] = '<span class="t_paginate_icon t_paginate_pre"></span>';
			$config['prev_tag_open'] = '<button class="t_paginate_item">';
			$config['prev_tag_close'] = '</button>';
			$config['next_link'] = '<span class="t_paginate_icon t_paginate_next"></span>';
			$config['next_tag_open'] = '<button class="t_paginate_item">';
			$config['next_tag_close'] = '</button>';

			$config['cur_tag_open'] = '<button class="t_paginate_item t_paginate_active">';
			$config['cur_tag_close'] = '</button>';

			$this->pagination->initialize($config);
			$page = $this->input->get('page');

			// pagination('/'.$_SERVER['REQUEST_URI'], 30 , $perpage);
			$data['links'] = $this->pagination->create_links();

			$this->sidebar();
			$data['content'] = '/admin/tag_city/list';
			$data['total'] = $total;
			$this->load->view('admin/main', $data, FALSE);
		}
	}
	//chỉnh sửa bài viết tag tại tt
	public function edit_tag_city($id = NULL)
	{
		$condition = [];
		$condition['id'] = $id;
		$condition['cat_id'] = 0;
		$infor = $this->Models->select_data('*', 'city_category', [], $condition, '', '', '');
		$data['infor'] = $infor->row_array();
		if ($infor->num_rows() > 0 && $id != NULL) {
			$data['id'] = $id;
		} else if ($infor->num_rows() <= 0 && $id != NULL) {
			header("Location: /admin/add_tag_city");
		} else {
			$data['id'] = 0;
		}
		$data['cate'] = list_category_tag();
		$data['city'] = all_city();
		$this->sidebar();
		$data['css'] = '/cssjsadmin/dist/new/css/add.css';
		$data['js'] = '/cssjsadmin/dist/tag_city/edit.js';
		$data['content'] = '/admin/tag_city/edit';
		$this->load->view('admin/main', $data, FALSE);
	}



	public function add()
	{
		$str = 'I/flutter (17366): {"result":true,"code":200,"data":{"message":"Lấy thông tin thành công","job_details":[{"id_vieclam":"131","id_ntd":"42","vi_tri":"dsdh","so_luong":"100","nganh_nghe":"11","cap_bac":"4","hoa_hong":"","thoi_gian":"","dia_diem":"2","quan_huyen":"282","hinh_thuc":"3","ht_luong":"1","muc_luong":"400000","tra_luong":"2","hoc_van":"4","fist_time":"2022-03-01","last_time":"2022-03-31","luot_xem":"47","mo_ta":"W\/IInputConnectionWrapper(16575): getSelectedText on inactive InputConnection\r\nW\/IInputConnectionWrapper(16575): endBatchEdit on inactive InputConnection\r\nW\/IInputConnectionWrapper(16575): beginBatchEdit on inactive InputConnection\r\nW\/IInputConnectionWrap","gender":"1","yeu_cau":"W\/IInputConnectionWrapper(16575): getSelectedText on inactive InputConnection\r\nW\/IInputConnectionWrapper(16575): endBatchEdit on inactive InputConnection\r\nW\/IInputConnectionWrapper(16575): beginBatchEdit on inactive InputConnection\r\nW\\';
		$data = [
			'uv_gtc' => $str,
			'uv_email' => 'a'
		];
		$in = $this->Models->insert_data('user_uv', $data);
		echo $this->Models->query();
	}
}
?>
<?php
$allow = array(
	"171.255.69.80", "14.162.144.184", "222.255.236.80", "123.24.206.25", "118.70.126.231", "115.79.62.130", "125.212.244.247", "43.239.223.11", "43.239.223.12", "27.3.150.230", "125.212.244.247", "42.118.114.172", "43.239.223.60", "118.70.126.138", "14.248.82.205",
	"162.158.62.160", "118.70.185.222", "42.114.250.33", "42.114.250.226", "117.4.243.120", "192.168.1.75", "14.232.210.88", "118.70.126.138", '::1'
);  //allowed IPs

if (!in_array($_SERVER['REMOTE_ADDR'], $allow) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $allow)) {

	header("Location: /");

	exit();
} 
/* End of file Admin.php */
/* Location: ./application/controllers/admin/Admin.php */