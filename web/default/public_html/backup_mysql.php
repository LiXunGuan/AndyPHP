<?php
// error_reporting(0);
ini_set('max_execution_time', '0');
$host = 'localhost';
$user = 'root';
$passwd = '';
$con = mysqli_connect($host, $user, $passwd);
if (!$con){die('Could not connect: ' . mysqli_connect_error());}
$result = mysqli_query($con, 'show databases');
$data = array();
$path = "./mysql_backup/" . date("Y-m-d_H-i-s") . "/";
mk_dir($path);
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $dbname = $row['Database'];
    mysqli_select_db($con, $dbname);
    $mysql = "set names utf8;\n";
    mysqli_query($con, $mysql);
    $tables = mysqli_query($con, 'show tables');
    while ($t = $tables->fetch_array()) {
        $table = $t[0];
        $mysql .= dump_table($con, $table);
    }
    $filename = $path . $dbname . ".sql";
    file_put_contents($filename, $mysql);
}
echo "Backedup  data successfully.";
function dump_table($con, $table)
{
    $q2 = mysqli_query($con, "show create table {$table}");
    $sql = $q2->fetch_array();
    $mysql = "DROP TABLE IF EXISTS {$table};\n";
    $mysql .= $sql['Create Table'] . ";\n";
    $q3 = mysqli_query($con, "select * from {$table}");
    while ($data = $q3->fetch_array(MYSQLI_ASSOC)) {
        $keys = array_keys($data);
        $keys = array_map('addslashes', $keys);
        $keys = join('`,`', $keys);
        $keys = "`" . $keys . "`";
        $vals = array_values($data);
        $vals = array_map('addslashes', $vals);
        $vals = join("','", $vals);
        $vals = "'" . $vals . "'";
        $mysql .= "insert into `{$table}`({$keys}) values({$vals});\n";
    }
    $mysql .= "\n";
    return $mysql;
}
function mk_dir($dir, $mode = 0755)
{
    if (is_dir($dir) || @mkdir($dir, $mode)) {
        return true;
    }
    if (!mk_dir(dirname($dir), $mode)) {
        return false;
    }
    return @mkdir($dir, $mode);
}
