<?php
class Engine {
  private $_config;

  public function __construct($config) {
    $this->_config = $config;
    spl_autoload_register(__NAMESPACE__ ."\Engine::moduleAutoLoad");
  }

  public function getConfig() {
    return $this->_config;
  }

  public function run() {
    // Initialize WebRequest and WebResponse objects by engine configuration.
    $request = new WebRequest;
    $response = new WebResponse;

    $ec = &$this->_config["engine"];
    if (isset($ec["default_encoding"]))
      $response->setEncoding($ec["default_encoding"]);
    if (isset($ec["default_content_type"]))
      $response->setContentType($ec["default_content_type"]);

    // ROUTING
    // Find module for current request.
    // Use base class implementation, if no specific module has been found.
    $module = $this->findModule($request);
    if (empty($module)) {
      $response->fail(404);
      return;
    }

    // Process the web request.
    $module->initialize($this);
    $module->processRequest($request, $response);
  }

  private function findModule(WebRequest $request) {
    // Try to find module based on request parameter.
    $module_id = $request->getParameter($this->_config["engine"]["module_parameter"]);

    // Try to find module based on request path-info (always overwrites the value from paramter).
    if (preg_match('/^\/([^\/]+)/', $request->getPathInfo(), $matches)) {
      $module_id = $matches[1];
    }

    if (empty($module_id)) {
      return null;
    }

    $modules = $this->_config["modules"];
    if (!isset($modules[$module_id])) {
      return null;
    }

    $module_class_name = $modules[$module_id]["class_name"];
    $obj = new $module_class_name;
    return $obj;
  }

  private function moduleAutoLoad($class_name) {
    $dir = "";
    if (!isset($this->_config["engine"]["module_directory"])) {
      return;
    }
    $dir = $this->_config["engine"]["module_directory"];
    if (!empty($dir) && substr($dir, strlen($dir) - 1, 1) != "/") {
      $dir.= "/";
    }
    if (file_exists($dir . $class_name . ".php")) {
      include_once($dir . $class_name . ".php");
    }
  }
}
?>