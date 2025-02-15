<?php
class config {
   var $controller = "home";
   var $function = "index";
   function config() {
      define('BASEURL', '/intranet/');
      define('INDEX', '?/');
   }
}