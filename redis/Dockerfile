FROM redis

ARG ENV_NAME


COPY "./conf/redis_${ENV_NAME}.conf" "/usr/local/etc/redis/redis.conf"
CMD [ "redis-server", "/usr/local/etc/redis/redis.conf", "--appendonly", "yes"]
