<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"E:\phpStudy\WWW\tplay\public/../application/admin\view\attachment\index.html";i:1513645503;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="__PUBLIC__/layui/css/layui.css"  media="all">
  <link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css" media="all" />
  <link rel="stylesheet" href="__CSS__/admin.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
  <style type="text/css">

/* tooltip */
#tooltip{
  position:absolute;
  border:1px solid #ccc;
  background:#333;
  padding:2px;
  display:none;
  color:#fff;
}
</style>
</head>
<body>
<fieldset class="layui-elem-field site-demo-button" style="margin-top: 30px;border:0"> 
<div class="layui-btn-group demoTable">
    <button type="button" class="layui-btn layui-btn-sm" id="test"><i class="layui-icon"></i>上传文件</button>
</div>
</fieldset>
<!-- <blockquote class="layui-elem-quote layui-quote-nm" style="margin:10px 20px;">注：由后台(admin模块)上传的文件默认为审核通过状态，另：模块为admin的文件，其上传id是指管理员id。</blockquote> -->
<table class="layui-table" lay-even="" lay-skin="row" lay-size="sm">
  <!-- <colgroup>
    <col width="50">
    <col width="80">
    <col width="100">
    <col width="150">
    <col width="150">
    <col width="200">
    <col width="200">
    <col width="200">
    <col width="100">
  </colgroup> -->
  <thead>
    <tr>
      <th>编号</th>
      <th>预览</th>
      <th>模块</th>
      <th>用途</th>
      <th>路径+名称</th>
      <th>大小</th>
      <th>格式</th>
      <th>上传id</th>
      <th>上传IP</th>
      <th>上传时间</th>
      <th>状态</th>
      <th>审核者</th>
      <th>审核时间</th>
      <th>已下载</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
    <?php if(is_array($attachment) || $attachment instanceof \think\Collection || $attachment instanceof \think\Paginator): $i = 0; $__LIST__ = $attachment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
      <td><?php echo $vo['id']; ?></td>
      <td><?php if($vo['fileext'] == 'zip'): ?><i class="fa fa-file"></i><?php else: ?><a href="<?php echo $vo['filepath']; ?>" class="tooltip"><img src="<?php echo $vo['filepath']; ?>" width="20" height="20"></a><?php endif; ?></td>
      <td><?php echo $vo['module']; ?></td>
      <td><?php echo $vo['use']; ?></td>
      <td><?php echo $vo['filepath']; ?></td>
      <td><?php echo round($vo['filesize']/1024,2); ?>KB</td>
      <td><?php echo $vo['fileext']; ?></td>
      <td><?php echo $vo['user_id']; ?></td>
      <td><?php echo $vo['uploadip']; ?></td>
      <td><?php echo $vo['create_time']; ?></td>
      <td><?php if($vo['status'] == 0): ?><span class="layui-badge layui-bg-orange">待审核</span><?php elseif($vo['status'] == 1): ?><span class="layui-badge">已审核</span><?php else: ?><span class="layui-badge layui-bg-gray">已拒绝</span><?php endif; ?></td>
      <td><?php echo $vo['admin']['nickname']; ?></td>
      <td><?php echo date("Y-m-d",$vo['audit_time']); ?></td>
      <td><?php echo $vo['download']; ?></td>
      <td class="operation-menu">
        <button class="layui-btn layui-btn-xs open" data-id="<?php echo $vo['id']; ?>"><i class="layui-icon"></i></button>
        <a class="layui-btn layui-btn-xs download" data-id="<?php echo $vo['id']; ?>" id="download<?php echo $vo['id']; ?>" style="margin-right: 0"><i class="fa fa-download"></i></a>
        <button class="layui-btn layui-btn-xs delete" id="<?php echo $vo['id']; ?>"><i class="layui-icon"></i></button>
      </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
</table>
<div style="padding:0 20px;"><?php echo $attachment->render(); ?></div>
        
