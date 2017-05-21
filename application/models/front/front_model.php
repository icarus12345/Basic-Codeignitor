<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front_Model extends CI_Model {
    private $configs;
    function __construct($table = '') {
        parent::__construct();
        $this->table = $table;
        $this->prefix = '';
        $this->colid = 'id';
        $this->status = '1';
        
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
            if(!empty($row->$longdata)) $row->$longdata = unserialize($row->$longdata);
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
            if(!empty($row->$longdata)) $row->$longdata = unserialize($row->$longdata);
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
            if(!empty($entrys[$key]->$data)) $entrys[$key]->data = unserialize($entrys[$key]->data);
            // if(!empty($entrys->$longdata)) $entrys->$longdata = unserialize($entrys->$longdata);
        }
        return $entrys;
    }
    function get_by_category($catid=''){
        if($this->status){
            $this->db->where("{$this->table}.{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->table}.{$this->prefix}category", $catid)
            ->get($this->table);
        $entrys = $query->result();
        if($entrys) foreach ($entrys as $key => $value) {
            $entrys[$key]->data = unserialize($entrys[$key]->data);
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
            if(!empty($entrys[$key]->$data)) $entrys[$key]->data = unserialize($entrys[$key]->data);
        }
        return $entrys;
    }

    function asc(){
        $this->db->order_by("{$this->table}.sorting",'ASC');
        return $this;
    }

    function desc(){
        $this->db->order_by("{$this->table}.sorting",'DESC');
        return $this;
    }

    function random(){
        $this->db->order_by('rand()');
        return $this;
    }
    function join_category(){
        $this->db->select('tbl_category.title as ctitle',false);
        $this->db->select("$this->table.*",false);
        $this->db->join('tbl_category', 'category = tbl_category.id', 'left');
        return $this;
    }
    function get_related($row){
        if(!$row) return null;
        if($this->status){
            $this->db->where("{$this->table}.{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->table}.{$this->prefix}type", $row->type)
            ->where("{$this->table}.{$this->prefix}id !=", $row->id)
            ->get($this->table);
        $entrys = $query->result();
        if($entrys) foreach ($entrys as $key => $value) {
            $data = $this->prefix.'data';
            $longdata = $this->prefix.'longdata';
            if(!empty($entrys[$key]->$data)) $entrys[$key]->data = unserialize($entrys[$key]->data);
            // if(!empty($entrys->$longdata)) $entrys->$longdata = unserialize($entrys->$longdata);
        }
        return $entrys;
    }
}