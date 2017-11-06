<?php

class ListPage {

  private $className = '';
  private $list = [];
  private $columnName = [];
  private $variableName = [];
  private $keywordColumn = [];
  private $path = '/';

  private $perpage = 4;
  private $page = 1;
  private $size = 0;

  private $keyword = '';
  private $department = '';

  function __construct($className, $path, $columnName, $variableName, $keywordColumn) {

    // ตั้งค่าการค้นหา
    $this->keyword = (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ;
    $stringVariables = '';
    if($this->keyword !== '') {
      $stringVariables = "`".$keywordColumn[0]."` LIKE '%$this->keyword%'";
      for( $i=1; $i<count($keywordColumn); $i++) {
        $stringVariables .= " OR `".$keywordColumn[$i]."` LIKE '%$this->keyword%'";
      }
    }
    $this->department = (isset($_GET['department']) && $_GET['department'] != -1) ? $_GET['department'] : '' ;
    $where = "";
    if( $this->keyword !== '' && $this->department !== '' ) {
      $where = " WHERE ($stringVariables) AND ".$className::$tableName.".department_id = '$this->department'";
    } else if($this->keyword !== '') {
      $where = " WHERE $stringVariables";
    } else if($this->department !== '') {
      $where = " WHERE ".$className::$tableName.".department_id = '$this->department'";
    }

    // ตั้งค่าหน้า
    $this->page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $start = ($this->page - 1) * $this->perpage;
    $this->size = $className::size($where)['size'];

    // ตั้งค่าตัวแปร
    $this->className = $className;
    $this->path = $path;
    if($this->className === 'Department') {
      $this->list = $className::getDepartmentList(" $where ORDER BY id ASC LIMIT $start, $this->perpage ");
    } else {
      $this->list = $className::getList(" $where ORDER BY id ASC LIMIT $start, $this->perpage ");
    }

    $this->columnName = $columnName;
    $this->variableName = $variableName;
  }

  function getListPage($title) {
    return "
    <div>
      <h4>
        <strong>$title</strong>
      </h4>
      ".$this->getHead().$this->getTable()."
    </div>
    ";
  }

  function getSearch() {
    return ($this->keyword !== '') ? "<span>ค้นหา <strong>$this->keyword</strong>, <strong>".Department::get($this->department)['department_name']."</strong> </span>" : '';
  }

  function getHead() {
    return '
    <form method="GET">
    <div class="managerHeader row">
      <div class="col-sm-7">
        <div class="input-group">
          <input type="text" name="keyword" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit">ค้นหา</button>
          </span>
        </div><!-- /input-group -->
      </div>
      <div class="col-sm-5 text-right">
        '. $this->getSearch() .'
        <span>ทั้งหมด : '.$this->getSize().' รายการ</span>
      </div>
    </div>
    <br>
    '.$this->getSelection().'
    </form>
    <hr>
    ';
  }

  function getSelection() {
    if($this->className !== 'Department' && $this->className !== 'Slide') {
    // if($this->className !== 'Slide') {
      return '
      <select class="selection" name="department">
        <option value="-1">เลือกแผนก</option>
        '.$this->getDepartmentList().'
        <optgroup label="อื่นๆ">
          <option value="0">ผู้ดูแลระบบ</option>
        </optgroup>
      </select>';
    }
    return '';
  }

  function getDepartmentList() {
    $list = '';
    foreach (Department::getList() as $department) {
      // $parent = Department::get($department['sub']);
      // $parentTxt = (!empty($parent)) ? $parent['department_name'] . ' : ':'';
      // $list .= "<option value='".$department['department_id']."'>$parentTxt".$department['name']."</option>";
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

  function getTable() {
    return "
    <form method='POST' action='$this->path/remove'>
    <table class='table table-bordered table-striped'>
    <thead>
    " . $this->getThead() . "
    </thead>
    <tbody>
    " . $this->getTbody() . "
    </tbody>
    </table>
    <div class='text-left'><button type='submit' class='btn btn-danger' name='button' value='selectedRemove'><i class='fa fa-check-square-o' aria-hidden='true'></i> ลบที่เลือก</button></div>
    </form>
    " . $this->getPagination() . "
    ";
  }

  function getPagination() {
    $total_page = ceil( $this->size / $this->perpage );
    $pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
    for( $i=1; $i<=$total_page; $i++ ) {
      $active = ($this->page == $i) ? 'active' : '';
      $pagination .= "<li class='$active'><a href='?page=$i&department=$this->department&keyword=$this->keyword'>$i</a></li>";
    }
    $pagination .= '</ul></nav>';
    return $pagination;
  }

  function getThead() {
    $thead = "<th width='25'></th>";
    $thead .= "<th width='10%'>#</th>";
    foreach( $this->columnName as $col ) {
      $cl = explode(':', $col);
      $width = (count($cl) == 2) ? $cl[1] : 'auto';
      $thead .= "<th width='$width'>".$cl[0]."</th>";
    }
    $thead .= "<th width='20%'>จัดการ</th>";
    return $thead;
  }

  function getTbody() {
    $tbody = "";
    $count = 1;
    foreach( $this->list as $obj ) {
      $tbody .= "<tr>";
      $tbody .= "<td> <input type='checkbox' name='id[]' value='".$obj['id']."'/> </td>";
      $tbody .= "<td> ".$obj['id']." </td>";
      foreach( $this->variableName as $var ) {
        $contents = explode(':', $var);
        $content = '';
        if(count($contents) == 2) {
          if($contents[1] == 'image') {
            $content = "<img class='imgInTD' src='/uploads/" . $obj[$contents[0]] . "'/>";
          } else if($contents[1] == 'sub') {
            $department = Department::get($obj[$contents[0]]);
            if(!empty($department)) {
              $content = $department['department_name'];
            }
          }
        } else {
          $content = $obj[$contents[0]];
        }
        $tbody .= "<td>".$content."</td>";
      }
      // <a class='btn btn-default' href='$this->path/view/".$obj['id']."' role='button'>ดู</a>
      $tbody .= "<td align='center'>
      <a class='btn btn-warning' href='$this->path/edit/".$obj['id']."' role='button'>แก้ไข</a>
      <a class='btn btn-danger' href='$this->path/remove/".$obj['id']."' role='button'>ลบ</a>
      </td>";
      $tbody .= "</tr>";
      $count++;
    }
    return $tbody;
  }

  function getSize() {
    return $this->size;
  }
}
