<?php

namespace classes\parsers;

use ReflectionClass;

abstract class Mapper {

	#region HIDE

	const HIDE_ANONYMOUS = 1;

	const HIDE_ELITE = 2;

	const HIDE_TRANSPARENT = 3;

	#endregion

	#region TYPE

	const TYPE_HTTP = 1;

	const TYPE_HTTPS = 2;

	#endregion

	#region COUNTRY

	const COUNTRY_AF = 4;//AFG

	const COUNTRY_AL = 8;//ALB

	const COUNTRY_DZ = 12;//DZA

	const COUNTRY_AS = 16;//ASM

	const COUNTRY_AD = 20;//AND

	const COUNTRY_AO = 24;//AGO

	const COUNTRY_AI = 660;//AIA

	const COUNTRY_AQ = 10;//ATA

	const COUNTRY_AG = 28;//ATG

	const COUNTRY_AR = 32;//ARG

	const COUNTRY_AM = 51;//ARM

	const COUNTRY_AW = 533;//ABW

	const COUNTRY_AU = 36;//AUS

	const COUNTRY_AT = 40;//AUT

	const COUNTRY_AZ = 31;//AZE

	const COUNTRY_BS = 44;//BHS

	const COUNTRY_BH = 48;//BHR

	const COUNTRY_BD = 50;//BGD

	const COUNTRY_BB = 52;//BRB

	const COUNTRY_BY = 112;//BLR

	const COUNTRY_BE = 56;//BEL

	const COUNTRY_BZ = 84;//BLZ

	const COUNTRY_BJ = 204;//BEN

	const COUNTRY_BM = 60;//BMU

	const COUNTRY_BT = 64;//BTN

	const COUNTRY_BO = 68;//BOL

	const COUNTRY_BQ = 535;//BES

	const COUNTRY_BA = 70;//BIH

	const COUNTRY_BW = 72;//BWA

	const COUNTRY_BV = 74;//BVT

	const COUNTRY_BR = 76;//BRA

	const COUNTRY_IO = 86;//IOT

	const COUNTRY_BN = 96;//BRN

	const COUNTRY_BG = 100;//BGR

	const COUNTRY_BF = 854;//BFA

	const COUNTRY_BI = 108;//BDI

	const COUNTRY_CV = 132;//CPV

	const COUNTRY_KH = 116;//KHM

	const COUNTRY_CM = 120;//CMR

	const COUNTRY_CA = 124;//CAN

	const COUNTRY_KY = 136;//CYM

	const COUNTRY_CF = 140;//CAF

	const COUNTRY_TD = 148;//TCD

	const COUNTRY_CL = 152;//CHL

	const COUNTRY_CN = 156;//CHN

	const COUNTRY_CX = 162;//CXR

	const COUNTRY_CC = 166;//CCK

	const COUNTRY_CO = 170;//COL

	const COUNTRY_KM = 174;//COM

	const COUNTRY_CD = 180;//COD

	const COUNTRY_CG = 178;//COG

	const COUNTRY_CK = 184;//COK

	const COUNTRY_CR = 188;//CRI

	const COUNTRY_HR = 191;//HRV

	const COUNTRY_CU = 192;//CUB

	const COUNTRY_CW = 531;//CUW

	const COUNTRY_CY = 196;//CYP

	const COUNTRY_CZ = 203;//CZE

	const COUNTRY_CI = 384;//CIV

	const COUNTRY_DK = 208;//DNK

	const COUNTRY_DJ = 262;//DJI

	const COUNTRY_DM = 212;//DMA

	const COUNTRY_DO = 214;//DOM

	const COUNTRY_EC = 218;//ECU

	const COUNTRY_EG = 818;//EGY

	const COUNTRY_SV = 222;//SLV

	const COUNTRY_GQ = 226;//GNQ

	const COUNTRY_ER = 232;//ERI

	const COUNTRY_EE = 233;//EST

	const COUNTRY_SZ = 748;//SWZ

	const COUNTRY_ET = 231;//ETH

	const COUNTRY_FK = 238;//FLK

	const COUNTRY_FO = 234;//FRO

	const COUNTRY_FJ = 242;//FJI

	const COUNTRY_FI = 246;//FIN

	const COUNTRY_FR = 250;//FRA

	const COUNTRY_GF = 254;//GUF

