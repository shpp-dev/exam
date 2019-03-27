do-default start-working "$@"

#php-fpm -F --pid /opt/bitnami/php/tmp/php-fpm.pid -y /opt/bitnami/php/etc/php-fpm.conf
echo "Hey, we're running now!"
cd ${projectDir}

if [ -f /var/www/env/.env ]
then
	cp /var/www/env/.env /var/www/html/.env
	echo "...no need generate new key!..."
else
    echo "...new key required!..."
	cp /configs/env /var/www/html/.env
	cd /var/www/html
	php artisan key:generate
	echo "...Saving key (please, do not loose it)..."
	cp .env /var/www/env/
fi

bash /project/docker/4-inside-container-migrate.sh

# Configure cron:
crontab /etc/crontab
crond;

php-fpm -y /etc/php-fpm.conf
nginx -g 'daemon off;'