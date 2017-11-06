# AndyPHP - PHP 运行环境一键安装包
能够在线开设虚拟主机、FTP、MySQL。适用于 x64 位系统，不能运行在 Windows XP 和 2003。 支持: Windows 7 SP1, Vista SP2, 8 / 8.1, Windows 10, Server 2008 SP2 / R2 SP1, Server 2012 / R2, Server 2016.

集成以下环境：

Apache 2.4.29 Win64

PHP 5.6 (5.6.32) VC11 x64 Thread Safe

MariaDB 10.2 Series

FileZilla Server 0.9.60

phpMyAdmin-4.7.5-all-languages

Adminer 4.3.1

## 下载
https://github.com/mingfunwong/AndyPHP/archive/master.zip

## 提示
1. 启动 Apache 需要系统安装有 VC15 环境，可到 http://www.xiazaiba.com/html/6081.html 下载 DirectX Repair V3.5 增强版一键安装。

2. MySQL 账号： root 密码：空 ，建议访问 http://127.0.0.1/reset_mysql.php 重设密码。

3. 虚拟主机编辑 账号：admin 密码：admin

4. 如启动后 PHP 不支持 cURL 则需要把 PHP 目录的 ssleay32.dll libssh2.dll libeay32.dll 三个文件复制到 C:\Windows\System32 目录。

## 使用方法

运行 start 即可启动 Apache 和 MySQL 服务。

运行 ftp_start 启动 FTP 服务。

## 修改虚拟主机
访问 http://127.0.0.1/vhost.php 可在线编辑。

## 一键安装包制作方法备忘录
```
Apache：
1. 到 https://www.apachelounge.com/download/ 下载 Apache 2.x.xx Win64 版，解压放到目录里，命名为 apache
2. 编辑 Apache24\conf\httpd.conf
2.1.1 ServerRoot "c:/Apache24" 前面加入 # 号
2.1.2 ErrorLog "logs/error.log" 前面加入 # 号
2.1.3 CustomLog "logs/access.log" common 前面加入 # 号
2.1.4 修改 LogLevel warn 到 LogLevel crit
2.1.5 修改 LoadModule log_config_module modules/mod_log_config.so 前面加入 # 号
2.2.6 修改 DocumentRoot "c:/Apache24/htdocs" 前面加入 # 号
2.2.7 修改 #LoadModule deflate_module modules/mod_deflate.so 去除前面 # 号
2.2.7 修改 #LoadModule filter_module modules/mod_filter.so 去除前面 # 号
2.4.8 修改 #LoadModule rewrite_module modules/mod_rewrite.so 去除前面 # 号
2.3. 删除
<Directory />
    AllowOverride none
    Require all denied
</Directory>
2.4.
最后在底部加入
ServerName localhost:80
AddType application/x-httpd-php .php
LoadModule php5_module ../php/php5apache2_4.dll
PHPIniDir ../php
Include conf/vhost/*.conf

2.5 在 apache\conf\ 新建目录 vhost ，新建文件 00000.default.conf 写入以下内容
<VirtualHost *:80>
DocumentRoot ../www/default/public_html
</VirtualHost>
<Directory ../www/default>
    Options FollowSymLinks
    DirectoryIndex index.php index.html
    AllowOverride All
    Order allow,deny
    Allow from all
</Directory>


2.6.1 网速限制模块 mod_bw：到 https://www.apachelounge.com/download/ 下载 mod_bw-0.92-win64-VC15.zip 解压放到 apache\modules 目录
2.6.2 在 #LoadModule xml2enc_module modules/mod_xml2enc.so 后面增加一行 LoadModule bw_module modules/mod_bw.so


PHP：
1. 到 http://windows.php.net/download/ 下载 VC11 x64 Thread Safe 版，解压放到目录里，命名为 php
2. php.ini-development 复制到 php.ini
3. 修改文件 php.ini
# extension_dir = "ext" 改为 extension_dir = "../php/ext"
;date.timezone = 改为 date.timezone = Asia/Shanghai
下面直接覆盖
extension=php_bz2.dll
extension=php_curl.dll
extension=php_fileinfo.dll
extension=php_gd2.dll
extension=php_gettext.dll
;extension=php_gmp.dll
;extension=php_intl.dll
;extension=php_imap.dll
;extension=php_interbase.dll
;extension=php_ldap.dll
extension=php_mbstring.dll
extension=php_exif.dll      ; Must be after mbstring as it depends on it
extension=php_mysql.dll
extension=php_mysqli.dll
;extension=php_oci8_12c.dll  ; Use with Oracle Database 12c Instant Client
;extension=php_openssl.dll
;extension=php_pdo_firebird.dll
extension=php_pdo_mysql.dll
;extension=php_pdo_oci.dll
;extension=php_pdo_odbc.dll
;extension=php_pdo_pgsql.dll
extension=php_pdo_sqlite.dll
;extension=php_pgsql.dll
;extension=php_shmop.dll

4. libssh2.dll 复制到 Apache24\bin 目录。

MariaDB：
1. 到 https://downloads.mariadb.org/ 下载 MariaDB 10.x Series 版，解压放到目录里，命名为 mysql
2. 复制 my-medium.ini 为 my.ini

FileZilla Server：
1. 到 https://filezilla-project.org/download.php?type=server 下载安装到目录，命名为 ftp

phpMyAdmin：
1. 到 https://www.phpmyadmin.net/downloads/ 下载 phpMyAdmin-4.x.x-all-languages.zip 版，解压放到 www\default 目录里
2. 复制 phpMyAdmin-4.7.5-all-languages\config.sample.inc.php 为 config.inc.php
3. 编辑 config.inc.php 的 $cfg['Servers'][$i]['AllowNoPassword'] = false; 为 $cfg['Servers'][$i]['AllowNoPassword'] = true;

Adminer：
1. 到 https://www.adminer.org/#download 下载 Adminer 4.x.x 版，放到 www\default 目录里
```