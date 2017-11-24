CREATE TABLE public.user_status
(
    id smallint NOT NULL,
    name varchar(50) NOT NULL
);
INSERT INTO public.user_status (id, name) VALUES (1, 'need confirm');
INSERT INTO public.user_status (id, name) VALUES (2, 'registered');
INSERT INTO public.user_status (id, name) VALUES (3, 'super admin');