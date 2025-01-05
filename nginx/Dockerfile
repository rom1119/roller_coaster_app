FROM nginx:1.27.3-alpine

ARG ENV_NAME

COPY ./${ENV_NAME}.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /app/public
# COPY ./app/php/public /app/public
WORKDIR /app

