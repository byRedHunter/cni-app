<?php
  class ViewModel {
    protected static function getViewsModel($view) {
      $pageList = ["home", "user-list", "user-new", "user-search", "user-update", "desk-recents", "desk-list", "desk-search", "book-reservation", "book-new", "book-list", "book-search"];

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