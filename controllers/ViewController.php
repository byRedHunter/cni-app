<?php
  require_once "./models/ViewModel.php";

  class ViewController extends ViewModel {
    public function getTemplateController() {
      return require_once "./views/template.php";
    }

    // get pages
    public function getViewController() {
      if(isset($_GET['view'])) {
        $view = explode("/", $_GET['view']);
        $response = ViewModel::getViewsModel($view[0]);
      } else {
        $response = "login";
      }

      return $response;
    }
  }