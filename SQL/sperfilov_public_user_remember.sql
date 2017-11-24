CREATE TABLE public.user_remember
(
    user_id bigint NOT NULL,
    hash varchar(53) NOT NULL,
    ip varchar(39) NOT NULL
);
INSERT INTO public.user_remember (user_id, hash, ip) VALUES (1, '99b84a8dc09a1fb11fd5buCC.vW/oc9IXBxCJcJSt5Qra8V5GMjwG', '127.0.0.1');
INSERT INTO public.user_remember (user_id, hash, ip) VALUES (30, '96b6ddae1c5a1e27a0d7aO2vldyD9nLWNxYJQCWAq94CTKvyDwQra', '127.0.0.1');