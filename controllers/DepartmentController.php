<?php

class DepartmentController {

  private $menus_department = [
    'title' => 'ตัวเลือกจัดการแผนก',
    'list' => [
      [
        'name' => 'ดูแผนกทั้งหมด',
        'url' => '/admin/departments'
      ],
      [
        'name' => '<i class="fa fa-plus-circle"></i> เพิ่มแผนก',
        'url' => '/admin/departments/new'
      ]
    ]
  ];

  function __construct() {
    if(!User::isAdmin() && strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
      header( "location: /404" );
      exit(0);
    }
  }

  function Departments($param, $gets) {
    return render([
      'template' => 'admin/department',
      'params' => [
        'menus' => $this->menus_department
      ],
      'title' => 'จัดการระบบ: แผนก'
    ]);
  }

  function NewDepartment($param, $gets) {
    return render([
      'template' => 'admin/department_add',
      'params' => [
        'menus' => $this->menus_department
      ],
      'title' => 'จัดการระบบ: แผนก'
    ]);
  }

  function AddDepartment($param, $gets) {
    $status = false;
    $message = '<strong>ล้มเหลว!</strong> ไม่สามารถเพิ่มใหม่ได้.';

    if(User::isAdmin()) {
        $sub = 0;
        if($_POST['department'] > -1) {
          $sub = $_POST['department'];
        }

        if(Department::add([
          'name' => $_POST['name'],
          'sub' => $sub
          ])) {
            $message = "<strong>สำเร็จ!</strong> <a href='/admin/departments'>กลับไปหน้ารายการ</a>";
            $status = true;
          } else {
            $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
            $status = false;
            break;
          }

      }

      return render([
        'template' => 'post/message',
        'params' => [
          'status' => $status,
          'message' => $message
        ],
        'title' => 'เพิ่มแผนก'
      ]);
    }

    function EditDepartment($param, $gets) {
      return render([
        'template' => 'admin/department_edit',
        'params' => [
          'menus' => $this->menus_department,
          'id' => $param['id']
        ],
        'title' => 'จัดการระบบ: แผนก'
      ]);
    }

    function UpdateDepartment($param, $gets) {
      $status = false;
      $message = '<strong>ล้มเหลว!</strong> ไม่สามารถแก้ไขได้.';

      if(User::isAdmin()) {
          $sub = 0;
          if($_POST['department'] > -1) {
            $sub = $_POST['department'];
          }
        if(Department::update([
          'department_id' => $param['id'],
          'name' => $_POST['name'],
          'sub' => $sub,
          ])) {
            $message = "<strong>สำเร็จ!</strong> <a href='/admin/departments'>กลับไปหน้ารายการ</a>";
            $status = true;
          } else {
            $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
            $status = false;
          }
        }

        return render([
          'template' => 'post/message',
          'params' => [
            'status' => $status,
            'message' => $message
          ],
          'title' => 'แก้ไขแผนก'
        ]);
      }

      function RemoveDepartments($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($_POST['id']) && User::isAdmin()) {
          foreach($_POST['id'] as $id) {
            if(Department::remove($id)) {
              $message = "<strong>สำเร็จ!</strong> <a href='/admin/departments'>กลับไปหน้ารายการ</a>";
              $status = true;
            } else {
              $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
              $status = false;
              break;
            }
          }
        }

        return render([
          'template' => 'post/message',
          'params' => [
            'status' => $status,
            'message' => $message
          ],
          'title' => 'ลบแผนก'
        ]);
      }

      function RemoveDepartment($param, $gets) {
        $status = false;
        $message = '<strong>ล้มเหลว!</strong> ไม่สามารถลบได้.';

        if(isset($param['id']) && User::isAdmin()) {
          if(Department::remove($param['id'])) {
            $message = "<strong>สำเร็จ!</strong> <a href='/admin/departments'>กลับไปหน้ารายการ</a>";
            $status = true;
          } else {
            $message = "<strong>ล้มเหลว!</strong> มีบางอย่างผิดพลาด.";
            $status = false;
            break;
          }
        }

        return render([
          'template' => 'post/message',
          'params' => [
            'status' => $status,
            'message' => $message
          ],
          'title' => 'ลบแผนก'
        ]);
      }

    }
