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
            ->where("{$this->prefix}type", $type);
        return $this;
    }
    
    function get($id) {
        if($this->status){
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->prefix}{$this->colid}", $id)
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
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->prefix}alias", $alias)
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
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->prefix}type", $type)
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
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->prefix}category", $catid)
            ->get($this->table);
        $entrys = $query->result();
        if($entrys) foreach ($entrys as $key => $value) {
            $entrys[$key]->data = unserialize($entrys[$key]->data);
        }
        return $entrys;
    }
    function gets() {
        if($this->status){
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->from($this->table)
            ->order_by($this->prefix . 'created', 'DESC')
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
        $this->db->order_by('sorting','ASC');
        return $this;
    }

    function desc(){
        $this->db->order_by('sorting','DESC');
        return $this;
    }

    function random(){
        $this->db->order_by('rand()');
        return $this;
    }

    function limit($n = 1){
        $this->db->limit($n);
        return $this;
    }

    function get_related($row){
        if(!$row) return null;
        if($this->status){
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->prefix}type", $row->type)
            ->where("{$this->prefix}id !=", $row->id)
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