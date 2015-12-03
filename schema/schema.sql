create table users(
username varchar(50) primary key,
password varchar(50),
user_name varchar(50),
user_email varchar(50) unique,
date_joined timestamp default current_timestamp,
is_admin boolean default false,
is_pending boolean default true,
date_approved timestamp
);


create table artist(
stage_name varchar(50) primary key,
artist_name varchar(50),
description varchar(100)
);


create table album(
album_name varchar(50) unique,
album_date_released date,
album_number_of_songs int default 0,
album_id serial primary key,
artist varchar(50) references artist(stage_name)
);


create table playlist(
playlist_id serial primary key,
playlist_name varchar(50),
number_of_songs int default 0,
number_of_times_played bigint default 0,
username varchar(50) references users(username) not null
);


create table song(
song_id serial primary key,
song_title varchar(50),
date_added timestamp default current_timestamp,
number_of_times_played bigint default 0,
is_recommended boolean default false,
username varchar(50) references users(username) not null,
artist varchar(50) references artist(stage_name) not null,
album varchar(50) references album(album_name) not null,
online_link varchar(150),
offline_link varchar(150) check (offline_link like '%.mp3')
);


create table playlist_song(
playlist_song_id serial primary key,
playlist_id int references playlist(playlist_id),
song_id int references song(song_id)
);

