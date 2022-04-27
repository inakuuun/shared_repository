#!/bin/sh

/Applications/MAMP/Library/bin/mysql_upgrade -u root -proot --socket=/Applications/MAMP/tmp/mysql/mysql.sock --force --verbose
