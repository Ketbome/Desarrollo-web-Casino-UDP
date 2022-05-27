# Desarrollo-web-Casino-UDP
sudo apt-get update

 

# Instalar Apache:

sudo apt-get install apache2

sudo chown -R ubuntu:ubuntu /var/www/html

 

# Instalar PHP:

sudo apt-get install php libapache2-mod-php

 

#Instalar Mongo:

 

sudo apt-get install mongodb

 

sudo apt-get install php-pear php-dev

sudo pecl install mongodb

 

#OJO AQUI CON LA VERSIÓN DE PHP

sudo -s

echo "extension=mongodb.so" > /etc/php/7.4/cli/conf.d/mongodb.ini

echo "extension=mongodb.so" > /etc/php/7.4/apache2/conf.d/mongodb.ini

exit

 

sudo apt-get install composer

cd /var/www/html

composer update

 

composer require mongodb/mongodb

composer update

 

sudo service apache2 restart

-------------------------------------------------------------------
Hoy vamos a ver como completar nuestra Progressive Web App.

https://www.youtube.com/watch?v=Z3s7szNK9QI (Enlaces a un sitio externo.)


Para hacerlo vamos a ver como crear un dominio gratuito con Freenom (https://www.freenom.com/es/index.html?lang=es (Enlaces a un sitio externo.)) y como activar https con Cloudflare (https://www.cloudflare.com/ (Enlaces a un sitio externo.)). Saber gestionar dominios y Cloudflare es muy util para sus vida profesional.

Se adjuntan tambien los archivos que se usan en el video: https://drive.google.com/file/d/1RK7KoutmIinqzORxoAK0cdHsF4su5iz4/view?usp=sharing (Enlaces a un sitio externo.)

_______________________

IMPORTANTE: las personas que prefieren costruir su API en Express.js  (en vez que PHP) necesitan activar HTTPS (https://hackernoon.com/set-up-ssl-in-nodejs-and-express-using-openssl-f2529eab5bb (Enlaces a un sitio externo.)) tambien en Express.js (y detras de Cloudflare) y permitir el aceso desde cualquier origin (CORS: https://expressjs.com/en/resources/middleware/cors.html (Enlaces a un sitio externo.)).

Para hacerlo pueden seguir este video (en este caso, no olviden abrir la puerta 2053 en AWS):
https://www.youtube.com/watch?v=UrColtMxkYs
