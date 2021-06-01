<?php
  require_once "./config/app.php";
  require_once "./controllers/ViewController.php";

  $template = new ViewController();
  $template->getTemplateController();