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
    }
    function get_common(){
        $query=$this->db
            ->select('id,title')
            ->where("type", '-1')
            ->get($this->table);

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

    function updateNodeByParent($Parent=0,$NewParent=0){
        // $this->db->set('update', 'NOW()', FALSE);
        $this->db->where('pid', $Parent);
        @$this->db->update($this->table, array('pid'=>$NewParent));
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count > 0)
            return true;
        return false;
    }
}

?>
