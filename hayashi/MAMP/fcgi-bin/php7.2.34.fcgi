#!/bin/sh
export PHP_FCGI_CHILDREN=4
export PHP_FCGI_MAX_REQUESTS=200
exec /Applications/MAMP/bin/php/php7.2.34/bin/php-cgi -c "/Library/Application Support/appsolute/MAMP PRO/conf/php7.2.34.ini"
