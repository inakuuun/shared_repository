#!/bin/sh

/Applications/MAMP/Library/bin/mysqlcheck --quick --check-upgrade -u root -proot --socket=/Applications/MAMP/tmp/mysql/mysql.sock mysql
