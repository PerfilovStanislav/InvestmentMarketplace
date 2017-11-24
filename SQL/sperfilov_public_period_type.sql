CREATE TABLE public.period_type
(
    id smallint PRIMARY KEY NOT NULL,
    name varchar(6) NOT NULL
);
INSERT INTO public.period_type (id, name) VALUES (1, 'Минута');
INSERT INTO public.period_type (id, name) VALUES (2, 'Час');
INSERT INTO public.period_type (id, name) VALUES (3, 'День');
INSERT INTO public.period_type (id, name) VALUES (4, 'Неделя');
INSERT INTO public.period_type (id, name) VALUES (5, 'Месяц');
INSERT INTO public.period_type (id, name) VALUES (6, 'Год');