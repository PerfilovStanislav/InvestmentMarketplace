/*
  From MAC
 */

create sequence project_langs_seq
;

create sequence project_plans_seq
;

create sequence project_seq
;

create sequence users_seq
;

create table country
(
	id smallint not null
		constraint country_pkey
			primary key,
	name varchar(64) not null,
	shortname varchar(2) not null
)
;

create unique index shortname
	on country (shortname)
;

create table currency_type
(
	id smallint not null
		constraint currency_type_pkey
			primary key,
	name varchar(3) not null
)
;

create table languages
(
	id smallint not null
		constraint languages_pkey
			primary key,
	name varchar(255) not null,
	shortname char(2) not null,
	own_name varchar(255) not null,
	flag varchar(2),
	pos smallint
)
;

create unique index english_language_name
	on languages (name)
;

create unique index native_language_name
	on languages (own_name)
;

create index flag
	on languages (flag)
;

create table payments
(
	id smallint not null
		constraint payments_pkey
			primary key,
	name varchar(32) not null,
	pos smallint not null
)
;

create unique index name
	on payments (name)
;

create unique index pos
	on payments (pos)
;

create table period_type
(
	id smallint not null
		constraint period_type_pkey
			primary key,
	name varchar(6) not null
)
;

create table project
(
	id integer default nextval('project_seq'::regclass) not null,
	name varchar(50) not null,
	admin integer not null,
	url varchar(64) not null,
	start_date date not null,
	add_date timestamp(6) default now() not null,
	paymenttype smallint not null,
	ref_percent real[],
	plan_percents real[] not null,
	plan_period integer[] not null,
	plan_period_type real[] not null,
	plan_start_deposit smallint[] not null,
	plan_currency_type smallint[] not null,
	payments integer[] not null,
	ref_url varchar(128) default ''::character varying not null
)
;

create index project_url_ix
	on project (lower(url::text))
;

create index "FK_project_admin"
	on project (admin)
;

create table project_lang
(
	id integer default nextval('project_langs_seq'::regclass) not null,
	project_id integer not null,
	lang_id smallint not null,
	description varchar(5000)
)
;

create table user_params
(
	user_id integer not null,
	lang_id smallint
)
;

create table user_remember
(
	user_id bigint not null,
	hash varchar(53) not null,
	ip varchar(39) not null
)
;

create table user_status
(
	id smallint not null,
	name varchar(50) not null
)
;

create table users
(
	id integer default nextval('users_seq'::regclass) not null,
	login varchar(32) not null,
	name varchar(64) not null,
	email varchar(64) not null,
	password varchar(53) not null,
	status_id smallint default 1 not null,
	date_create timestamp(6) default now() not null
)
;















