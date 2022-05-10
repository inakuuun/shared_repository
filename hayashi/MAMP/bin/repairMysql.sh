#!/bin/sh

/Applications/MAMP/Library/bin/mysqlcheck --all-databases --repair -u root -proot --socket=/Applications/MAMP/tmp/mysql/mysql.sock
