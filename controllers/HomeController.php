<?php

class HomeController {
  function Index($params, $gets) {
    return render([
      'template' => 'home',
      'params' => [
        'test' => 'asdasdasd'
      ],
      'title' => 'SOP'
    ]);
  }
}
