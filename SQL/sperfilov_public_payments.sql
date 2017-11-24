CREATE TABLE public.payments
(
    id smallint PRIMARY KEY NOT NULL,
    name varchar(32) NOT NULL,
    pos smallint NOT NULL
);
CREATE UNIQUE INDEX name ON public.payments (name);
CREATE UNIQUE INDEX pos ON public.payments (pos);
INSERT INTO public.payments (id, name, pos) VALUES (1, 'VISA', 1);
INSERT INTO public.payments (id, name, pos) VALUES (2, '2co', 16);
INSERT INTO public.payments (id, name, pos) VALUES (3, 'Advcash', 25);
INSERT INTO public.payments (id, name, pos) VALUES (4, 'AmericanExpress', 3);
INSERT INTO public.payments (id, name, pos) VALUES (5, 'Bitcoin', 7);
INSERT INTO public.payments (id, name, pos) VALUES (6, 'Cirrus', 17);
INSERT INTO public.payments (id, name, pos) VALUES (7, 'Delta', 18);
INSERT INTO public.payments (id, name, pos) VALUES (8, 'Discover', 4);
INSERT INTO public.payments (id, name, pos) VALUES (9, 'MasterCard', 2);
INSERT INTO public.payments (id, name, pos) VALUES (10, 'MoneyBookers', 19);
INSERT INTO public.payments (id, name, pos) VALUES (11, 'PayPal', 20);
INSERT INTO public.payments (id, name, pos) VALUES (12, 'Payeer', 5);
INSERT INTO public.payments (id, name, pos) VALUES (13, 'Payza', 21);
INSERT INTO public.payments (id, name, pos) VALUES (14, 'PerfectMoney', 6);
INSERT INTO public.payments (id, name, pos) VALUES (15, 'Qiwi', 8);
INSERT INTO public.payments (id, name, pos) VALUES (16, 'Solo', 22);
INSERT INTO public.payments (id, name, pos) VALUES (17, 'Switch', 23);
INSERT INTO public.payments (id, name, pos) VALUES (18, 'WesternUnion', 24);
INSERT INTO public.payments (id, name, pos) VALUES (19, 'Liqpay', 11);
INSERT INTO public.payments (id, name, pos) VALUES (20, 'Neteller', 15);
INSERT INTO public.payments (id, name, pos) VALUES (21, 'NixMoney', 14);
INSERT INTO public.payments (id, name, pos) VALUES (22, 'OKpay', 13);
INSERT INTO public.payments (id, name, pos) VALUES (23, 'SolidTrustPay', 12);
INSERT INTO public.payments (id, name, pos) VALUES (24, 'WebMoney', 10);
INSERT INTO public.payments (id, name, pos) VALUES (25, 'Yandex', 9);