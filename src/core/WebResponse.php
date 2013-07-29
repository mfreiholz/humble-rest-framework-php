<?php
//header("HTTP/1.0 404 Not Found");
//header("Status: 404 Not Found");  // FastCGI
class WebResponse {
  private $_headers = array();
  private $_headers_written = false;

  public function setHeader($key, $value) {
    $this->_headers[$key] = $value;
  }

  public function setContentType($contentType = "application/json") {
    if (!empty($contentType)) {
      $this->setHeader("Content-Type", $contentType);
    }
  }
  
  public function setEncoding($encoding = "UTF-8") {
    if (!empty($encoding)) {
      $this->setHeader("Encoding", $encoding);
    }
  }
  
  public function write($data) {
    $this->writeHeadersOnce();
    print($data);
  }

  public function done($data) {
    $this->writeHeadersOnce();
    print($data);
  }
  
  public function done2json($obj) {
    $this->done(json_encode($obj));
  }
  
  public function fail($statusCode, $statusMessage = null) {
    if (empty($statusMessage)) {
      header("HTTP/1.1 " . $statusCode);
    } else {
      header("HTTP/1.1 " . $statusCode . " " . $statusMessage);
    }
    $this->writeHeadersOnce();
    print(json_encode(array("message" => "Invalid request")));
  }
  
  public function redirect($uri) {
    header("Location: " . $uri);
  }
  
  private function writeHeadersOnce() {
    if (!$this->_headers_written) {
      $this->_headers_written = true;
      foreach ($this->_headers as $k => $v) {
        header($k . ": " . $v);
      }
    }
  }
}
?>