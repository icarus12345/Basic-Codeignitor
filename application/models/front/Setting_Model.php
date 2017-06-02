<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_Model extends CI_Model {
    private $configs;
    function __construct($table = 'tbl_setting') {
        parent::__construct();
        $this->table = $table;
        $this->prefix = '';
        $this->colid = 'id';
        
    }

    function select($fields){
        $this->db->select($fields);
        return $this;
    }

    function set_type($type = null){
        $this->db
            ->where("{$this->table}.{$this->prefix}type", $type);
        return $this;
    }
    function CALC_FOUND_ROWS(){
        $this->db->select("SQL_CALC_FOUND_ROWS {$this->table}.id as uid",false);
        return $this;
    }

    function limit($page=1,$perpage = 10){
        
        $this->db->limit($perpage, ($page - 1) * $perpage);
        return $this;
    }
    
    function get($id) {
        if($this->status){
            $this->db->where("{$this->table}.{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->table}.{$this->prefix}{$this->colid}", $id)
            ->get($this->table);
        $row = $query->row();
        if($row) {
            $data = $this->prefix.'data';
            $longdata = $this->prefix.'longdata';
            if(!empty($row->$data)) $row->$data = unserialize($row->$data);
        }
        return $row;
    }
    function get_by_alias($alias) {
        if($this->status){
            $this->db->where("{$this->table}.{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->table}.{$this->prefix}alias", $alias)
            ->get($this->table);
        $row = $query->row();
        if($row) {
            $data = $this->prefix.'data';
            $longdata = $this->prefix.'longdata';
            if(!empty($row->$data)) $row->$data = unserialize($row->$data);
        }
        return $row;
    }
    function get_by_type($type=''){
        if($this->status){
            $this->db->where("{$this->table}.{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->table}.{$this->prefix}type", $type)
            ->get($this->table);
        $entrys = $query->result();
        if($entrys) foreach ($entrys as $key => $value) {
            $data = $this->prefix.'data';
            $longdata = $this->prefix.'longdata';
            if(!empty($entrys[$key]->$data)) $entrys[$key]->$data = unserialize($entrys[$key]->$data);
        }
        return $entrys;
    }
    function gets() {
        if($this->status){
            $this->db->where("{$this->table}.{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->from($this->table)
            ->order_by("{$this->table}.created", 'DESC')
            ->get();
        $entrys = $query->result();
        if($entrys) foreach ($entrys as $key => $value) {
            $data = $this->prefix.'data';
            $longdata = $this->prefix.'longdata';
            if(!empty($entrys[$key]->$data)) $entrys[$key]->$data = unserialize($entrys[$key]->$data);
        }
        return $entrys;
    }

    function get_list($type=null){
        if(!empty($type)){
            $entrys = $this->get_by_type($type);
            
        }else{
            $entrys = $this->gets();
        }
        $rs = array();
        foreach ($entrys as $key => $value) {
            $rs[$value->alias] = $value;
        }
        return $rs;
    }
}