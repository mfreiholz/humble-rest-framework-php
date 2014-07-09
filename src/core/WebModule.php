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

  /**
   * Gets called before the "processRequest()" method.
   * @param WebRequest $request
   * @param WebResponse $response
   * @return boolean If the function returns "false", the module execution will end.
   * The "processRequest()" method, will never be called.
   */
  public function beforeProcessRequest(WebRequest $request, WebResponse $response) {
    return true;
  }

  /**
   * The basic web request logic should be handled here.
   * This method gets called for every HTTP request.
   * @param WebRequest $request
   * @param WebResponse $response
   * @return boolean
   */
  public function processRequest(WebRequest $request, WebResponse $response) {
    $response->fail(404);
    return true;
  }

  /**
   * Gets called after the "processRequest()" method.
   * @param WebRequest $request
   * @param WebResponse $response
   * @return boolean
   */
  public function afterProcessRequest(WebRequest $request, WebResponse $response) {
    return true;
  }
}
?>