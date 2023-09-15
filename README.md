# CurrencyConverter
Currency converter based on Yii2

## Install
You need installed <b>docker</b> and <b>docker-compose</b>

1. Clone repo to your directory;
2. Run containers (you can run from root directory <code>docker-compose -f docker/docker-compose.yml up -d</code>);
3. Connecting to the container <code>docker exec -it docker-app-1 bash</code>;
4. Run <code>composer install</code> and <code>php /var/www/app/yii migrate</code> in php container;
   
