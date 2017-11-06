<?php
class UserForm {

  private $obj = [
    'id' => '',
    'fullname' => '',
    'no' => '',
    'position' => '',
    'username' => '',
    'department_id' => ''
  ];

  private $title;
  private $path;

  function __construct() {
    $this->title = "<i class='fa fa-plus-circle'></i> เพิ่มสมาชิก";
    $this->path = "/admin/members/new";
  }

  function setObj($obj) {
    $this->obj = $obj;
    $this->title = "<i class='fa fa-cog'></i> แก้ไขสมาชิก";
    $this->path = "/admin/edit/" + $obj['user_id'];
  }

  function getUserForm() {
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
    <option value="0">ผู้ดูแลระบบ</option>
    </select>';
  }

  // function getDepartmentList() {
  //   $list = '';
  //   foreach (Department::getList() as $department) {
  //     $selected = ($department['department_id'] == $this->obj['department_id']) ? 'selected': '';
  //     $list .= "<option value='".$department['department_id']."' $selected>".$department['name']."</option>";
  //   }
  //   return $list;
  // }

  function getDepartmentList() {
    $list = '';
    foreach (Department::getList() as $department) {
      if($department['sub'] == 0) {
        $list .= '<optgroup label="'.$department['name'].'">';
        foreach (Department::getSub($department['department_id']) as $sub) {
          $list .= "<option value='".$sub['department_id']."'>".$sub['department_name']."</option>";
        }
        $list .= '</optgroup>';
      }
    }
    return $list;
  }

  function getForm() {
    return <<< HTML
    <form method="POST" action="$this->path" onsubmit="return askConfirm()">
    <div class="form-group">
    <label for="forFullname">ชื่อเต็ม</label>
    <input type="text" class="form-control" name="fullname" id="forFullname" placeholder="fullname" value="{$this->obj['fullname']}">
    </div>
    <div class="form-group">
    <label for="forNo">รหัสพนักงาน</label>
    <input type="text" class="form-control" name="no" id="forNo" placeholder="xxxxxx" value="{$this->obj['no']}">
    </div>
    <div class="form-group">
    <label for="forPosition">ตำแหน่ง</label>
    <input type="text" class="form-control" name="position" id="forPosition" placeholder="position" value="{$this->obj['position']}">
    </div>
    <div class="form-group">
    <label for="forUsername">แผนก</label>
    {$this->getSelection()}
    </div>
    <hr/>
    <div class="form-group">
    <label for="forUsername">ยูเซอร์เนม</label>
    <input type="text" class="form-control" name="username" id="forUsername" placeholder="username" value="{$this->obj['username']}">
    </div>
    <div class="form-group">
    <label for="forPassword">รหัสผ่าน</label>
    <input type="password" class="form-control" name="password" id="forPassword" placeholder="password">
    </div>
    <button type="submit" style="width: 150px" class="btn btn-default">ยืนยัน</button>
    <a href="" class="btn btn-danger">ยกเลิก</a>
    </form>
    <br><br>
HTML;
  }

}
