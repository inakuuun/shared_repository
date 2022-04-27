#!/bin/sh

/Applications/MAMP/Library/bin/mysqld_safe --port=8889 --socket=/Applications/MAMP/tmp/mysql/mysql.sock --pid-file=/Applications/MAMP/tmp/mysql/mysql.pid --log-error=/Applications/MAMP/logs/mysql_error.log &