	const COUNTRY_PF = 258;//PYF

	const COUNTRY_TF = 260;//ATF

	const COUNTRY_GA = 266;//GAB

	const COUNTRY_GM = 270;//GMB

	const COUNTRY_GE = 268;//GEO

	const COUNTRY_DE = 276;//DEU

	const COUNTRY_GH = 288;//GHA

	const COUNTRY_GI = 292;//GIB

	const COUNTRY_GR = 300;//GRC

	const COUNTRY_GL = 304;//GRL

	const COUNTRY_GD = 308;//GRD

	const COUNTRY_GP = 312;//GLP

	const COUNTRY_GU = 316;//GUM

	const COUNTRY_GT = 320;//GTM

	const COUNTRY_GG = 831;//GGY

	const COUNTRY_GN = 324;//GIN

	const COUNTRY_GW = 624;//GNB

	const COUNTRY_GY = 328;//GUY

	const COUNTRY_HT = 332;//HTI

	const COUNTRY_HM = 334;//HMD

	const COUNTRY_VA = 336;//VAT

	const COUNTRY_HN = 340;//HND

	const COUNTRY_HK = 344;//HKG

	const COUNTRY_HU = 348;//HUN

	const COUNTRY_IS = 352;//ISL

	const COUNTRY_IN = 356;//IND

	const COUNTRY_ID = 360;//IDN

	const COUNTRY_IR = 364;//IRN

	const COUNTRY_IQ = 368;//IRQ

	const COUNTRY_IE = 372;//IRL

	const COUNTRY_IM = 833;//IMN

	const COUNTRY_IL = 376;//ISR

	const COUNTRY_IT = 380;//ITA

	const COUNTRY_JM = 388;//JAM

	const COUNTRY_JP = 392;//JPN

	const COUNTRY_JE = 832;//JEY

	const COUNTRY_JO = 400;//JOR

	const COUNTRY_KZ = 398;//KAZ

	const COUNTRY_KE = 404;//KEN

	const COUNTRY_KI = 296;//KIR

	const COUNTRY_KP = 408;//PRK

	const COUNTRY_KR = 410;//KOR

	const COUNTRY_KW = 414;//KWT

	const COUNTRY_KG = 417;//KGZ

	const COUNTRY_LA = 418;//LAO

	const COUNTRY_LV = 428;//LVA

	const COUNTRY_LB = 422;//LBN

	const COUNTRY_LS = 426;//LSO

	const COUNTRY_LR = 430;//LBR

	const COUNTRY_LY = 434;//LBY

	const COUNTRY_LI = 438;//LIE

	const COUNTRY_LT = 440;//LTU

	const COUNTRY_LU = 442;//LUX

	const COUNTRY_MO = 446;//MAC

	const COUNTRY_MG = 450;//MDG

	const COUNTRY_MW = 454;//MWI

	const COUNTRY_MY = 458;//MYS

	const COUNTRY_MV = 462;//MDV

	const COUNTRY_ML = 466;//MLI

	const COUNTRY_MT = 470;//MLT

	const COUNTRY_MH = 584;//MHL

	const COUNTRY_MQ = 474;//MTQ

	const COUNTRY_MR = 478;//MRT

	const COUNTRY_MU = 480;//MUS

	const COUNTRY_YT = 175;//MYT

	const COUNTRY_MX = 484;//MEX

	const COUNTRY_FM = 583;//FSM

	const COUNTRY_MD = 498;//MDA

	const COUNTRY_MC = 492;//MCO

	const COUNTRY_MN = 496;//MNG

	const COUNTRY_ME = 499;//MNE

	const COUNTRY_MS = 500;//MSR

	const COUNTRY_MA = 504;//MAR

	const COUNTRY_MZ = 508;//MOZ

	const COUNTRY_MM = 104;//MMR

	const COUNTRY_NA = 516;//NAM

	const COUNTRY_NR = 520;//NRU

	const COUNTRY_NP = 524;//NPL

	const COUNTRY_NL = 528;//NLD

	const COUNTRY_NC = 540;//NCL

	const COUNTRY_NZ = 554;//NZL

	const COUNTRY_NI = 558;//NIC

	const COUNTRY_NE = 562;//NER

	const COUNTRY_NG = 566;//NGA

	const COUNTRY_NU = 570;//NIU

