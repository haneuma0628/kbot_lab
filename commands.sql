create database kbot_lab;

grant all on kbot_lab. * to dbuser@localhost identified by 'sider5821';

use kbot_lab;

create table message (
    id int(11) auto_increment primary key not null,
    text varchar(140),
    created datetime
);

/* show databases; */
/* show tables;  */
/* select * from tabla_name */

insert into message value('', '朝ですよ。可愛い後輩が起こしにくるなんて夢ですよ、自力で起きてください。起きて研究室に行ってください、研究室で現実と向き合ってください。', '');