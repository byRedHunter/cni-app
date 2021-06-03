<?php
  class ViewModel {
    protected static function getViewsModel($view) {
      $pageList = ["home"];

      if(in_array($view, $pageList)) {
        if(is_file("./views/pages/" . $view . "-view.php")) {
          $content = "./views/pages/" . $view . "-view.php";
        } else {
          $content = "404";
        }
      } elseif($view == "login" || $view == "sistema") {
        $content = "login";
      } elseif($view == "index" || $view == "landing" || $view == "") {
        $content = "landing";
      } elseif($view == "library" || $view == "biblioteca" || $view == "") {
        $content = "library";
      } elseif($view == "procedure" || $view == "solicitud" || $view == "") {
        $content = "procedure";
      } else {
        $content = "404";
      }

      return $content;
    }
  }