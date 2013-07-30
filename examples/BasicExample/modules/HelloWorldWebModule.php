<?php
class HelloWorldWebModule extends WebModule {
  public function processRequest(WebRequest $request, WebResponse $response) {
    $buff = "<!DOCTYPE html>\n";
    $buff.= "<html><head><meta charset=\"UTF-8\"><title>Hello World Example</title></head><body>";
    $buff.= "<h1>Hello World</h1>";
    $buff.= "<pre>" . print_r($this->_config, true) . "</pre>";
    $buff.= "</body></html>";
    $response->setContentType("text/html");
    $response->done($buff);
  }
}
?>