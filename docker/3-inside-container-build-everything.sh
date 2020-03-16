do-default
chown -R fo:apache /var/lib/php/session
chmod -R 777  /var/lib/php/session
mkdir /supervisor && chown -R ${FO_UID}:${FO_GID} /supervisor
cp -f /configs/supervisord.conf /etc/