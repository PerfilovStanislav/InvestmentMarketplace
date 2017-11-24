CREATE TABLE public.languages
(
    id smallint PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    shortname char(2) NOT NULL,
    own_name varchar(255) NOT NULL,
    flag varchar(2),
    pos smallint
);
CREATE UNIQUE INDEX english_language_name ON public.languages (name);
CREATE UNIQUE INDEX native_language_name ON public.languages (own_name);
CREATE INDEX flag ON public.languages (flag);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (183, 'Afar', 'aa', 'Afaraf', 'dj', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (184, 'Abkhaz', 'ab', 'аҧсуа', 'ge', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (186, 'Afrikaans', 'af', 'Afrikaans', 'za', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (187, 'Akan', 'ak', 'Akan', 'gh', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (188, 'Amharic', 'am', 'አማርኛ', 'et', 33, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (190, 'Arabic', 'ar', 'العربية', 'ae', 6, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (191, 'Assamese', 'as', 'অসমীয়া', 'in', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (192, 'Avaric', 'av', 'авар мац', 'ru', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (193, 'Aymara', 'ay', 'aymar aru', 'pe', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (194, 'Azerbaijani', 'az', 'azərbaycan', 'az', 23, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (195, 'Bashkir', 'ba', 'башҡорт теле', 'ru', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (196, 'Belarusian', 'be', 'Беларуская', 'by', 31, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (197, 'Bulgarian', 'bg', 'български език', 'bg', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (199, 'Bislama', 'bi', 'Bislama', 'vu', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (200, 'Bambara', 'bm', 'bamanankan', 'ml', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (201, 'Bengali', 'bn', 'বাংলা', 'bd', 8, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (202, 'Tibetan, Central', 'bo', 'བོད་ཡིག', 'cn', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (205, 'Catalan; Valencian', 'ca', 'Català', 'es', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (206, 'Chechen', 'ce', 'нохчийн мотт', 'ru', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (207, 'Chamorro', 'ch', 'Chamoru', 'gu', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (210, 'Czech', 'cs', 'česky, čeština', 'cz', 30, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (212, 'Chuvash', 'cv', 'чӑваш чӗлхи', 'ru', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (214, 'Danish', 'da', 'dansk', 'dk', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (215, 'German', 'de', 'Deutsch', 'de', 11, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (216, 'Dhivehi, Maldivian', 'dv', 'ދިވެހި', 'mv', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (217, 'Ewe', 'ee', 'Eʋegbe', 'gh', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (218, 'Greek, Modern', 'el', 'Ελληνικά', 'gr', 29, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (220, 'Esperanto', 'eo', 'Esperanto', null, null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (221, 'Spanish', 'es', 'español', 'es', 4, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (222, 'Estonian', 'et', 'eesti', 'ee', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (223, 'Basque', 'eu', 'euskara, euskera', 'es', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (224, 'Persian', 'fa', 'فارسی', 'ir', 24, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (225, 'Fulah, Pulaar', 'ff', 'Fulfulde, Pulaar', 'ng', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (226, 'Finnish', 'fi', 'suomi', 'fi', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (227, 'Fijian', 'fj', 'vosa Vakaviti', 'fj', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (228, 'Faroese', 'fo', 'føroyskt', 'fo', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (229, 'French', 'fr', 'français', 'fr', 15, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (231, 'Irish', 'ga', 'Gaeilge', 'ie', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (233, 'Galician', 'gl', 'Galego', 'es', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (234, 'Guaraní', 'gn', 'Avañeẽ', 'py', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (235, 'Gujarati', 'gu', 'ગુજરાતી', 'in', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (237, 'Hausa', 'ha', 'Hausa, هَوُسَ', 'ng', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (238, 'Hebrew (modern)', 'he', 'עברית', 'il', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (239, 'Hindi', 'hi', 'हिन्दी, हिंदी', 'in', 5, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (241, 'Croatian', 'hr', 'hrvatski', 'hr', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (242, 'Haitian Creole', 'ht', 'Kreyòl ayisyen', 'ht', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (243, 'Hungarian', 'hu', 'Magyar', 'hu', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (244, 'Armenian', 'hy', 'Հայերեն', 'am', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (245, 'Herero', 'hz', 'Otjiherero', 'na', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (247, 'Indonesian', 'id', 'Bahasa Indonesia', 'id', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (249, 'Igbo', 'ig', 'Asụsụ Igbo', 'ng', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (252, 'Ido', 'io', 'Ido', 'ng', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (253, 'Icelandic', 'is', 'Íslenska', 'is', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (254, 'Italian', 'it', 'Italiano', 'it', 19, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (256, 'Japanese', 'ja', '日本語', 'jp', 9, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (257, 'Javanese', 'jv', 'basa Jawa', 'id', 12, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (258, 'Georgian', 'ka', 'ქართული', 'ge', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (259, 'Kongo', 'kg', 'KiKongo', 'cd', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (260, 'Kikuyu, Gikuyu', 'ki', 'Gĩkũyũ', 'ke', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (262, 'Kazakh', 'kk', 'Қазақ тілі', 'kz', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (264, 'Khmer', 'km', 'ភាសាខ្មែរ', 'kh', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (265, 'Kannada', 'kn', 'ಕನ್ನಡ', 'in', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (266, 'Korean', 'ko', '한국어 , 조선말', 'kr', 14, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (267, 'Kanuri', 'kr', 'Kanuri', 'ng', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (269, 'Kurdish', 'ku', 'Kurdî, كوردی‎', 'tr', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (272, 'Kirghiz, Kyrgyz', 'ky', 'кыргыз тили', 'kg', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (274, 'Luxembourgish', 'lb', 'Lëtzebuergesch', 'lu', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (276, 'Limburgish', 'li', 'Limburgs', 'sl', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (278, 'Lao', 'lo', 'ພາສາລາວ', 'th', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (279, 'Lithuanian', 'lt', 'lietuvių kalba', 'lt', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (280, 'Luba-Katanga', 'lu', 'Kiluba', 'cd', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (281, 'Latvian', 'lv', 'latviešu valoda', 'lv', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (282, 'Malagasy', 'mg', 'Malagasy', 'mg', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (283, 'Marshallese', 'mh', 'Kajin M̧ajeļ', 'mh', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (284, 'Māori', 'mi', 'te reo Māori', 'nz', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (285, 'Macedonian', 'mk', 'македонски', 'mk', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (286, 'Malayalam', 'ml', 'മലയാളം', 'id', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (287, 'Mongolian', 'mn', 'монгол', 'mn', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (288, 'Marathi (Marāṭhī)', 'mr', 'मराठी', 'in', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (289, 'Malay', 'ms', 'بهاس ملايو‎', 'my', 18, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (290, 'Maltese', 'mt', 'Malti', 'mt', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (291, 'Burmese', 'my', 'ဗမာစာ', 'mm', 22, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (292, 'Nauru', 'na', 'Ekakairũ Naoero', 'nr', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (294, 'North Ndebele', 'nd', 'Northern Ndebele', 'zw', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (295, 'Nepali', 'ne', 'नेपाली', 'np', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (297, 'Dutch', 'nl', 'Nederlands, Vlaams', 'nl', 28, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (299, 'Norwegian', 'no', 'Norsk', 'no', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (300, 'South Ndebele', 'nr', 'Southern Ndebele', 'zw', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (302, 'Chichewa, Nyanja', 'ny', 'chiCheŵa', 'zm', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (305, 'Oromo', 'om', 'Afaan Oromoo', 'et', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (307, 'Ossetian', 'os', 'ирон æвзаг', 'ge', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (308, 'Panjabi, Punjabi', 'pa', 'ਪੰਜਾਬੀ, پنجابی‎', 'pk', 10, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (310, 'Polish', 'pl', 'polski', 'pl', 21, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (311, 'Pashto, Pushto', 'ps', 'پښتو', 'af', 25, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (312, 'Portuguese', 'pt', 'Português', 'pt', 7, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (313, 'Quechua', 'qu', 'Runa Simi, Kichwa', 'gt', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (314, 'Romansh', 'rm', 'rumantsch grischun', 'ch', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (315, 'Kirundi', 'rn', 'kiRundi', 'bi', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (316, 'Romanian, Moldavian', 'ro', 'română', 'ro', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (320, 'Sardinian', 'sc', 'sardu', 'it', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (321, 'Sindhi', 'sd', 'सिन्धी, سنڌي، سندھی‎', 'pk', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (323, 'Sango', 'sg', 'yângâ tî sängö', 'cg', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (324, 'Sinhalese', 'si', 'සිංහල', 'lk', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (325, 'Slovak', 'sk', 'slovenčina', 'sk', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (326, 'Slovene', 'sl', 'slovenščina', 'si', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (327, 'Samoan', 'sm', 'gagana faa Samoa', 'ws', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (328, 'Shona', 'sn', 'chiShona', 'zw', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (329, 'Somali', 'so', 'Soomaaliga', 'so', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (330, 'Albanian', 'sq', 'Shqip', 'al', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (331, 'Serbian', 'sr', 'српски', 'hr', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (332, 'Swati', 'ss', 'SiSwati', 'za', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (333, 'Southern Sotho', 'st', 'Sesotho', 'ls', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (334, 'Sundanese', 'su', 'Basa Sunda', 'id', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (335, 'Swedish', 'sv', 'svenska', 'se', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (336, 'Swahili', 'sw', 'Kiswahili', 'tz', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (337, 'Tamil', 'ta', 'தமிழ்', 'sg', 16, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (338, 'Telugu', 'te', 'తెలుగు', 'in', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (339, 'Tajik', 'tg', 'тоҷикӣ', 'tj', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (340, 'Thai', 'th', 'ไทย', 'th', 20, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (341, 'Tigrinya', 'ti', 'ትግርኛ', 'et', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (342, 'Turkmen', 'tk', 'Türkmen', 'tm', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (343, 'Tagalog', 'tl', 'Wikang Tagalog', 'us', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (344, 'Tswana', 'tn', 'Setswana', 'za', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (345, 'Tonga', 'to', 'faka Tonga', 'zm', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (317, 'Russian', 'ru', 'русский', 'ru', 2, true);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (347, 'Tsonga', 'ts', 'Xitsonga', 'mz', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (348, 'Tatar', 'tt', 'татарча', 'ru', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (350, 'Tahitian', 'ty', 'Reo Tahiti', 'pf', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (351, 'Uighur, Uyghur', 'ug', 'Uyƣurqə, ئۇيغۇرچە‎', 'ch', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (352, 'Ukrainian', 'uk', 'українська', 'ua', 32, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (353, 'Urdu', 'ur', 'اردو', 'in', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (354, 'Uzbek', 'uz', 'zbek', 'uz', 26, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (355, 'Venda', 've', 'Tshivenḓa', 'za', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (356, 'Vietnamese', 'vi', 'Tiếng Việt', 'vn', 13, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (359, 'Wolof', 'wo', 'Wollof', 'sn', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (360, 'Xhosa', 'xh', 'isiXhosa', 'za', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (362, 'Yoruba', 'yo', 'Yorùbá', 'ng', 27, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (363, 'Zhuang, Chuang', 'za', 'Saɯ cueŋƅ', 'cn', null, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (364, 'Chinese', 'zh', '中文, 汉语, 漢語', 'cn', 3, false);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (219, 'English', 'en', 'English', 'us', 1, true);
INSERT INTO public.languages (id, name, shortname, own_name, flag, pos, available) VALUES (346, 'Turkish', 'tr', 'Türkçe', 'tr', 17, true);