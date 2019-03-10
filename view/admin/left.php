<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo SITEURL?>/resources/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $data["adminInfo"]["username"]?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <?php
        $permission = json_decode($data["adminInfo"]["permission"]); // 权限数组
        // print_r($data["leftList"]);
        // print_r($data);
        foreach($data["leftList"] as $menu){
          if($menu["parent_id"]==0 && $data["adminInfo"]["username"]=="admin"){  //超级管理员，全部显示
          ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span><?php echo $menu["title"]?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php
                foreach($data["leftList"] as $menuZi){
                  if($menuZi["parent_id"] == $menu["id"]){
                  ?>
                    <li><a href="<?php echo $menuZi["uri"]?>"><i class="fa fa-circle-o"></i> <?php echo $menuZi["title"]?></a></li>
                  <?php
                  }
                }
                ?>
              </ul>
            </li>
          <?php
          }
          elseif($menu["parent_id"]==0 && in_array($menu["id"],$permission))  // 不是超级管理员，判断权限
          {
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span><?php echo $menu["title"]?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php
                foreach($data["leftList"] as $menuZi){
                  if($menuZi["parent_id"] == $menu["id"]){
                ?>
                  <li><a href="<?php echo $menuZi["uri"]?>"><i class="fa fa-circle-o"></i> <?php echo $menuZi["title"]?></a></li>
                <?php
                  }
                }
                ?>
              </ul>
            </li>
            <?php
          }
        }
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>