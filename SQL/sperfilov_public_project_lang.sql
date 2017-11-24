CREATE TABLE public.project_lang
(
    id integer DEFAULT nextval('project_langs_seq'::regclass) NOT NULL,
    project_id integer NOT NULL,
    lang_id smallint NOT NULL,
    description varchar(5000)
);
INSERT INTO public.project_lang (id, project_id, lang_id, description) VALUES (1, 129, 317, 'gg');
INSERT INTO public.project_lang (id, project_id, lang_id, description) VALUES (2, 129, 219, 'hjk');
INSERT INTO public.project_lang (id, project_id, lang_id, description) VALUES (16, 133, 308, 'Russian ( русский )
 Chinese ( 中文, 汉语, 漢語 )
 Spanish ( español )
 Hindi ( हिन्दी, हिंदी )
 Arabic ( العربية )
 Portuguese ( Português )
 Bengali ( বাংলা )
 Japanese ( 日本語 )
 Panjabi, Punjabi ( ਪੰਜਾਬੀ, پنجابی‎ )
 German ( Deutsch )
 Javanese ( basa Jawa )
 Vietnamese ( Tiếng Việt )
 Korean ( 한국어 , 조선말 )
 French ( français )
 Tamil ( தமிழ் )
 Turkish ( Türkçe )
 Malay ( بهاس ملايو‎ )
 Italian ( Italiano )
 Thai ( ไทย )
 Polish ( polski )
 Burmese ( ဗမာစာ )
 Azerbaijani ( azərbaycan )
 Persian ( فارسی )
 Pashto, Pushto ( پښتو )
 Uzbek ( zbek )
 Yoruba ( Yorùbá )
 Dutch ( Nederlands, Vlaams )
 Greek, Modern ( Ελληνικά )
 Czech ( česky, čeština )
 Belarusian ( Беларуская )
 Ukrainian ( українська )
 Amharic ( አማርኛ )');
INSERT INTO public.project_lang (id, project_id, lang_id, description) VALUES (19, 135, 219, '111');
INSERT INTO public.project_lang (id, project_id, lang_id, description) VALUES (20, 135, 317, '222');
INSERT INTO public.project_lang (id, project_id, lang_id, description) VALUES (21, 136, 312, 'fg');