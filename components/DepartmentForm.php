<?php
class DepartmentForm {

  private $obj = [
    'id' => '',
    'name' => '',
    'sub' => ''
  ];

  private $title;
  private $path;

  function __construct() {
    $this->title = "<i class='fa fa-plus-circle'></i> เพิ่มแผนก";
    $this->path = "/admin/departments/new";
  }

  function setObj($obj) {
    $this->obj = [
      'id' => $obj['department_id'],
      'name' => $obj['department_name'],
      'sub' => $obj['sub']
    ];
    $this->title = "<i class='fa fa-cog'></i> แก้ไขแผนก";
    $this->path = "/admin/departments/edit/" + $obj['department_id'];
  }

  function getDepartmentForm() {
    return $this->getHeader().$this->getForm();
  }

  function getHeader() {
    return "
    <div>
    <h4>
    <strong>$this->title</strong>
    </h4>
    <hr>
    </div>
    ";
  }

  function getSelection() {
    return '
    <select class="selection" name="department">
    <option value="-1">เลือกแผนก</option>
    '.$this->getDepartmentList().'
    </select>';
  }

  function getDepartmentList() {
    $list = '';
    foreach (Department::getList() as $department) {
      $selected = ($department['department_id'] == $this->obj['sub']) ? 'selected': '';
      if($department['sub'] == 0) {
        $list .= "<option value='".$department['department_id']."' $selected>".$department['name']."</option>";
      }
    }
    return $list;
  }

  function getForm() {
    return <<< HTML
    <form method="POST" action="$this->path" enctype="multipart/form-data" onsubmit="return askConfirm()">
    <div class="form-group">
    <label for="forTitle">ชื่อแผนก</label>
    <input type="text" class="form-control" name="name" id="forTitle" placeholder="name" value="{$this->obj['name']}">
    </div>
    <div class="form-group">
    <label for="forSelection">แผนกหลัก</label>
    {$this->getSelection()}
    </div>
    </hr>
    <button type="submit" style="width: 150px" class="btn btn-default">ยืนยัน</button>
    <a href="" class="btn btn-danger">ยกเลิก</a>
    </form>
    <br><br>
HTML;
  }

}
