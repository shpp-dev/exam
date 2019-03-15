do-default build-everything "$@"

function fixRights() {
	dir=$1
	user=$2

	echo ""
	echo "...Fixing build rights for dir $dir / user $user"

	mkdir -p $dir/storage/logs
	chown -R $user:$user $dir
	chmod -R 640 $dir
	find $dir -type d -exec chmod 750 {} \;
	chmod -R 770 $dir/bootstrap/cache
	chmod -R 770 $dir/storage
}

echo "* * * * * cd /var/www/html && php artisan schedule:run  >> /dev/null 2>&1 && echo OK >> /tmp/artisanDebug" >> /etc/crontab

cp -r /project/site/* /var/www/html
cp /configs/keys/* /var/www/html

cd /var/www/html
composer.phar install

fixRights /var/www/html ${FO_USER_NAME}