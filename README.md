# movie_store

***
## Crear la base de datos 
***
```
CREATE DATABASE movie_store;

/*CREAR LAS TABLAS*/

create table movies
(
    id          int auto_increment
        primary key,
    title       varchar(255)                        not null,
    year        int                                 not null,
    author      varchar(255)                        not null,
    category    varchar(255)                        not null,
    description text                                null,
    created_at  timestamp default CURRENT_TIMESTAMP null
);

create table users
(
    id         int auto_increment
        primary key,
    nombre     varchar(150)                        null,
    email      varchar(255)                        not null,
    password   varchar(255)                        not null,
    role       varchar(25)                         not null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    constraint email
        unique (email)
);

create table purchases
(
    id            int auto_increment
        primary key,
    user_id       int                                 not null,
    movie_id      int                                 not null,
    purchase_date timestamp default CURRENT_TIMESTAMP null,
    constraint purchases_ibfk_1
        foreign key (user_id) references users (id),
    constraint purchases_ibfk_2
        foreign key (movie_id) references movies (id)
);

create index movie_id
    on purchases (movie_id);

create index user_id
    on purchases (user_id);

create table reviews
(
    id         int auto_increment
        primary key,
    movie_id   int                                 not null,
    user_id    int                                 not null,
    rating     int                                 not null,
    review     text                                null,
    created_at timestamp default CURRENT_TIMESTAMP null,
    constraint reviews_ibfk_1
        foreign key (movie_id) references movies (id),
    constraint reviews_ibfk_2
        foreign key (user_id) references users (id)
);

create index movie_id
    on reviews (movie_id);

create index user_id
    on reviews (user_id);
```
