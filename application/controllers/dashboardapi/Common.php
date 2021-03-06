<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends DApi_Controller {
    function __construct() {
        parent::__construct();
        $this->Module_Model = new Core_Model('tbl_module');
        $this->load->model("dashboard/Category_Model");
    }
    
    function index(){
        echo 'Welcome API';
    }
    public $rules = array(
        'unique' => array(
            'data[title]' => array(
                'field'=>'data[title]',
                'label'=>'Title',
                'rules'=>'callback_title_check'
            ),
        ),
        'insert' => array(
            'data[title]' => array(
                'field'=>'data[title]',
                'label'=>'Title',
                'rules'=>'trim|required|max_length[255]'
                ),
            'data[alias]' => array(
                'field'=>'data[alias]',
                'label'=>'Alias',
                'rules'=>'trim|required|max_length[255]'
                ),
            'data[type]' => array(
                'field'=>'data[type]',
                'label'=>'Type',
                'rules'=>'trim|required|max_length[50]'
                ),
            'data[category]' => array(
                'field'=>'data[category]',
                'label'=>'Category',
                'rules'=>'trim|integer'
                ),
            'sid' => array(
                'field'=>'sid',
                'label'=>'Setting Entry',
                'rules'=>'trim|required|is_natural_no_zero',
                'errors' => array (
                    // 'required' => 'Error Message rule "required" for field Type',
                    // 'trim' => 'Error message for rule "trim" for field email',
                )
            ),
        ),
        'update' => array(
            'data[title]' => array(
                'field'=>'data[title]',
                'label'=>'Title',
                'rules'=>'trim|required|max_length[255]'
                ),
            'data[alias]' => array(
                'field'=>'data[alias]',
                'label'=>'Alias',
                'rules'=>'trim|required|max_length[255]'
                ),
            'data[type]' => array(
                'field'=>'data[type]',
                'label'=>'Type',
                'rules'=>'trim|required|max_length[50]'
                ),
            'data[category]' => array(
                'field'=>'data[category]',
                'label'=>'Category',
                'rules'=>'trim|integer'
                ),

            'sid' => array(
                'field'=>'sid',
                'label'=>'Setting Entry',
                'rules'=>'trim|required|is_natural_no_zero',
                'errors' => array (
                    // 'required' => 'Error Message rule "required" for field Type',
                    // 'trim' => 'Error message for rule "trim" for field email',
                )
            ),
            'id' => array(
                'field'=>'id',
                'label'=>'Id',
                'rules'=>'trim|is_natural_no_zero|required'
            ),
        )
    );
    public function title_check($str){
        $alias = $this->input->post('data[alias]');
        $type = $this->input->post('data[type]');
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $row = $this->Core_Model
            ->set_type($type)
            ->get_by_alias($alias);
        if($row && $row->id!=$id){
            $this->form_validation->set_message('title_check', 'The {field} field are already inserted');
            return FALSE;
        }
        return TRUE;
    }
    function detail(){
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => null
        );
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $onlysave = $this->input->post('onlysave');
        if(!empty($sid)) {
            $entry_setting = $this->Module_Model->get($sid);
            if($entry_setting){
                if(
                    !empty($entry_setting->data['catetype']) &&
                    (
                        $entry_setting->data['cateviewer'] == 'tree' ||
                        $entry_setting->data['cateviewer'] == 'list'
                    )
                    ){
                    $cat_type = $entry_setting->data['catetype'];
                    $cate_data = $this->Category_Model->get_by_type($cat_type);
                    $entry_setting->data['categories'] = $this->Category_Model
                        ->buildTreeArray($cate_data);
                }
                if(!empty($entry_setting->data['columns'])) foreach ($entry_setting->data['columns'] as $key => $column) {
                    if($column['type'] == 'catetree'){
                        $cat_type = $column['name'];
                        $cate_data = $this->Category_Model->get_by_type($cat_type);
                        $entry_setting->data['columns'][$key]['categories'] = $this->Category_Model
                            ->buildTreeArray($cate_data);
                    } else if($column['type'] == 'catelist'){
                        $cat_type = $column['name'];
                        $cate_data = $this->Category_Model->get_by_type($cat_type);
                        $entry_setting->data['columns'][$key]['categories'] = $cate_data;
                    }
                }
                $this->load->vars(array(
                    'entry_setting' => $entry_setting
                ));
                $storage = $entry_setting->data['storage'];
                if(!empty($storage)){
                    if(!empty($id)) {
                        if($entry_setting->data['add']=='false'){
                            $output['code'] = -1;
                            $output['message'] = 'Access Denied .';
                        }
                        $this->Core_Model = new Core_Model($storage);
                        $entry_detail = $this->Core_Model->get($id);
                        $this->load->vars(array(
                            'entry_detail' => $entry_detail,
                            'onlysave'=>$onlysave
                            ));
                        $output['data'] = $entry_detail;
                    } else{
                        if($entry_setting->data['add']=='false'){
                            $output['code'] = -1;
                            $output['message'] = 'Access Denied .';
                        }
                    }
                    $output['html'] = $this->load->view('dashboard/forms/common_detail',null,true);
                } else {
                    $output['text'] = 'fail';
                    $output['code'] = -1;
                    $output['message'] = 'Storage does\'t exitst.';
                }
            } else {
                $output['text'] = 'fail';
                $output['code'] = -1;
                $output['message'] = 'Setting does\'t exitst.';
            }
        };
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    function subdetail(){
        $output = array(
            'text' => 'ok',
            'code' => 1,
            'data' => null
        );
        $data = $this->input->post('data');
        $sid = $this->input->post('sid');
        if(!empty($sid)) {
            $entry_setting = $this->Module_Model->get($sid);
            if($entry_setting){
                if(
                    !empty($entry_setting->data['catetype']) &&
                    (
                        $entry_setting->data['cateviewer'] == 'tree' ||
                        $entry_setting->data['cateviewer'] == 'list'
                    )
                    ){
                    $cat_type = $entry_setting->data['catetype'];
                    $cate_data = $this->Category_Model->get_by_type($cat_type);
                    $entry_setting->data['categories'] = $this->Category_Model
                        ->buildTreeArray($cate_data);
                }
                if(!empty($entry_setting->data['columns'])) foreach ($entry_setting->data['columns'] as $key => $column) {
                    if($column['type'] == 'catetree'){
                        $cat_type = $column['name'];
                        $cate_data = $this->Category_Model->get_by_type($cat_type);
                        $entry_setting->data['columns'][$key]['categories'] = $this->Category_Model
                            ->buildTreeArray($cate_data);
                    } else if($column['type'] == 'catelist'){
                        $cat_type = $column['name'];
                        $cate_data = $this->Category_Model->get_by_type($cat_type);
                        $entry_setting->data['columns'][$key]['categories'] = $cate_data;
                    }
                }
                $this->load->vars(array(
                    'entry_setting' => $entry_setting
                ));
                $storage = $entry_setting->data['storage'];
                if(!empty($storage)){
                    if(!empty($data)) {
                        $this->load->vars(array(
                            'entry_detail' => (object)$data
                            ));
                        $output['data'] = $data;
                    }
                    $output['html'] = $this->load->view('dashboard/forms/subcommon_detail',null,true);
                } else {
                    $output['text'] = 'fail';
                    $output['code'] = -1;
                    $output['message'] = 'Storage does\'t exitst.';
                }
            } else {
                $output['text'] = 'fail';
                $output['code'] = -1;
                $output['message'] = 'Setting does\'t exitst.';
            }
        }
        ;
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    function commit(){
        $id = $this->input->post('id');
        if(!empty($id)) $this->onupdate();
        else $this->oncreate();
    }

    function update(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $title = $this->input->post('data[title]');
        $alias = $this->input->post('data[alias]');
        $type = $this->input->post('data[type]');
        $status = $this->input->post('data[status]');
        $category = $this->input->post('data[category]');
        $data = $this->input->post('data[data]');
        $longdata = $this->input->post('data[longdata]');

        $entry_setting = $this->Module_Model->get($sid);
        if($entry_setting){
            $storage = $entry_setting->data['storage'];
            $this->Core_Model = new Core_Model($storage);
            if($entry_setting->data['columns']) foreach ($entry_setting->data['columns'] as $key => $column) {
                if(!empty($column['server'])){
                    $label = $column['title'];
                    $rule = $column['server'];
                    if($column['biz'] == '1'){
                        $field = 'data[longdata]['.$column['name'].']';
                        if(isset($longdata)) foreach ($longdata as $key => $value) {
                            if($key == $field) $this->form_validation->set_rules($field,$label,$rule);
                        }
                    } else {
                        $field = 'data[data]['.$column['name'].']';
                        if(isset($data)) foreach ($data as $key => $value) {
                            if($key == $field) $this->form_validation->set_rules($field,$label,$rule);
                        }
                    }
                    
                    
                    
                }
            }
            // $this->form_validation->set_rules($this->rules['update']);
            // if ($this->form_validation->run() == FALSE) {
                // $output['validation'] = validation_errors_array();
                // $output['message'] = validation_errors();
                // $output['code'] = -1;
            // } else {

                $params = array();
                
                if(isset($category)) $params['category'] = $category;
                if(isset($title)) $params['title'] = $title;
                if(isset($alias)) $params['alias'] = $alias;
                if(isset($type)) $params['type'] = $type;
                if(isset($status)) $params['status'] = $status;
                if(isset($data)) $params['data'] = serialize($data);
                if(isset($longdata)) $params['longdata'] = serialize($longdata);
                $entry_detail = $this->Core_Model->get($id);
                if($entry_detail){
                    if(isset($data)){
                        foreach ($data as $key => $value) {
                            $entry_detail->data[$key] = $value;
                        }
                        $params['data'] = serialize($entry_detail->data);
                    }
                    if(isset($longdata)){
                        foreach ($longdata as $key => $value) {
                            $entry_detail->longdata[$key] = $value;
                        }
                        $params['longdata'] = serialize($entry_detail->longdata);
                    }
                    $rs = $this->Core_Model->onUpdate($id, $params);
                    if ($rs === true) {
                        $output["code"] = 1;
                        $output["text"] = 'ok';
                        $output["message"] = 'Register Entry to database.';
                    } else {
                        $output["code"] = -1;
                        $output["message"] = "Entry faily to insert. Please check data input and try again.";
                    }
                }else{
                    $output["message"] = 'Entry doest exists.';
                }
            // }
        } else {
            $output["message"] = 'Setting Entry doest exists.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    public function onupdate(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $user = $this->session->userdata('dasbboard_user');
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $title = $this->input->post('data[title]');
        $alias = $this->input->post('data[alias]');
        $type = $this->input->post('data[type]');
        $status = $this->input->post('data[status]');
        $category = $this->input->post('data[category]');
        $data = $this->input->post('data[data]');
        $longdata = $this->input->post('data[longdata]');

        $entry_setting = $this->Module_Model->get($sid);
        $this->entry_setting = $entry_setting;
        if($entry_setting){
            $storage = $entry_setting->data['storage'];
            $this->Core_Model = new Core_Model($storage);
            if($entry_setting->data['columns']) foreach ($entry_setting->data['columns'] as $key => $column) {
                if(!empty($column['server'])){
                    $field = 'data[data]['.$column['name'].']';
                    if($column['biz'] == '1'){
                        $field = 'data[longdata]['.$column['name'].']';
                    }
                    $label = $column['title'];
                    $rule = $column['server'];
                    $this->form_validation->set_rules($field,$label,$rule);
                }
            }
            $this->form_validation->set_rules($this->rules['update']);
            if($entry_setting->data['unique'] == 'true'){
                $this->form_validation->set_rules($this->rules['unique']);
            }
            if ($this->form_validation->run() == FALSE) {
                $output['validation'] = validation_errors_array();
                $output['message'] = validation_errors();
                // $output['code'] = -1;
            } else {

                $params = array();
                
                if(isset($category)) $params['category'] = $category;
                if(isset($title)) $params['title'] = $title;
                if(isset($alias)) $params['alias'] = $alias;
                if(isset($type)) $params['type'] = $type;
                if(isset($status)) $params['status'] = $status;;
                if(isset($data)) $params['data'] = serialize($data);
                if(isset($longdata)) $params['longdata'] = serialize($longdata);

                
                $entry_detail = $this->Core_Model->get($id);
                if($entry_detail){
                    // if(empty($entry_detail->author)) 
                        $params['author'] = $user->ause_id;
                    if(isset($data)){
                        foreach ($data as $key => $value) {
                            $entry_detail->data[$key] = $value;
                        }
                        $params['data'] = serialize($entry_detail->data);
                    }
                    if(isset($longdata)){
                        foreach ($longdata as $key => $value) {
                            $entry_detail->longdata[$key] = $value;
                        }
                        $params['longdata'] = serialize($entry_detail->longdata);
                    }
                    $rs = $this->Core_Model->onUpdate($id, $params);
                    if ($rs === true) {
                        $output["code"] = 1;
                        $output["text"] = 'ok';
                        $output["message"] = 'Register Entry to database.';
                    } else {
                        $output["code"] = -1;
                        $output["message"] = "Entry faily to insert. Please check data input and try again.";
                    }
                }else{
                    $output["message"] = 'Entry doest exists.';
                }
            }
        } else {
            $output["message"] = 'Setting Entry doest exists.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    public function oncreate(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $user = $this->session->userdata('dasbboard_user');
        $sid = $this->input->post('sid');
        $title = $this->input->post('data[title]');
        $alias = $this->input->post('data[alias]');
        $type = $this->input->post('data[type]');
        $category = $this->input->post('data[category]');
        $data = $this->input->post('data[data]');
        $longdata = $this->input->post('data[longdata]');

        $entry_setting = $this->Module_Model->get($sid);
        $this->entry_setting = $entry_setting;
        if($entry_setting){
            $storage = $entry_setting->data['storage'];
            $this->Core_Model = new Core_Model($storage);
            if($entry_setting->data['columns']) foreach ($entry_setting->data['columns'] as $key => $column) {
                if(!empty($column['server'])){
                    $field = 'data[data]['.$column['name'].']';
                    if($column['biz'] == '1'){
                        $field = 'data[longdata]['.$column['name'].']';
                    }
                    $label = $column['title'];
                    $rule = $column['server'];
                    $this->form_validation->set_rules($field,$label,$rule);
                }
            }
            $this->form_validation->set_rules($this->rules['insert']);
            if($entry_setting->data['unique'] == 'true'){
                $this->form_validation->set_rules($this->rules['unique']);
            }
            if ($this->form_validation->run() == FALSE) {
                $output['validation'] = validation_errors_array();
                $output['message'] = validation_errors();
                // $output['code'] = -1;
            } else {

                $params = array();
                
                if(isset($category)) $params['category'] = $category;
                if(isset($title)) $params['title'] = $title;
                if(isset($alias)) $params['alias'] = $alias;
                if(isset($type)) $params['type'] = $type;
                if(isset($data)) $params['data'] = serialize($data);
                if(isset($longdata)) $params['longdata'] = serialize($longdata);
                $params['status'] = 1;
                $params['author'] = $user->ause_id;

                
                $rs = $this->Core_Model->onInsert($params);
                if ($rs === true) {
                    $output["code"] = 1;
                    $output["text"] = 'ok';
                    $output["message"] = 'Register record to database.';
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Record faily to insert. Please check data input and try again.";
                }
            }
        } else {
            $output["message"] = 'Setting Entry doest exists.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    public function sendlatest(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $entry_setting = $this->Module_Model->get($sid);
        $this->entry_setting = $entry_setting;
        if($entry_setting){
            $storage = $entry_setting->data['storage'];
            $this->Core_Model = new Core_Model($storage);
            
            $entry_detail = $this->Core_Model->get($id);
            if($entry_detail){
                
                $rs = $this->Core_Model->onSendLatest($id);
                if ($rs === true) {
                    $output["code"] = 1;
                    $output["text"] = 'ok';
                    $output["message"] = 'Success.';
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Entry faily to update. Please check data input and try again.";
                }
            }else{
                $output["message"] = 'Entry doest exists.';
            }
        } else {
            $output["message"] = 'Setting Entry doest exists.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }

    public function sendoldest(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $entry_setting = $this->Module_Model->get($sid);
        $this->entry_setting = $entry_setting;
        if($entry_setting){
            $storage = $entry_setting->data['storage'];
            $this->Core_Model = new Core_Model($storage);
            
            $entry_detail = $this->Core_Model->get($id);
            if($entry_detail){
                
                $rs = $this->Core_Model->onSendOldest($id);
                if ($rs === true) {
                    $output["code"] = 1;
                    $output["text"] = 'ok';
                    $output["message"] = 'Success.';
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Entry faily to update. Please check data input and try again.";
                }
            }else{
                $output["message"] = 'Entry doest exists.';
            }
        } else {
            $output["message"] = 'Setting Entry doest exists.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
    public function delete(){
        $output = array(
            'text' => 'fail',
            'code' => -1,
            'data' => null
        );
        $id = $this->input->post('id');
        $sid = $this->input->post('sid');
        $entry_setting = $this->Module_Model->get($sid);
        $this->entry_setting = $entry_setting;
        if($entry_setting){
            $storage = $entry_setting->data['storage'];
            $this->Core_Model = new Core_Model($storage);
            
            $entry_detail = $this->Core_Model->get($id);
            if($entry_detail){
                
                $rs = $this->Core_Model->onDelete($id);
                if ($rs === true) {
                    $output["code"] = 1;
                    $output["text"] = 'ok';
                    $output["message"] = 'Deleted record on database.';
                } else {
                    $output["code"] = -1;
                    $output["message"] = "Record faily to delete. Please check data input and try again.";
                }
            }else{
                $output["message"] = 'Record doest exists.';
            }
        } else {
            $output["message"] = 'Setting Entry doest exists.';
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($output));
    }
}
