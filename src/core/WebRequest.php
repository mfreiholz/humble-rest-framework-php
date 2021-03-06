<?php
class WebRequest {
  public static $GET  = 1;
  public static $POST = 2;
  public static $ANY  = 3;

  public function getParameter($name, $defaultValue = null, $type = null) {
    if ($type === null)
      $type = self::$ANY;
    if (($type == self::$ANY || $type == self::$GET) && isset($_GET[$name])) {
      return $_GET[$name];
    } else if (($type == self::$ANY || $type == self::$POST) && isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $defaultValue;
  }
  
  public function hasCookie($name) {
    return isset($_COOKIE[$name]);
  }
  
  public function getCookie($name, $defaultValue = null) {
    if (isset($_COOKIE[$name])) {
      return $_COOKIE[$name];
    }
    return $defaultValue;
  }

  public function getServerHost() {
    if (isset($_SERVER["SERVER_ADDR"])) {
      return $_SERVER["SERVER_ADDR"];
    } else if (isset($_SERVER["SERVER_NAME"])) {
      return $_SERVER["SERVER_NAME"];
    }
    return "";
  }

  public function getServerPort() {
    if (isset($_SERVER["SERVER_PORT"])) {
      return $_SERVER["SERVER_PORT"];
    }
    return 0;
  }

  public function getRemoteAddr() {
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
      return $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (isset($_SERVER["REMOTE_ADDR"])) {
      return $_SERVER["REMOTE_ADDR"];
    }
    return "";
  }
  
  public function getRequestMethod() {
    return $_SERVER["REQUEST_METHOD"];
  }
  
  /*
    Gets the part of the URL, which comes right after the current executed script name.
    e.g.: http://localhost/index.php/MyWebModule/MoreData?foo=bar
                                    ^begin              ^end
                                    (=> /MyWebModule/MoreData)
    @return string
  */
  public function getPathInfo() {
    if (isset($_SERVER["PATH_INFO"])) {
      return $_SERVER["PATH_INFO"];
    }
    return "";
  }
  
  /*
    Gets the entire path of the URL, without the host address.
    e.g.: http://localhost/index.php/MyWebModule/MoreData?foo=bar
                          ^begin                                ^end
                          (=> /index.php/MyWebModule/MoreData?foo=bar)
    @return string
  */
  public function getRequestUri() {
    if (isset($_SERVER["REQUEST_URI"])) {
      return $_SERVER["REQUEST_URI"];
    }
    return "";
  }
  
  public function getRequestBody() {
    return file_get_contents("php://input");
  }

}
?>