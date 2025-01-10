# roller_coaster_app
system to help managing roller coasters to optymize number of wagons and coasters needed



# requirements
app launched on 
docker version 20.10.11
docker-compose 1.29.2


# 1. run Redis server 
this command run redis instances for prod and dev 
```
  docker-compose -f docker-compose-redis.yml up --build
```
access to redis outside container
dev = localhost:6666
prod = localhost:6667

# 2. Check the redis IP and set address IP for redis server on the prod and dev environment app
For DEV
 ```
docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' roller_coaster_redis_dev
```
next update this env variable "redis_host" in this file ./app/app_dev.env

and next for PROD 
 ```
docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' roller_coaster_redis_prod
```
next update this env variable "redis_host" in this file ./app/app_prod.env
# 3. run App 

```
  docker-compose up --build
```



# 4. console commands
1. running tests
- first go to docker container with php app and type in command
  ```
  cd /app
  php bin/phpunit tests/UnitTests.php
  ```

2. running monitoring coasters
- first go to docker container with php app and type in command, monitoring is updated every 10s
  ```
  cd /app
  php bin/console app:roller-coasters-monitoring
  ```

# 5. API
access host to API
dev = http://localhost:8088
prod = http://localhost:8099

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

# 5. DEV APP is allow only for one IP defined in file ./nginx/dev.conf in line 34
so edit this IP and restrart your app container
if you don't know your outside docker IP check the nginx logs in docker container console 
like this
```
roller_coaster_nginx_dev | 2025/01/10 09:25:48 [error] 30#30: *2 access forbidden by rule, client: 172.22.0.1, server: , request: "POST /api/coasters HTTP/1.1", host: "localhost:8088"
```

for example if you see client: 172.22.0.1   your target IP is 172.22.0.1