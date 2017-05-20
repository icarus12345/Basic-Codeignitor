<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Category_Model extends Core_Model {

    function __construct()
    {
        parent::__construct('tbl_category','','id');
        $this->status = '1';
    }
    
    function select($fields){
        $this->db->select($fields);
        return $this;
    }

    function set_type($type = null){
        $this->db
            ->where("type", $type);
        return $this;
    }

    function asc(){
        $this->db->order_by('sorting','ASC');
        return $this;
    }

    function desc(){
        $this->db->order_by('sorting','DESC');
        return $this;
    }

    function get($id) {
        if($this->status){
            $this->db->where("status",$this->status);
        }
        $query = $this->db
            ->where("{$this->prefix}{$this->colid}", $id)
            ->get($this->table);
        $row = $query->row();
        if($row) {
            $data = $this->prefix.'data';
            if(!empty($row->$data)) $row->$data = unserialize($row->$data);
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
            if(!empty($entrys->$data)) $entrys[$key]->data = unserialize($entrys[$key]->data);
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
            $entrys[$key]->data = unserialize($entrys[$key]->data);
        }
        return $entrys;
    }

    function buildTree(array $elements, $pid = 0,$parents=array(0)) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element->pid == $pid) {
                $tmp=$parents;$tmp[]=$element->id;
                $children = $this->buildTree($elements, $element->id,$tmp);
                if ($children) {
                    $element->children = $children;
                }
                $element->parents=$parents;
                $branch[] = $element;
            }
        }
        return $branch;
    }

    function buildTreeArray(array $elements, $pid = 0,$level=0,$p_title='',$path='') {
        if($pid==0){
            for ($i=0;$i<count($elements);$i++) {
                $f=false;
                
                for ($j=0;$j<count($elements);$j++) {
                    if( 
                        $elements[$i]->pid==$elements[$j]->id &&
                        $elements[$i]->type==$elements[$j]->type
                    ){
                        $f=true;
                        break;
                    }
                }
                if($f==false){
                    $elements[$i]->pid=0;
                    $elements[$i]->p_title='';
                    $elements[$i]->error='parent not exist';
                    $elements[$i]->path='';
                }
                if($elements[$i]->pid==$elements[$i]->id){
                    $elements[$i]->pid=0;
                    $elements[$i]->p_title='';
                    $elements[$i]->path='';
                    $elements[$i]->error=2;
                }
            }
        }
        $branch = array();
        foreach ($elements as $element) {
            if ($element->pid == $pid) {
                $element->level=$level;
                $element->p_title=$p_title;
                $element->display=repeater('----',$level).$element->title;
                $element->display=$path."/".$element->title;
                $element->isparent = 0;
                $children = $this->buildTreeArray($elements, $element->id,$level+1,$element->title,$path.'/'.$element->title);
                if (!empty($children)) $element->isparent = 1;
                $branch[] = $element;
                if (!empty($children)){

                    foreach ($children as $ch){
                        $branch[] = $ch;
                    }
                }
            }
        }
        return $branch;
    }
}

?>
