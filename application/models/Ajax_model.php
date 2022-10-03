<?php

class Ajax_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }


    public function check_email_ntd($email)
    {
        $this->db->select('ntd_email');
        $this->db->where('ntd_email',$email);
        $query = $this->db->get('user_ntd');
        return $query->result_array();
    }

    
    public function check_alias_ntd($name)
    { 
        $alias = vn_str_filter($name);
        $this->db->select('ntd_alias');
        $this->db->where('ntd_alias',$alias);
        $query = $this->db->get('user_ntd');
        return $query->result_array();
    }

    public function dang_ky_ntd($ntd_email,$ntd_number,$ntd_password,$n_city,$n_qh,$ntd_address,$ntd_name)
    {
        $code = rand(1000000, 9999999);
        $ntd_alias = vn_str_filter($ntd_name);
        $data = array(
            'ntd_email' => $ntd_email,
            'ntd_phone' => $ntd_number,
            'ntd_password' => $ntd_password,
            'ntd_city' => $n_city,
            'ntd_quanhuyen' => $n_qh,
            'ntd_address' => $ntd_address,
            'ntd_company' => $ntd_name,
            'ntd_alias' => $ntd_alias,
            'ntd_authentic' => 0,
            'ntd_sign_up_from' => 1,
            'ntd_token' => $code,
        );
        $this->db->insert('user_ntd', $data);
        $result = ['id' => $this->db->insert_id(), 'token' => $code];
        return $result;
    }


    public function check_email_uv($email)
    {
        $this->db->select('uv_email');
        $this->db->where('uv_email',$email);
        $query = $this->db->get('user_uv');
        return $query->result_array();
    }

    public function dang_ky_uv($n_dky_name,$n_dky_email,$n_dky_pwd,$n_city,$n_qh,$n_addr,$n_cate,$n_cv,$n_city_hope,$n_tel ,$ca_lam)
    {
        $code = rand(1000000, 9999999);
        $data = array(
            'uv_name' => $n_dky_name,
            'uv_email' => $n_dky_email,
            'uv_pass' => $n_dky_pwd,
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
        );
        $this->db->insert('user_uv', $data);
    }

    

}