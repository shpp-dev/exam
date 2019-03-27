#do-default install-cacheable "$@"

mkdir -p /var/www/html/storage
mkdir -p /var/www/html/public
mkdir -p /var/www/configs
mkdir -p  /var/log/php-fpm/
touch /var/log/php-fpm/error.log
mkdir -p /run/php-fpm/
mkdir -p /var/log/nginx/
mkdir -p /var/lib/nginx/tmp/client_body

# To build new laravel project just uncomment this line
#cd /var/www/html && composer.phar create-project --prefer-dist laravel/laravel .
chown -R ${FO_UID}:${FO_GID} /var/www
chown -R ${FO_UID}:${FO_GID} /var/log/php-fpm/
chown -R ${FO_UID}:${FO_GID} /run/php-fpm/
chown -R ${FO_UID}:${FO_GID} /etc/php-fpm.d/
chown -R ${FO_UID}:${FO_GID} /etc/php-fpm.conf
chown -R ${FO_UID}:${FO_GID} /var/log/nginx/
chown -R ${FO_UID}:${FO_GID} /var/lib/nginx/
chown -R ${FO_UID}:${FO_GID} /run/
chmod -R u+w,g+w /var/www/html/storage
chmod +x /run

# Set configuration for our site:

sed -i 's/{HOSTNAME}/exam.a.p2p.shpp.me/g' /etc/nginx/conf.d/dumbSite.conf

chown -R ${FO_USER_NAME}:${FO_GROUP_NAME} /var/www/

# Clone repo

chown -R ${FO_UID}:${FO_GID} /var/www/html

cd /deps
function try_install_composer() {
    composer.phar install
}

try_install_composer
cp -r vendor /var/www/html/
ls /var/www/html