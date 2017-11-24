CREATE TABLE public.users
(
    id integer DEFAULT nextval('users_seq'::regclass) NOT NULL,
    login varchar(32) NOT NULL,
    name varchar(64) NOT NULL,
    email varchar(64) NOT NULL,
    password varchar(53) NOT NULL,
    status_id smallint DEFAULT 1 NOT NULL,
    date_create timestamp(6) DEFAULT now() NOT NULL
);
INSERT INTO public.users (id, login, name, email, password, status_id, date_create) VALUES (1, 'beautynight', 'Станислав', 'beautynights@gmail.com', '6c16d9f394351a2c2996aea1uPdmytpCR0bY2G07CzJOq2lZXbnJa', 3, '2016-07-03 17:07:37.000000');
INSERT INTO public.users (id, login, name, email, password, status_id, date_create) VALUES (4, 'beautynight2', 'beautynight2', 'beautynight2', '0cdd88e4a16f2f4c48386uT1f29wHPV3Dp2iUPjn4LD34yQ0EtVea', 1, '2016-07-03 17:07:37.000000');
INSERT INTO public.users (id, login, name, email, password, status_id, date_create) VALUES (10, 'beautynights3', 'beautynight3', 'beautynight3', '63e55ddfbba40b4bc03f4eRsxzWF0GOmJPYx9mElsiOfwRUaOFnui', 1, '2016-07-03 17:08:19.000000');
INSERT INTO public.users (id, login, name, email, password, status_id, date_create) VALUES (30, 'admin', 'itsall4you', 'stanislav.perfilov@gmail.com', '8e01a17e86df65ce73784efHS1jD7S3PINNeozuqpMw38zlkIysY6', 1, '2017-08-09 21:58:18.338060');
INSERT INTO public.users (id, login, name, email, password, status_id, date_create) VALUES (31, 'xxxxx', 'ssss', 'asd@ad.ru', '74aefc6fdf4566c04a625ubcG4UOVZBw8FRZHl13SN1qn1yV3AXCi', 1, '2017-10-04 07:38:46.719490');
INSERT INTO public.users (id, login, name, email, password, status_id, date_create) VALUES (32, 'beautynight3', 'Stanislav', 'perfilov.stanislav@gmail.com', '2840dc1aab3bb14a48e53uX400UT8/sJpxcHntGDRfefQoFTARzMu', 1, '2017-10-16 12:59:08.229211');
INSERT INTO public.users (id, login, name, email, password, status_id, date_create) VALUES (33, 'xxxxxxx', 'xxxxxxx', 'perfilov2.stanislav@gmail.com', 'b98defaf4d21384b697d6Ok6celBV0g5JVbkhgJ5dSpT01oEfQh6W', 1, '2017-10-17 15:58:39.609427');