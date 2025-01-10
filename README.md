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



# 4. running tests
- first go to docker container with php app and type in commands
  ```
  cd /app
  php bin/phpunit tests/UnitTests.php
  ```

# 5. API

- add coasters
```
POST http://localhost:8088/api/coasters
{
    "liczba_personelu": 10,
    "liczba_klientow": 200,
    "dl_trasy": 24,
    "godziny_od": "7:10",
    "godziny_do": "17:10"
}
```

- add wagon to coaster
```
POST http://localhost:8088/api/coasters/{coaster_id}/wagons
{
    "ilosc_miejsc": 10,
    "predkosc_wagonu": 5.9
}
```

- delete wagon from coaster
```
DELETE http://localhost:8088/api/coasters/{coaster_id}/wagons/{wagon_id}

```

- update coaster
```
PUT http://localhost:8088/api/coasters/{coaster_id}
{
    "liczba_personelu": 20,
    "liczba_klientow": 100,
    "godziny_od": "8:20",
    "godziny_do": "17:35"
}
```