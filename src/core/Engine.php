<?php
class Engine {
  private $_config;

  /*
    Holds association between module's prefix list and the module's ID.
    e.g.: array("/service/search" => "SearchServiceModule", "/home" => "HomeModule")
  */
  private $_prefix_to_module_map = array();

  public function __construct(array $config = array()) {
    $this->_config = $config;

    // Register module prefix paths.
    if (isset($this->_config["modules"])) {
      foreach ($this->_config["modules"] as $module_id => $val) {
        if (!isset($val["prefixes"]))
          continue;
        foreach ($val["prefixes"] as $prefix) {
          if (empty($prefix)) continue;
          $this->_prefix_to_module_map[$prefix] = $module_id;
        }
      }
    }

    // Register auto module class loader.
    spl_autoload_register(__NAMESPACE__ ."\Engine::moduleAutoLoad");
  }

  public function getConfig() {
    return $this->_config;
  }

  public function run() {
    // Initialize WebRequest and WebResponse objects by engine configuration.
    $request = new WebRequest;
    $response = new WebResponse;

    if (isset($this->_config["engine"])) {
      $ec = $this->_config["engine"];
      if (isset($ec["default_encoding"]))
        $response->setEncoding($ec["default_encoding"]);
      if (isset($ec["default_content_type"]))
        $response->setContentType($ec["default_content_type"]);
    }

    // ROUTING
    // Find module for current request.
    // Use base class implementation, if no specific module has been found.
    $module = $this->findModule($request);
    if (empty($module)) {
      $response->fail(404);
      return;
    }

    // Module execution.
    if (!$module->beforeProcessRequest($request, $response)) {
      return;
    }
    if (!$module->processRequest($request, $response)) {
      return;
    }
    if (!$module->afterProcessRequest($request, $response)) {
      return;
    }
  }

  private function findModule(WebRequest $request) {
    if (!isset($this->_config["modules"]))
      return null;

    $module_id = "";

    // Try to find module based on request parameter.
    if (empty($module_id) && isset($this->_config["engine"]["module_parameter"])) {
      $module_id = $request->getParameter($this->_config["engine"]["module_parameter"]);
    }

    // Try to find module by it's prefix path.
    if (empty($module_id)) {
      foreach ($this->_prefix_to_module_map as $prefix => $mid) {
        if (strpos($request->getPathInfo(), $prefix) === 0) {
          $module_id = $mid;
          break;
        }
      }
    }

    // Try to find module based on request path-info (always overwrites the value from parameter).
    if (empty($module_id) && preg_match('/^\/([^\/]+)/', $request->getPathInfo(), $matches)) {
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
    $obj->initialize($this, $modules[$module_id]);
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