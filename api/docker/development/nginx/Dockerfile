ARG NGINX_VERSION

FROM nginx:${NGINX_VERSION}-alpine

COPY ./common/nginx/conf.d /etc/nginx/conf.d

WORKDIR /application