<script src="__PUBLIC__/layui/layui.js" charset="utf-8"></script>
<script src="__PUBLIC__/jquery/jquery.min.js"></script>
<script>
        var message;
        layui.config({
            base: '__JS__/',
            version: '1.0.1'
        }).use(['app', 'message'], function() {
            var app = layui.app,
                $ = layui.jquery,
                layer = layui.layer;
            //将message设置为全局以便子页面调用
            message = layui.message;
            //主入口
            app.set({
                type: 'iframe'
            }).init();
        });
    </script> 
<script type="text/javascript">
$(function(){
  var x = 10;
  var y = 20;
  $(".tooltip").mouseover(function(e){ 
    var tooltip = "<div id='tooltip'><img src='"+ this.href +"' alt='预览图' height='200'/>"+"<\/div>"; //创建 div 元素
    $("body").append(tooltip);  //把它追加到文档中             
    $("#tooltip")
      .css({
        "top": (e.pageY+y) + "px",
        "left":  (e.pageX+x)  + "px"
      }).show("fast");    //设置x坐标和y坐标，并且显示
    }).mouseout(function(){  
    $("#tooltip").remove();  //移除 
    }).mousemove(function(e){
    $("#tooltip")
      .css({
        "top": (e.pageY+y) + "px",
        "left":  (e.pageX+x)  + "px"
      });
  });
})

$('.delete').click(function(){
  var id = $(this).attr('id');
  layer.confirm('确定要删除?', function(index) {
    $.ajax({
      url:"<?php echo url('admin/attachment/delete'); ?>",
      data:{id:id},
      success:function(res) {
        layer.msg(res.msg);
        if(res.code == 1) {
          setTimeout(function(){
            location.href = res.url;
          },1500)
        }
      }
    })
  })
})


$('.download').on('click',function(event){
    var data_id = $(this).attr('data-id');
    var id = $(this).attr('id');
    var download = document.getElementById(id);
    $.ajax({
      url:"<?php echo url('admin/attachment/download'); ?>",
      data:{id:data_id},
      async:false,
      success:function(res) {
        console.log('res:'+res.code);
        if(res.code == 1) {
          download.setAttribute('href',res.data);
          download.setAttribute('download',res.name);
          // download.click();
          i++;
        } else {
          layer.msg(res.msg);
        }
      }
    }) 
})
</script>
<script type="text/javascript">
  layui.use('layer', function(){
    var layer = layui.layer;
    $('.open').click(function(){
      var id = $(this).attr('data-id');
      layer.msg('文件审核',{
        time:20000
        ,btn: ['仁慈通过', '残忍拒绝', '再想想']
        ,yes: function(index, layero){
          $.ajax({
            url:"<?php echo url('admin/attachment/audit'); ?>"
            ,type:'post'
            ,data:{id:id,status:'1'}
            ,success:function(res){
              layer.msg(res.msg);
              if(res.code == 1){
                setTimeout(function(){
                  location.href = res.url;
                },1500)
              }
            }
          })
        }
        ,btn2: function(index, layero){
          $.ajax({
            url:"<?php echo url('admin/attachment/audit'); ?>"
            ,type:'post'
            ,data:{id:id,status:'-1'}
            ,success:function(res){
              layer.msg(res.msg);
              if(res.code == 1){
                setTimeout(function(){
                  location.href = res.url;
                },1500)
              }
            }
          })
        }
      })
    })
  });              
</script>

<script>
layui.use('upload', function(){
  var $ = layui.jquery
  ,upload = layui.upload;
  
  //指定允许上传的文件类型
  upload.render({
    elem: '#test'
    ,url: "<?php echo url('admin/attachment/upload'); ?>"
    ,accept: 'file' //普通文件
    ,exts: 'zip|rar|7z' //只允许上传压缩文件
    ,done: function(res){
      layer.msg(res.msg);
      if(res.code == 1) {
        setTimeout(function(){
          location.href = res.url;
        },1500)
      }
    }
  }); 
});
</script>
</body>
</html>
