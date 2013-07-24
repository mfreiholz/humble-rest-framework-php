<?php
function __autoload($class_name) {
  if (file_exists($class_name . ".php")) {
    include_once($class_name . ".php");
  } else if (file_exists("core/" . $class_name . ".php")) {
    include_once("core/" . $class_name . ".php");
  } else if (file_exists("modules/" . $class_name . ".php")) {
    include_once("modules/" . $class_name . ".php");
  }
}

$e = new Engine((include 'config.php'));
$e->run();
?>