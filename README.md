# roller_coaster_app
system to help managing roller coasters to optymize number of wagons and coasters needed



# requirements
app launched on 
docker version 20.10.11
docker-compose 1.29.2


# 1. run Redis server 
```
  docker-compose -f docker-compose-redis.yml up --build
```
# 2. Check the redis IP and set address IP for redis server on the prod and dev environment app
For DEV
 ```
docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' roller_coaster_redis_dev
```
next update this env variable "redis_host" from this file ./app/app_dev.env

and next for PROD 
 ```
docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' roller_coaster_redis_prod
```
next update this env variable "redis_host" from this file ./app/app_prod.env
# 3. run App 

```
  docker-compose up --build
```





- add coasters
```
POST http://localhost:8000/api/coasters
{
  
}
```


# 4. running tests
- first go to docker container with php app and type in commands
  ```
  cd /app
  php bin/phpunit tests/Tests.php
  ```