	const COUNTRY_NF = 574;//NFK

	const COUNTRY_MP = 580;//MNP

	const COUNTRY_NO = 578;//NOR

	const COUNTRY_OM = 512;//OMN

	const COUNTRY_PK = 586;//PAK

	const COUNTRY_PW = 585;//PLW

	const COUNTRY_PS = 275;//PSE

	const COUNTRY_PA = 591;//PAN

	const COUNTRY_PG = 598;//PNG

	const COUNTRY_PY = 600;//PRY

	const COUNTRY_PE = 604;//PER

	const COUNTRY_PH = 608;//PHL

	const COUNTRY_PN = 612;//PCN

	const COUNTRY_PL = 616;//POL

	const COUNTRY_PT = 620;//PRT

	const COUNTRY_PR = 630;//PRI

	const COUNTRY_QA = 634;//QAT

	const COUNTRY_MK = 807;//MKD

	const COUNTRY_RO = 642;//ROU

	const COUNTRY_RU = 643;//RUS

	const COUNTRY_RW = 646;//RWA

	const COUNTRY_RE = 638;//REU

	const COUNTRY_BL = 652;//BLM

	const COUNTRY_SH = 654;//SHN

	const COUNTRY_KN = 659;//KNA

	const COUNTRY_LC = 662;//LCA

	const COUNTRY_MF = 663;//MAF

	const COUNTRY_PM = 666;//SPM

	const COUNTRY_VC = 670;//VCT

	const COUNTRY_WS = 882;//WSM

	const COUNTRY_SM = 674;//SMR

	const COUNTRY_ST = 678;//STP

	const COUNTRY_SA = 682;//SAU

	const COUNTRY_SN = 686;//SEN

	const COUNTRY_RS = 688;//SRB

	const COUNTRY_SC = 690;//SYC

	const COUNTRY_SL = 694;//SLE

	const COUNTRY_SG = 702;//SGP

	const COUNTRY_SX = 534;//SXM

	const COUNTRY_SK = 703;//SVK

	const COUNTRY_SI = 705;//SVN

	const COUNTRY_SB = 90;//SLB

	const COUNTRY_SO = 706;//SOM

	const COUNTRY_ZA = 710;//ZAF

	const COUNTRY_GS = 239;//SGS

	const COUNTRY_SS = 728;//SSD

	const COUNTRY_ES = 724;//ESP

	const COUNTRY_LK = 144;//LKA

	const COUNTRY_SD = 729;//SDN

	const COUNTRY_SR = 740;//SUR

	const COUNTRY_SJ = 744;//SJM

	const COUNTRY_SE = 752;//SWE

	const COUNTRY_CH = 756;//CHE

	const COUNTRY_SY = 760;//SYR

	const COUNTRY_TW = 158;//TWN

	const COUNTRY_TJ = 762;//TJK

	const COUNTRY_TZ = 834;//TZA

	const COUNTRY_TH = 764;//THA

	const COUNTRY_TL = 626;//TLS

	const COUNTRY_TG = 768;//TGO

	const COUNTRY_TK = 772;//TKL

	const COUNTRY_TO = 776;//TON

	const COUNTRY_TT = 780;//TTO

	const COUNTRY_TN = 788;//TUN

	const COUNTRY_TR = 792;//TUR

	const COUNTRY_TM = 795;//TKM

	const COUNTRY_TC = 796;//TCA

	const COUNTRY_TV = 798;//TUV

	const COUNTRY_UG = 800;//UGA

	const COUNTRY_UA = 804;//UKR

	const COUNTRY_AE = 784;//ARE

	const COUNTRY_GB = 826;//GBR

	const COUNTRY_UM = 581;//UMI

	const COUNTRY_US = 840;//USA

	const COUNTRY_UY = 858;//URY

	const COUNTRY_UZ = 860;//UZB

	const COUNTRY_VU = 548;//VUT

	const COUNTRY_VE = 862;//VEN

	const COUNTRY_VN = 704;//VNM

	const COUNTRY_VG = 92;//VGB

	const COUNTRY_VI = 850;//VIR

	const COUNTRY_WF = 876;//WLF

	const COUNTRY_EH = 732;//ESH

	const COUNTRY_YE = 887;//YEM

	const COUNTRY_ZM = 894;//ZMB

