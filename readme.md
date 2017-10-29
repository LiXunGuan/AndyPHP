# AndyPHP - PHP 运行环境一键安装包
适用于 x64 位系统

集成以下环境：

Apache 2.4.29 Win64

PHP 5.6 (5.6.32) VC11 x64 Thread Safe

MariaDB 10.2 Series

phpMyAdmin-4.7.5-all-languages

Adminer 4.3.1

## 下载
https://github.com/mingfunwong/AndyPHP/archive/master.zip

## 提示
启动 Apache 需要系统安装有 VC15 环境，可到 http://www.xiazaiba.com/html/6081.html 下载 DirectX Repair V3.5 增强版一键安装。

MySQL 用户名： root 密码：空

## 使用方法

右击以管理员身份运行 install 即完成安装。

## 修改虚拟主机
编辑 Apache24\conf\extra\httpd-vhosts.conf 文件，然后右击以管理员身份运行 apache_restart 重启 apache 即可生效。

## 一键安装包制作方法备忘录
```
Apache：
1. 到 https://www.apachelounge.com/download/ 下载 Apache 2.x.xx Win64 版，解压放到目录里
2. 编辑 Apache24\conf\httpd.conf
2.1.1 ServerRoot "c:/Apache24" 前面加入 # 号
2.1.2 ErrorLog "logs/error.log" 前面加入 # 号
2.1.3 CustomLog "logs/access.log" common 前面加入 # 号
2.1.4 修改 LogLevel warn 到 LogLevel crit
2.1.5 修改LoadModule log_config_module modules/mod_log_config.so 前面加入 # 号
2.2. 删除 DocumentRoot "c:/Apache24/htdocs"
2.3. 删除
<Directory />
    AllowOverride none
    Require all denied
</Directory>
2.4. 找到 LoadModule rewrite_module modules/mod_rewrite.so 移除 # 号
2.5.
最后在底部加入
ServerName localhost:80
DocumentRoot "../Sites"
<Directory />
    Options FollowSymLinks
    DirectoryIndex index.php index.html
    AllowOverride All
    Order deny,allow
    Allow from all
</Directory>
AddType application/x-httpd-php .php
LoadModule php5_module ../php-5.6.32-Win32-VC11-x64/php5apache2_4.dll
PHPIniDir ../php-5.6.32-Win32-VC11-x64
Include conf/extra/httpd-vhosts.conf
3. 复制 Apache24\conf\extra\httpd-vhosts.conf 为 httpd-vhosts.conf.bak
4. 覆盖 Apache24\conf\extra\httpd-vhosts.conf 内容是：
<VirtualHost *:80>
    DocumentRoot "../Sites/default"
    ServerName localhost
    ServerAlias 127.0.0.1
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "../Sites/domain1.com"
    ServerName domain1.lvh.me
</VirtualHost>

PHP：
1. 到 http://windows.php.net/download/ 下载 VC11 x64 Thread Safe 版，解压放到目录里
2. php.ini-development 复制到 php.ini
3. 修改文件 php.ini
# extension_dir = "ext" 改为 extension_dir = "../php-5.6.32-Win32-VC11-x64/ext"
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

MariaDB：
1. 到 https://downloads.mariadb.org/ 下载 MariaDB 10.x Series 版，解压放到目录里
2. 复制 my-medium.ini 为 my.ini

phpMyAdmin：
1. 到 https://www.phpmyadmin.net/downloads/ 下载 phpMyAdmin-4.x.x-all-languages.zip 版，解压放到 Sites\default 目录里
2. 复制 phpMyAdmin-4.7.5-all-languages\config.sample.inc.php 为 config.inc.php
3. 编辑 config.inc.php 的 $cfg['Servers'][$i]['AllowNoPassword'] = false; 为 $cfg['Servers'][$i]['AllowNoPassword'] = true;

Adminer：
1. 到 https://www.adminer.org/#download 下载 Adminer 4.x.x 版，放到 Sites\default 目录里
```