<?php
class DownloadWebModule extends WebModule {
  private $_bytes_per_second = 0;

  public function __construct() {
    @set_time_limit(0);
    
    // TODO Load "bytes per second" from config.
    $this->_bytes_per_second = 1024 * 50;  // 50 kbit/s
  }

  public function processRequest(WebRequest $request, WebResponse $response) {
    $file_path = "D:\\Downloads\\qt-windows-opensource-5.1.0-msvc2012_opengl-x86_64-offline.exe";
    $file_size = filesize($file_path);
    $file_info = pathinfo($file_path);
    $bytes_per_tick = $this->_bytes_per_second / 5;
    
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
      usleep(200000);
    }
  }
}
?>