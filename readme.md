# Introduction to Database Systems 2018 fall
# A Browser-Server forum using mysql

apache server for windows: https://www.apachelounge.com/download/
httpd -k install
AH00558: httpd: Could not reliably determine the server's fully qualified domain name, using fe80::2c20:bca8:cb79:6163. Set the 'ServerName' directive globally to suppress this message
add "ServerName localhost" in httpd.conf
httpd -k start -n Apache2.4
httpd -k stop -n Apache2.4
change DocumentRoot in http.conf 
in browser: http://localhost/

install mysql
unzip
create my.ini in base dir:
    [mysqld]
    # set basedir to your installation path
    basedir=E:/mysql
    # set datadir to the location of your data directory
    datadir=E:/mydata/data
data directory initialization:
bin\mysqld --defaults-file=my.ini --initialize --console

start the server:
bin\mysqld --console

install:
mysqld install
start the service:
net start mysql
if we log in the local mysql:
mysql -u root -p

add to httpd.conf of Apache:
    # PHP8 module
    PHPIniDir ""
    LoadModule php_module "E:/Programs/php-8.0.14-Win32-vs16-x64/php8apache2_4.dll"
    AddType application/x-httpd-php .php

in php.ini:
    extension=mysqli
    extension_dir = "E:/Programs/php-8.0.14-Win32-vs16-x64/ext"

to begin with the forum:
caution: change the user name and password in backend_utils/conn_db.php
go to http://localhost/frontend_utils/create_db_table.html select "create all tables"
then go to http://localhost/ and use it

