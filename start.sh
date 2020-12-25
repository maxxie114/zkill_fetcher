#!/bin/bash
while true
do
    # -Xms -- initial java heap space
    # -Xmx -- maximum java heap space
    php -f zkill_fetch.php
    echo "If you want to completely stop the server process now, press Ctrl+C before the time is up!"
    echo "Rebooting in:"
for i in 5 4 3 2 1
do
    echo -en "\r$i"
    sleep 1
done
    echo "Rebooting now!"
done