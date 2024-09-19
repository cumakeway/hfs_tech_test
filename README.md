## How to run

<li> git clone project </li>
<li> run `docker-compose up` to create docker container </li>
<li> start apache server in docker container. First type `bash` in command line of docker container. Then `service apache2 start`</li>
<li> run `composer install` </li>
<li> setup database credentials in .env </li>
<li> run `php artisan jwt:secret` to generate jwt key </li>
