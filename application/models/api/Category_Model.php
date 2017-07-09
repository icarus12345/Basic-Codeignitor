<?php

/*
  Project     : 48c6c450f1a4a0cc53d9585dc0fee742
  Created on  : Mar 16, 2013, 11:29:15 PM
  Author      : Truong Khuong - khuongxuantruong@gmail.com
  Description :
  Purpose of the stylesheet follows.
 */

class Category_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_list(){
        $query=$this->db
            ->select('id,title,pid,created,modified,data')
            ->where("type", 'risk')
            ->where("status", '1')
            ->get('tbl_category');

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $entrys = $query->result();
        if($entrys) foreach ($entrys as $key => $value) {
                $data = unserialize($entrys[$key]->data);
                $entrys[$key]->desc = $data['desc'];
                unset($entrys[$key]->data);
        }
        return $entrys;
    }
    function get_by_pid($pid=0){
        $query=$this->db
            ->select('id,title,pid,created,modified,status,value,child_num,quest_num,total_num')
            ->where("pid", $pid)
            ->where("status", '1')
            ->get('risk_cate');

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        return $query->result();
    }
    function get_by_id($id=0){
        $query=$this->db
            ->select('id,title,data')
            ->where("id", $id)
            ->where("status", '1')
            ->get('tbl_category');

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        $row = $query->row();
        if($row){
            $row->data = unserialize($row->data);
        }
        return $query->row();
    }
    function get_answer_number($uid,$pid){
        $query=$this->db
            ->select('tbl_category.id,tbl_category.title,tbl_category.value,tbl_category.pid,sum(risk_answer.num) AS answered_num')
            ->from('tbl_category')
            ->join('risk_answer','CONCAT(`risk_answer`.`value`, ">") LIKE CONCAT("%>", `tbl_category`.`id`, ">%")','left')
            ->where("tbl_category.type", 'risk')
            ->where("risk_answer.uid", $uid)
            ->where("risk_answer.pid", $pid)
            ->group_by(array('tbl_category.id','tbl_category.title','tbl_category.value','tbl_category.pid'))
            ->get();

        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']!==0){
            return null;
        }
        return $query->result();
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

    function buildTreeArray(array $elements, $pid = 0,$level=0,$p_title='',$path='',$value='') {
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
                $elements[$i]->_value=">".$elements[$i]->id;
            }
        }
        $branch = array();
        foreach ($elements as $element) {
            if ($element->pid == $pid) {
                $element->level=$level;
                $element->p_title=$p_title;
                $element->display=repeater('----',$level).$element->title;
                $element->display=$path."/".$element->title;
                $element->_value=$value.">".$element->id;
                $element->isparent = 0;
                $children = $this->buildTreeArray($elements, $element->id,$level+1,$element->title,$path.'/'.$element->title,$value.">".$element->id);
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
