<?php
class WebModule {
  protected $_engine = null;
  protected $_config = null;
  
  public function initialize(Engine $engine, $config) {
    $this->_engine = $engine;
    $this->_config = $config;
  }
  
  public function getEngine() {
    return $this->_engine;
  }
  
  public function getConfig() {
    return $this->_config;
  }
  
  public function getConfigValue($key, $defaultValue = null) {
    if (empty($this->_config) || !isset($this->_config[$key])) {
      return $defaultValue;
    }
    return $this->_config[$key];
  }

  public function processRequest(WebRequest $request, WebResponse $response) {
    $buff = "<!DOCTYPE html>\n";
    $buff.= "<h1>Default Web Module</h1>";
    $buff.= "<pre>" . print_r($_SERVER, true) . "</pre>";
    $response->setContentType("text/html");
    $response->done($buff);
  }
}
?>