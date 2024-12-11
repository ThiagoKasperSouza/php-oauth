# PHP OAUTH - exemplo

## Docs das credenciais
https://developers.google.com/identity/protocols/oauth2/javascript-implicit-flow?hl=pt-br

## criar um ambiente local do composer
curl -sS https://getcomposer.org/installer | php

## rodar:
php -S localhost:8000


## Exemplo de db

### instalar docker
https://docs.docker.com/engine/install/

### docker sem sudo
https://cursos.alura.com.br/forum/topico-executar-o-docker-sem-precisar-de-sudo-50764
https://stackoverflow.com/questions/48957195/how-to-fix-docker-got-permission-denied-issue


### comando para criar container de exemplo  (postgresql)

docker network create -d bridge --subnet=192.168.0.0/24 --gateway=192.168.0.1 my_custom_network

docker run -d --name my_postgres_container --network my_custom_network -e POSTGRES_PASSWORD=mysecretpassword -p 5432:5432 postgres

docker exec -it my_postgres_container bash


### comandos para configurar banco de teste

psql -U postgres

CREATE DATABASE meu_db;

\c meu_db;

CREATE TABLE USERS (
    ID SERIAL PRIMARY KEY,
    NAME VARCHAR(40) NOT NULL,
    EMAIL VARCHAR(30) NOT NULL UNIQUE,
);

INSERT INTO USERS (NAME,EMAIL) VALUES
('João Silva', 'joao.silva@example.com'),
('Maria Oliveira', 'maria.oliveira@example.com'),
('Carlos Pereira', 'carlos.pereira@example.com');

\dt

SELECT * FROM users;

### credenciais para teste:

dsn pgsql:host=ip:5432;dbname=meu_db
postgres
mysecretpassword