	const COUNTRY_ZW = 716;//ZWE

	const COUNTRY_AX = 248;//ALA

	#endregion

	public static $country_enumMap = [
		"Afghanistan" => self::COUNTRY_AF,
		"Albania" => self::COUNTRY_AL,
		"Algeria" => self::COUNTRY_DZ,
		"American Samoa" => self::COUNTRY_AS,
		"Andorra" => self::COUNTRY_AD,
		"Angola" => self::COUNTRY_AO,
		"Anguilla" => self::COUNTRY_AI,
		"Antarctica" => self::COUNTRY_AQ,
		"Antigua and Barbuda" => self::COUNTRY_AG,
		"Argentina" => self::COUNTRY_AR,
		"Armenia" => self::COUNTRY_AM,
		"Aruba" => self::COUNTRY_AW,
		"Australia" => self::COUNTRY_AU,
		"Austria" => self::COUNTRY_AT,
		"Azerbaijan" => self::COUNTRY_AZ,
		"Bahamas (the)" => self::COUNTRY_BS,
		"Bahrain" => self::COUNTRY_BH,
		"Bangladesh" => self::COUNTRY_BD,
		"Barbados" => self::COUNTRY_BB,
		"Belarus" => self::COUNTRY_BY,
		"Belgium" => self::COUNTRY_BE,
		"Belize" => self::COUNTRY_BZ,
		"Benin" => self::COUNTRY_BJ,
		"Bermuda" => self::COUNTRY_BM,
		"Bhutan" => self::COUNTRY_BT,
		"Bolivia (Plurinational State of)" => self::COUNTRY_BO,
		"Bonaire, Sint Eustatius and Saba" => self::COUNTRY_BQ,
		"Bosnia and Herzegovina" => self::COUNTRY_BA,
		"Botswana" => self::COUNTRY_BW,
		"Bouvet Island" => self::COUNTRY_BV,
		"Brazil" => self::COUNTRY_BR,
		"British Indian Ocean Territory (the)" => self::COUNTRY_IO,
		"Brunei Darussalam" => self::COUNTRY_BN,
		"Bulgaria" => self::COUNTRY_BG,
		"Burkina Faso" => self::COUNTRY_BF,
		"Burundi" => self::COUNTRY_BI,
		"Cabo Verde" => self::COUNTRY_CV,
		"Cambodia" => self::COUNTRY_KH,
		"Cameroon" => self::COUNTRY_CM,
		"Canada" => self::COUNTRY_CA,
		"Cayman Islands (the)" => self::COUNTRY_KY,
		"Central African Republic (the)" => self::COUNTRY_CF,
		"Chad" => self::COUNTRY_TD,
		"Chile" => self::COUNTRY_CL,
		"China" => self::COUNTRY_CN,
		"Christmas Island" => self::COUNTRY_CX,
		"Cocos (Keeling) Islands (the)" => self::COUNTRY_CC,
		"Colombia" => self::COUNTRY_CO,
		"Comoros (the)" => self::COUNTRY_KM,
		"Congo (the Democratic Republic of the)" => self::COUNTRY_CD,
		"Congo (the)" => self::COUNTRY_CG,
		"Cook Islands (the)" => self::COUNTRY_CK,
		"Costa Rica" => self::COUNTRY_CR,
		"Croatia" => self::COUNTRY_HR,
		"Cuba" => self::COUNTRY_CU,
		"Curaçao" => self::COUNTRY_CW,
		"Cyprus" => self::COUNTRY_CY,
		"Czechia" => self::COUNTRY_CZ,
		"Côte d'Ivoire" => self::COUNTRY_CI,
		"Denmark" => self::COUNTRY_DK,
		"Djibouti" => self::COUNTRY_DJ,
		"Dominica" => self::COUNTRY_DM,
		"Dominican Republic (the)" => self::COUNTRY_DO,
		"Ecuador" => self::COUNTRY_EC,
		"Egypt" => self::COUNTRY_EG,
		"El Salvador" => self::COUNTRY_SV,
		"Equatorial Guinea" => self::COUNTRY_GQ,
		"Eritrea" => self::COUNTRY_ER,
		"Estonia" => self::COUNTRY_EE,
		"Eswatini" => self::COUNTRY_SZ,
		"Ethiopia" => self::COUNTRY_ET,
		"Falkland Islands (the) [Malvinas]" => self::COUNTRY_FK,
		"Faroe Islands (the)" => self::COUNTRY_FO,
		"Fiji" => self::COUNTRY_FJ,
		"Finland" => self::COUNTRY_FI,
		"France" => self::COUNTRY_FR,
		"French Guiana" => self::COUNTRY_GF,
		"French Polynesia" => self::COUNTRY_PF,
		"French Southern Territories (the)" => self::COUNTRY_TF,
		"Gabon" => self::COUNTRY_GA,
		"Gambia (the)" => self::COUNTRY_GM,
		"Georgia" => self::COUNTRY_GE,
		"Germany" => self::COUNTRY_DE,
		"Ghana" => self::COUNTRY_GH,
		"Gibraltar" => self::COUNTRY_GI,
		"Greece" => self::COUNTRY_GR,
		"Greenland" => self::COUNTRY_GL,
		"Grenada" => self::COUNTRY_GD,
		"Guadeloupe" => self::COUNTRY_GP,
		"Guam" => self::COUNTRY_GU,
		"Guatemala" => self::COUNTRY_GT,
		"Guernsey" => self::COUNTRY_GG,
		"Guinea" => self::COUNTRY_GN,
		"Guinea-Bissau" => self::COUNTRY_GW,
		"Guyana" => self::COUNTRY_GY,
		"Haiti" => self::COUNTRY_HT,
		"Heard Island and McDonald Islands" => self::COUNTRY_HM,
		"Holy See (the)" => self::COUNTRY_VA,
		"Honduras" => self::COUNTRY_HN,
		"Hong Kong" => self::COUNTRY_HK,
		"Hungary" => self::COUNTRY_HU,
		"Iceland" => self::COUNTRY_IS,
		"India" => self::COUNTRY_IN,
		"Indonesia" => self::COUNTRY_ID,
		"Iran (Islamic Republic of)" => self::COUNTRY_IR,
		"Iran" => self::COUNTRY_IR,
		"Iraq" => self::COUNTRY_IQ,
		"Ireland" => self::COUNTRY_IE,
		"Isle of Man" => self::COUNTRY_IM,
		"Israel" => self::COUNTRY_IL,
		"Italy" => self::COUNTRY_IT,
		"Jamaica" => self::COUNTRY_JM,
		"Japan" => self::COUNTRY_JP,
		"Jersey" => self::COUNTRY_JE,
		"Jordan" => self::COUNTRY_JO,
		"Kazakhstan" => self::COUNTRY_KZ,
		"Kenya" => self::COUNTRY_KE,
		"Kiribati" => self::COUNTRY_KI,
		"Korea (the Democratic People's Republic of)" => self::COUNTRY_KP,
		"Korea (the Republic of)" => self::COUNTRY_KR,
		"Kuwait" => self::COUNTRY_KW,
		"Kyrgyzstan" => self::COUNTRY_KG,
		"Lao People's Democratic Republic (the)" => self::COUNTRY_LA,
		"Latvia" => self::COUNTRY_LV,
		"Lebanon" => self::COUNTRY_LB,
		"Lesotho" => self::COUNTRY_LS,
		"Liberia" => self::COUNTRY_LR,
		"Libya" => self::COUNTRY_LY,
		"Liechtenstein" => self::COUNTRY_LI,
		"Lithuania" => self::COUNTRY_LT,
		"Luxembourg" => self::COUNTRY_LU,
		"Macao" => self::COUNTRY_MO,
		"Madagascar" => self::COUNTRY_MG,
		"Malawi" => self::COUNTRY_MW,
		"Malaysia" => self::COUNTRY_MY,
		"Maldives" => self::COUNTRY_MV,
		"Mali" => self::COUNTRY_ML,
		"Malta" => self::COUNTRY_MT,
		"Marshall Islands (the)" => self::COUNTRY_MH,
		"Martinique" => self::COUNTRY_MQ,
		"Mauritania" => self::COUNTRY_MR,
		"Mauritius" => self::COUNTRY_MU,
		"Mayotte" => self::COUNTRY_YT,
		"Mexico" => self::COUNTRY_MX,
		"Micronesia (Federated States of)" => self::COUNTRY_FM,
		"Moldova (the Republic of)" => self::COUNTRY_MD,
		"Monaco" => self::COUNTRY_MC,
		"Mongolia" => self::COUNTRY_MN,
		"Montenegro" => self::COUNTRY_ME,
		"Montserrat" => self::COUNTRY_MS,
		"Morocco" => self::COUNTRY_MA,
		"Mozambique" => self::COUNTRY_MZ,
		"Myanmar" => self::COUNTRY_MM,
		"Namibia" => self::COUNTRY_NA,
		"Nauru" => self::COUNTRY_NR,
		"Nepal" => self::COUNTRY_NP,
		"Netherlands (the)" => self::COUNTRY_NL,
		"New Caledonia" => self::COUNTRY_NC,
		"New Zealand" => self::COUNTRY_NZ,
		"Nicaragua" => self::COUNTRY_NI,
		"Niger (the)" => self::COUNTRY_NE,
		"Nigeria" => self::COUNTRY_NG,
		"Niue" => self::COUNTRY_NU,
		"Norfolk Island" => self::COUNTRY_NF,
		"Northern Mariana Islands (the)" => self::COUNTRY_MP,
		"Norway" => self::COUNTRY_NO,
		"Oman" => self::COUNTRY_OM,
		"Pakistan" => self::COUNTRY_PK,
		"Palau" => self::COUNTRY_PW,
		"Palestine, State of" => self::COUNTRY_PS,
		"Panama" => self::COUNTRY_PA,
		"Papua New Guinea" => self::COUNTRY_PG,
		"Paraguay" => self::COUNTRY_PY,
		"Peru" => self::COUNTRY_PE,
		"Philippines (the)" => self::COUNTRY_PH,
		"Pitcairn" => self::COUNTRY_PN,
		"Poland" => self::COUNTRY_PL,
		"Portugal" => self::COUNTRY_PT,
		"Puerto Rico" => self::COUNTRY_PR,
		"Qatar" => self::COUNTRY_QA,
		"Republic of North Macedonia" => self::COUNTRY_MK,
		"Romania" => self::COUNTRY_RO,
		"Russian Federation (the)" => self::COUNTRY_RU,
		"Rwanda" => self::COUNTRY_RW,
		"Réunion" => self::COUNTRY_RE,
		"Saint Barthélemy" => self::COUNTRY_BL,
		"Saint Helena, Ascension and Tristan da Cunha" => self::COUNTRY_SH,
		"Saint Kitts and Nevis" => self::COUNTRY_KN,
		"Saint Lucia" => self::COUNTRY_LC,
		"Saint Martin (French part)" => self::COUNTRY_MF,
		"Saint Pierre and Miquelon" => self::COUNTRY_PM,
		"Saint Vincent and the Grenadines" => self::COUNTRY_VC,
		"Samoa" => self::COUNTRY_WS,
		"San Marino" => self::COUNTRY_SM,
		"Sao Tome and Principe" => self::COUNTRY_ST,
		"Saudi Arabia" => self::COUNTRY_SA,
		"Senegal" => self::COUNTRY_SN,
		"Serbia" => self::COUNTRY_RS,
		"Seychelles" => self::COUNTRY_SC,
		"Sierra Leone" => self::COUNTRY_SL,
		"Singapore" => self::COUNTRY_SG,
		"Sint Maarten (Dutch part)" => self::COUNTRY_SX,
		"Slovakia" => self::COUNTRY_SK,
		"Slovenia" => self::COUNTRY_SI,
		"Solomon Islands" => self::COUNTRY_SB,
		"Somalia" => self::COUNTRY_SO,
		"South Africa" => self::COUNTRY_ZA,
		"South Georgia and the South Sandwich Islands" => self::COUNTRY_GS,
		"South Sudan" => self::COUNTRY_SS,
		"Spain" => self::COUNTRY_ES,
		"Sri Lanka" => self::COUNTRY_LK,
		"Sudan (the)" => self::COUNTRY_SD,
		"Suriname" => self::COUNTRY_SR,
		"Svalbard and Jan Mayen" => self::COUNTRY_SJ,
		"Sweden" => self::COUNTRY_SE,
		"Switzerland" => self::COUNTRY_CH,
		"Syrian Arab Republic" => self::COUNTRY_SY,
		"Syria" => self::COUNTRY_SY,
		"Taiwan (Province of China)" => self::COUNTRY_TW,
		"Tajikistan" => self::COUNTRY_TJ,
		"Tanzania, United Republic of" => self::COUNTRY_TZ,
		"Thailand" => self::COUNTRY_TH,
		"Timor-Leste" => self::COUNTRY_TL,
		"Togo" => self::COUNTRY_TG,
		"Tokelau" => self::COUNTRY_TK,
		"Tonga" => self::COUNTRY_TO,
		"Trinidad and Tobago" => self::COUNTRY_TT,
		"Tunisia" => self::COUNTRY_TN,
		"Turkey" => self::COUNTRY_TR,
		"Turkmenistan" => self::COUNTRY_TM,
		"Turks and Caicos Islands (the)" => self::COUNTRY_TC,
		"Tuvalu" => self::COUNTRY_TV,
		"Uganda" => self::COUNTRY_UG,
		"Ukraine" => self::COUNTRY_UA,
		"United Arab Emirates (the)" => self::COUNTRY_AE,
		"United Kingdom of Great Britain and Northern Ireland (the)" => self::COUNTRY_GB,
		"United States Minor Outlying Islands (the)" => self::COUNTRY_UM,
		"United States of America (the)" => self::COUNTRY_US,
		"Uruguay" => self::COUNTRY_UY,
		"Uzbekistan" => self::COUNTRY_UZ,
		"Vanuatu" => self::COUNTRY_VU,
		"Venezuela (Bolivarian Republic of)" => self::COUNTRY_VE,
		"Venezuela" => self::COUNTRY_VE,
		"Viet Nam" => self::COUNTRY_VN,
		"Virgin Islands (British)" => self::COUNTRY_VG,
		"Virgin Islands (U.S.)" => self::COUNTRY_VI,
		"Wallis and Futuna" => self::COUNTRY_WF,
		"Western Sahara" => self::COUNTRY_EH,
		"Yemen" => self::COUNTRY_YE,
		"Zambia" => self::COUNTRY_ZM,
		"Zimbabwe" => self::COUNTRY_ZW,
		"Åland Islands" => self::COUNTRY_AX,
		'Laos' => self::COUNTRY_LA,
		'Netherlands' => self::COUNTRY_NL,
		'North Macedonia' => self::COUNTRY_MK,
		'Palestine' => self::COUNTRY_PS,
		'Philippines' => self::COUNTRY_PH,
		'Republic of Lithuania' => self::COUNTRY_LT,
		'Republic of Moldova' => self::COUNTRY_MD,
		'Russia' => self::COUNTRY_RU,
		'South Korea' => self::COUNTRY_KR,
		'Taiwan' => self::COUNTRY_TW,
		'United Kingdom' => self::COUNTRY_GB,
		'United States' => self::COUNTRY_US,
		'Vietnam' => self::COUNTRY_VN,
		'Republic of the Congo' => self::COUNTRY_CD,
		'Dominican Republic' => self::COUNTRY_DO,
		'Bolivia' => self::COUNTRY_BO,
		'Tanzania' => self::COUNTRY_TZ,
		'Hashemite Kingdom of Jordan' => self::COUNTRY_JO,
		'Democratic Republic of Timor-Leste' => self::COUNTRY_TL,
		'Congo' => self::COUNTRY_CD,
		'Kosovo' => self::COUNTRY_RS,
	];

	public static $hide_enumMap = [
		'Transparent' => self::HIDE_TRANSPARENT,
		'Elite' => self::HIDE_ELITE,
		'Anonymous' => self::HIDE_ANONYMOUS,
	];

	public static $type_enumMap = [
		'HTTP' => self::TYPE_HTTP,
		'HTTPS' => self::TYPE_HTTPS,
	];

	public static function getConstantGroup(string $needle, bool $upperCase): array {
		$class = new ReflectionClass(self::class);
		$constants = [];
		$needleLen = strlen($needle);

		foreach ($class->getConstants() as $constant => $value) {
			if (strpos($constant, $needle) === 0) {
				$text = substr($constant, $needleLen);

				if (!$upperCase) {
					$text = ucwords(strtolower(str_replace('_', ' ', $text)));
				} else {
					$text = strtoupper($text);
				}

				$constants[$value] = $text;;
			}
		}

		return $constants;
	}
}