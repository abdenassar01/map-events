create table if not exists departement
(
    id   int auto_increment
    primary key,
    name varchar(255) null
    );

create table if not exists user
(
    id       int auto_increment
    primary key,
    username varchar(100) null,
    password varchar(100) null,
    role     varchar(10)  null
    );

create table if not exists event
(
    id             int auto_increment
    primary key,
    departement_id int           null,
    title          varchar(100)  null,
    description    varchar(2555) null,
    type           varchar(100)  null,
    image          varchar(100)  null,
    lng            double        null,
    lat            double        null,
    user_id        int           null,
    start_time     date          null,
    end_time       date          null,
    constraint FK_departement_id
    foreign key (departement_id) references departement (id),
    constraint FK_user_id
    foreign key (user_id) references user (id)
    );

create table if not exists attachment
(
    id       int auto_increment
    primary key,
    event_id int           null,
    path     varchar(1024) null,
    type     varchar(50)   null,
    size     double        null,
    constraint FK_event_id
    foreign key (event_id) references event (id)
    );

