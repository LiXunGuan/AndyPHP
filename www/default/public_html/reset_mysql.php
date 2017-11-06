<meta charset='utf-8'>

<?php
define('MYSQL_HOSTNAME', 'localhost');
define('MYSQL_USERNAME', 'root');
define('MYSQL_PASSWORD', 'bBG5q9MxPo');

$new_password = random();

$con = mysqli_connect(MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD);
if (!$con){die('Could not connect: ' . mysql_error());}

$sql = "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('{$new_password}');";
mysqli_query($con, $sql);

$user = 'root';
$host = '127.0.0.1';
$sql = "REVOKE ALL PRIVILEGES ON `{$user}`.* FROM '{$user}'@'{$host}';DROP USER '{$user}'@'{$host}';";
mysqli_query($con, $sql);

$user = 'root';
$host = ' ::1';
$sql = "REVOKE ALL PRIVILEGES ON `{$user}`.* FROM '{$user}'@'{$host}';DROP USER '{$user}'@'{$host}';";
mysqli_query($con, $sql);

$user = '';
$host = 'localhost';
$sql = "REVOKE ALL PRIVILEGES ON `{$user}`.* FROM '{$user}'@'{$host}';DROP USER '{$user}'@'{$host}';";
mysqli_query($con, $sql);

mysqli_close($con);

echo "设置成功，新密码：{$new_password}";

$file = "./reset_mysql.php";
$content = file_get_contents($file);
$content = preg_replace("/define\('MYSQL_PASSWORD'.*/", "define('MYSQL_PASSWORD', '{$new_password}');", $content, 1);
file_put_contents($file, $content);

$file = "./vhost.php";
$content = file_get_contents($file);
$content = preg_replace("/define\('MYSQL_PASSWORD'.*/", "define('MYSQL_PASSWORD', '{$new_password}');", $content, 1);
file_put_contents($file, $content);

function random($length = 10){
  $str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $s = '';
  $len = strlen($str)-1;
  for($i=0 ; $i<$length; $i++){
      $s .= $str[rand(0,$len)];
  }
  return $s;
}
