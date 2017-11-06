<?php

class AdminController {

  function __construct() {
    if(!User::isAdmin() && strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
      header( "location: /404" );
      exit(0);
    }
  }

}
