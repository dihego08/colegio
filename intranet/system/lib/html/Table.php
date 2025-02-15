<?php
/*
TABLE
$id (string): Unique id to be assigned to the table element (optional)
$klass (string): Class name to be attached to the table (optional)
$border (integer): Border attribute of table element (optional, default is 0)
$cellspacing (integer): Table's cellspacing attribute - amount of spacing between table cells (optional, default is 2)
$cellpadding (integer): Table's cellpadding attribute - amount of padding around table cell content (optional, default is 0)
$attr_ar (array): Associative array of additional attributes (optional)

ROW
$klass (string): Class name to be attached to the table row (optional)
$attr_ar (array): Associative array of additional attributes (optional)

CELL
$data (string): Content to be displayed in table cell.
$klass (string): Class name to be attached to the table cell (optional)
$type (string): Type of table cell, data (<td>) or header (<th>). Default: 'data'
$attr_ar (array): Associative array of additional attributes (optional)

*/ 
class Table { 
    private $rows = array(); 
    private $tableStr = ''; 
     
    function __construct($attr_ar = array(), $id = NULL, $klass = NULL, $border = 0, $cellspacing = 2, $cellpadding = 0) { 
        $this->tableStr = "<table" . ( !empty($id)? " id=\"$id\"": '' ) .  
            ( !empty($klass)? " class=\"$klass\"": '' ) . $this->addAttribs( $attr_ar ) .  
             " border=\"$border\" cellspacing=\"$cellspacing\" cellpadding=\"$cellpadding\">"; 
    } 
     
    private function addAttribs( $attr_ar ) { 
        $str = ''; 
        foreach( $attr_ar as $key=>$val ) { 
            $str .= " $key=\"$val\""; 
        } 
        return $str; 
    } 
     
    public function addRow($attr_ar = array(), $klass = NULL) { 
        $row = new HTML_TableRow( $klass, $attr_ar ); 
        array_push( $this->rows, $row ); 
    } 
     
    public function addCell($data = '', $attr_ar = array(), $klass = NULL, $type = 'data') { 
        $cell = new HTML_TableCell( $data, $klass, $type, $attr_ar ); 
        // add new cell to current row's list of cells 
        $curRow = &$this->rows[ count( $this->rows ) - 1 ]; // copy by reference 
        array_push( $curRow->cells, $cell ); 
    } 
     
    public function getTable() { 
        foreach( $this->rows as $row ) { 
            $this->tableStr .= !empty($row->klass) ? "<tr class=\"$row->klass\"": "<tr"; 
            $this->tableStr .= $this->addAttribs( $row->attr_ar ) . ">"; 
            $this->tableStr .= $this->getRowCells( $row->cells ); 
            $this->tableStr .= "</tr>"; 
        } 
        $this->tableStr .= "</table>"; 
        return $this->tableStr; 
    } 
     
    function getRowCells($cells) { 
        $str = ''; 
        foreach( $cells as $cell ) { 
            $tag = ($cell->type == 'data')? 'td': 'th'; 
            $str .= !empty($cell->klass) ? "<$tag class=\"$cell->klass\"": "<$tag"; 
            $str .= $this->addAttribs( $cell->attr_ar ) . ">"; 
            $str .= $cell->data; 
            $str .= "</$tag>"; 
        } 
        return $str; 
    } 
     
} 


class HTML_TableRow { 
    function __construct($klass = NULL, $attr_ar = array()) { 
        $this->klass = $klass; 
        $this->attr_ar = $attr_ar; 
        $this->cells = array(); 
    } 
} 

class HTML_TableCell { 
    function __construct( $data, $klass, $type, $attr_ar ) { 
        $this->data = $data; 
        $this->klass = $klass; 
        $this->type = $type; 
        $this->attr_ar = $attr_ar; 
    } 
} 