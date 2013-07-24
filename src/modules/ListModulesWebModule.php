<?php
class ListModulesWebModule extends WebModule {
  public function processRequest(WebRequest $request, WebResponse $response) {
    $config = $this->_engine->getConfig();
    $json = json_encode($config["modules"]);
    $response->done($json);
  }
}
?>