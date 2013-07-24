<?php
// Define the relative or absolute path to the framework's base directory,
// before including the "autoload.php" from the directory.
define("HRF_AUTO_LOAD_BASE_DIR", "../../src");
require_once("../../src/autoload.php");

// Create Engine with custom configuration.
// Copy from $HRF_BASE_DIR/config.dist.php
$e = new Engine((include 'config.php'));
$e->run();
?>