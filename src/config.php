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
     
    "ListModulesWebModule" => array(
      "class_name" => "ListModulesWebModule",
      "description" => "Response a list of all existing modules in JSON format.",
      "author" => "Manuel Freiholz",
      "prefixes" => array(
        "/modules/list"
      ),
    ),

  )

);
?>