<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>

    <div class="container">
      <div class="page-header">
        <h1><a href="<?php echo $_SERVER['SCRIPT_URI'] ?>">编辑虚拟主机</a></h1>
      </div>
      <?php echo action() ?>
      <form class="form-inline" action="" enctype="multipart/form-data" method="post">
        <div class="form-group">
          <label >
            域名
            <input type="text" class="form-control" value="1.lvh.me" name="domain">
          </label>
        </div>
        <div class="form-group">
          <label>
            目录
            <input type="text" class="form-control" value="1.lvh.me" name="dir">
          </label>
        </div>
        <input type="hidden" name="act" value="add">
        <button type="submit" class="btn btn-default">增加</button>
      </form>
      <h3>虚拟主机列表</h3>
      <table class="table table-condensed">
      <thead>
        <tr>
          <th>#</th>
          <th>域名</th>
          <th>目录</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      <?php $i = 0; foreach (get_list() as $key => $value) : $i++; ?>
        <tr>
          <th scope="row"><?php echo $i ?></th>
          <td><a href='http://<?php echo $key ?>/' target='_blank'><?php echo $key ?></a></td>
          <td><?php echo $value ?></td>
          <td><a href="javascript:if(confirm('是否要删除所选域名？'))window.location='?act=del&domain=<?php echo $key ?>'">删除</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
      </table>
    </div>



  </body>
</html>
<?php

function action() {
  // 新增
  if (from($_POST, 'act') == 'add') {
    $domain = from($_POST, 'domain');
    $dir = from($_POST, 'dir');
    if (!$domain) return "<div class='alert alert-danger'>请填写域名</div>";
    if (!$dir) return "<div class='alert alert-danger'>请填写目录</div>";
    $list = get_list();
    if (isset($list[$domain])) {
      return "<div class='alert alert-danger'>域名已存在，点击访问 <a href='http://{$domain}/' target='_blank'>http://{$domain}/</a></div>";
    } else {
      $dir = pathinfo($_SERVER['DOCUMENT_ROOT'] . "../")['dirname'] . '/' . $dir;
      $list[$domain] = $dir;
      save_list($list);
      if (!file_exists($dir)) {
        mkdir($dir);
        file_put_contents("{$dir}/index.html", "<meta charset='utf-8'>虚拟主机创建成功！域名：{$domain}");
      }
      return "<div class='alert alert-success'>虚拟主机增加成功，点击访问 <a href='http://{$domain}/' target='_blank'>http://{$domain}/</a></div>";
    }
  }
  // 删除
  if (from($_GET, 'act') == 'del') {
    $domain = from($_GET, 'domain');
    $list = get_list();
    if (isset($list[$domain])) unset($list[$domain]);
    save_list($list);
    return "<div class='alert alert-success'>域名删除成功</div>";
  }
}


function get_list() {
  $file = './vhost.txt';
  $content = file_get_contents($file);
  $data = explode("\n", $content);
  $items = array();
  foreach ($data as $key => $value) {
    if ($value) {
      list($domain, $dir) = explode(" ", $value);
      $items[$domain] = $dir;
    }
  }
  return $items;
}

function save_list($items) {
  $file = './vhost.txt';
  $data = '';
  foreach ($items as $key => $value) {
    if ($key)
      $data .= "{$key} {$value}\n";
  }
  file_put_contents($file, $data);
}



function from($array, $key, $default = FALSE)
{
  $return = $default;
  if (is_object($array)) $return = (isset($array->$key) === TRUE && empty($array->$key) === FALSE) ? $array->$key : $default;
  if (is_array($array)) $return = (isset($array[$key]) === TRUE && empty($array[$key]) === FALSE) ? $array[$key] : $default;
  return $return;
}

?>