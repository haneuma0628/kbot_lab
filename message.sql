create database 6days_php;

grant all on 6days_php.* to dbuser@localhost identified by 'h0geh0ge';

use 6days_php;

create table users (
    id int(11) auto_increment primary key not null,
    twitter_user_id varchar(30) unique,
    twitter_screen_name varchar(15),
    twitter_profile_image_url varchar(255),
    twitter_access_token varchar(255),
    twitter_access_token_secret varchar(255),
    created datetime,
    modified datetime
);

create table task (
    id int(16) auto_increment primary key not null,
    user_id int(11),
    task_name varchar(70),
    task_started date,
    task_category enum('job', 'personal', 'other'),
    task_memo varchar(140),
    task_cheer int(4)
);