<?php
function hrf_autoload($class_name) {
  $base_dir = "";
  if (defined("HRF_AUTO_LOAD_BASE_DIR") && !empty(HRF_AUTO_LOAD_BASE_DIR)) {
    $base_dir = HRF_AUTO_LOAD_BASE_DIR;
    if (substr($base_dir, strlen($base_dir) - 1, 1) != "/") {
      $base_dir.= "/";
    }
  }
  if (file_exists($base_dir . $class_name . ".php")) {
    include_once($base_dir . $class_name . ".php");
  } else if (file_exists($base_dir . "core/" . $class_name . ".php")) {
    include_once($base_dir . "core/" . $class_name . ".php");
  } else if (file_exists($base_dir . "modules/" . $class_name . ".php")) {
    include_once($base_dir . "modules/" . $class_name . ".php");
  }
}

spl_autoload_register("hrf_autoload");
?>