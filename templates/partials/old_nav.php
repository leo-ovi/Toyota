<div class="header--nav">
  <nav class="navbar navbar-pills">
    <div class="container-fluid">

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div>
        <ul class="nav navbar-nav nav-pills col-sm-8 col-xs-12">
          <li class="active"><a href="#">หน้าแรก</a></li>
          <li><a href="#">Link</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle">แผนก <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Separated link</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right nav-pills col-sm-4 col-xs-12">
          <?php if(isset($user)): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li><a href="#">เข้าสู่ระบบ</a></li>
          <?php endif; ?>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</div>
