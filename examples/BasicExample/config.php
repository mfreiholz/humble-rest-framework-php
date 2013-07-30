<?php
return array(
  
  // Basic Engine configuration.
  "engine" => array(
    // Name of the request parameter, which contains the module ID.
    "module_parameter" => "m",
    
    // Used "Encoding", if not set by module.
    "default_encoding" => "UTF-8",
    
    // Default "Content-Type", if not set by module.
    "default_content_type" => "application/json",
    
    // Directory which contains the modules.
    "module_directory" => "modules/",
  ),
  
  // Register and configure web modules.
  "modules" => array(

    "HelloWorldWebModule" => array(
      "class_name" => "HelloWorldWebModule",
      "description" => "Says 'Hello World' to you.",
      "author" => "Manuel Freiholz",
     ),
     
    "download" => array(
      "class_name" => "DownloadWebModule",
      "description" => "Starts a big download. Requires 64-bit system to download files bigger than 2 GB.",
      "author" => "Manuel Freiholz",
      
      // Maximum transfer rate (bytes per second; 0=no limit).
      "max_bytes_per_second" => 1024 * 50,  // 50 KB/s
      
      // File to download.
      "file_path" => "D:\\Downloads\\qt-windows-opensource-5.1.0-msvc2012_opengl-x86_64-offline.exe",
     ),

  ),

);
?>