<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo SITEURL?>/resources/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo SITEURL?>/resources/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo SITEURL?>/resources/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo SITEURL?>/resources/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo SITEURL?>/resources/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo SITEURL?>/resources/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo SITEURL?>/resources/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
    include "header.php";
  ?>
  
  <?php
    include "left.php";
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
        <small> </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">增加菜单</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">菜单标题</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" checkstatus="yes" tag=标题 checklist='{"lengthMax":"2","lengthMin":"20"}' id="title" placeholder="请输入菜单标题">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">uri</label>
                  <div class="col-sm-8">
                    <input type="text" checkstatus="yes" checklist='{}' tag=“uri” class="form-control" id="uri" placeholder="请输入菜单路径">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">图标</label>
                  <div class="col-sm-10">
                    <input type="text" checkstatus="yes" checklist='{}' tag="图标" class="form-control" id="icon" placeholder="请选择图标">
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">排序</label>
                  <div class="col-sm-10">
                    <input type="number" checkstatus="yes" checklist='{}' tag="排序" class="form-control" id="order" placeholder="请输入排序数字，数字越大排序越高，默认是0">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">上级菜单</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" id="parentId">
                      <option value="0" selected="selected">一级菜单</option>
                      <?php
                      $menuList = $data["menuList"];
                      foreach($menuList as $menuArr){
                        if($menuArr["parent_id"]==0){  
                        ?>
                          <option value="<?php echo $menuArr["id"]?>"><?php echo $menuArr["title"]?></option>
                        <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default">重置</button>
                <button type="submit" operate="add" modal_id="sureAdd" class="btn btn-info pull-right">添加</button>
              </div>
              <!-- /.box-footer -->
            </div>
          </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<div class="modal fade bs-example-modal-sm" id="sureAdd" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-title">确定要添加?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="sure">确定</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- 错误提示框 -->
<div class="modal modal-warning fade" id="modal-warning">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p id="warning-msg">error</p>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- jQuery 3 -->
<script src="<?php echo SITEURL?>/resources/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo SITEURL?>/resources/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo SITEURL?>/resources/bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo SITEURL?>/resources/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo SITEURL?>/resources/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo SITEURL?>/resources/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo SITEURL?>/resources/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo SITEURL?>/resources/dist/js/demo.js"></script>
<!-- page script -->
<script src="<?php echo SITEURL?>/resources/formcheck.js"></script>
<!-- Select2 -->
<script src="<?php echo SITEURL?>/resources/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$(function () {
  //Initialize Select2 Elements
  $('.select2').select2()
  $("#sure").click(function(options){
    console.log($("#parentId").val(),$("#uri").val(),$("#icon").val(),$("#order").val(),$("#title").val())
    // 提交
    $.post(
      "/Admin/MenuAdd",
      {
        submit:"submit",
        parentId:$("#parentId").val(),
        uri:$("#uri").val(),
        // icon:$("#icon").val(),
        icon:'icon',
        order:$("#order").val(),
        title:$("#title").val(),
      },
      function(res){
        console.log(res)
        if(res>0){
          // $("#sureAdd").modal("hide")
          $("#modal-title").html("添加成功!")
          setTimeout(() => {
            $("#sureAdd").modal("hide")
            $(window).attr('location','/Admin/getMenuList')
            setTimeout(() => {
              $("#modal-title").html("确定要添加?")
            }, 500);
          }, 500);
        }
      }
    )
  })
})
</script>
</body>
</html>
