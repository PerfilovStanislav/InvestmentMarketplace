create sequence message_seq;

create sequence project_seq;

create sequence project_langs_seq;

create sequence project_status_seq
    maxvalue 64;

create sequence session_seq;

create sequence users_seq;

create sequence project_plans_seq;

create sequence redirect_seq;

create sequence user_params_seq;

create sequence user_remember_seq;

create sequence user_confirm_seq;

create table country
(
    id        smallint    not null,
    name      varchar(64) not null,
    shortname varchar(2)  not null,
    constraint country_pkey
        primary key (id)
);

create unique index shortname
    on country (shortname);

create table currency_type
(
    id   smallint   not null,
    name varchar(3) not null,
    constraint currency_type_pkey
        primary key (id)
);

create table languages
(
    id        smallint     not null,
    name      varchar(255) not null,
    shortname char(2)      not null,
    own_name  varchar(255) not null,
    flag      varchar(2),
    pos       smallint,
    available boolean default false,
    constraint languages_pkey
        primary key (id)
);

create unique index english_language_name
    on languages (name);

create index flag
    on languages (flag);

create unique index native_language_name
    on languages (own_name);

create unique index languages_pkey_ix
    on languages (shortname);

create table payments
(
    id   smallint    not null,
    name varchar(32) not null,
    pos  smallint    not null,
    constraint payments_pkey
        primary key (id)
);

create unique index name
    on payments (name);

create unique index pos
    on payments (pos);

create table period_type
(
    id   smallint   not null,
    name varchar(6) not null,
    constraint period_type_pkey
        primary key (id)
);

create table project_status
(
    id   smallint default nextval('project_status_seq'::regclass) not null,
    name varchar(50)                                              not null,
    constraint project_status_pkey
        primary key (id)
);

create table session
(
    id          integer      default nextval('session_seq'::regclass) not null,
    uid         char(32)                                              not null,
    date_create timestamp(6) default now()                            not null,
    ip          inet                                                  not null,
    constraint session_pkey
        primary key (id)
);

create unique index "UN_session_uid"
    on session (uid);

create table user_status
(
    id   smallint    not null,
    name varchar(50) not null,
    constraint user_status_pkey
        primary key (id)
);

create table users
(
    id          integer      default nextval('users_seq'::regclass) not null,
    login       varchar(32)                                         not null,
    name        varchar(64)                                         not null,
    password    varchar(53)                                         not null,
    status_id   smallint     default 1                              not null,
    date_create timestamp(6) default now()                          not null,
    has_photo   boolean      default false                          not null,
    lang_id     smallint     default 317                            not null,
    constraint users_pkey
        primary key (id),
    constraint users_login_key
        unique (login),
    constraint users_lang_id_fkey
        foreign key (lang_id) references languages
            on update restrict on delete restrict
);

create table project
(
    id                 integer      default nextval('project_seq'::regclass) not null,
    name               varchar(50)                                           not null,
    admin              integer                                               not null,
    url                varchar(64)                                           not null,
    start_date         date                                                  not null,
    add_date           timestamp(6) default now()                            not null,
    paymenttype        smallint                                              not null,
    ref_percent        real[],
    plan_percents      real[]                                                not null,
    plan_period        integer[]                                             not null,
    plan_period_type   integer[]                                             not null,
    plan_start_deposit real[]                                                not null,
    plan_currency_type smallint[]                                            not null,
    id_payments        integer[]                                             not null,
    ref_url            varchar(128) default ''::character varying            not null,
    status_id          smallint     default 1                                not null,
    constraint project_pkey
        primary key (id),
    constraint project_status_id_fkey
        foreign key (status_id) references project_status,
    constraint project_admin_fkey
        foreign key (admin) references users
);

create table message
(
    id          integer      default nextval('message_seq'::regclass)        not null,
    date_create timestamp(1) default (now())::timestamp(0) without time zone not null,
    user_id     integer,
    project_id  integer                                                      not null,
    lang_id     smallint                                                     not null,
    message     varchar(2047)                                                not null,
    session_id  integer                                                      not null,
    constraint message_pkey
        primary key (id),
    constraint message_user_id_fkey
        foreign key (user_id) references users,
    constraint message_session_id_fkey
        foreign key (session_id) references session,
    constraint message_lang_id_fkey
        foreign key (lang_id) references languages,
    constraint message_project_id_fkey
        foreign key (project_id) references project
);

create index "IX_message_date_create"
    on message (date_create desc);

create index "IX_message_date_create_project_id_lang_id"
    on message (date_create desc, project_id desc, lang_id asc);

create index "IX_message_lang_id"
    on message (lang_id);

create index "IX_message_project_id"
    on message (project_id desc);

create index "IX_message_session_id"
    on message (session_id);

create index "IX_message_user_id"
    on message (user_id desc);

create index "FK_project_admin"
    on project (admin);

create index project_url_ix
    on project (lower(url::text));

