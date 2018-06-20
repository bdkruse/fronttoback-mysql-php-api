# fronttoback-mysql-php-api
This is the PHP API component that is a requirement for the [front to back data demo](https://github.com/bdkruse/Front-Back-Data-Demo)

### Prerequisites
```
Web Server Stack supporting MySQL and PHP, something like:
LAMP https://bitnami.com/stack/lamp/installer
WAMP http://www.wampserver.com/en/
```

### Getting Started
Download or clone this repository into your web hosting folder, the folder should be called "fronttoback-mysql-php-api"

Create a database named mysql_php_demo by following the commandline directions or use your favorite application.

After logging into MySQL
```
mysql> CREATE DATABASE mysql_php_demo;
```
Open command line and navigate to your mysql installiation bin folder. Run the following, adjusting the file path to the mysql-php-dump.sql file in the root directory of this project.
```
mysql -u [username] -p mysql_php_demo < _path_/_to_/_file_/mysql-php-dump.sql
```
Configure the connection using the src/config/db.php file to match your mysql login credientials. 

Start your web server and test the api is working using: 
```
http://localhost/fronttoback-mysql-php-api/public/football
```