drop database if exists giftOfGivingdb;
create database if not exists giftOfGivingdb;
use giftOfGivingdb;


create table login_information( 
	login_information_id int unsigned auto_increment,
	username nvarchar(32) not null unique,
	login_password char(60) not null,
    primary key (login_information_id)
    );
    
create table user_information(
	user_information_id int unsigned auto_increment,
	login_information_id int unsigned,
    first_name nvarchar(50),
    last_name nvarchar(50),
    birthday date,
    family_id int unsigned,
    primary key(user_information_id)
    );
    
create table family(
    family_id int unsigned auto_increment, 
    family_name varchar(50) not null,
    primary key(family_id)
    );
    
create table wishlist(
    wishlist_id int unsigned auto_increment,
	login_information_id int unsigned,
	item_name nvarchar(255),
	item_description nvarchar(255),
	item_link nvarchar(255),
	quantity decimal,
	item_price decimal,
	birthday_gift boolean,
	holiday_gift boolean,
	already_purchased boolean,
	primary key(wishlist_id)
	);
    
create table holiday (
	holiday_id int unsigned auto_increment,
	family_id int unsigned,
    holiday_name nvarchar(50),
    holiday_date date,
    gift_exchange_type nvarchar(50),
    price_limit decimal,
    primary key(holiday_id)
   );

alter table user_information add constraint `login_user_fk`
FOREIGN KEY (login_information_id) REFERENCES login_information(login_information_id)
on delete cascade
on update restrict;

alter table wishlist add constraint `login_wishlist_fk`
FOREIGN KEY (login_information_id) REFERENCES login_information (login_information_id)
on delete cascade
on update restrict;

alter table user_information add constraint `families_user_fk`
FOREIGN KEY (family_id) REFERENCES family(family_id)
on delete cascade
on update restrict;


alter table holiday add constraint `holidays_user_fk`
foreign key (family_id) references family(family_id)
on delete cascade
on update restrict; 


insert into login_information (username, login_password) values ('hello', 'hello');
insert into family (family_name) VALUES ('Davis');
insert into user_information (login_information_id, first_name, last_name, birthday, family_id) VALUES(last_insert_id(), 'donkey','kong', '2021/01/26', '1');
insert into holiday (family_id, holiday_name, holiday_date, gift_exchange_type, price_limit) VALUES ('1', 'Christmas', '2021/01/26', 'white-elephant','20' );
insert into wishlist (login_information_id, item_name, item_description, item_link, quantity, item_price, birthday_gift, holiday_gift, already_purchased) VALUES('1', 'donkey','kong','donkey','2', '2', true, true,true);
UPDATE user_information SET family_id= '1' WHERE user_information_id = '2';