create table project_lang
(
    id          integer default nextval('project_langs_seq'::regclass) not null,
    project_id  integer                                                not null,
    lang_id     smallint                                               not null,
    description varchar(5000)                                          not null,
    constraint project_lang_pkey
        primary key (id),
    constraint project_lang_project_id_fkey
        foreign key (project_id) references project,
    constraint project_lang_lang_id_fkey
        foreign key (lang_id) references languages
);

create index "IX_project_lang_lang"
    on project_lang (lang_id);

create index "IX_project_lang_project"
    on project_lang (project_id desc);

create unique index "UN_project_lang_project_lang"
    on project_lang (project_id desc, lang_id asc);

create table user_remember
(
    user_id integer                                                not null,
    hash    varchar(53)                                            not null,
    ip      varchar(39)                                            not null,
    id      integer default nextval('user_remember_seq'::regclass) not null,
    constraint user_remember_pkey
        primary key (id),
    constraint user_remember_user_id_ip_key
        unique (user_id, ip),
    constraint user_remember_user_id_fkey
        foreign key (user_id) references users
);

create unique index user_remember_ixpkey
    on user_remember (id desc);

create unique index ix_user_remember
    on user_remember (user_id, ip);

create index "FK_user_status_id"
    on users (status_id);

create unique index "UN_user_login"
    on users (login);

create index fki_users_lang_id_fkey
    on users (lang_id);

create table redirect
(
    id          integer      default nextval('redirect_seq'::regclass)       not null,
    date_create timestamp(1) default (now())::timestamp(0) without time zone not null,
    user_id     integer,
    project_id  integer                                                      not null,
    session_id  integer                                                      not null,
    constraint redirect_pkey
        primary key (id),
    constraint redirect_session_id_fkey
        foreign key (session_id) references session
            on delete cascade,
    constraint redirect_user_id_fkey
        foreign key (user_id) references users
            on delete cascade,
    constraint redirect_project_id_fkey
        foreign key (project_id) references project
            on delete cascade
);

create index "IX_redirect_date_create"
    on redirect (date_create desc);

create index "IX_redirect_project_session_id"
    on redirect (project_id desc, session_id asc);

create table user_confirm
(
    id      integer default nextval('user_confirm_seq'::regclass) not null,
    user_id integer                                               not null,
    code    varchar(64)                                           not null,
    constraint user_confirm_pkey
        primary key (id),
    constraint user_confirm_code
        unique (code),
    constraint user_confirm_user_id
        foreign key (user_id) references users
            on delete cascade
);

comment on table user_confirm is 'Подтверждение почты';

create table queue
(
    id         serial                              not null,
    action_id  smallint                            not null,
    status_id  smallint                            not null,
    payload    jsonb                               not null,
    start_time timestamp,
    end_time   timestamp,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    constraint queue_pk
        primary key (id)
);

create materialized view mv_projectfilteravailablelangs as
SELECT pl.lang_id,
       p.status_id,
       count(*) AS cnt
FROM project p
         JOIN project_lang pl ON pl.project_id = p.id
GROUP BY p.status_id, pl.lang_id
ORDER BY p.status_id, (count(*)) DESC;

comment on materialized view mv_projectfilteravailablelangs is 'для вывода возможных языков в фильтре с кол-вом проектов по статусам';

create index projectfilteravailablelangs_status_id
    on mv_projectfilteravailablelangs (status_id);

create unique index un_projectfilteravailablelangs_all
    on mv_projectfilteravailablelangs (status_id asc, cnt desc, lang_id asc);

comment on index un_projectfilteravailablelangs_all is 'all columns for refresh CONCURRENTLY';

create materialized view mv_projectsearchs as
SELECT p.id,
       pl.lang_id,
       p.status_id
FROM project p
         JOIN project_lang pl ON pl.project_id = p.id
         JOIN mv_projectfilteravailablelangs pfal ON pfal.lang_id = pl.lang_id AND pfal.status_id = p.status_id
ORDER BY pfal.status_id, pfal.cnt DESC, p.id DESC;

comment on materialized view mv_projectsearchs is 'Поиск проектов по статусу и языку';

create index projectsearch_lang_id_status_id
    on mv_projectsearchs (status_id, lang_id);

create unique index un_projectsearch_all
    on mv_projectsearchs (status_id asc, lang_id desc, id desc);

create materialized view mv_projectlangs as
SELECT project_lang.project_id         AS id,
       array_agg(project_lang.lang_id) AS lang_id
FROM project_lang
GROUP BY project_lang.project_id
ORDER BY project_lang.project_id DESC;

comment on materialized view mv_projectlangs is 'какие языки есть в проекте';

create unique index projectlangs_un
    on mv_projectlangs (id desc);

create unique index un_projectlangs_all
    on mv_projectlangs (id desc, lang_id asc);

create materialized view mv_sitemapxml as
SELECT p.id,
       p.name,
       to_char(p.add_date::date::timestamp with time zone, 'yyyy-mm-dd'::text) AS add_date,
       p.url,
       l.shortname,
       pl.description
FROM project p
         JOIN project_lang pl ON pl.project_id = p.id
         JOIN languages l ON pl.lang_id = l.id
WHERE p.status_id = 1
ORDER BY p.add_date DESC;

comment on materialized view mv_sitemapxml is 'sitemap.xml';


