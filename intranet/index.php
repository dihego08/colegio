<?php
class index {
   var $f = "";
   function ini() {
      include("system/f.php");
      $this->f = new f();
      $this->f->direct();
   }
}
$page = new index();
$page->ini();

	