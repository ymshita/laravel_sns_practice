FROM mysql:8.0

ENV MYSQL_DATABASE=laravel_sns \
  MYSQL_USER=dev \
  MYSQL_PASSWORD=dev111 \
  MYSQL_ROOT_PASSWORD=dev111 \
  TZ=Asia/Tokyo

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod 644 /etc/mysql/conf.d/my.cnf