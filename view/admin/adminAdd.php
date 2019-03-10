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
<style>
hr{
  margin-top:3px;
  margin-bottom:3px;
}
</style>
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
        <small></small>
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
              <h3 class="box-title">增加管理员</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">账号</label>
                  <div class="col-sm-10">
                    <input type="text" id="username" class="form-control" checkstatus="yes" tag=账号 checklist='{"lengthMax":"3","lengthMin":"20"}' id="title" placeholder="请输入菜单标题">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
                  <div class="col-sm-10">
                    <input type="text" id="password" class="form-control" checkstatus="yes" tag=密码 checklist='{"lengthMax":"3","lengthMin":"20"}' id="title" placeholder="请输入菜单标题">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                  <div class="col-sm-10">
                    <input type="text" id="name" class="form-control" checkstatus="yes" tag=姓名 checklist='{"lengthMax":"2","lengthMin":"20"}' id="title" placeholder="请输入菜单标题">
                  </div>
                </div>
                <?php
                $menuList = $data["menuList"];
                ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">权限</label>
                  <div class="col-sm-10">
                    <?php
                    foreach($menuList as $menuArr){
                      if($menuArr['parent_id'] == 0){
                      ?>
                      <div class="checkbox">
                        <label>
                          <input id="<?php echo $menuArr["id"]?>" parentid="0" type="checkbox"> <span class="label label-default"><?php echo $menuArr["title"]?></span>
                        </label>
                      </div>
                      <div class="checkbox checkbox1">
                        <?php
                        foreach($menuList as $menuZi){
                          if($menuZi["parent_id"] == $menuArr["id"]){
                            ?>
                              <label>
                                <input id="<?php echo $menuZi["id"]?>" parentid="<?php echo $menuArr["id"]?>" type="checkbox"> <?php echo $menuZi["title"]?>
                              </label>
                            <?php
                          }
                        }
                        ?>
                      </div>
                      <hr>
                      <?php
                      }
                    }
                    ?>
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
<script>
  $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
    $(":checkbox").click(function(options){
      if($(this).attr("parentid")==0){ //一级菜单
        let parentid = "#"+$(this).attr("parentid")
        let status = $("#"+this.id).prop("checked")
        if(status){
          $("[parentid="+this.id+"]").prop("checked",true)  //parentId等于当前id的，都设置为选中状态
        }else{
          $("[parentid="+this.id+"]").prop("checked",false)  //parentId等于当前id的，都设置为选中状态
        }
      }else{  //二级菜单
        let parentid = "#"+$(this).attr("parentid")
        let status = false
        let inputList = $("[parentid='"+$(this).attr("parentid")+"']")
        for(let i=0;i<inputList.length;i++){
          if(inputList[i].checked){
            status = true
          }
        }
        if(status){
          $(parentid).prop("checked",true)
        }else{
          $(parentid).prop("checked",false)
        }
      }
    })
    $("#sure").click(function(options){
      console.log("--")
      console.log($("input:checkbox:checked"))
      let checkArr = []
      $("input:checkbox:checked").each(function(res){
        console.log('--',res,this.id)
        checkArr.push(this.id)
      })
      console.log(checkArr)
      console.log($("#username").val())
      console.log($("#password").val())
      console.log($("#name").val())
      let obj = {}
      obj.check = encodeURIComponent(JSON.stringify(checkArr))
      obj.username = $("#username").val()
      obj.password = $("#password").val()
      obj.name = $("#name").val()
      obj.submit = 'submit'
      $.post(
        "/admin/adminAdd",
        obj,
        function(res){
          console.log('res',res)
          if(res>0){
            $("#modal-title").html("添加成功!")
            setTimeout(() => {
              $("#sureAdd").modal("hide")
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
