<?php

class Models extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_data($tbl, $data, $condition)
    {
        $this->db->update($tbl, $data, $condition);
    }

    public function delete_data($table, $condition)
    {
        return $this->db->delete($table, $condition);
        // Delete from uv_knlv where id_knlv = ''
    }

    public function select_data($select, $table, $join = [], $condition = '', $oder_by = '', $start = '', $perpage = '')
    {
        $this->db->select($select);
        $this->db->from($table);
        if (count($join) > 0) {
            foreach ($join as $value) {
                $this->db->join($value['table'], $value['on']);
            }
        }
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($start >= 0 && $perpage > 0) {
            // echo 'abc';
            $this->db->limit($perpage, $start);
        }
        // order_by('title DESC, name ASC') == ORDER BY `title` DESC, `name` ASC
        if ($oder_by != '') {
            $this->db->order_by($oder_by);
        }
        // echo $this->db->last_query();
        return $this->db->get();
    }

    public function select_data2($select, $table, $join, $condition, $oder_by, $start, $perpage)
    {
        $this->db->select($select);
        $this->db->from($table);
        if (count($join) > 0) {
            foreach ($join as $value) {
                $this->db->join($value['table'], $value['on']);
            }
        }
        // var_dump($condition);
        if ($condition != '') {
            $this->db->where($condition);
        }
        // echo $start; echo $perpage;
        if ($start >= 0 && $perpage > 0) {
            // echo 'abc';
            $this->db->limit($perpage, $start);
        }
        // order_by('title DESC, name ASC') == ORDER BY `title` DESC, `name` ASC
        if ($oder_by != '') {
            $this->db->order_by($oder_by);
        }

        return $this->db->get();
    }

    public function select_where_and($select, $table, $condition)
    {
        // $condition là 1 mảng các điều kiện hoặc 1 câu sql điều kiện 
        // vd: $condition=['id'=>$id, 'value >'=>$value] <=> $condition='id=$id AND value>$value'
        $this->db->select($select);
        $this->db->from($table);
        if ($condition != '') {
            $this->db->where($condition);
        }
        // $this->db->get();
        // var_dump($this->db->last_query());die;  
        return $this->db->get();
    }

    public function update_where_and($data, $table, $condition)
    {
        $this->db->where($condition);
        return $this->db->update($table, $data);
    }
    public function select_sql($tbl, $data, $condition, $like, $join, $orderBy, $start, $limit, $is_multi = 1)
    {
        $this->db->select($data);
        $this->db->from($tbl);
        if ($join != null) {
            foreach ($join as $key => $value) {
                $this->db->join($key, $value);
            }
        }
        if ($condition != null) {
            foreach ($condition as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($like != null) {
            foreach ($like as $key => $value) {
                $this->db->like($key, $value);
            }
        }
        if ($orderBy != null) {
            foreach ($orderBy as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        if ($start != null || $limit != null) {
            $this->db->limit($start, $limit);
        }
        if ($is_multi == 1) {
            return $this->db->get()->result_array();
        } else {
            return $this->db->get()->row_array();
        }
        // var_dump($this->db->last_query());die;  
    }
    public function select_sql_or($tbl, $data, $condition, $or_like, $join, $orderBy, $start, $limit, $is_multi = 1)
    {
        $this->db->select($data);
        $this->db->from($tbl);
        if ($join != null) {
            foreach ($join as $key => $value) {
                $this->db->join($key, $value);
            }
        }
        if ($condition != null) {
            foreach ($condition as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($or_like != null) {
            $this->db->group_start();
            foreach ($or_like as $key => $value) {
                $this->db->or_like($key, $value);
            }
            $this->db->group_end();
        }
        if ($orderBy != null) {
            foreach ($orderBy as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        if ($start != null || $limit != null) {
            $this->db->limit($start, $limit);
        }
        if ($is_multi == 1) {
            return $this->db->get()->result_array();
        } else {
            return $this->db->get()->row_array();
        }
        // var_dump($this->db->last_query());die;  
    }
    public function inc_data($table, $data, $condition)
    {
        if ($data != null) {
            foreach ($data as $key => $value) {
                $this->db->set($key, $value, FALSE);
            }
        }
        if ($condition != null) {
            $this->db->where($condition);
        }
        return $this->db->update($table);
    }
    public function select_sql_like_and($tbl, $data, $condition, $like, $join, $orderBy, $start, $limit, $is_multi = 1)
    {
        $this->db->select($data);
        $this->db->from($tbl);
        if ($join != null) {
            foreach ($join as $key => $value) {
                $this->db->join($key, $value);
            }
        }
        if ($condition != null) {
            foreach ($condition as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($like != null) {
            foreach ($like as $key => $value) {
                $this->db->like($value['col'], $value['val'], '', false);
            }
        }
        if ($orderBy != null) {
            foreach ($orderBy as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        if ($start != null || $limit != null) {
            $this->db->limit($start, $limit);
        }
        if ($is_multi == 1) {
            return $this->db->get()->result_array();
        } else {
            return $this->db->get()->row_array();
        }
        // var_dump($this->db->last_query());die;  
    }
    public function interJoinPaginate($table1, $school1, $table2, $school2, $total, $start, $where = [], $orderBy)
    {
        // $sql = "SELECT {$need} FROM {$table1} INNER JOIN {$table2} ON {$table1}.{$school1} = {$table2}.{$shool2}";
        // $query = $this->db->query($sql);
        $this->db->from($table1);
        $this->db->join($table2, $table1 . '.' . $school1 . ' = '  . $table2 . '.' . $school2, 'inner');
        $this->db->where($where);
        $this->db->limit($total, $start);
        $this->db->order_by($orderBy, 'DESC');
        return $this->db->get()->result_array();
    }
    public function query()
    {
        return $this->db->last_query();
    }
}
