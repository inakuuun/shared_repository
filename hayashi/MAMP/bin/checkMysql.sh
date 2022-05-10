#!/bin/sh

/Applications/MAMP/Library/bin/mysqlcheck --all-databases --check --check-upgrade -u root -proot --socket=/Applications/MAMP/tmp/mysql/mysql.sock
