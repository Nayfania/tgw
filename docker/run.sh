#!/bin/bash

#enable xdebug
echo "xdebug.mode = debug" >>  /etc/php/8.1/mods-available/xdebug.ini
echo 'xdebug.start_with_request = 1' >> /etc/php/8.1/mods-available/xdebug.ini
echo 'xdebug.discover_client_host = 1' >> /etc/php/8.1/mods-available/xdebug.ini
echo 'xdebug.log_level = 0' >> /etc/php/8.1/mods-available/xdebug.ini

#RUN apps in container
apache2ctl start

#run it until SIGTERM
while true
do
  tail -f /dev/null & wait ${!}
done
