CREATE TABLE public.project
(
    id integer DEFAULT nextval('project_seq'::regclass) NOT NULL,
    name varchar(50) NOT NULL,
    admin integer NOT NULL,
    url varchar(64) NOT NULL,
    start_date date NOT NULL,
    add_date timestamp(6) DEFAULT now() NOT NULL,
    paymenttype smallint NOT NULL,
    ref_percent real[],
    plan_percents real[] NOT NULL,
    plan_period integer[] NOT NULL,
    plan_period_type real[] NOT NULL,
    plan_start_deposit smallint[] NOT NULL,
    plan_currency_type smallint[] NOT NULL,
    payments integer[] NOT NULL,
    ref_url varchar(128) DEFAULT ''::character varying NOT NULL
);
CREATE INDEX project_url_ix ON public.project (lower(url::text));
CREATE INDEX "FK_project_admin" ON public.project (admin);
INSERT INTO public.project (id, name, admin, url, start_date, add_date, paymenttype, ref_percent, plan_percents, plan_period, plan_period_type, plan_start_deposit, plan_currency_type, payments, ref_url) VALUES (126, 'ыфв', 1, '', '2017-07-05', '2017-07-25 22:36:39.959546', 2, '{1.00000000}', '{1.00000000}', '{1}', '{1.00000000}', '{1}', '{1}', '{1}', 'ааа');
INSERT INTO public.project (id, name, admin, url, start_date, add_date, paymenttype, ref_percent, plan_percents, plan_period, plan_period_type, plan_start_deposit, plan_currency_type, payments, ref_url) VALUES (128, '123', 1, 'google.ru', '2017-08-03', '2017-08-02 22:38:23.842403', 1, '{23.00000000}', '{2.00000000}', '{3}', '{3.00000000}', '{4}', '{1}', '{1,9}', 'https://www.google.ru/s');
INSERT INTO public.project (id, name, admin, url, start_date, add_date, paymenttype, ref_percent, plan_percents, plan_period, plan_period_type, plan_start_deposit, plan_currency_type, payments, ref_url) VALUES (129, '123', 1, 'goo3gle.ru', '2017-08-03', '2017-08-02 22:40:17.050878', 1, '{23.00000000}', '{2.00000000}', '{3}', '{3.00000000}', '{4}', '{1}', '{1,9}', 'https://www.goo3gle.ru/s');
INSERT INTO public.project (id, name, admin, url, start_date, add_date, paymenttype, ref_percent, plan_percents, plan_period, plan_period_type, plan_start_deposit, plan_currency_type, payments, ref_url) VALUES (133, 'dsff', 1, 'nefco.ru', '2017-08-02', '2017-08-06 16:11:34.957390', 1, '{4.00000000}', '{1.00000000}', '{2}', '{3.00000000}', '{3}', '{1}', '{9}', 'http://redmine.nefco.ru/red');
INSERT INTO public.project (id, name, admin, url, start_date, add_date, paymenttype, ref_percent, plan_percents, plan_period, plan_period_type, plan_start_deposit, plan_currency_type, payments, ref_url) VALUES (135, 'Test', 1, 'stackoverflow.com', '2017-08-10', '2017-08-09 22:50:51.298399', 2, '{5.00000000}', '{1.00000000,2.00000000}', '{2,3}', '{3.00000000,3.00000000}', '{3,4}', '{1,1}', '{1,9}', 'https://stackoverflow.com');
INSERT INTO public.project (id, name, admin, url, start_date, add_date, paymenttype, ref_percent, plan_percents, plan_period, plan_period_type, plan_start_deposit, plan_currency_type, payments, ref_url) VALUES (136, 'sdfg', 1, 'postgresql.org', '2017-08-16', '2017-08-16 21:21:08.960050', 2, '{3.00000000}', '{1.00000000,33.00000000}', '{2,2}', '{3.00000000,3.00000000}', '{4,3}', '{1,1}', '{1,9}', 'https://wiki.postgresql.org/wiki/AutomatedBackuponWindows');