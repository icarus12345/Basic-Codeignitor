<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core_Model extends CI_Model {
    private $configs;
    function __construct($table = '', $prefix = '',$colid='id',$status=null) {
        parent::__construct();
        $this->table = $table;
        $this->prefix = $prefix;
        $this->colid = $colid;
        $this->status = $status;
    }
    function select($fields){
        $this->db->select($fields);
        return $this;
    }
    function get_last_insert_id() {
        $query = $this->db->query("SELECT LAST_INSERT_ID() as last_insert_id ;");
        $row = $query->row();
        return $row->last_insert_id;
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
            $row->$data = unserialize($row->$data);
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
        return $query->row();
    }
    function get_by_type($type=''){
        if($this->status){
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->where("{$this->prefix}type", $type)
            ->get($this->table);
        return $query->result();
    }
    function gets() {
        if($this->status){
            $this->db->where("{$this->prefix}status",$this->status);
        }
        $query = $this->db
            ->from($this->table)
            ->order_by($this->prefix . 'created', 'DESC')
            ->get();
        return $query->result();
    }
    function onInsert($params) {
        $this->db->set($this->prefix . 'created', 'NOW()', FALSE);
        @$this->db->insert($this->table, $params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    function onDelete($id) {
        $where = array("$this->prefix$this->colid" => $id);
        $this->db->delete($this->table, $where);
        $count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    function onUpdate($id, $params) {
        $this->db->set($this->prefix . 'modified', 'NOW()', FALSE);
        $this->db->where("$this->prefix$this->colid", $id);
        @$this->db->update($this->table, $params);
        @$count = $this->db->affected_rows(); //should return the number of rows affected by the last query
        if ($count == 1)
            return true;
        return false;
    }
    function databinding(){
        if(!isset($this->table_config)){
            if(empty($this->table)){
                echo json_encode(array('result'=>-1,'message'=>"Table invalid !"));
                die;
            }
            $this->table_config=array(
                "table"=>$this->table,
                "order_by"=>"ORDER BY `{$this->prefix}created` DESC",
                "columnmaps"=>array(
                )
            );
        }
        return $this->datatableBinding();
    }
    function jqxBinding() {
        $method=$_REQUEST;
        $pagenum = isset($method['pagenum']) ? $method['pagenum'] : 0;
        $pagesize = isset($method['pagesize']) ? $method['pagesize'] : 10;
        $start = $pagenum * $pagesize;
        
        if(!empty($this->table_config)){
            if(!empty($this->table_config["select"])){
                $FstrSQL = $select = (!empty($this->table_config["select"])?$this->table_config["select"]:"")
                    ." ".
                    (!empty($this->table_config["from"])?$this->table_config["from"]:"");
            }else{
                $FstrSQL="SELECT SQL_CALC_FOUND_ROWS `{$this->table_config["table"]}`.* FROM `{$this->table_config["table"]}`";
            }
            $where = (!empty($this->table_config["where"])?$this->table_config["where"]:"Where true");
            $strgroupby = (!empty($this->table_config["group_by"])?$this->table_config["group_by"]:"");
            $orderby = (!empty($this->table_config["order_by"])?$this->table_config["order_by"]:"");
            $fields = (!empty($this->table_config["columnmaps"])?$this->table_config["columnmaps"]:array());
            $datefields = (!empty($this->table_config["datefields"])?$this->table_config["datefields"]:array());
            $limit = "";
            if (isset($this->table_config["limit"]) && $this->table_config["limit"]) {
                $limit = "LIMIT $start, $pagesize";
            }else{
                if($pagesize==10)
                    $pagesize=1000;
                $limit = "LIMIT $start, $pagesize";
            }
        }else{
            $FstrSQL = $this->configs["strQuery"];
            $select = $this->configs["strQuery"];
            $where = $this->configs["strWhere"];
            $strgroupby = $this->configs["strGroupBy"];
            $orderby = $this->configs["strOrderBy"];
            $fields = $this->configs["fields"];
            $datefields = $this->configs["datefields"];
            $limit = "";
            if (isset($this->configs["usingLimit"]) && $this->configs["usingLimit"]) {
                $limit = "LIMIT $start, $pagesize";
            }else{
                $limit = "LIMIT 1000";
            }
        }
        
        

        if (isset($method['filterslength']) && !isset($method['filterscount'])){
            $method['filterscount'] = $method['filterslength'];
        }
        if (isset($method['filterscount'])) {
            $filterscount = $method['filterscount'];
            if ($filterscount > 0) {
                $where.= " AND (";
                $tmpdatafield = "";
                $tmpfilteroperator = "";
                for ($i = 0; $i < $filterscount; $i++) {
                    // get the filter's value.
                    $filtervalue = $method["filtervalue" . $i];
                    // get the filter's condition.
                    $filtercondition = $method["filtercondition" . $i];
                    // get the filter's column.
                    $filterdatafield = $method["filterdatafield" . $i];
                    // get the filter's operator.
                    $filteroperator = $method["filteroperator" . $i];

                    if ($filterdatafield[0] === "_" && $filterdatafield[strlen($filterdatafield) - 1] === "_") {
                        $filterdatafield = substr($filterdatafield, 1, -1);
                    }


                    if (count($datefields) > 0 && in_array($filterdatafield, $datefields)) {
                        $tmp = explode("GMT", $filtervalue);
                        if (isset($tmp[0])) {
                            $filtervalue = date("Y-m-d H:i:s", strtotime($tmp[0]));
                        }
                    }
                    $filtervalue = $this->db->escape_str($filtervalue);
                    if (count($fields) > 0 && isset($fields[$filterdatafield])) {
                        $filterdatafield = $fields[$filterdatafield];
                    } else {
                        $filterdatafield = "`$filterdatafield`";
                    }

                    //check filterdatafield
                    if ($tmpdatafield == "") {
                        $tmpdatafield = $filterdatafield;
                    } else if ($tmpdatafield <> $filterdatafield) {
                        $where .= " ) AND ( ";
                    } else if ($tmpdatafield == $filterdatafield) {
                        if ($tmpfilteroperator == 0) {
                            $where .= " AND ";
                        }
                        else
                            $where .= " OR ";
                    }

                    // build the "WHERE" clause depending on the filter's condition, value and datafield.
                    // possible conditions for string filter: 
                    //      'EMPTY', 'NOT_EMPTY', 'CONTAINS', 'CONTAINS_CASE_SENSITIVE',
                    //      'DOES_NOT_CONTAIN', 'DOES_NOT_CONTAIN_CASE_SENSITIVE', 
                    //      'STARTS_WITH', 'STARTS_WITH_CASE_SENSITIVE',
                    //      'ENDS_WITH', 'ENDS_WITH_CASE_SENSITIVE', 'EQUAL', 
                    //      'EQUAL_CASE_SENSITIVE', 'NULL', 'NOT_NULL'
                    // 
                    // possible conditions for numeric filter: 'EQUAL', 'NOT_EQUAL', 'LESS_THAN',
                    //  'LESS_THAN_OR_EQUAL', 'GREATER_THAN', 'GREATER_THAN_OR_EQUAL', 
                    //  'NULL', 'NOT_NULL'
                    //  
                    // possible conditions for date filter: 'EQUAL', 'NOT_EQUAL', 'LESS_THAN', 
                    // 'LESS_THAN_OR_EQUAL', 'GREATER_THAN', 'GREATER_THAN_OR_EQUAL', 'NULL', 
                    // 'NOT_NULL'                         

                    switch ($filtercondition) {
                        case "NULL":
                            $where .= " ($filterdatafield is null)";
                            break;
                        case "EMPTY":
                            $where .= " ($filterdatafield is null) or ($filterdatafield='')";
                            break;
                        case "NOT_NULL":
                            $where .= " ($filterdatafield is not null)";
                            break;
                        case "NOT_EMPTY":
                            $where .= " ($filterdatafield is not null) and ($filterdatafield <>'')";
                            break;
                        case "CONTAINS_CASE_SENSITIVE":
                        case "CONTAINS":
                            $where .= " $filterdatafield LIKE '%$filtervalue%'";
                            break;
                        case "DOES_NOT_CONTAIN_CASE_SENSITIVE":
                        case "DOES_NOT_CONTAIN":
                            $where .= " $filterdatafield NOT LIKE '%$filtervalue%'";
                            break;
                        case "EQUAL_CASE_SENSITIVE":
                        case "EQUAL":
                            $where .= " $filterdatafield = '$filtervalue'";
                            break;
                        case "NOT_EQUAL":
                            $where .= " $filterdatafield <> '$filtervalue'";
                            break;
                        case "GREATER_THAN":
                            $where .= " $filterdatafield > '$filtervalue'";
                            break;
                        case "LESS_THAN":
                            $where .= " $filterdatafield < '$filtervalue'";
                            break;
                        case "GREATER_THAN_OR_EQUAL":
                            $where .= " $filterdatafield >= '$filtervalue'";
                            break;
                        case "LESS_THAN_OR_EQUAL":
                            $where .= " $filterdatafield <= '$filtervalue'";
                            break;
                        case "STARTS_WITH_CASE_SENSITIVE":
                        case "STARTS_WITH":
                            $where .= " $filterdatafield LIKE '$filtervalue%'";
                            break;
                        case "ENDS_WITH_CASE_SENSITIVE":
                        case "ENDS_WITH":
                            $where .= " $filterdatafield LIKE '%$filtervalue'";
                            break;
                        default:
                            $where .= " $filterdatafield LIKE '%$filtervalue%'";
                    }

                    if ($i == $filterscount - 1) {
                        $where .= ")";
                    }

                    $tmpfilteroperator = $filteroperator;
                    $tmpdatafield = $filterdatafield;
                }
                // build the query.
            }
        }

        if (isset($method['sortdatafield'])) {
            $sortfield = $method['sortdatafield'];
            //fix sortfield
            if ($sortfield[0] === "_" && $sortfield[strlen($sortfield) - 1] === "_") {
                $sortfield = substr($sortfield, 1, -1);
            }

            if (count($fields) > 0 && isset($fields[$sortfield])) {
                $sortfield = $fields[$sortfield];
            } else {
                $sortfield = "`$sortfield`";
            }
            $sortorder = $method['sortorder'];
            if ($sortorder == "desc") {
                $SQLquery = "$FstrSQL $where $strgroupby ORDER BY $sortfield DESC $limit";
            } elseif ($sortorder == "asc") {
                $SQLquery = "$FstrSQL $where $strgroupby ORDER BY $sortfield ASC $limit";
            } else {
                $SQLquery = "$FstrSQL $where $strgroupby $orderby $limit";
            }
        } else {
            $SQLquery = "$FstrSQL $where $strgroupby $orderby $limit";
        }
        $query = $this->db->query($SQLquery);
        // $result['query'] =$SQLquery;
        $errordb = $this->db->error();
        $error_message = $errordb['message'];
        if($errordb['code']==0){
            $result['rows'] = $query->result();
            $sql = "SELECT FOUND_ROWS() AS `found_rows`;";
            $query = $this->db->query($sql);
            $rows = $query->row_array();
            $total_rows = (int)$rows['found_rows'];
            $result['totalrecords'] = $total_rows;
            $result['pagenum'] = (int)$pagenum;
            $result['pagesize'] = (int)$pagesize;
            $result['totalpages'] = ceil($result['totalrecords'] / $result['pagesize']);
        }
        return $result;
    }
    function datatableBinding() {
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        //$aColumns = array( 'engine', 'browser', 'platform', 'version', 'grade' );

        /* Indexed column (used for fast and accurate table cardinality) */
        //$sIndexColumn = "id";

        /* DB table to use */
        if(!isset($this->table_config)) $this->table_config= null;
        if(isset($this->table_config['table']))
                $sTable = $this->table_config['table'];
        else
                $sTable=$this->table;
        if (isset($this->table_config['where']))
            $sWhere = $this->table_config['where'];
        else
            $sWhere = 'WHERE true ';

        $sFrom = "FROM `$sTable`";
        if (isset($this->table_config['from'])) {
            $sFrom = $this->table_config['from'];
        }
        $method=$_REQUEST;
        $iColumns = isset($aColumns) ? count($aColumns) : (isset($method['iColumns']) ? $method['iColumns'] : 0);
        if (!isset($aColumns)) {
            for ($i = 0; $i < $iColumns; $i++) {
                if (isset($method["mDataProp_$i"]))
                    $aColumns[$i] = $method["mDataProp_$i"];
            }
        }


        /*
         * Paging
         */
        $sLimit = "";
        if (isset($method['iDisplayStart']) && $method['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($method['iDisplayStart']) . ", " .
                    intval($method['iDisplayLength']);
        }else{
            $sLimit = "LIMIT 1000";
        }


        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($method['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($method['iSortingCols']); $i++) {
                if ($method['bSortable_' . intval($method['iSortCol_' . $i])] == "true") {
                    if (isset($aColumns[intval($method['iSortCol_' . $i])])) {
                        $_colum = $aColumns[intval($method['iSortCol_' . $i])];
                    } elseif (isset($method["mDataProp_$i"])) {
                        $_colum = $method["mDataProp_$i"];
                    }
                    if (!empty($_colum)) {
                        if (isset($this->table_config['columnmaps'][$_colum])) {
                            $_colum = $this->table_config['columnmaps'][$_colum];
                        } else {
                            if ($_colum[0] !== "`" || $_colum[strlen($_colum) - 1] !== "`") {
                                $_colum = "`$_colum`";
                            }
                        }
                        $sOrder .= "$_colum " . ($method['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                    }
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        if ($sOrder == "")
            if (isset($this->table_config['order_by']))
                $sOrder = $this->table_config['order_by'];


        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($method['sSearch']) && $method['sSearch'] != "") {
            $filterfields = $aColumns;
            if(!empty($this->table_config["filterfields"])){
                $filterfields = $this->table_config["filterfields"];
            }
            if (!empty($filterfields)) {
                $sWhere .= " AND (";
                for ($i = 0; $i < count($filterfields); $i++) {
                    if (isset($method['bSearchable_' . $i]) && $method['bSearchable_' . $i] == "true") {
                        if (isset($filterfields[$i])) {
                            $_colum = $filterfields[$i];
                        } elseif (isset($method["mDataProp_$i"])) {
                            $_colum = $method["mDataProp_$i"];
                        }
                        if (!empty($_colum)) {
                            if (isset($this->table_config['columnmaps'][$_colum])) {
                                $_colum = $this->table_config['columnmaps'][$_colum];
                            } else {
                                if ($_colum[0] !== "`" || $_colum[strlen($_colum) - 1] !== "`") {
                                    $_colum = "`$_colum`";
                                }
                            }
                            $sWhere .= $_colum . " LIKE '%" . $this->db->escape_str($method['sSearch']) . "%' OR ";
                        }
                    }
                }
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')';
            }
            
        }
        
        /* Individual column filtering */
        if(!empty($aColumns))
            $filterfields = $aColumns;
        if(!empty($this->table_config["filterfields"])){
            $filterfields = $this->table_config["filterfields"];
        }
        if (!empty($filterfields)) {
            for ($i = 0; $i < count($filterfields); $i++) {
                if (
                        isset($method['bSearchable_' . $i]) && $method['bSearchable_' . $i] == "true" &&
                        $method['sSearch_' . $i] != ''
                ) {
                    if ($sWhere == "") {
                        $sWhere = "WHERE ";
                    } else {
                        $sWhere .= " AND ";
                    }
                    if (isset($filterfields[$i])) {
                        $_colum = $filterfields[$i];
                    } elseif (isset($method["mDataProp_$i"])) {
                        $_colum = $method["mDataProp_$i"];
                    }
                    if (!empty($_colum)) {
                        if (isset($this->table_config['columnmaps'][$_colum])) {
                            $_colum = $this->table_config['columnmaps'][$_colum];
                        } else {
                            if ($_colum[0] !== "`" || $_colum[strlen($_colum) - 1] !== "`") {
                                $_colum = "`$_colum`";
                            }
                        }
                        $sWhere .= $filterfields[$i] . " LIKE '%" . $this->db->escape_str($method['sSearch_' . $i]) . "%' ";
                    }
                }
            }
        } else {
            
        }
        
        $sGroupby = !empty($this->table_config['group_by'])?$this->table_config['group_by']:'';
        /*
         * SQL queries
         * Get data to display
         */
        if (isset($aColumns)) {

            if(isset($this->table_config['select']))
                $sSelect = $this->table_config['select'];
            else{
                $sSelect = "SELECT SQL_CALC_FOUND_ROWS *";
                for ($i = 0; $i < count($aColumns); $i++) {
                    $_colum = $aColumns[$i];
                    if (isset($this->table_config['columnmaps'][$_colum])) {
                        $_colum = $this->table_config['columnmaps'][$_colum];
                    }
                    if ($_colum[0] !== "`" || $_colum[strlen($_colum) - 1] !== "`") {
                        $_colum = "`$_colum`";
                    }
                    $sSelect.= "$_colum , ";
                }
                $sSelect = substr_replace($sSelect, "", -3);
            }
            $sQuery = "
				$sSelect
				$sFrom
				$sWhere
                                $sGroupby
				$sOrder
				$sLimit
			";
        } else {
            
            if(isset($this->table_config['select']))
                $sSelect = $this->table_config['select'];
            else
                $sSelect = "SELECT SQL_CALC_FOUND_ROWS *";
            $sQuery = "
				$sSelect
				$sFrom
				$sWhere
                                $sGroupby
				$sOrder
				$sLimit
			";
        }
        $query = $this->db->query($sQuery);
        $_error_number = $this->db->_error_number();
        if($_error_number!=0){
            $_error_message =  $this->db->_error_message();
            $log="<div class='sql-message'>$_error_number - $_error_message</div>";
            $log.="<div class='sql-query'>$sQuery</div>";
            $this->writelog($log,'Binding Table');
        }else{
            $rows = $query->result();
            $sql = "SELECT FOUND_ROWS() AS `found_rows`;";
            $query = $this->db->query($sql);
            $tmp = $query->row_array();
            $total_rows = $tmp['found_rows'];
            /*
             * Output
             */
            $output = array(
                "sEcho" => isset($method['sEcho']) ? $method['sEcho'] : 0,
                "iTotalRecords" => (int)$total_rows,
                "iTotalDisplayRecords" => (int)$total_rows,
                "aaData" => $rows,
                "sWuery" => $sQuery
            );
        }
        return $output;
    }
}