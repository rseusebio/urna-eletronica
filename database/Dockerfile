FROM mysql

COPY create_all.sql  /docker-entrypoint-initdb.d/

ENV MYSQL_ROOT_PASSWORD=MYSQL_ROOT_PASSWORD
ENV MYSQL_DATABASE=MYSQL_DATABASE
# ENV MYSQL_USER=MYSQL_USER
# ENV MYSQL_PASSWORD=MYSQL_PASSWORD

EXPOSE 3306

# CMD ["mysql", "--user=root", "--password=MYSQL_ROOT_PASSWORD" , "-e",  "alter user 'MYSQL_USER'@'%' identified with mysql_native_password by 'MYSQL_PASSWORD';"]