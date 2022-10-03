<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
		$this->load->helper('form');
		$this->load->model('Models');
		$this->load->helper('url');
		$this->load->helper('func_helper');
		$this->load->library('session');
	}
	public function index()
	{
		$select = 'new_id,new_title,new_alias,new_city,new_loai_hinh,new_hinh_thuc,new_httl,new_knlv,new_luong_1,new_luong_2,new_luong_3,
		new_user_id,ntd_id,ntd_avatar,ntd_create_time,ntd_alias';
		// việc làm mới nhất
		$order_by = 'new_updated_time DESC';
		$perpage = 84;
		$start = 0;
		$join = [
			[
				'table' => 'user_ntd',
				'on' => 'new_user_id = ntd_id'
			]
		];
		$list_job = $this->Models->select_data($select, 'new', $join, '', $order_by, $start, $perpage);
		$data['list_job'] = $list_job->result_array();
		// việc làm trả lương theo ngày
		$perpage = 8;
		$day_job = $this->Models->select_data($select, 'new', $join, ['new_httl' => 3], $order_by, $start, $perpage);
		$data['day_job'] = $day_job->result_array();
		// việc làm bán hàng
		$sell_job = $this->Models->select_data($select, 'new', $join, ['new_cat' => 1], $order_by, $start, $perpage);
		$data['sell_job'] = $sell_job->result_array();
		// việc làm hành chính
		$daily_job = $this->Models->select_data($select, 'new', $join, ['new_cat' => 5], $order_by, $start, $perpage);
		$data['daily_job'] = $daily_job->result_array();
		// việc làm giao hàng
		$giao_hang = $this->Models->select_data($select, 'new', $join, ['new_cat' => 6], $order_by, $start, $perpage);
		$data['giao_hang'] = $giao_hang->result_array();
		// ds category
		$data['category'] = list_category();

		$data['robot'] 		= ''; // seo
		$data['title'] 		= 'Tìm Việc Làm Theo Giờ Lương Cao, Mới Nhất ' . date("m-Y", getdate()[0]); // seo
		$data['keyword'] 	= 'Việc làm theo giờ, tìm việc làm theo giờ'; // seo
		$data['canonical'] 	= 'https://vieclamtheogio.vieclam123.vn'; // seo
		$data['ogImage'] 	= 'https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png'; // seo
		$data['description'] = ' Danh sách việc làm theo giờ mới nhất ' . date("m-Y", getdate()[0]) . '. Hàng nghìn việc làm theo giờ lương cao. Tham khảo và nộp hồ sơ ngay
		'; // seo
		$data['content'] = 'includes/home';
		$data['css'] = array('includes/search_job', 'includes/home', 'includes/popup_dang_nhap');
		$data['js'] = array('includes/search_filter_job', 'includes/home', 'includes/popup_dang_nhap');
		$this->load->view('template', $data, FALSE);
	}
	public function page_404()
	{
		$data['css'] = ['includes/404'];
		$data['content'] = 'includes/page_404';
		$this->load->view('template', $data, FALSE);
	}
	public function List_job_nn($alias, $nn, $tt)
	{
		// trả dl cho thanh search
		$data['nn'] = $nn;
		if ($tt > 63) {
			$data['tt'] = get_district($tt)['cit_parent'];
		} else {
			$data['tt'] = $tt;
		}
		//ds category
		$list_category = list_category();
		$data['category'] = $list_category;
		// số page, start row
		$page = $this->uri->segment(2);
		if ($page == 0 || $page == '') {
			$page = 1;
		}
		$perpage = 10;
		$start = $perpage * ($page - 1);
		// ds vl
		$data['category_name'] = '';
		$select = 'new_id,new_title,new_alias,new_httl,,new_cat,new_city,new_loai_hinh,new_hinh_thuc,new_knlv,
			new_luong_1,new_luong_2,new_luong_3,new_han_nop,
			ntd_id,ntd_avatar,ntd_create_time,ntd_alias';
		$join = [
			[
				'table' => 'user_ntd',
				'on' => 'new_user_id = ntd_id'
			]
		];
		$condition = [];
		$order_by = 'new_updated_time DESC';
		if ($tt > 63) {
			$condition['new_qh'] = $tt;
			$data['category_name'] = 'tại ' . get_city_where($tt);
		} elseif ($tt > 0) {
			$condition['new_city'] = $tt;
			$data['category_name'] = 'tại ' . get_city_where($tt);
		}
		if ($nn > 0) {
			$condition['new_cat'] = $nn;
			$data['category_name'] = $list_category[$nn]['cat_name'];
		}
		if ($nn > 0 && $tt > 0) {
			$data['category_name'] = $list_category[$nn]['cat_name'] . ' theo giờ tại ' . get_city_where($tt);
		}

		$new = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage);
		$data['new'] = $new->result_array();
		// total

		$total =  $this->Models->select_data('new_id', 'new', $join, $condition, $order_by, '', '');
		$total = $total->num_rows();
		// phân trang
		pagination('/' . $this->uri->segment(1), $total, $perpage);
		// bv chân trang
		$data['article'] = '';
		$data['article_content_sg'] = '';
		$data['article_title_sg'] = '';
		if ($nn > 0 && $tt > 0) {
			$article = $this->Models->select_data('*', 'city_category', [], ['cit_id' => $tt, 'cat_id' => $nn], '', '', '')->row_array();
			if ($article != null) {
				$data['article'] = $article['content'];
				$data['article_title_sg'] = $article['title_suggest'];
				$data['article_content_sg'] = $article['content_suggest'];
			} else {
				$data['article'] = '';
			}
			// $data['article'] = $article['content'];
		} elseif ($nn > 0) {
			$article = $this->Models->select_data('*', 'category', [], ['cat_id' => $nn], '', '', '')->row_array();
			$data['article'] = $article['content'];
			$data['article_title_sg'] =  $article['title_suggest'];
			$data['article_content_sg'] = $article['content_suggest'];
		} elseif ($tt > 0 && $tt < 64) {
			$article = $this->Models->select_data('*', 'city', [], ['cit_id' => $tt], '', '', '')->row_array();
			$data['article'] = $article['content'];
			$data['article_title_sg'] = $article['title_suggest'];
			$data['article_content_sg'] = $article['content_suggest'];
		}
		$categoties = list_category();
		$text_cat = '';
		foreach ($categoties as $v) {
			if ($nn == $v['cat_id']) {
				$text_cat .= $v['cat_name'];
			}
		}
		// header
		$data['robot'] 		= ''; // seo
		if ($nn > 0 && $tt == 0) {
			$data['title'] 		= 'Việc Làm ' . $text_cat . ' Theo Giờ Lương Cao, Mới Nhất ' .  date("m-Y", getdate()[0]); // seo
			$data['keyword'] 	= 'việc làm ' . $text_cat . ' theo giờ'; // seo
			$data['description'] = ' Danh sách việc làm  ' . $text_cat . ' theo giờ mới nhất ' .  date("m-Y", getdate()[0]) . '. Tham khảo ngay và ứng tuyển ngay hôm nay'; // seo
		} elseif ($tt > 0 && $nn == 0) {
			$data['title'] 		= 'Việc Làm Theo Giờ tại ' . get_city_where($tt) . ' Lương Cao, Mới Nhất ' .  date("m-Y", getdate()[0]); // seo
			$data['keyword'] 	= 'Việc làm theo giờ tại ' . get_city_where($tt) . ' theo giờ'; // seo
			$data['description'] = ' Danh sách việc làm theo giờ tại  ' .  get_city_where($tt) . '  mới nhất ' .  date("m-Y", getdate()[0]) . '. Tham khảo ngay và ứng tuyển ngay hôm nay'; // seo
		} else {
			$data['title'] 		= 'Việc Làm ' . $data['category_name'] . ' Lương Cao, Mới Nhất ' .  date("m-Y", getdate()[0]); // seo
			$data['keyword'] 	= 'việc làm ' . $data['category_name'] . ' theo giờ';
			$data['description'] = ' Danh sách việc làm ' . $data['category_name'] . '  mới nhất ' .  date("m-Y", getdate()[0]) . '. Tham khảo ngay và ứng tuyển ngay hôm nay'; // seo
		}
		$data['ogImage'] 	= 'https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png';
		$data['canonical'] 	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$data['total'] = $total;
		$data['content'] = 'includes/List_job';
		$data['css'] = array('includes/search_job', 'includes/search_filter_job', 'includes/List_job', 'includes/popup_dang_nhap');
		$data['js'] = array('includes/search_filter_job', 'includes/popup_dang_nhap');

		$this->load->view('template', $data, FALSE);
	}

	public function List_job_tag($alias, $tag, $tt)
	{
		// trả dl cho thanh search
		$data['key'] = list_category_tag()[$tag]['tag_name'];
		if ($tt > 63) {
			$data['tt'] = get_district($tt)['cit_parent'];
		} else {
			$data['tt'] = $tt;
		}
		//ds category
		$list_category = list_category();
		$data['category'] = $list_category;
		$list_category_tag = list_category_tag();
		// số page, start row
		$page = $this->uri->segment(2);
		if ($page == 0 || $page == '') {
			$page = 1;
		}
		$perpage = 10;
		$start = $perpage * ($page - 1);

		// ds vl
		$select = 'new_id,new_title,new_alias,new_httl,,new_cat,new_city,new_loai_hinh,new_hinh_thuc,new_knlv,
			new_luong_1,new_luong_2,new_luong_3,new_han_nop,
			ntd_id,ntd_avatar,ntd_create_time,ntd_alias';
		$join = [
			[
				'table' => 'user_ntd',
				'on' => 'new_user_id = ntd_id'
			]
		];
		$data['category_name'] = '';
		$condition = [];
		$order_by = 'new_updated_time DESC';
		if ($tt > 63) {
			$condition['new_qh'] = $tt;
		} elseif ($tt > 0) {
			$condition['new_city'] = $tt;
		}
		if ($tag > 0) {
			$condition['new_tag'] = $tag;
			$data['category_name'] = $list_category_tag[$tag]['tag_name'];
		}
		$more_job = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage);
		$data['new'] = $more_job->result_array();
		// total
		$total =  $this->Models->select_data('new_id', 'new', $join, $condition, $order_by, '', '');
		$total = $total->num_rows();
		// phân trang
		pagination('/' . $this->uri->segment(1), $total, $perpage);
		// bv chân trang
		$data['article'] = '';
		$data['article_content_sg'] = '';
		$data['article_title_sg'] = '';
		if ($tag > 0 && $tt > 0) {
			$article = $this->Models->select_data('*', 'city_category', [], ['cit_id' => $tt, 'tag_id' => $tag], '', '', '')->row_array();
			$data['article'] = $article['content'];
			$data['article_title_sg'] = $article['title_suggest'];
			$data['article_content_sg'] = $article['content_suggest'];
		} elseif ($tag > 0) {
			$article = $this->Models->select_data('*', 'category_tag', [], ['tag_id' => $tag], '', '', '')->row_array();
			$data['article'] = $article['content'];
			$data['article_title_sg'] = $article['title_suggest'];
			$data['article_content_sg'] = $article['content_suggest'];
			// echo 'tag';
		} elseif ($tt > 0 && $tt < 64) {
			$article = $this->Models->select_data('*', 'city', [], ['cit_id' => $tt], '', '', '')->row_array();
			$data['article'] = $article['content'];
			$data['article_title_sg'] = $article['title_suggest'];
			$data['article_content_sg'] = $article['content_suggest'];
		}

		// header
		$data['robot'] 		= ''; // seo
		$data['title'] 		= ''; // seo
		$data['keyword'] 	= ''; // seo
		$data['canonical'] 	= ''; // seo
		$data['description'] = ''; // seo
		$data['total'] = $total;
		$data['content'] = 'includes/List_job';
		$data['css'] = array('includes/search_job', 'includes/search_filter_job', 'includes/List_job', 'includes/popup_dang_nhap');
		$data['js'] = array('includes/search_filter_job', 'includes/popup_dang_nhap');

		$this->load->view('template', $data, FALSE);
	}

	public function List_job_key()
	{
		//get value từ url key=abc&nn=1&tt=1&htl=1&hv=1&gt=3&cb=1&kn=1&lh=1&ht=1
		$key = $this->input->get('key');
		$nn = $this->input->get('nn');
		$tt = $this->input->get('tt');
		$qh = $this->input->get('qh');
		$htl = $this->input->get('htl');
		$hv = $this->input->get('hv');
		$gt = $this->input->get('gt');
		$cb = $this->input->get('cb');
		$kn = $this->input->get('kn');
		$lh = $this->input->get('lh');
		$ht = $this->input->get('ht');
		// trả dl cho thanh search
		$data['key'] = $key;
		$data['nn'] = $nn;
		if ($qh > 63) {
			$data['tt'] = get_district($qh)['cit_parent'];
		} else if ($tt > 0) {
			$data['tt'] = $tt;
		}
		$data['htl'] = $htl;
		$data['hv'] = $hv;
		$data['gt'] = $gt;
		$data['cb'] = $cb;
		$data['kn'] = $kn;
		$data['lh'] = $lh;
		$data['ht'] = $ht;
		//ds category
		$list_category = list_category();
		$data['category'] = $list_category;
		// số page, start row
		$page = $this->uri->segment(2);
		if ($page == 0 || $page == '') {
			$page = 1;
		}
		$perpage = 10;
		$start = $perpage * ($page - 1);

		// ds vl
		$select = 'new_id,new_title,new_alias,new_httl,,new_cat,new_city,new_loai_hinh,new_hinh_thuc,new_knlv,
			new_luong_1,new_luong_2,new_luong_3,new_han_nop,
			ntd_id,ntd_avatar,ntd_create_time,ntd_alias';
		$join =
			['user_ntd' => 'new_user_id = ntd_id'];
		$order_by = ['new_updated_time' => 'DESC'];
		$condition = [];
		$like = [];
		if ($key != '') {
			// `field` LIKE '%a%' and field LIKE '%b%'
			// $arr_key = explode('-',vn_str_filter($key));
			// $like = [];
			// foreach ($arr_key as $value) {
			// 	$like[] = ['col'=>'new_title', 'val'=>$value];
			// }

			// `field` LIKE '%a%b%'
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
		if ($htl > 0) {
			$condition['new_httl'] = $htl;
		}
		if ($hv > 0) {
			$condition['new_hoc_van'] = $hv;
		}
		if ($gt > 0) {
			$condition['new_sex'] = $gt;
		}
		if ($cb > 0) {
			$condition['new_cap_bac'] = $cb;
		}
		if ($kn > 0) {
			$condition['new_knlv'] = $kn;
		}
		if ($lh > 0) {
			$condition['new_loai_hinh'] = $lh;
		}
		if ($ht > 0) {
			$condition['new_hinh_thuc'] = $ht;
		}
		$more_job = $this->Models->select_sql_like_and('new', $select, $condition, $like, $join, $order_by, $perpage, $start, 1);
		$data['new'] = $more_job;
		// total
		$total =  $this->Models->select_sql_like_and('new', $select, $condition, $like, $join, $order_by, null, null, 1);


		$total = count($total);
		// phân trang
		pagination('/' . $this->uri->segment(1), $total, $perpage);

		$data['category_name'] = '';

		// header
		$data['robot'] 		= ''; // seo
		$data['title'] 		= 'Tin Tuyển Dụng Việc Theo Giờ Lương Cao, Mới Nhất ' .  date("m-Y", getdate()[0]); // seo
		$data['keyword'] 	= 'tin tuyển dụng việc làm theo giờ'; // seo
		$data['canonical'] 	= 'https://vieclamtheogio.vieclam123.vn/'; // seo
		$data['ogImage'] 	= 'https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png';
		$data['description'] = 'Tin tuyển dụng việc làm theo giờ mới nhất lương cao, cập nhật liên tục. Tham khảo và ứng tuyển ngay hôm nay'; // seo
		$data['total'] = $total;
		$data['content'] = 'includes/List_job';
		$data['css'] = array('includes/search_job', 'includes/search_filter_job', 'includes/List_job', 'includes/popup_dang_nhap');
		$data['js'] = array('includes/search_filter_job', 'includes/popup_dang_nhap');

		$this->load->view('template', $data, FALSE);
	}

	public function trang_ung_vien()
	{
		$search_uv = $this->input->get();

		$keyword = $this->input->get("keyword");
		$key_word = preg_replace('/[-\s]+/', ' ', $keyword);
		$city = $this->input->get("diadiem");

		$arr_search['uv_found'] = 1;
		if (array_key_exists("hinhthuc", $search_uv)) {
			$arr_search['uv_hinh_thuc'] = $search_uv['hinhthuc'];
			$data['hinhthuc_uv'] = $search_uv['hinhthuc'];
		}
		if (array_key_exists("loailv", $search_uv)) {
			$arr_search['uv_loai_hinh'] = $search_uv['loailv'];
			$data['loailv_uv'] = $search_uv['loailv'];
		}
		if (array_key_exists("gioitinh", $search_uv)) {
			$arr_search['uv_sex'] = $search_uv['gioitinh'];
			$data['gioitinh_uv'] = $search_uv['gioitinh'];
		}
		if (array_key_exists("honnhan", $search_uv)) {
			$arr_search['uv_mary'] = $search_uv['honnhan'];
			$data['honnhan_uv'] = $search_uv['honnhan'];
		}
		if (array_key_exists("luong", $search_uv)) {
			$arr_search['uv_luong_1'] = $search_uv['luong'];
			$data['luong_uv'] = $search_uv['luong'];
		}
		if (isset($keyword)) {
			$data['keyword_uv'] = $key_word;
			$like_key = str_replace('-', '%', vn_str_filter($key_word));
			$like = [['col' => 'uv_vitri ', 'val' => $like_key]];
		} else {
			$like = NULL;
		}
		if (isset($city)) {
			$data['id_city_uv'] = $city;
			$arr_search['uv_city'] = $city;
		}

		$data['bread_cum_title'] = '';
		$page = $this->uri->segment(2);
		if ($page == 0 || $page == '') {
			$page = 1;
		}
		$perpage = 10;
		$start = $perpage * ($page - 1);

		$select = 'uv_id,uv_name,uv_city,uv_loai_hinh,uv_hinh_thuc,uv_vitri,uv_cat,uv_luong_1,uv_createtime,uv_avatar,uv_alias';

		$infor = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, $like, null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), $perpage, $start, 1);


		if (count($infor) == 0) {
			if (isset($keyword)) {
				$data['keyword_uv'] = $key_word;
				$like_key = str_replace('-', '%', vn_str_filter($key_word));
				$like = [['col' => 'uv_name', 'val' => $like_key]];
			} else {
				$like = null;
			}
			$infor = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, $like, null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), $perpage, $start, 1);
		}

		// die();
		$data['infor'] = $infor;
		$data['category'] = list_category();

		$infor_p = $this->Models->select_sql_like_and('user_uv', $select, $arr_search, $like, null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), null, null, 1);
		$total = count($infor_p);

		pagination('/' . $this->uri->segment(1), $total, $perpage);
		// header
		$data['robot'] 		= ''; // seo	
		$data['ogImage'] 	= 'https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png';
		$data['title'] 		= 'Danh sách Ứng viên theo giờ mới nhất' .  date("m-Y", getdate()[0]); // seo
		$data['description'] 	= 'Tổng hợp danh sách ứng viên theo giờ mới nhất ' .  date("m-Y", getdate()[0]) . '. Tham khảo ngay danh sách ứng viên phù hợp nhất'; // seo
		$data['canonical'] 	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // seo
		$data['keyword'] = 'Ứng viên theo giờ'; // seo
		$data['css'] = [
			'includes/trang_ung_vien', 'includes/search_form', 'includes/popup_dang_nhap'
		];
		$data['js'] = [
			'includes/trang_ung_vien', 'includes/search_form', 'includes/popup_dang_nhap'
		];
		$data['content'] = 'ungvien/trang_ung_vien';
		$this->load->view('template', $data);
	}

	public function List_uv_nn($alias, $nn, $tt)
	{
		$cate = list_category();
		$page = $this->uri->segment(2);
		if ($page == 0 || $page == '') {
			$page = 1;
		}
		$perpage = 10;
		$start = $perpage * ($page - 1);

		$select = 'uv_id,uv_name,uv_city,uv_loai_hinh,uv_hinh_thuc,uv_vitri,uv_cat,uv_luong_1,uv_createtime,uv_avatar,uv_alias';
		$order_by = '';
		$data['bread_cum_title'] = '';
		if ($nn == 0 && $tt != 0) {
			$condition = array('uv_city' => $tt, 'uv_found' => 1);
			$data['bread_cum_title'] = 'tại ' . get_city($tt);
		} else if ($nn != 0 && $tt == 0) {
			$condition = array("FIND_IN_SET('" . $nn . "', uv_cat) >" => 0, 'uv_found' => 1);
			$data['bread_cum_title'] = $cate[$nn]['cat_name'];
		} else if ($nn != 0 && $tt != 0) {
			$condition = array("FIND_IN_SET('" . $nn . "', uv_cat) >" => 0, 'uv_city' => $tt, 'uv_found' => 1);
			$data['bread_cum_title'] = $cate[$nn]['cat_name'] . ' tại ' . get_city($tt);
		}

		$infor = $this->Models->select_sql('user_uv', $select, $condition, null, null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), $perpage, $start, 1);
		$data['infor'] = $infor;

		$category = $this->Models->select_data('cat_id,cat_name,cat_alias', 'category', [], '', $order_by, $start, $perpage);
		$data['category'] = $category->result_array();

		$infor_p = $this->Models->select_sql('user_uv', $select, $condition, null, null, array('date_refresh' => 'DESC', 'uv_id' => 'DESC'), null, null, 1);
		$total = count($infor_p);

		pagination('/' . $this->uri->segment(1), $total, $perpage);


		if ($nn != 0) {
			$data['keyword_uv'] = $cate[$nn]["cat_name"];
		}
		if ($tt != 0) {
			$data['id_city_uv'] = $tt;
		}

		// header
		$data['robot'] 		= ''; // seo
		$data['title'] 		= ''; // seo
		$data['keyword'] 	= ''; // seo
		$data['canonical'] 	= ''; // seo
		$data['description'] = ''; // seo
		$data['css'] = [
			'includes/trang_ung_vien', 'includes/search_form', 'includes/popup_dang_nhap'
		];
		$data['js'] = [
			'includes/trang_ung_vien', 'includes/search_form', 'includes/popup_dang_nhap'
		];
		$data['content'] = 'ungvien/trang_ung_vien';

		$this->load->view('template', $data, FALSE);
	}
	public function Detail_job($alias, $id_job)
	{
		// chi tiết tin
		$select = 'new.*,ntd_id,ntd_avatar,ntd_create_time,ntd_company,ntd_alias';
		$condition = ['new_id' => $id_job];
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
		if ($infor_job->num_rows() > 0) {
			$data['infor_job'] = $infor_job->row_array();
			// check like, check ut
			if ((isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3)) {
				$data['save_new'] = $this->Models->select_data('id', 'save_new', [], ['id_uv' => $_COOKIE['UserId'], 'id_new' => $id_job], '', '', '')->num_rows();
				$data['apply_new'] = $this->Models->select_data('id', 'apply_new', [], ['id_uv' => $_COOKIE['UserId'], 'id_new' => $id_job], '', '', '')->num_rows();
			} else {
				$data['save_new'] = 0;
				$data['apply_new'] = 0;
			}
			// tin tuyển dụng cùng công ty
			$id_ntd = $data['infor_job']['ntd_id'];
			$condition = ['ntd_id' => $id_ntd];
			$order_by = 'new_updated_time DESC';
			$start = 0;
			$perpage = 3;
			$data['job'] = $this->Models->select_data($select, 'new', $join, $condition, $order_by, $start, $perpage)->result_array();
			// tăng view
			$update = $this->Models->inc_data('new', ['view_new' => 'view_new+1'], ['new_id' => $id_job]);
		} else {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: /page-404");
		}

		$data['robot'] 		= ''; // seo
		$data['title'] 		= $data['infor_job']['new_title'] . ' - id ' . $id_job; // seo
		$data['ogImage'] 	= 'https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png';
		$data['keyword'] 	= $data['infor_job']['new_title'] . ' - id ' . $id_job; // seo
		$data['canonical'] 	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // seo
		$data['description'] = $data['infor_job']['new_title'] . ' - id ' . $id_job . ' tin đang cần tuyển ứng viên. Tham khảo và nộp hồ sơ ngay.'; // seo
		$data['content'] = 'ungvien/detail_job';
		$data['css'] = array('includes/search_job', 'ungvien/detail_job', 'includes/popup_dang_nhap', 'includes/popup_ung_tuyen');
		$data['js'] = array('includes/search_filter_job', 'ungvien/detail_job', 'includes/popup_dang_nhap', 'includes/popup_ung_tuyen');

		$this->load->view('template', $data, FALSE);
	}
	public function Detail_ntd($alias, $id)
	{
		// chi tiết ntd
		$select = 'ntd_id,ntd_avatar,ntd_cover_background,ntd_email,ntd_phone,ntd_city,ntd_quanhuyen,ntd_address,ntd_msthue,
		ntd_company,ntd_zalo,ntd_skype,ntd_gioi_thieu,ntd_img_1,ntd_img_2,ntd_img_3,ntd_csptnl,ntd_chtt,ntd_salary_award,
		ntd_create_time,ntd_alias,cit_name';
		$condition = [
			'ntd_alias' => $alias,
			'ntd_id' => $id,
		];
		$join = [['table' => 'city2', 'on' => 'ntd_quanhuyen = cit_id']];
		$order_by = '';
		$start = '';
		$perpage = '';
		$ntd_detail = $this->Models->select_data($select, 'user_ntd', $join, $condition, $order_by, $start, $perpage);
		if ($ntd_detail->num_rows() > 0) {
			$data['ntd_detail'] = $ntd_detail->row_array();
			// việc làm của ntd
			$select = 'new_id,new_title,new_alias,new_httl,new_user_id,new_cat,new_city,new_loai_hinh,new_hinh_thuc,new_knlv,
			new_luong_1,new_luong_2,new_luong_3,new_han_nop';
			$join = [];
			$order_by = 'new_updated_time DESC';
			$condition = ['new_user_id' => $id];
			$ntd_job = $this->Models->select_data($select, 'new', $join, $condition, $order_by, 0, 10);
			$data['ntd_job'] = $ntd_job->result_array();
			$data['total_job'] = $this->Models->select_data('new_id', 'new', $join, $condition, $order_by, $start, $perpage)->num_rows();
			// check save new
			if ((isset($_COOKIE['Type']) && $_COOKIE['Type'] == 3)) {
				$data['save_new'] = array_column($this->Models->select_data('id_new', 'save_new', [], ['id_uv' => $_COOKIE['UserId'], 'id_ntd' => $id], '', '', '')->result_array(), 'id_new');
			} else {
				$data['save_new'] = [];
				$data['apply_new'] = [];
			}
		} else {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: /page-404");
		}
		$data['robot'] 		= ''; // seo
		$data['title'] 		=  $data['ntd_detail']['ntd_company'] . ' - id ' . $id . ' tuyển dụng ' . date("m-Y", getdate()[0]); // seo
		$data['keyword'] 	=  $data['ntd_detail']['ntd_company'] . ' - id ' . $id; // seo
		$data['canonical'] 	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // seo 
		$data['ogImage'] 	= 'https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png';
		$data['description'] = $data['ntd_detail']['ntd_company'] . ' - id ' . $id . 'đang có nhu cầu tuyển dụng ứng viên. Tham khảo ngay thông tin công ty
		'; // seo
		$data['content'] = 'nhatuyendung/detail_ntd';
		$data['css'] = array('includes/search_job', 'ntd/detail_ntd', 'includes/popup_dang_nhap');
		$data['js'] = array('includes/search_filter_job', 'includes/popup_dang_nhap');

		$this->load->view('template', $data, FALSE);
	}
	public function Detail_uv($alias, $id)
	{
		if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
			$id_ntd = $_COOKIE['UserId'];
			$id_uv = $id;
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
		$condition = ['uv_id' => $id];
		$join = [];
		$order_by = '';
		$start = '';
		$perpage = '';

		$infor = $this->Models->select_data($select, 'user_uv', $join, $condition, $order_by, $start, $perpage);
		$infor = $infor->result_array();
		if (count($infor) > 0) {
			$data['infor'] = $infor[0];
			// var_dump($data['infor']);
			$select = 'cat_id,cat_name,cat_alias';
			$condition = '';
			$category = $this->Models->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);
			$data['category'] = $category->result_array();

			$select = 'com_name,vi_tri,date_from,date_to,mo_ta';
			$condition = ['id_uv' => $id];
			$work_infor = $this->Models->select_data($select, 'uv_knlv', $join, $condition, $order_by, $start, $perpage);
			$work_infor = $work_infor->result_array();

			$data['work_infor'] = $work_infor;

			$select = 'uv_id,uv_name,uv_city,uv_cat,uv_avatar,uv_createtime,uv_alias';
			$cat_tn = explode(',', $data['infor']['uv_cat']);
			$cat_tn = $cat_tn[0];
			$data['cat_tn'] = $cat_tn;
			$condition = 'FIND_IN_SET(' . $cat_tn . ',uv_cat) > 0';

			$uvtiemnang = $this->Models->select_data($select, 'user_uv', $join, $condition, $order_by, 0, 7);
			$uvtiemnang = $uvtiemnang->result_array();
			$data['uvtn'] = $uvtiemnang;

			if (isset($_COOKIE['UserId']) && isset($_COOKIE['Type']) && $_COOKIE['Type'] == 4) {
				$data['check_save_uv']   =  $this->Models->select_sql('save_uv', '*', array('id_ntd' => $_COOKIE['UserId'], 'id_uv' => $id), null, null, null, null, null, 0);
				$data['check_see_uv']   =  $this->Models->select_sql('see_uv', 'see_uv.*, user_uv.uv_email, user_uv.uv_phone', array('see_uv.id_ntd' => $_COOKIE['UserId'], 'see_uv.id_uv' => $id), null, array('user_uv' => 'see_uv.id_uv = user_uv.uv_id'), null, null, null, 0);
			}

			//view ứng viên
			$view_uv = $data['infor']['uv_view'];
			$view_uv = $view_uv + 1;
			$update = $this->Models->update_data('user_uv', array('uv_view' => $view_uv), array('uv_id' => $id));
		} else {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: /page-404");
		}
		$data['robot'] 		= ''; // seo
		$data['title'] 		= ' Ứng viên ' . $infor[0]['uv_name'] . '- id:' . $id; // seo
		$data['keyword'] 	= 'Ứng viên ' . $infor[0]['uv_name'] . '- id:' . $id; // seo
		$data['canonical'] 	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // seo
		$data['ogImage'] 	= 'https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png'; // seo
		$data['description'] = ' Ứng viên ' . $infor[0]['uv_name'] . '- id:' . $id . ' ứng viên đang tìm kiếm việc làm theo giờ. Tham khảo ngay công việc của ứng viên'; // seo
		$data['content'] = 'ungvien/detail_uv';
		$data['css'] = array('includes/search_form', 'ungvien/detail_uv', 'includes/popup_dang_nhap');
		$data['js'] = array('includes/search_form', 'ungvien/detail_uv', 'includes/popup_dang_nhap');

		$this->load->view('template', $data, FALSE);
	}
}
