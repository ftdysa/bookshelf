FROM nginx:mainline

COPY nginx.conf /etc/nginx/nginx.conf
COPY vhost.conf /etc/nginx/conf.d/default.conf

ARG APP_UPSTREAM_NAME=fpm
ARG APP_UPSTREAM_PORT=9005

RUN sed -i 's/{APP_UPSTREAM_PORT}/'"$APP_UPSTREAM_PORT"'/g' /etc/nginx/conf.d/default.conf
RUN sed -i 's/{APP_UPSTREAM_NAME}/'"$APP_UPSTREAM_NAME"'/g' /etc/nginx/conf.d/default.conf
