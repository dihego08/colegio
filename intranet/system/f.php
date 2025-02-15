<?php
class f {
   private $controller_default = "";
   private $controller_default_function = "";
   private $controller = "";
   private $config;

   
   function f() {

       date_default_timezone_set('America/lima');
       setlocale(LC_TIME, "spanish");
           
      $this->config                      = $this->load()->config("config");
      $this->controller_default          =  $this->config->controller;
      $this->controller_default_function =  $this->config->function;
   }
   function direct() {
      $this->cargar($this->uri()->getController(), $this->uri()->getFunction());
   }
   function load() {
      return new load();
   }
   function uri() {
      return new uri($this->config);
   }
   private function cargar($v, $func) {
      $this->load()->controller($v, false);
      $this->controller = (@new $v()) OR die();
      if (method_exists($this->controller, $func))
         $this->controller->$func();
      else
         die("there is no method");
   }
}
class load {
   function load() {
   }
   function lib($file, $obj = "true") {
      if (!class_exists($file)) {
         (@include("system/lib/" . $file . ".php")) OR die("Could not find lib file");
         if ($obj)
            return new $file();
      } else if ($obj)
         return new $file();
   }
   function lib_file($file, $data_print) {
      return (@include("system/lib/" . $file . ".php")) OR die("Could not find lib file other");
   }
   function lib_html($file, $obj = "true") {
      if (!class_exists($file)) {
         (@include("system/lib/html/" . $file . ".php")) OR die("Could not find lib html file");
         if ($obj)
            return new $file();
      } else if ($obj)
         return new $file();
   }
   function lib_tool($file, $obj = "true") {
      if (!class_exists($file)) {
         (@include("system/lib/tools/" . $file . ".php")) OR die("Could not find lib tool file");
         if ($obj)
            return new $file();
      } else if ($obj)
         return new $file();
   }
   function model($file, $obj = "true") {
      if (!class_exists($file)) {
         (@include("system/models/" . $file . ".php")) OR die("Could not find model file");
         if ($obj)
            return new $file();
      } else if ($obj)
         return new $file();
   }
   function controller($file, $obj = "true") {
      if (!class_exists($file)) {
         (@include("system/controllers/" . $file . ".php")) OR die("Could not find controller file");
         if ($obj)
            return new $file();
      } else if ($obj)
         return new $file();
   }
   function view($file, $obj = "true") {
      if (!class_exists($file)) {
         (@include("system/views/" . $file . ".php")) OR die("Could not find view file");
         if ($obj)
            return $this->objeto($file);
      } else if ($obj)
         return new $file();
   }
   function viewHtmlPage($file) {
      (@include("system/views/" . $file . ".html")) OR die("Could not find viewhtml file");
   }
   function db($file) {
      if (!class_exists($file)) {
         (@include("system/db/" . $file . ".php")) OR die("Could not find db file");
         return new $file();
      } else if ($obj)
         return new $file();
   }
   function config($file) {
      if (!class_exists($file)) {
         (@include("system/config/" . $file . ".php")) OR die("Could not find config file");
         return new $file();
      } else if ($obj)
         return new $file();
   }
   function file($ar) {
      (@include($ar . ".php")) OR die("Could not find file");
   }
   private function objeto($c) {
      return new $c();
   }
}
class uri {
   var $uri = "";
   var $segments = array();
   var $config = "";
   function uri($config) {
      $this->config = $config;
      $this->uri    = trim($_SERVER["REQUEST_URI"]);
      $ini          = strpos($this->uri, "?") + 2;
      if ($ini < 3)
         $this->segments = array();
      else {
         $tmp = explode("/", substr($this->uri, $ini, strlen($this->uri)));
         foreach ($tmp as $r) {
            if (trim($r) != "") {
               $this->segments[] = $r;
            }
         }
      }
   }
   function seg($pos) {
      if (isset($this->segments[$pos]))
         return $this->segments[$pos];
      else
         return "false";
   }
   function getController() {
      if (count($this->segments) > 0)
         return $this->segments[0];
      else
         return $this->config->controller;
   }
   function getFunction() {
      if (count($this->segments) > 1)
         return $this->segments[1];
      else
         return $this->config->function;
   }
}