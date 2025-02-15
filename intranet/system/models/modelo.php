<?php
class Modelo extends f {
   var $db = "";
   function Modelo() {
      $this->db = $this->load()->db("Db", $load);
   }
   function select($table, $where = "") {
      if ($where != "")
         $w = " where " . $this->db->array_to_where_value($where);
      return $this->db->query("select * from " . $table . $w);
   }
   function delete($table, $field, $id) {
      $this->db->execute("delete from " . $table . " where " . $field . " = '" . $id . "'");
   }
   function insert($table, $data) {
      $this->db->insert($table, $data);
   }
   function update($table, $data, $where) {
      $this->db->execute("update " . $table . " set " . $this->db->array_to_set_value($data) . " where " . $this->db->array_to_where_value($where));
      
   }
   function getCon(){
      return $this->db->con;
   }
   
   function getBd(){
      return $this->db->database;
   }
}