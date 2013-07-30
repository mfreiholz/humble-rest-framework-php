<?php
class DownloadWebModule extends WebModule {
  public function __construct() {
    @set_time_limit(0);
  }

  public function processRequest(WebRequest $request, WebResponse $response) {
    $max_bytes_per_second = $this->getConfigValue("max_bytes_per_second", 0);
    $file_path            = $this->getConfigValue("file_path");

    $file_size = filesize($file_path);
    $file_info = pathinfo($file_path);
    
    $bytes_per_tick = 4096;
    if ($max_bytes_per_second > 0) {
      $bytes_per_tick = $max_bytes_per_second / 5;
    }
    
    $fh = fopen($file_path, "r");
    if (!$fh) {
      $response->fail(404);
      return;
    }

    $response->setContentType("application/octet-stream");
    $response->setHeader("Content-Disposition", "attachment; filename=\"" . $file_info["basename"] . "\"");
    $response->setHeader("Content-Length", $file_size);
    
    while (!feof($fh)) {
      $buff = fread($fh, $bytes_per_tick);
      if ($buff === FALSE)
        break;
      $response->write($buff);
      
      if ($max_bytes_per_second > 0) {
        usleep(200000);
      }
    }
    $response->done();
  }
}
?>