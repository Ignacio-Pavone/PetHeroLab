create database  if not exists pethero; 
use pethero;

create table Owners(
id_owner int AUTO_INCREMENT,
email varchar(60) unique,
fullname varchar(60),
dni varchar(10) unique,
age int,
password varchar(60),
constraint pk_id_duenio primary key (id_owner)
);


create table Guardians(
id_guardian int AUTO_INCREMENT,
email varchar(60) unique,
fullname varchar(60),
dni varchar(10) unique,
age int,
password varchar(60),
pet_size ENUM('Chico','Mediano','Grande'),
reputation float,
fee double,
init_date date,
finish_date date,
constraint pk_id_guardian primary key (id_guardian)
);

create table Pets(
id_pet int AUTO_INCREMENT,
id_owner int,
name varchar(60),
type varchar(60),
breed varchar(60),
pet_size ENUM('Chico','Mediano','Grande'),
vaccination_schedule varchar(512),
photo_url varchar(512),
video_url varchar(512),
constraint pk_id_pet primary key (id_pet),
constraint fk_id_owner_d foreign key(id_owner) references Owners(id_owner)
);


create table payments(
id_payment int auto_increment,
id_owner int,
price float,
payment_method varchar(60),
payment_date date,
constraint pk_id_payment primary key (id_payment),
constraint fk_id_owner_p foreign key (id_owner) references Owners(id_owner)
);

create table Requests(
    id_request int auto_increment,
	id_pet int,
    id_owner int,
    id_guardian int,
    init_date date,
    finish_date date,
    req_status ENUM('Pendiente','Confirmado',"En Curso",'Rechazado',"Completo","Calificado"),
    score float default null,
    final_price float,
    type varchar(50),
    breed varchar(50),
    days_amount int,
    constraint pk_id_request primary key (id_request),
    constraint fk_id_owner_r foreign key (id_owner) references owners(id_owner),
    constraint fk_id_guardian_r foreign key (id_guardian) references guardians(id_guardian),
    constraint fk_id_pet_r foreign key (id_pet) references Pets(id_pet)
);