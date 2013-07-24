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
  ),
  
  // Register and configure web modules.
  "modules" => array(

    "HelloWorldWebModule" => array(
      "class_name" => "HelloWorldWebModule",
      "description" => "Says 'Hello World' to you.",
      "author" => "Manuel Freiholz",
     ),
     
    "ListModulesWebModule" => array(
      "class_name" => "ListModulesWebModule",
      "description" => "Shows a list of all existing modules.",
      "author" => "Manuel Freiholz",
    ),

  ),
  
  // IN - DEVELOPMENT - IDEAS
  
  // Request/Response filter. (Not implemented yet!)
  "filter" => array(
  ),
);
?>