<?php
class WebModule {
  protected $_engine = null;
  
  public function initialize(Engine $engine) {
    $this->_engine = $engine;
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