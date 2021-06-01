<?php
  class ViewModel {
    protected static function getViewsModel($view) {
      $pageList = ["book-new"];

      if(in_array($view, $pageList)) {
        if(is_file("./views/pages/" . $view . "-view.php")) {
          $content = "./views/pages/" . $view . "-view.php";
        } else {
          $content = "404";
        }
      } elseif($view == "login") {
        $content = "login";
      } elseif($view == "index" || $view == "landing" || $view == "") {
        $content = "landing";
      } else {
        $content = "404";
      }

      return $content;
    }
  }