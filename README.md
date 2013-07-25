Humble REST Framework (PHP)
===========================
HRF is a simple library to easily create REST services with PHP.
It's designed to be used from any directory. On this way its possible to use it without mixing sources.


Writing a custom module/service
===============================
Each service has to be in its own single file inside the `modules` directory.
The file must have the same name as the module's class to be found from the auto-class-loader.

File: _$HRF_BASE/modules/MyModule.php_
```php
<?php
class MyModule extends WebModule {

  // Overwrite from WebModule base class.
  public function processRequest(WebRequest $request, WebResponse $response) {
    $response->done('{"message": "It\'s done!"}');
  }

}
?>
```

As you can see, the `MyModule` extends from `WebModule`, which is the base class for all web modules.
It provides additional functionality to each module, including access on the current `Engine` object.
Each sub-class of `WebModule` must overwrite the `processRequest(WebRequest $request, WebResponse $response)` method,
which is the main entry point.

Last, its required to configure and activate the module in `config.php`.
It already contains a module configuration, which you can simply copy/paste.

```php
  // Register and configure web modules.
  "modules" => array(
     
    "MyModule" => array(           // ID of the module, used as route to the module (does NOT need to match the file or class name)
      "class_name" => "MyModule",  // Name of the class and file of the module.
    ),

  ),
```

The module can now be called in two ways:

* By parameter: `http://localhost/hrf/index.php?m=MyModule`
* By URI path: `http://localhost/hrf/index.php/MyModule`

With Apache/NGINX/.. rewrite rules you can create even more possible ways to reach the service.
