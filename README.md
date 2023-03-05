Demo support ticketing project based on Laravel 8.

Project is partly generated with [QuickAdminPanel](https://2019.quickadminpanel.com)

---

![Laravel Support Tickets 01](https://laraveldaily.com/wp-content/uploads/2019/11/Screen-Shot-2019-11-15-at-6.11.07-PM.png)

---

![Laravel Support Tickets 02](https://laraveldaily.com/wp-content/uploads/2019/11/Screen-Shot-2019-11-15-at-6.11.34-PM.png)

---

![Laravel Support Tickets 03](https://laraveldaily.com/wp-content/uploads/2019/11/Screen-Shot-2019-11-15-at-6.11.48-PM.png)

---

![Laravel Support Tickets 04](https://laraveldaily.com/wp-content/uploads/2019/11/Screen-Shot-2019-11-15-at-6.12.10-PM.png)

---

![Laravel Support Tickets 05](https://laraveldaily.com/wp-content/uploads/2019/11/Screen-Shot-2019-11-15-at-6.12.33-PM.png)

---

![Laravel Support Tickets 06](https://laraveldaily.com/wp-content/uploads/2019/11/Screen-Shot-2019-11-15-at-6.17.59-PM.png)

---

## How to use

Amiket javítani kellett:
- sudo apt-get install php7.4-mbstring
- sudo apt-get install php7.4-xml
- sudo apt-get install php7.4-xmlwriter
- wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
- composer update
- php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
- php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
- php composer-setup.php
- php -r "unlink('composer-setup.php');"
- composer update
- sudo mv composer.phar /usr/local/bin/composer
- reboot
----------------------------------------------------------
- docker-compose fileba a DB user nem lehet rootű
- a redis container nem fért hozzá a ./docker/etc/redis/redis.conf-hoz >>>> sudo chmod -R 777 ./docker/etc/redis/
- Béna, de hardcode-olnom kelett a mysql container IP címét :)
- Nginx containeren belül a /var/www-t át kellet adni a www-data usernek


- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- That's it: launch the main URL 
- If you want to login, click `Login` on top-right and use credentials __admin@admin.com__ - __password__ 
- Agent's credentials are __agent1@agent1.com__ - __password__ 

---

## License

Basically, feel free to use and re-use any way you want.

---

## More from our LaravelDaily Team

- Check out our adminpanel generator [QuickAdminPanel](https://quickadminpanel.com)
- Read our [Blog with Laravel Tutorials](https://laraveldaily.com)
- FREE E-book: [50 Laravel Quick Tips (and counting)](https://laraveldaily.com/free-e-book-40-laravel-quick-tips-and-counting/)
- Subscribe to our [YouTube channel Laravel Business](https://www.youtube.com/channel/UCTuplgOBi6tJIlesIboymGA)
- Enroll in our [Laravel Online Courses](https://laraveldaily.teachable.com/)
