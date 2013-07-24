<?php
class HelloWorldWebModule extends WebModule {
  public function processRequest(WebRequest $request, WebResponse $response) {
    $buff = "<!DOCTYPE html>\n";
    $buff.= "<html><head><meta charset=\"UTF-8\"><title>Hello World Example</title></head>";
    $buff.= "<body>Hello World</body>";
    $buff.= "</html>";
    $response->setContentType("text/html");
    $response->done($buff);
  }
}
?>