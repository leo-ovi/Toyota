<?php

$route = new Route();

$route->get('/','HomeController@Index');
$route->get('/d/:id','ProgressController@ListPage');
$route->get('/p/:id','ProgressController@ShowPage');

$route->get('/login','LoginController@Page');
$route->get('/logout','LoginController@Logout');
$route->post('/login','LoginController@Login');

$route->get('/admin','UserController@Members');
$route->get('/admin/members/new','UserController@NewMember');
$route->post('/admin/members/new','UserController@AddMember');
$route->get('/admin/edit/:id','UserController@EditMember');
$route->post('/admin/edit/:id','UserController@UpdateMember');
$route->post('/admin/remove','UserController@RemoveMembers', 'button', 'selectedRemove');
$route->get('/admin/remove/:id','UserController@RemoveMember');

$route->get('/admin/slides','SlideController@Slides');
$route->get('/admin/slides/new','SlideController@NewSlide');
$route->post('/admin/slides/new','SlideController@AddSlide');
$route->get('/admin/slides/edit/:id','SlideController@EditSlide');
$route->post('/admin/slides/edit/:id','SlideController@UpdateSlide');
$route->post('/admin/slides/remove','SlideController@RemoveSlides', 'button', 'selectedRemove');
$route->get('/admin/slides/remove/:id','SlideController@RemoveSlide');

$route->get('/admin/departments','DepartmentController@Departments');
$route->get('/admin/departments/new','DepartmentController@NewDepartment');
$route->post('/admin/departments/new','DepartmentController@AddDepartment');
$route->get('/admin/departments/edit/:id','DepartmentController@EditDepartment');
$route->post('/admin/departments/edit/:id','DepartmentController@UpdateDepartment');
$route->post('/admin/departments/remove','DepartmentController@RemoveDepartments', 'button', 'selectedRemove');
$route->get('/admin/departments/remove/:id','DepartmentController@RemoveDepartment');

$route->get('/admin/progresses','ProgressController@Progresses');
$route->get('/admin/progresses/new','ProgressController@NewProgress');
$route->post('/admin/progresses/new','ProgressController@AddProgress');
$route->get('/admin/progresses/edit/:id','ProgressController@EditProgress');
$route->post('/admin/progresses/edit/:id','ProgressController@UpdateProgress');
$route->post('/admin/progresses/remove','ProgressController@RemoveProgresses', 'button', 'selectedRemove');
$route->get('/admin/progresses/remove/:id','ProgressController@RemoveProgress');


$route->error('ErrorController@Page');


class Route {

  private $methodName;
  private $params;
  private $gets;

  function __construct() {

    // เก็บชื่อ Method ไว้ตรวจสอบ
    $this->methodName = $_SERVER['REQUEST_METHOD'];
    // เก็บ parameter GET
    $this->gets = $_GET;

  }

  function post($path, $controller, $name = '', $value = '') {
    if($this->methodName === 'POST' && $this->check('POST', $path, $name, $value)):
      $this->call( $controller );
    endif;
  }

  function get($path, $controller, $name = '', $value = '') {
    if($this->methodName === 'GET' && $this->check('GET', $path, $name, $value)):
      $this->call( $controller );
    endif;
  }

  function error($controller) {
    $this->call( $controller );
  }

  // ล้างข้อมูล
  private function clear() {
    $this->params = [];
  }

  private function call($controller) {
    $variables = $this->splitController($controller);
    $newClass = new $variables['ctrl'];
    $response = $newClass->$variables['func']( $this->params, $this->gets );
    if( $response['type'] === 'render' )
      $this->render($response);
    else if( $response['type'] === 'json' )
      $this->json($response);
    exit();
  }

  private function render($res) {
    $params = $res['params'];
    $title = (isset($res['title'])) ? $res['title'] : AppName;
    include PATH_TEMPLATE . '/' . $res['template'] . '.php';
  }

  private function json($res) {
    echo json_encode($res['params']);
  }

  private function splitController ($controller) {
    $temp = explode('@', $controller);
    return [
      'ctrl' => $temp[0],
      'func' => $temp[1]
    ];
  }

  private function check($method, $path, $name, $value) {
    if( !$this->checkPath($path) || !$this->checkButton($method, $name, $value) ) {
      $this->clear();
      return false;
    }
    return true;
  }

  // ตรวจสอบว่า path url ตรงตามที่ระบบไว้หรือไม่ ?
  private function checkPath($url) {
    $temp_url = explode('/', $url);
    $temp_uri = explode('?', $_SERVER['REQUEST_URI']);
    $temp_uri = explode('/', $temp_uri[0]);
    if(count($temp_url) !== count($temp_uri) ) return false;
    for ($i=0; $i<count($temp_url); $i++) {
      // path ตรงกันหรือไม่ ? กับ ระบุเป็น param รึเปล่า ?
      if( $temp_url[$i] !== $temp_uri[$i] && strpos( $temp_url[$i], ':' ) === false ) return false;
      // หากเป็น param ให้เก็บค่าเอาไว้
      else if( strpos( $temp_url[$i], ':' ) !== false ) {
        $index = str_replace(':', '', $temp_url[$i]);
        $this->params[ $index ] = $temp_uri[$i];
      }
    }
    return true;
  }

  private function checkButton($method, $name, $value) {
    if($name === '') return true;
    if($method === 'GET') {
      return ($_GET[$name] === $value);
    } else if($method === 'POST') {
      return ($_POST[$name] === $value);
    }
    return false;
  }
}
