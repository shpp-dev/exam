supervisord -c /etc/supervisord.conf

cd /project/site
-c "php artisan ptp:config-update"

do-default
