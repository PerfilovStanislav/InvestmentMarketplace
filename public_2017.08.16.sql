/*
Navicat PGSQL Data Transfer

Source Server         : localhost
Source Server Version : 90602
Source Host           : localhost:5432
Source Database       : HyipMonitoring
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90602
File Encoding         : 65001

Date: 2017-09-12 20:36:27
*/


-- ----------------------------
-- Sequence structure for project_langs_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "project_langs_seq";
CREATE SEQUENCE "project_langs_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 21
 CACHE 1;
SELECT setval('"public"."project_langs_seq"', 21, true);

-- ----------------------------
-- Sequence structure for project_plans_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "project_plans_seq";
CREATE SEQUENCE "project_plans_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 48
 CACHE 1;
SELECT setval('"public"."project_plans_seq"', 48, true);

-- ----------------------------
-- Sequence structure for project_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "project_seq";
CREATE SEQUENCE "project_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 136
 CACHE 1;
SELECT setval('"public"."project_seq"', 136, true);

-- ----------------------------
-- Sequence structure for users_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "users_seq";
CREATE SEQUENCE "users_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 30
 CACHE 1;
SELECT setval('"public"."users_seq"', 30, true);

-- ----------------------------
-- Table structure for country
-- ----------------------------
DROP TABLE IF EXISTS "country";
CREATE TABLE "country" (
"id" int2 NOT NULL,
"name" varchar(64) COLLATE "default" NOT NULL,
"shortname" varchar(2) COLLATE "default" NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of country
-- ----------------------------
BEGIN;
INSERT INTO "country" VALUES ('1', 'Afghanistan', 'AF');
INSERT INTO "country" VALUES ('2', 'Albania', 'AL');
INSERT INTO "country" VALUES ('3', 'Algeria', 'DZ');
INSERT INTO "country" VALUES ('4', 'American Samoa', 'AS');
INSERT INTO "country" VALUES ('5', 'Andorra', 'AD');
INSERT INTO "country" VALUES ('6', 'Angola', 'AO');
INSERT INTO "country" VALUES ('7', 'Anguilla', 'AI');
INSERT INTO "country" VALUES ('9', 'Antigua and Barbuda', 'AG');
INSERT INTO "country" VALUES ('10', 'Argentina', 'AR');
INSERT INTO "country" VALUES ('11', 'Armenia', 'AM');
INSERT INTO "country" VALUES ('12', 'Aruba', 'AW');
INSERT INTO "country" VALUES ('13', 'Australia', 'AU');
INSERT INTO "country" VALUES ('14', 'Austria', 'AT');
INSERT INTO "country" VALUES ('15', 'Azerbaijan', 'AZ');
INSERT INTO "country" VALUES ('16', 'Bahamas', 'BS');
INSERT INTO "country" VALUES ('17', 'Bahrain', 'BH');
INSERT INTO "country" VALUES ('18', 'Bangladesh', 'BD');
INSERT INTO "country" VALUES ('19', 'Barbados', 'BB');
INSERT INTO "country" VALUES ('20', 'Belarus', 'BY');
INSERT INTO "country" VALUES ('21', 'Belgium', 'BE');
INSERT INTO "country" VALUES ('22', 'Belize', 'BZ');
INSERT INTO "country" VALUES ('23', 'Benin', 'BJ');
INSERT INTO "country" VALUES ('24', 'Bermuda', 'BM');
INSERT INTO "country" VALUES ('25', 'Bhutan', 'BT');
INSERT INTO "country" VALUES ('26', 'Bolivia', 'BO');
INSERT INTO "country" VALUES ('27', 'Bosnia and Herzegovina', 'BA');
INSERT INTO "country" VALUES ('28', 'Botswana', 'BW');
INSERT INTO "country" VALUES ('30', 'Brazil', 'BR');
INSERT INTO "country" VALUES ('33', 'British Virgin Islands', 'VG');
INSERT INTO "country" VALUES ('34', 'Brunei', 'BN');
INSERT INTO "country" VALUES ('35', 'Bulgaria', 'BG');
INSERT INTO "country" VALUES ('36', 'Burkina Faso', 'BF');
INSERT INTO "country" VALUES ('37', 'Burundi', 'BI');
INSERT INTO "country" VALUES ('38', 'Cambodia', 'KH');
INSERT INTO "country" VALUES ('39', 'Cameroon', 'CM');
INSERT INTO "country" VALUES ('40', 'Canada', 'CA');
INSERT INTO "country" VALUES ('42', 'Cape Verde', 'CV');
INSERT INTO "country" VALUES ('43', 'Cayman Islands', 'KY');
INSERT INTO "country" VALUES ('44', 'Central African Republic', 'CF');
INSERT INTO "country" VALUES ('45', 'Chad', 'TD');
INSERT INTO "country" VALUES ('46', 'Chile', 'CL');
INSERT INTO "country" VALUES ('47', 'China', 'CN');
INSERT INTO "country" VALUES ('50', 'Colombia', 'CO');
INSERT INTO "country" VALUES ('51', 'Comoros', 'KM');
INSERT INTO "country" VALUES ('52', 'Congo - Brazzaville', 'CG');
INSERT INTO "country" VALUES ('53', 'Congo - Kinshasa', 'CD');
INSERT INTO "country" VALUES ('54', 'Cook Islands', 'CK');
INSERT INTO "country" VALUES ('55', 'Costa Rica', 'CR');
INSERT INTO "country" VALUES ('56', 'Croatia', 'HR');
INSERT INTO "country" VALUES ('57', 'Cuba', 'CU');
INSERT INTO "country" VALUES ('58', 'Cyprus', 'CY');
INSERT INTO "country" VALUES ('59', 'Czech Republic', 'CZ');
INSERT INTO "country" VALUES ('60', 'Côte d’Ivoire', 'CI');
INSERT INTO "country" VALUES ('61', 'Denmark', 'DK');
INSERT INTO "country" VALUES ('62', 'Djibouti', 'DJ');
INSERT INTO "country" VALUES ('63', 'Dominica', 'DM');
INSERT INTO "country" VALUES ('64', 'Dominican Republic', 'DO');
INSERT INTO "country" VALUES ('67', 'Ecuador', 'EC');
INSERT INTO "country" VALUES ('68', 'Egypt', 'EG');
INSERT INTO "country" VALUES ('69', 'El Salvador', 'SV');
INSERT INTO "country" VALUES ('70', 'Equatorial Guinea', 'GQ');
INSERT INTO "country" VALUES ('71', 'Eritrea', 'ER');
INSERT INTO "country" VALUES ('72', 'Estonia', 'EE');
INSERT INTO "country" VALUES ('73', 'Ethiopia', 'ET');
INSERT INTO "country" VALUES ('75', 'Faroe Islands', 'FO');
INSERT INTO "country" VALUES ('76', 'Fiji', 'FJ');
INSERT INTO "country" VALUES ('77', 'Finland', 'FI');
INSERT INTO "country" VALUES ('78', 'France', 'FR');
INSERT INTO "country" VALUES ('80', 'French Polynesia', 'PF');
INSERT INTO "country" VALUES ('83', 'Gabon', 'GA');
INSERT INTO "country" VALUES ('84', 'Gambia', 'GM');
INSERT INTO "country" VALUES ('85', 'Georgia', 'GE');
INSERT INTO "country" VALUES ('86', 'Germany', 'DE');
INSERT INTO "country" VALUES ('87', 'Ghana', 'GH');
INSERT INTO "country" VALUES ('88', 'Gibraltar', 'GI');
INSERT INTO "country" VALUES ('89', 'Greece', 'GR');
INSERT INTO "country" VALUES ('90', 'Greenland', 'GL');
INSERT INTO "country" VALUES ('91', 'Grenada', 'GD');
INSERT INTO "country" VALUES ('92', 'Guadeloupe', 'GP');
INSERT INTO "country" VALUES ('93', 'Guam', 'GU');
INSERT INTO "country" VALUES ('94', 'Guatemala', 'GT');
INSERT INTO "country" VALUES ('95', 'Guernsey', 'GG');
INSERT INTO "country" VALUES ('96', 'Guinea', 'GN');
INSERT INTO "country" VALUES ('97', 'Guinea-Bissau', 'GW');
INSERT INTO "country" VALUES ('98', 'Guyana', 'GY');
INSERT INTO "country" VALUES ('99', 'Haiti', 'HT');
INSERT INTO "country" VALUES ('101', 'Honduras', 'HN');
INSERT INTO "country" VALUES ('102', 'Hong Kong SAR China', 'HK');
INSERT INTO "country" VALUES ('103', 'Hungary', 'HU');
INSERT INTO "country" VALUES ('104', 'Iceland', 'IS');
INSERT INTO "country" VALUES ('105', 'India', 'IN');
INSERT INTO "country" VALUES ('106', 'Indonesia', 'ID');
INSERT INTO "country" VALUES ('107', 'Iran', 'IR');
INSERT INTO "country" VALUES ('108', 'Iraq', 'IQ');
INSERT INTO "country" VALUES ('109', 'Ireland', 'IE');
INSERT INTO "country" VALUES ('110', 'Isle of Man', 'IM');
INSERT INTO "country" VALUES ('111', 'Israel', 'IL');
INSERT INTO "country" VALUES ('112', 'Italy', 'IT');
INSERT INTO "country" VALUES ('113', 'Jamaica', 'JM');
INSERT INTO "country" VALUES ('114', 'Japan', 'JP');
INSERT INTO "country" VALUES ('115', 'Jersey', 'JE');
INSERT INTO "country" VALUES ('117', 'Jordan', 'JO');
INSERT INTO "country" VALUES ('118', 'Kazakhstan', 'KZ');
INSERT INTO "country" VALUES ('119', 'Kenya', 'KE');
INSERT INTO "country" VALUES ('120', 'Kiribati', 'KI');
INSERT INTO "country" VALUES ('121', 'Kuwait', 'KW');
INSERT INTO "country" VALUES ('122', 'Kyrgyzstan', 'KG');
INSERT INTO "country" VALUES ('123', 'Laos', 'LA');
INSERT INTO "country" VALUES ('124', 'Latvia', 'LV');
INSERT INTO "country" VALUES ('125', 'Lebanon', 'LB');
INSERT INTO "country" VALUES ('126', 'Lesotho', 'LS');
INSERT INTO "country" VALUES ('127', 'Liberia', 'LR');
INSERT INTO "country" VALUES ('128', 'Libya', 'LY');
INSERT INTO "country" VALUES ('129', 'Liechtenstein', 'LI');
INSERT INTO "country" VALUES ('130', 'Lithuania', 'LT');
INSERT INTO "country" VALUES ('131', 'Luxembourg', 'LU');
INSERT INTO "country" VALUES ('132', 'Macau SAR China', 'MO');
INSERT INTO "country" VALUES ('133', 'Macedonia', 'MK');
INSERT INTO "country" VALUES ('134', 'Madagascar', 'MG');
INSERT INTO "country" VALUES ('135', 'Malawi', 'MW');
INSERT INTO "country" VALUES ('136', 'Malaysia', 'MY');
INSERT INTO "country" VALUES ('137', 'Maldives', 'MV');
INSERT INTO "country" VALUES ('138', 'Mali', 'ML');
INSERT INTO "country" VALUES ('139', 'Malta', 'MT');
INSERT INTO "country" VALUES ('140', 'Marshall Islands', 'MH');
INSERT INTO "country" VALUES ('141', 'Martinique', 'MQ');
INSERT INTO "country" VALUES ('142', 'Mauritania', 'MR');
INSERT INTO "country" VALUES ('143', 'Mauritius', 'MU');
INSERT INTO "country" VALUES ('146', 'Mexico', 'MX');
INSERT INTO "country" VALUES ('147', 'Micronesia', 'FM');
INSERT INTO "country" VALUES ('149', 'Moldova', 'MD');
INSERT INTO "country" VALUES ('150', 'Monaco', 'MC');
INSERT INTO "country" VALUES ('151', 'Mongolia', 'MN');
INSERT INTO "country" VALUES ('153', 'Montserrat', 'MS');
INSERT INTO "country" VALUES ('154', 'Morocco', 'MA');
INSERT INTO "country" VALUES ('155', 'Mozambique', 'MZ');
INSERT INTO "country" VALUES ('156', 'Myanmar [Burma]', 'MM');
INSERT INTO "country" VALUES ('157', 'Namibia', 'NA');
INSERT INTO "country" VALUES ('158', 'Nauru', 'NR');
INSERT INTO "country" VALUES ('159', 'Nepal', 'NP');
INSERT INTO "country" VALUES ('160', 'Netherlands', 'NL');
INSERT INTO "country" VALUES ('161', 'Netherlands Antilles', 'AN');
INSERT INTO "country" VALUES ('163', 'New Caledonia', 'NC');
INSERT INTO "country" VALUES ('164', 'New Zealand', 'NZ');
INSERT INTO "country" VALUES ('165', 'Nicaragua', 'NI');
INSERT INTO "country" VALUES ('166', 'Niger', 'NE');
INSERT INTO "country" VALUES ('167', 'Nigeria', 'NG');
INSERT INTO "country" VALUES ('170', 'North Korea', 'KP');
INSERT INTO "country" VALUES ('173', 'Norway', 'NO');
INSERT INTO "country" VALUES ('174', 'Oman', 'OM');
INSERT INTO "country" VALUES ('176', 'Pakistan', 'PK');
INSERT INTO "country" VALUES ('177', 'Palau', 'PW');
INSERT INTO "country" VALUES ('178', 'Palestinian Territories', 'PS');
INSERT INTO "country" VALUES ('179', 'Panama', 'PA');
INSERT INTO "country" VALUES ('181', 'Papua New Guinea', 'PG');
INSERT INTO "country" VALUES ('182', 'Paraguay', 'PY');
INSERT INTO "country" VALUES ('184', 'Peru', 'PE');
INSERT INTO "country" VALUES ('185', 'Philippines', 'PH');
INSERT INTO "country" VALUES ('187', 'Poland', 'PL');
INSERT INTO "country" VALUES ('188', 'Portugal', 'PT');
INSERT INTO "country" VALUES ('189', 'Puerto Rico', 'PR');
INSERT INTO "country" VALUES ('190', 'Qatar', 'QA');
INSERT INTO "country" VALUES ('191', 'Romania', 'RO');
INSERT INTO "country" VALUES ('192', 'Russia', 'RU');
INSERT INTO "country" VALUES ('193', 'Rwanda', 'RW');
INSERT INTO "country" VALUES ('194', 'Réunion', 'RE');
INSERT INTO "country" VALUES ('197', 'Saint Kitts and Nevis', 'KN');
INSERT INTO "country" VALUES ('198', 'Saint Lucia', 'LC');
INSERT INTO "country" VALUES ('201', 'Saint Vincent and the Grenadines', 'VC');
INSERT INTO "country" VALUES ('202', 'Samoa', 'WS');
INSERT INTO "country" VALUES ('203', 'San Marino', 'SM');
INSERT INTO "country" VALUES ('204', 'Saudi Arabia', 'SA');
INSERT INTO "country" VALUES ('205', 'Senegal', 'SN');
INSERT INTO "country" VALUES ('206', 'Serbia', 'RS');
INSERT INTO "country" VALUES ('207', 'Montenegro', 'CS');
INSERT INTO "country" VALUES ('208', 'Seychelles', 'SC');
INSERT INTO "country" VALUES ('209', 'Sierra Leone', 'SL');
INSERT INTO "country" VALUES ('210', 'Singapore', 'SG');
INSERT INTO "country" VALUES ('211', 'Slovakia', 'SK');
INSERT INTO "country" VALUES ('212', 'Slovenia', 'SI');
INSERT INTO "country" VALUES ('213', 'Solomon Islands', 'SB');
INSERT INTO "country" VALUES ('214', 'Somalia', 'SO');
INSERT INTO "country" VALUES ('215', 'South Africa', 'ZA');
INSERT INTO "country" VALUES ('217', 'South Korea', 'KR');
INSERT INTO "country" VALUES ('218', 'Spain', 'ES');
INSERT INTO "country" VALUES ('219', 'Sri Lanka', 'LK');
INSERT INTO "country" VALUES ('220', 'Sudan', 'SD');
INSERT INTO "country" VALUES ('221', 'Suriname', 'SR');
INSERT INTO "country" VALUES ('223', 'Swaziland', 'SZ');
INSERT INTO "country" VALUES ('224', 'Sweden', 'SE');
INSERT INTO "country" VALUES ('225', 'Switzerland', 'CH');
INSERT INTO "country" VALUES ('226', 'Syria', 'SY');
INSERT INTO "country" VALUES ('227', 'São Tomé and Príncipe', 'ST');
INSERT INTO "country" VALUES ('228', 'Taiwan', 'TW');
INSERT INTO "country" VALUES ('229', 'Tajikistan', 'TJ');
INSERT INTO "country" VALUES ('230', 'Tanzania', 'TZ');
INSERT INTO "country" VALUES ('231', 'Thailand', 'TH');
INSERT INTO "country" VALUES ('232', 'Timor-Leste', 'TL');
INSERT INTO "country" VALUES ('233', 'Togo', 'TG');
INSERT INTO "country" VALUES ('235', 'Tonga', 'TO');
INSERT INTO "country" VALUES ('236', 'Trinidad and Tobago', 'TT');
INSERT INTO "country" VALUES ('237', 'Tunisia', 'TN');
INSERT INTO "country" VALUES ('238', 'Turkey', 'TR');
INSERT INTO "country" VALUES ('239', 'Turkmenistan', 'TM');
INSERT INTO "country" VALUES ('240', 'Turks and Caicos Islands', 'TC');
INSERT INTO "country" VALUES ('241', 'Tuvalu', 'TV');
INSERT INTO "country" VALUES ('244', 'U.S. Virgin Islands', 'VI');
INSERT INTO "country" VALUES ('245', 'Uganda', 'UG');
INSERT INTO "country" VALUES ('246', 'Ukraine', 'UA');
INSERT INTO "country" VALUES ('248', 'United Arab Emirates', 'AE');
INSERT INTO "country" VALUES ('249', 'United Kingdom', 'GB');
INSERT INTO "country" VALUES ('250', 'United States', 'US');
INSERT INTO "country" VALUES ('252', 'Uruguay', 'UY');
INSERT INTO "country" VALUES ('253', 'Uzbekistan', 'UZ');
INSERT INTO "country" VALUES ('254', 'Vanuatu', 'VU');
INSERT INTO "country" VALUES ('255', 'Vatican City', 'VA');
INSERT INTO "country" VALUES ('256', 'Venezuela', 'VE');
INSERT INTO "country" VALUES ('257', 'Vietnam', 'VN');
INSERT INTO "country" VALUES ('260', 'Western Sahara', 'EH');
INSERT INTO "country" VALUES ('261', 'Yemen', 'YE');
INSERT INTO "country" VALUES ('262', 'Zambia', 'ZM');
INSERT INTO "country" VALUES ('263', 'Zimbabwe', 'ZW');
COMMIT;

-- ----------------------------
-- Table structure for currency_type
-- ----------------------------
DROP TABLE IF EXISTS "currency_type";
CREATE TABLE "currency_type" (
"id" int2 NOT NULL,
"name" varchar(3) COLLATE "default" NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of currency_type
-- ----------------------------
BEGIN;
INSERT INTO "currency_type" VALUES ('1', 'usd');
INSERT INTO "currency_type" VALUES ('2', 'eur');
INSERT INTO "currency_type" VALUES ('3', 'btc');
INSERT INTO "currency_type" VALUES ('4', 'rub');
INSERT INTO "currency_type" VALUES ('5', 'gbp');
INSERT INTO "currency_type" VALUES ('6', 'jpy');
INSERT INTO "currency_type" VALUES ('7', 'won');
INSERT INTO "currency_type" VALUES ('8', 'inr');
COMMIT;

-- ----------------------------
-- Table structure for languages
-- ----------------------------
DROP TABLE IF EXISTS "languages";
CREATE TABLE "languages" (
"id" int2 NOT NULL,
"name" varchar(255) COLLATE "default" NOT NULL,
"shortname" char(2) COLLATE "default" NOT NULL,
"own_name" varchar(255) COLLATE "default" NOT NULL,
"flag" varchar(2) COLLATE "default",
"pos" int2
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of languages
-- ----------------------------
BEGIN;
INSERT INTO "languages" VALUES ('183', 'Afar', 'aa', 'Afaraf', 'dj', null);
INSERT INTO "languages" VALUES ('184', 'Abkhaz', 'ab', 'аҧсуа', 'ge', null);
INSERT INTO "languages" VALUES ('186', 'Afrikaans', 'af', 'Afrikaans', 'za', null);
INSERT INTO "languages" VALUES ('187', 'Akan', 'ak', 'Akan', 'gh', null);
INSERT INTO "languages" VALUES ('188', 'Amharic', 'am', 'አማርኛ', 'et', '33');
INSERT INTO "languages" VALUES ('190', 'Arabic', 'ar', 'العربية', 'ae', '6');
INSERT INTO "languages" VALUES ('191', 'Assamese', 'as', 'অসমীয়া', 'in', null);
INSERT INTO "languages" VALUES ('192', 'Avaric', 'av', 'авар мац', 'ru', null);
INSERT INTO "languages" VALUES ('193', 'Aymara', 'ay', 'aymar aru', 'pe', null);
INSERT INTO "languages" VALUES ('194', 'Azerbaijani', 'az', 'azərbaycan', 'az', '23');
INSERT INTO "languages" VALUES ('195', 'Bashkir', 'ba', 'башҡорт теле', 'ru', null);
INSERT INTO "languages" VALUES ('196', 'Belarusian', 'be', 'Беларуская', 'by', '31');
INSERT INTO "languages" VALUES ('197', 'Bulgarian', 'bg', 'български език', 'bg', null);
INSERT INTO "languages" VALUES ('199', 'Bislama', 'bi', 'Bislama', 'vu', null);
INSERT INTO "languages" VALUES ('200', 'Bambara', 'bm', 'bamanankan', 'ml', null);
INSERT INTO "languages" VALUES ('201', 'Bengali', 'bn', 'বাংলা', 'bd', '8');
INSERT INTO "languages" VALUES ('202', 'Tibetan, Central', 'bo', 'བོད་ཡིག', 'cn', null);
INSERT INTO "languages" VALUES ('205', 'Catalan; Valencian', 'ca', 'Català', 'es', null);
INSERT INTO "languages" VALUES ('206', 'Chechen', 'ce', 'нохчийн мотт', 'ru', null);
INSERT INTO "languages" VALUES ('207', 'Chamorro', 'ch', 'Chamoru', 'gu', null);
INSERT INTO "languages" VALUES ('210', 'Czech', 'cs', 'česky, čeština', 'cz', '30');
INSERT INTO "languages" VALUES ('212', 'Chuvash', 'cv', 'чӑваш чӗлхи', 'ru', null);
INSERT INTO "languages" VALUES ('214', 'Danish', 'da', 'dansk', 'dk', null);
INSERT INTO "languages" VALUES ('215', 'German', 'de', 'Deutsch', 'de', '11');
INSERT INTO "languages" VALUES ('216', 'Dhivehi, Maldivian', 'dv', 'ދިވެހި', 'mv', null);
INSERT INTO "languages" VALUES ('217', 'Ewe', 'ee', 'Eʋegbe', 'gh', null);
INSERT INTO "languages" VALUES ('218', 'Greek, Modern', 'el', 'Ελληνικά', 'gr', '29');
INSERT INTO "languages" VALUES ('219', 'English', 'en', 'English', 'us', '1');
INSERT INTO "languages" VALUES ('220', 'Esperanto', 'eo', 'Esperanto', null, null);
INSERT INTO "languages" VALUES ('221', 'Spanish', 'es', 'español', 'es', '4');
INSERT INTO "languages" VALUES ('222', 'Estonian', 'et', 'eesti', 'ee', null);
INSERT INTO "languages" VALUES ('223', 'Basque', 'eu', 'euskara, euskera', 'es', null);
INSERT INTO "languages" VALUES ('224', 'Persian', 'fa', 'فارسی', 'ir', '24');
INSERT INTO "languages" VALUES ('225', 'Fulah, Pulaar', 'ff', 'Fulfulde, Pulaar', 'ng', null);
INSERT INTO "languages" VALUES ('226', 'Finnish', 'fi', 'suomi', 'fi', null);
INSERT INTO "languages" VALUES ('227', 'Fijian', 'fj', 'vosa Vakaviti', 'fj', null);
INSERT INTO "languages" VALUES ('228', 'Faroese', 'fo', 'føroyskt', 'fo', null);
INSERT INTO "languages" VALUES ('229', 'French', 'fr', 'français', 'fr', '15');
INSERT INTO "languages" VALUES ('231', 'Irish', 'ga', 'Gaeilge', 'ie', null);
INSERT INTO "languages" VALUES ('233', 'Galician', 'gl', 'Galego', 'es', null);
INSERT INTO "languages" VALUES ('234', 'Guaraní', 'gn', 'Avañeẽ', 'py', null);
INSERT INTO "languages" VALUES ('235', 'Gujarati', 'gu', 'ગુજરાતી', 'in', null);
INSERT INTO "languages" VALUES ('237', 'Hausa', 'ha', 'Hausa, هَوُسَ', 'ng', null);
INSERT INTO "languages" VALUES ('238', 'Hebrew (modern)', 'he', 'עברית', 'il', null);
INSERT INTO "languages" VALUES ('239', 'Hindi', 'hi', 'हिन्दी, हिंदी', 'in', '5');
INSERT INTO "languages" VALUES ('241', 'Croatian', 'hr', 'hrvatski', 'hr', null);
INSERT INTO "languages" VALUES ('242', 'Haitian Creole', 'ht', 'Kreyòl ayisyen', 'ht', null);
INSERT INTO "languages" VALUES ('243', 'Hungarian', 'hu', 'Magyar', 'hu', null);
INSERT INTO "languages" VALUES ('244', 'Armenian', 'hy', 'Հայերեն', 'am', null);
INSERT INTO "languages" VALUES ('245', 'Herero', 'hz', 'Otjiherero', 'na', null);
INSERT INTO "languages" VALUES ('247', 'Indonesian', 'id', 'Bahasa Indonesia', 'id', null);
INSERT INTO "languages" VALUES ('249', 'Igbo', 'ig', 'Asụsụ Igbo', 'ng', null);
INSERT INTO "languages" VALUES ('252', 'Ido', 'io', 'Ido', 'ng', null);
INSERT INTO "languages" VALUES ('253', 'Icelandic', 'is', 'Íslenska', 'is', null);
INSERT INTO "languages" VALUES ('254', 'Italian', 'it', 'Italiano', 'it', '19');
INSERT INTO "languages" VALUES ('256', 'Japanese', 'ja', '日本語', 'jp', '9');
INSERT INTO "languages" VALUES ('257', 'Javanese', 'jv', 'basa Jawa', 'id', '12');
INSERT INTO "languages" VALUES ('258', 'Georgian', 'ka', 'ქართული', 'ge', null);
INSERT INTO "languages" VALUES ('259', 'Kongo', 'kg', 'KiKongo', 'cd', null);
INSERT INTO "languages" VALUES ('260', 'Kikuyu, Gikuyu', 'ki', 'Gĩkũyũ', 'ke', null);
INSERT INTO "languages" VALUES ('262', 'Kazakh', 'kk', 'Қазақ тілі', 'kz', null);
INSERT INTO "languages" VALUES ('264', 'Khmer', 'km', 'ភាសាខ្មែរ', 'kh', null);
INSERT INTO "languages" VALUES ('265', 'Kannada', 'kn', 'ಕನ್ನಡ', 'in', null);
INSERT INTO "languages" VALUES ('266', 'Korean', 'ko', '한국어 , 조선말', 'kr', '14');
INSERT INTO "languages" VALUES ('267', 'Kanuri', 'kr', 'Kanuri', 'ng', null);
INSERT INTO "languages" VALUES ('269', 'Kurdish', 'ku', 'Kurdî, كوردی‎', 'tr', null);
INSERT INTO "languages" VALUES ('272', 'Kirghiz, Kyrgyz', 'ky', 'кыргыз тили', 'kg', null);
INSERT INTO "languages" VALUES ('274', 'Luxembourgish', 'lb', 'Lëtzebuergesch', 'lu', null);
INSERT INTO "languages" VALUES ('276', 'Limburgish', 'li', 'Limburgs', 'sl', null);
INSERT INTO "languages" VALUES ('278', 'Lao', 'lo', 'ພາສາລາວ', 'th', null);
INSERT INTO "languages" VALUES ('279', 'Lithuanian', 'lt', 'lietuvių kalba', 'lt', null);
INSERT INTO "languages" VALUES ('280', 'Luba-Katanga', 'lu', 'Kiluba', 'cd', null);
INSERT INTO "languages" VALUES ('281', 'Latvian', 'lv', 'latviešu valoda', 'lv', null);
INSERT INTO "languages" VALUES ('282', 'Malagasy', 'mg', 'Malagasy', 'mg', null);
INSERT INTO "languages" VALUES ('283', 'Marshallese', 'mh', 'Kajin M̧ajeļ', 'mh', null);
INSERT INTO "languages" VALUES ('284', 'Māori', 'mi', 'te reo Māori', 'nz', null);
INSERT INTO "languages" VALUES ('285', 'Macedonian', 'mk', 'македонски', 'mk', null);
INSERT INTO "languages" VALUES ('286', 'Malayalam', 'ml', 'മലയാളം', 'id', null);
INSERT INTO "languages" VALUES ('287', 'Mongolian', 'mn', 'монгол', 'mn', null);
INSERT INTO "languages" VALUES ('288', 'Marathi (Marāṭhī)', 'mr', 'मराठी', 'in', null);
INSERT INTO "languages" VALUES ('289', 'Malay', 'ms', 'بهاس ملايو‎', 'my', '18');
INSERT INTO "languages" VALUES ('290', 'Maltese', 'mt', 'Malti', 'mt', null);
INSERT INTO "languages" VALUES ('291', 'Burmese', 'my', 'ဗမာစာ', 'mm', '22');
INSERT INTO "languages" VALUES ('292', 'Nauru', 'na', 'Ekakairũ Naoero', 'nr', null);
INSERT INTO "languages" VALUES ('294', 'North Ndebele', 'nd', 'Northern Ndebele', 'zw', null);
INSERT INTO "languages" VALUES ('295', 'Nepali', 'ne', 'नेपाली', 'np', null);
INSERT INTO "languages" VALUES ('297', 'Dutch', 'nl', 'Nederlands, Vlaams', 'nl', '28');
INSERT INTO "languages" VALUES ('299', 'Norwegian', 'no', 'Norsk', 'no', null);
INSERT INTO "languages" VALUES ('300', 'South Ndebele', 'nr', 'Southern Ndebele', 'zw', null);
INSERT INTO "languages" VALUES ('302', 'Chichewa, Nyanja', 'ny', 'chiCheŵa', 'zm', null);
INSERT INTO "languages" VALUES ('305', 'Oromo', 'om', 'Afaan Oromoo', 'et', null);
INSERT INTO "languages" VALUES ('307', 'Ossetian', 'os', 'ирон æвзаг', 'ge', null);
INSERT INTO "languages" VALUES ('308', 'Panjabi, Punjabi', 'pa', 'ਪੰਜਾਬੀ, پنجابی‎', 'pk', '10');
INSERT INTO "languages" VALUES ('310', 'Polish', 'pl', 'polski', 'pl', '21');
INSERT INTO "languages" VALUES ('311', 'Pashto, Pushto', 'ps', 'پښتو', 'af', '25');
INSERT INTO "languages" VALUES ('312', 'Portuguese', 'pt', 'Português', 'pt', '7');
INSERT INTO "languages" VALUES ('313', 'Quechua', 'qu', 'Runa Simi, Kichwa', 'gt', null);
INSERT INTO "languages" VALUES ('314', 'Romansh', 'rm', 'rumantsch grischun', 'ch', null);
INSERT INTO "languages" VALUES ('315', 'Kirundi', 'rn', 'kiRundi', 'bi', null);
INSERT INTO "languages" VALUES ('316', 'Romanian, Moldavian', 'ro', 'română', 'ro', null);
INSERT INTO "languages" VALUES ('317', 'Russian', 'ru', 'русский', 'ru', '2');
INSERT INTO "languages" VALUES ('320', 'Sardinian', 'sc', 'sardu', 'it', null);
INSERT INTO "languages" VALUES ('321', 'Sindhi', 'sd', 'सिन्धी, سنڌي، سندھی‎', 'pk', null);
INSERT INTO "languages" VALUES ('323', 'Sango', 'sg', 'yângâ tî sängö', 'cg', null);
INSERT INTO "languages" VALUES ('324', 'Sinhalese', 'si', 'සිංහල', 'lk', null);
INSERT INTO "languages" VALUES ('325', 'Slovak', 'sk', 'slovenčina', 'sk', null);
INSERT INTO "languages" VALUES ('326', 'Slovene', 'sl', 'slovenščina', 'si', null);
INSERT INTO "languages" VALUES ('327', 'Samoan', 'sm', 'gagana faa Samoa', 'ws', null);
INSERT INTO "languages" VALUES ('328', 'Shona', 'sn', 'chiShona', 'zw', null);
INSERT INTO "languages" VALUES ('329', 'Somali', 'so', 'Soomaaliga', 'so', null);
INSERT INTO "languages" VALUES ('330', 'Albanian', 'sq', 'Shqip', 'al', null);
INSERT INTO "languages" VALUES ('331', 'Serbian', 'sr', 'српски', 'hr', null);
INSERT INTO "languages" VALUES ('332', 'Swati', 'ss', 'SiSwati', 'za', null);
INSERT INTO "languages" VALUES ('333', 'Southern Sotho', 'st', 'Sesotho', 'ls', null);
INSERT INTO "languages" VALUES ('334', 'Sundanese', 'su', 'Basa Sunda', 'id', null);
INSERT INTO "languages" VALUES ('335', 'Swedish', 'sv', 'svenska', 'se', null);
INSERT INTO "languages" VALUES ('336', 'Swahili', 'sw', 'Kiswahili', 'tz', null);
INSERT INTO "languages" VALUES ('337', 'Tamil', 'ta', 'தமிழ்', 'sg', '16');
INSERT INTO "languages" VALUES ('338', 'Telugu', 'te', 'తెలుగు', 'in', null);
INSERT INTO "languages" VALUES ('339', 'Tajik', 'tg', 'тоҷикӣ', 'tj', null);
INSERT INTO "languages" VALUES ('340', 'Thai', 'th', 'ไทย', 'th', '20');
INSERT INTO "languages" VALUES ('341', 'Tigrinya', 'ti', 'ትግርኛ', 'et', null);
INSERT INTO "languages" VALUES ('342', 'Turkmen', 'tk', 'Türkmen', 'tm', null);
INSERT INTO "languages" VALUES ('343', 'Tagalog', 'tl', 'Wikang Tagalog', 'us', null);
INSERT INTO "languages" VALUES ('344', 'Tswana', 'tn', 'Setswana', 'za', null);
INSERT INTO "languages" VALUES ('345', 'Tonga', 'to', 'faka Tonga', 'zm', null);
INSERT INTO "languages" VALUES ('346', 'Turkish', 'tr', 'Türkçe', 'tr', '17');
INSERT INTO "languages" VALUES ('347', 'Tsonga', 'ts', 'Xitsonga', 'mz', null);
INSERT INTO "languages" VALUES ('348', 'Tatar', 'tt', 'татарча', 'ru', null);
INSERT INTO "languages" VALUES ('350', 'Tahitian', 'ty', 'Reo Tahiti', 'pf', null);
INSERT INTO "languages" VALUES ('351', 'Uighur, Uyghur', 'ug', 'Uyƣurqə, ئۇيغۇرچە‎', 'ch', null);
INSERT INTO "languages" VALUES ('352', 'Ukrainian', 'uk', 'українська', 'ua', '32');
INSERT INTO "languages" VALUES ('353', 'Urdu', 'ur', 'اردو', 'in', null);
INSERT INTO "languages" VALUES ('354', 'Uzbek', 'uz', 'zbek', 'uz', '26');
INSERT INTO "languages" VALUES ('355', 'Venda', 've', 'Tshivenḓa', 'za', null);
INSERT INTO "languages" VALUES ('356', 'Vietnamese', 'vi', 'Tiếng Việt', 'vn', '13');
INSERT INTO "languages" VALUES ('359', 'Wolof', 'wo', 'Wollof', 'sn', null);
INSERT INTO "languages" VALUES ('360', 'Xhosa', 'xh', 'isiXhosa', 'za', null);
INSERT INTO "languages" VALUES ('362', 'Yoruba', 'yo', 'Yorùbá', 'ng', '27');
INSERT INTO "languages" VALUES ('363', 'Zhuang, Chuang', 'za', 'Saɯ cueŋƅ', 'cn', null);
INSERT INTO "languages" VALUES ('364', 'Chinese', 'zh', '中文, 汉语, 漢語', 'cn', '3');
COMMIT;

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS "payments";
CREATE TABLE "payments" (
"id" int2 NOT NULL,
"name" varchar(32) COLLATE "default" NOT NULL,
"pos" int2 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of payments
-- ----------------------------
BEGIN;
INSERT INTO "payments" VALUES ('1', 'VISA', '1');
INSERT INTO "payments" VALUES ('2', '2co', '16');
INSERT INTO "payments" VALUES ('3', 'Advcash', '25');
INSERT INTO "payments" VALUES ('4', 'AmericanExpress', '3');
INSERT INTO "payments" VALUES ('5', 'Bitcoin', '7');
INSERT INTO "payments" VALUES ('6', 'Cirrus', '17');
INSERT INTO "payments" VALUES ('7', 'Delta', '18');
INSERT INTO "payments" VALUES ('8', 'Discover', '4');
INSERT INTO "payments" VALUES ('9', 'MasterCard', '2');
INSERT INTO "payments" VALUES ('10', 'MoneyBookers', '19');
INSERT INTO "payments" VALUES ('11', 'PayPal', '20');
INSERT INTO "payments" VALUES ('12', 'Payeer', '5');
INSERT INTO "payments" VALUES ('13', 'Payza', '21');
INSERT INTO "payments" VALUES ('14', 'PerfectMoney', '6');
INSERT INTO "payments" VALUES ('15', 'Qiwi', '8');
INSERT INTO "payments" VALUES ('16', 'Solo', '22');
INSERT INTO "payments" VALUES ('17', 'Switch', '23');
INSERT INTO "payments" VALUES ('18', 'WesternUnion', '24');
INSERT INTO "payments" VALUES ('19', 'Liqpay', '11');
INSERT INTO "payments" VALUES ('20', 'Neteller', '15');
INSERT INTO "payments" VALUES ('21', 'NixMoney', '14');
INSERT INTO "payments" VALUES ('22', 'OKpay', '13');
INSERT INTO "payments" VALUES ('23', 'SolidTrustPay', '12');
INSERT INTO "payments" VALUES ('24', 'WebMoney', '10');
INSERT INTO "payments" VALUES ('25', 'Yandex', '9');
COMMIT;

-- ----------------------------
-- Table structure for period_type
-- ----------------------------
DROP TABLE IF EXISTS "period_type";
CREATE TABLE "period_type" (
"id" int2 NOT NULL,
"name" varchar(6) COLLATE "default" NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of period_type
-- ----------------------------
BEGIN;
INSERT INTO "period_type" VALUES ('1', 'Минута');
INSERT INTO "period_type" VALUES ('2', 'Час');
INSERT INTO "period_type" VALUES ('3', 'День');
INSERT INTO "period_type" VALUES ('4', 'Неделя');
INSERT INTO "period_type" VALUES ('5', 'Месяц');
INSERT INTO "period_type" VALUES ('6', 'Год');
COMMIT;

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS "project";
CREATE TABLE "project" (
"id" int4 DEFAULT nextval('project_seq'::regclass) NOT NULL,
"name" varchar(50) COLLATE "default" NOT NULL,
"admin" int4 NOT NULL,
"url" varchar(64) COLLATE "default" NOT NULL,
"start_date" date NOT NULL,
"add_date" timestamp(6) DEFAULT now() NOT NULL,
"paymenttype" int2 NOT NULL,
"ref_percent" float4[],
"plan_percents" float4[] NOT NULL,
"plan_period" int4[] NOT NULL,
"plan_period_type" float4[] NOT NULL,
"plan_start_deposit" int2[] NOT NULL,
"plan_currency_type" int2[] NOT NULL,
"payments" int4[] NOT NULL,
"ref_url" varchar(128) COLLATE "default" DEFAULT ''::character varying NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of project
-- ----------------------------
BEGIN;
INSERT INTO "project" VALUES ('126', 'ыфв', '1', '', '2017-07-05', '2017-07-25 22:36:39.959546', '2', '{1}', '{1}', '{1}', '{1}', '{1}', '{1}', '{1}', 'ааа');
INSERT INTO "project" VALUES ('128', '123', '1', 'google.ru', '2017-08-03', '2017-08-02 22:38:23.842403', '1', '{23}', '{2}', '{3}', '{3}', '{4}', '{1}', '{1,9}', 'https://www.google.ru/s');
INSERT INTO "project" VALUES ('129', '123', '1', 'goo3gle.ru', '2017-08-03', '2017-08-02 22:40:17.050878', '1', '{23}', '{2}', '{3}', '{3}', '{4}', '{1}', '{1,9}', 'https://www.goo3gle.ru/s');
INSERT INTO "project" VALUES ('133', 'dsff', '1', 'nefco.ru', '2017-08-02', '2017-08-06 16:11:34.95739', '1', '{4}', '{1}', '{2}', '{3}', '{3}', '{1}', '{9}', 'http://redmine.nefco.ru/red');
INSERT INTO "project" VALUES ('135', 'Test', '1', 'stackoverflow.com', '2017-08-10', '2017-08-09 22:50:51.298399', '2', '{5}', '{1,2}', '{2,3}', '{3,3}', '{3,4}', '{1,1}', '{1,9}', 'https://stackoverflow.com');
INSERT INTO "project" VALUES ('136', 'sdfg', '1', 'postgresql.org', '2017-08-16', '2017-08-16 21:21:08.96005', '2', '{3}', '{1,33}', '{2,2}', '{3,3}', '{4,3}', '{1,1}', '{1,9}', 'https://wiki.postgresql.org/wiki/AutomatedBackuponWindows');
COMMIT;

-- ----------------------------
-- Table structure for project_lang
-- ----------------------------
DROP TABLE IF EXISTS "project_lang";
CREATE TABLE "project_lang" (
"id" int4 DEFAULT nextval('project_langs_seq'::regclass) NOT NULL,
"project_id" int4 NOT NULL,
"lang_id" int2 NOT NULL,
"description" varchar(5000) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of project_lang
-- ----------------------------
BEGIN;
INSERT INTO "project_lang" VALUES ('1', '129', '317', 'gg');
INSERT INTO "project_lang" VALUES ('2', '129', '219', 'hjk');
INSERT INTO "project_lang" VALUES ('16', '133', '308', 'Russian ( русский )
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
INSERT INTO "project_lang" VALUES ('19', '135', '219', '111');
INSERT INTO "project_lang" VALUES ('20', '135', '317', '222');
INSERT INTO "project_lang" VALUES ('21', '136', '312', 'fg');
COMMIT;

-- ----------------------------
-- Table structure for user_params
-- ----------------------------
DROP TABLE IF EXISTS "user_params";
CREATE TABLE "user_params" (
"user_id" int4 NOT NULL,
"lang_id" int2
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of user_params
-- ----------------------------
BEGIN;
INSERT INTO "user_params" VALUES ('1', '219');
COMMIT;

-- ----------------------------
-- Table structure for user_remember
-- ----------------------------
DROP TABLE IF EXISTS "user_remember";
CREATE TABLE "user_remember" (
"user_id" int8 NOT NULL,
"hash" varchar(53) COLLATE "default" NOT NULL,
"ip" varchar(39) COLLATE "default" NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of user_remember
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for user_status
-- ----------------------------
DROP TABLE IF EXISTS "user_status";
CREATE TABLE "user_status" (
"id" int2 NOT NULL,
"name" varchar(50) COLLATE "default" NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of user_status
-- ----------------------------
BEGIN;
INSERT INTO "user_status" VALUES ('1', 'need confirm');
INSERT INTO "user_status" VALUES ('2', 'registered');
INSERT INTO "user_status" VALUES ('3', 'super admin');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "users";
CREATE TABLE "users" (
"id" int4 DEFAULT nextval('users_seq'::regclass) NOT NULL,
"login" varchar(32) COLLATE "default" NOT NULL,
"name" varchar(64) COLLATE "default" NOT NULL,
"email" varchar(64) COLLATE "default" NOT NULL,
"password" varchar(53) COLLATE "default" NOT NULL,
"status_id" int2 DEFAULT 1 NOT NULL,
"date_create" timestamp(6) DEFAULT now() NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO "users" VALUES ('1', 'beautynight', 'Станислав', 'beautynights@gmail.com', '6c16d9f394351a2c2996aea1uPdmytpCR0bY2G07CzJOq2lZXbnJa', '3', '2016-07-03 17:07:37');
INSERT INTO "users" VALUES ('4', 'beautynight2', 'beautynight2', 'beautynight2', '0cdd88e4a16f2f4c48386uT1f29wHPV3Dp2iUPjn4LD34yQ0EtVea', '1', '2016-07-03 17:07:37');
INSERT INTO "users" VALUES ('10', 'beautynights3', 'beautynight3', 'beautynight3', '63e55ddfbba40b4bc03f4eRsxzWF0GOmJPYx9mElsiOfwRUaOFnui', '1', '2016-07-03 17:08:19');
INSERT INTO "users" VALUES ('30', 'admin', 'itsall4you', 'stanislav.perfilov@gmail.com', '8e01a17e86df65ce73784efHS1jD7S3PINNeozuqpMw38zlkIysY6', '1', '2017-08-09 21:58:18.33806');
COMMIT;

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Indexes structure for table country
-- ----------------------------
CREATE UNIQUE INDEX "shortname" ON "country" USING btree ("shortname");

-- ----------------------------
-- Primary Key structure for table country
-- ----------------------------
ALTER TABLE "country" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table currency_type
-- ----------------------------
ALTER TABLE "currency_type" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table languages
-- ----------------------------
CREATE UNIQUE INDEX "english_language_name" ON "languages" USING btree ("name");
CREATE INDEX "flag" ON "languages" USING btree ("flag");
CREATE UNIQUE INDEX "native_language_name" ON "languages" USING btree ("own_name");

-- ----------------------------
-- Primary Key structure for table languages
-- ----------------------------
ALTER TABLE "languages" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table payments
-- ----------------------------
CREATE UNIQUE INDEX "name" ON "payments" USING btree ("name");
CREATE UNIQUE INDEX "pos" ON "payments" USING btree ("pos");

-- ----------------------------
-- Primary Key structure for table payments
-- ----------------------------
ALTER TABLE "payments" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table period_type
-- ----------------------------
ALTER TABLE "period_type" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table project
-- ----------------------------
CREATE INDEX "FK_project_admin" ON "project" USING btree ("admin");
CREATE INDEX "project_url_ix" ON "project" USING btree (lower(url::text));

-- ----------------------------
-- Triggers structure for table project
-- ----------------------------
CREATE TRIGGER "delete_project" BEFORE DELETE ON "project"
FOR EACH ROW
EXECUTE PROCEDURE "deleteproject"();

-- ----------------------------
-- Primary Key structure for table project
-- ----------------------------
ALTER TABLE "project" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table project_lang
-- ----------------------------
CREATE INDEX "IX_project_lang_lang" ON "project_lang" USING btree ("lang_id");
CREATE INDEX "IX_project_lang_project" ON "project_lang" USING btree ("project_id");

-- ----------------------------
-- Primary Key structure for table project_lang
-- ----------------------------
ALTER TABLE "project_lang" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table user_params
-- ----------------------------
CREATE INDEX "FK_user_params_user_id" ON "user_params" USING btree ("user_id");
ALTER TABLE "user_params" CLUSTER ON "FK_user_params_user_id";

-- ----------------------------
-- Primary Key structure for table user_params
-- ----------------------------
ALTER TABLE "user_params" ADD PRIMARY KEY ("user_id");

-- ----------------------------
-- Indexes structure for table user_remember
-- ----------------------------
CREATE UNIQUE INDEX "ix_user_remember" ON "user_remember" USING btree ("user_id", "ip");

-- ----------------------------
-- Uniques structure for table user_remember
-- ----------------------------
ALTER TABLE "user_remember" ADD UNIQUE ("user_id", "ip");

-- ----------------------------
-- Indexes structure for table users
-- ----------------------------
CREATE INDEX "FK_user_status_id" ON "users" USING btree ("status_id");
CREATE UNIQUE INDEX "UN_user_email" ON "users" USING btree ("email");
CREATE UNIQUE INDEX "UN_user_login" ON "users" USING btree ("login");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "users" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Key structure for table "project"
-- ----------------------------
ALTER TABLE "project" ADD FOREIGN KEY ("admin") REFERENCES "users" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Key structure for table "project_lang"
-- ----------------------------
ALTER TABLE "project_lang" ADD FOREIGN KEY ("lang_id") REFERENCES "languages" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "project_lang" ADD FOREIGN KEY ("project_id") REFERENCES "project" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Key structure for table "user_params"
-- ----------------------------
ALTER TABLE "user_params" ADD FOREIGN KEY ("lang_id") REFERENCES "languages" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Key structure for table "user_remember"
-- ----------------------------
ALTER TABLE "user_remember" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
