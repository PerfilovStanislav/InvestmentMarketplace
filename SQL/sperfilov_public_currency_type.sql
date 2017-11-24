CREATE TABLE public.currency_type
(
    id smallint PRIMARY KEY NOT NULL,
    name varchar(3) NOT NULL
);
INSERT INTO public.currency_type (id, name) VALUES (1, 'usd');
INSERT INTO public.currency_type (id, name) VALUES (2, 'eur');
INSERT INTO public.currency_type (id, name) VALUES (3, 'btc');
INSERT INTO public.currency_type (id, name) VALUES (4, 'rub');
INSERT INTO public.currency_type (id, name) VALUES (5, 'gbp');
INSERT INTO public.currency_type (id, name) VALUES (6, 'jpy');
INSERT INTO public.currency_type (id, name) VALUES (7, 'won');
INSERT INTO public.currency_type (id, name) VALUES (8, 'inr');