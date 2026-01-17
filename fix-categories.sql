-- Category-Product Relationship Corrections
-- Generated: 2026-01-17 10:06:13
-- Total products to fix: 1303

START TRANSACTION;

-- Step 1: Remove existing incorrect relationships
DELETE FROM category_product WHERE product_id IN (5,6,7,8,9,10,15,17,18,21,23,24,25,26,29,31,39,41,42,43,45,46,47,48,52,54,55,56,57,60,61,63,64,67,68,69,70,74,77,81,92,93,94,130,131,132,135,168,169,170,171,173,174,188,192,193,210,217,219,220,224,247,248,249,250,251,252,253,254,255,256,257,258,267,269,270,271,275,276,278,280,282,283,284,296,301,304,309,310,311,312,313,315,316,317,318,343,344,345,346);
DELETE FROM category_product WHERE product_id IN (360,361,362,363,364,365,366,367,369,370,371,372,374,375,376,377,378,379,380,381,382,383,385,386,387,388,392,393,394,395,396,397,398,399,401,402,403,410,411,412,413,414,427,431,432,433,434,445,457,467,468,477,508,509,510,511,514,515,577,581,609,639,642,645,646,647,649,652,653,654,658,676,677,678,679,697,698,700,714,718,719,722,725,728,729,732,733,734,736,737,740,744,748,749,750,752,753,754,755,756);
DELETE FROM category_product WHERE product_id IN (757,758,759,760,761,763,764,765,767,768,776,786,787,788,789,790,791,794,797,800,814,818,819,820,822,824,839,841,843,866,867,872,876,878,886,888,889,890,891,892,893,894,895,900,901,906,928,929,930,931,932,933,934,936,938,941,943,944,945,948,950,951,953,956,959,960,961,962,964,983,989,990,994,1019,1021,1023,1027,1028,1085,1094,1097,1137,1139,1141,1143,1144,1146,1148,1152,1153,1155,1157,1160,1161,1164,1166,1167,1168,1172,1173);
DELETE FROM category_product WHERE product_id IN (1176,1177,1178,1179,1180,1181,1182,1184,1188,1189,1199,1204,1217,1236,1237,1256,1258,1259,1262,1264,1265,1267,1268,1271,1272,1274,1276,1278,1279,1282,1283,1284,1285,1287,1288,1290,1308,1309,1310,1311,1312,1314,1316,1317,1324,1325,1326,1327,1328,1330,1333,1334,1335,1336,1337,1340,1344,1345,1346,1347,1348,1349,1350,1351,1352,1353,1354,1355,1356,1357,1360,1368,1369,1370,1372,1374,1376,1377,1378,1380,1382,1383,1384,1385,1386,1388,1389,1390,1391,1393,1394,1395,1398,1401,1402,1403,1404,1405,1406,1426);
DELETE FROM category_product WHERE product_id IN (1427,1428,1484,1566,1597,1598,1599,1601,1602,1603,1606,1608,1610,1614,1615,1616,1617,1618,1619,1624,1625,1627,1672,1716,1718,1720,1721,1722,1723,1724,1725,1727,1728,1730,1731,1732,1733,1734,1735,1736,1737,1738,1739,1743,1748,1749,1750,1756,1758,1759,1760,1761,1762,1763,1765,1767,1768,1769,1770,1771,1772,1773,1774,1775,1776,1777,1778,1779,1780,1781,1782,1783,1784,1785,1786,1787,1788,1789,1790,1791,1792,1793,1794,1795,1797,1798,1799,1800,1801,1802,1803,1804,1805,1806,1807,1808,1809,1810,1811,1812);
DELETE FROM category_product WHERE product_id IN (1813,1814,1815,1816,1817,1818,1819,1820,1821,1822,1823,1824,1825,1826,1827,1828,1829,1830,1831,1832,1833,1834,1835,1836,1837,1838,1839,1840,1841,1842,1843,1844,1845,1846,1848,1849,1850,1851,1852,1853,1854,1855,1856,1857,1858,1859,1860,1861,1862,1863,1864,1865,1866,1874,1875,1883,1884,1889,1902,1911,1912,1913,1915,1955,1958,1968,1972,1980,1981,1983,1984,1985,1987,1988,1989,1991,1993,1995,1996,2001,2003,2005,2009,2011,2012,2013,2017,2019,2021,2024,2025,2027,2029,2031,2032,2039,2040,2041,2046,2047);
DELETE FROM category_product WHERE product_id IN (2048,2049,2050,2051,2052,2062,2066,2068,2103,2106,2114,2115,2116,2127,2129,2130,2131,2134,2145,2148,2152,2165,2179,2190,2195,2197,2200,2205,2254,2311,2312,2328,2334,2335,2336,2337,2338,2339,2385,2402,2404,2406,2409,2417,2442,2443,2444,2449,2455,2460,2461,2462,2478,2485,2491,2492,2493,2494,2495,2496,2497,2513,2519,2520,2534,2551,2587,2588,2608,2609,2614,2615,2616,2646,2647,2648,2649,2651,2673,2687,2689,2690,2691,2692,2714,2717,2733,2749,2773,2795,2796,2797,2798,2799,2800,2801,2802,2818,2823,2827);
DELETE FROM category_product WHERE product_id IN (2844,2848,2849,2851,2852,2853,2855,2856,2860,2862,2864,2867,2868,2869,2870,2871,2872,2888,2894,2895,2896,2897,2904,2905,2906,2909,2910,2911,2912,2926,2930,2933,2941,2942,2945,2956,2957,2962,2963,2973,2974,2975,2979,2980,2983,2984,2988,2999,3002,3008,3009,3023,3025,3035,3036,3058,3110,3113,3115,3127,3129,3130,3147,3148,3150,3152,3156,3157,3172,3183,3184,3185,3194,3195,3196,3210,3211,3212,3216,3227,3230,3231,3236,3274,3276,3277,3278,3289,3290,3323,3343,3359,3365,3372,3373,3374,3375,3377,3378,3390);
DELETE FROM category_product WHERE product_id IN (3395,3398,3399,3406,3466,3467,3470,3479,3480,3481,3482,3483,3484,3500,3501,3512,3522,3553,3554,3632,3633,3682,3689,3690,3691,3693,3694,3713,3721,3729,3730,3731,3732,3735,3736,3737,3738,3749,3752,3753,3754,3755,3756,3757,3763,3764,3781,3787,3789,3790,3791,3794,3795,3797,3802,3803,3807,3810,3813,3814,3839,3840,3878,3879,3880,3881,3885,3886,3887,3894,3896,3922,3940,3944,3948,3949,3950,3951,3952,3957,3960,3961,3972,3976,3980,3990,3991,4010,4011,4012,4013,4014,4017,4018,4019,4020,4021,4022,4023,4024);
DELETE FROM category_product WHERE product_id IN (4025,4026,4027,4028,4029,4030,4031,4032,4033,4034,4035,4036,4037,4038,4039,4040,4041,4042,4043,4044,4047,4048,4049,4050,4052,4053,4056,4061,4063,4075,4079,4085,4087,4121,4127,4128,4134,4137,4144,4149,4150,4151,4152,4153,4155,4180,4181,4182,4183,4198,4205,4206,4209,4210,4224,4225,4229,4230,4231,4232,4235,4236,4238,4250,4251,4252,4264,4265,4266,4270,4276,4293,4294,4295,4296,4322,4327,4328,4329,4330,4331,4338,4348,4349,4352,4373,4374,4376,4380,4381,4387,4391,4402,4403,4404,4405,4406,4407,4408,4409);
DELETE FROM category_product WHERE product_id IN (4414,4415,4416,4417,4418,4431,4433,4441,4445,4446,4455,4456,4459,4460,4461,4467,4474,4518,4519,4520,4521,4522,4523,4524,4527,4531,4542,4544,4546,4547,4548,4552,4553,4563,4568,4583,4585,4587,4588,4599,4603,4605,4610,4613,4616,4618,4655,4658,4659,4660,4661,4662,4663,4679,4680,4690,4691,4692,4698,4699,4703,4704,4705,4706,4707,4708,4711,4712,4714,4715,4716,4718,4719,4720,4721,4722,4723,4725,4727,4728,4729,4736,4760,4761,4763,4764,4771,4778,4806,4807,4808,4815,4830,4835,4837,4838,4839,4841,4842,4844);
DELETE FROM category_product WHERE product_id IN (4845,4846,4847,4848,4849,4850,4851,4859,4860,4861,4862,4863,4876,4881,4882,4891,4894,4895,4898,4902,4903,4904,4905,4906,4907,4911,4912,4913,4914,4915,4916,4917,4918,4922,4925,4926,4927,4928,4929,4930,4933,4936,4943,4946,4947,4948,4954,4955,4958,4967,4969,4973,4974,4975,4976,4977,4978,4979,4980,4991,4992,5001,5006,5010,5015,5016,5017,5019,5020,5026,5027,5028,5029,5030,5031,5032,5033,5034,5035,5036,5037,5038,5046,5047,5051,5052,5055,5056,5057,5058,5059,5060,5064,5069,5070,5071,5073,5076,5079,5080);
DELETE FROM category_product WHERE product_id IN (5082,5091,5097,5102,5104,5105,5106,5107,5108,5109,5110,5111,5112,5113,5114,5115,5116,5117,5124,5130,5131,5132,5133,5137,5140,5141,5142,5149,5150,5151,5159,5164,5170,5174,5175,5177,5178,5184,5185,5186,5188,5191,5192,5193,5195,5196,5197,5199,5200,5201,5202,5203,5204,5212,5214,5215,5216,5217,5218,5227,5231,5232,5233,5234,5239,5245,5246,5250,5255,5256,5265,5268,5269,5270,5275,5277,5291,5292,5293,5294,5295,5296,5297,5298,5302,5303,5304,5305,5307,5309,5315,5317,5323,5324,5325,5326,5327,5335,5341,5342);
DELETE FROM category_product WHERE product_id IN (5343,5345,5351);

-- Step 2: Add correct category relationships
-- Product: لايت اند سويت بسكويت براوني 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 5);

-- Product: لايت اند سويت بسكويت القرفة 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 6);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 6);

-- Product: لايت اند سويت برجر لحم بقري 450 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 7);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 7);

-- Product: لايت اند سويت برجر دجاج 450 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 8);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 8);

-- Product: لايت اند سويت برازق السمسم 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 9);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 9);

-- Product: ارز معتق خفيف لايت اند سويت 800 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 10);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 10);

-- Product: فيدال سوس اسباني نكهة الفواكة   90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 15);

-- Product: فيدال سوس اسباني نكهة الفراولة والكريم   90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 17);

-- Product: فيدال سوس اسباني نكهة الفراولة 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 18);

-- Product: كويتا حليب عضوي لوز خالي سكر 1 لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 21);
-- WARNING: Category 'حليب نباتي' not found in database for product 21

-- Product: شار رقائق الحبوب 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 23);

-- Product: شار حبوب الافطار المقرمشة مغطاه بالشوكولاتة 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 24);

-- Product: شار بسكويت ويفر فانيلا 125 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 25);

-- Product: شار بسكويت ويفر بالليمون 125 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 26);

-- Product: لايت اند سويت محلي ستيفيا 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 29);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 29);

-- Product: لايت اند سويت خليط كيك فانيلا 400غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 31);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 31);

-- Product: ينجوين مربى المشمش 230 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 39);

-- Product: ينجوين مربى المشمش ستيفيا 280 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 41);

-- Product: ينجوين مربى ستيفيا الكرز الحامض 280 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 42);

-- Product: ينجوين مربى الكرز 230 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 43);

-- Product: ينجوين مربى الفواكة المشكلة 230 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 45);

-- Product: ينجوين مربى ستيفيا الفراولة 280 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 46);

-- Product: ينجوين مرطبان مربى الفراولة بدون سكر مضاف 290 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 47);

-- Product: ينجوين مربى الفراولة 230 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 48);

-- Product: ينجوين مرطبان مربى التوت الازرق  بدون سكر مضاف 290 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 52);

-- Product: يم ايرث مصاصات الفواكه العضوية 85 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 54);

-- Product: يم ايرث حلوى الكرات الحامضة العضوية 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 55);

-- Product: يم ايرث جلي عضوي مصنوع من الفواكه المشكلة 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 56);

-- Product: ينجوين مربى التوت  230 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 57);

-- Product: يم ايرث جلى الدببة العضوي 50 غ1.90
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 60);

-- Product: يـ لايت اند سويت بهارات الماجي 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 61);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 61);
-- WARNING: Category 'بديل ماجي' not found in database for product 61

-- Product: يـ كوشار بديل الماجي 200غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 63);
-- WARNING: Category 'بديل ماجي' not found in database for product 63

-- Product: بـ فيجيتا بديل الماجي 250 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 64

-- Product: بـ باديا ادوبو بديل الماجي مع بهارات سيزون 361 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 67

-- Product: بـ باديا ادوبو  بديل الماجي مع البهارات المتكاملة 255.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 68

-- Product: بـ باديا ادوبو بديل الماجي الطبيعي مع فلفل 198.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 69

-- Product: بـ باديا ادوبو بديل الماجي الطبيعي بدون فلفل 198.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 70

-- Product: ويذرز اورجينال دروبس خالي سكر 42 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 74);

-- Product: ووريور كرانشي بروتين رقائق شوكولاتة 64 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 77);

-- Product: باديا كينوا 340.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 81

-- Product: هيراو بروتين  فول سوداني 55 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 92);

-- Product: هيراو بروتين رول قرفة  55 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 93);

-- Product: هيراو بروتين  الكوكيز  55 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 94);

-- Product: باديا شيا 42.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 130

-- Product: باديا بذور شيا 255.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 131

-- Product: باديا بذور الكتان + بذور الشيا + بذور القنب 42.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 132

-- Product: هاينز  كاتشب خالي من السكر 369 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 135);

-- Product: نوتري بايت لوح مشمش وبذور 40 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 168);

-- Product: نوتري بايت لوح فستق حلبي 40 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 169);

-- Product: نوتري بايت لوح فستق 40 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 170);

-- Product: نوتري بايت لوح فراولة تفاح كينوا 40 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 171);

-- Product: نوتري بايت لوح جوز هند 40 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 173);
-- WARNING: Category 'حليب نباتي' not found in database for product 173

-- Product: نوتري بايت لوح التمر والجوز 40 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 174);

-- Product: نايتشر فالي بروتين بار فول سوداني ولوز  بالكراميل 40غ*4
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 188);

-- Product: نايتشر فالي بروتين بار  جوز بالكراميل المملح  40غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 192);

-- Product: نايتشر فالي بروتين بار  بالفول السوداني و رقائق الشوكولاتة الشوكولاته 40 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 193);

-- Product: نايتشرز باث شوفان ملفوف 510 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 210

-- Product: ناكيونال كورن فليكس خالي سكر 375 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 217);

-- Product: مينتوس علكة خالية من السكر نكهة النعناع البارد 56غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 219);

-- Product: مينتوس علكة خالية من السكر نكهة النعناع 56غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 220);

-- Product: ميلينيوم شوكولاتة داكنة مع ستيفيا 74% 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 224);

-- Product: ملتولين حلوى نكهة نعنع خفيف 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 247);

-- Product: ملتولين حلوى نكهة نعناع قوية 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 248);

-- Product: ملتولين حلوى نكهة ليمون ونعناع 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 249);

-- Product: ملتولين حلوى نكهة فراولة 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 250);

-- Product: ملتولين حلوى نكهة عسل ونعناع 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 251);

-- Product: ملتولين حلوى نكهة سوس ونعناع 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 252);

-- Product: ملتولين حلوى نكهة زنجبيل 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 253);

-- Product: ملتولين حلوى نكهة برتقال ونعناع 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 254);

-- Product: ملتولين حلوى نكهة الشومر100غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 255);

-- Product: ملتولين حلوى نكهة الاكولبيتوس والنعناع 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 256);

-- Product: ملبس كافندش نكهة الكرز  خالي سكر 175 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 257);

-- Product: ملبس كافندش نكهة الفواكة خالي سكر 175 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 258);

-- Product: مشروب الذهبي رد اند بلو بالزنك والعسل خالي من السكر المضاف 250مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 267);
-- WARNING: Category 'معادن' not found in database for product 267

-- Product: مربى مشمش دايت 240 غ كوسكا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 269);

-- Product: مربى كرز دايت 240 غ كوسكا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 270);

-- Product: مربى فراولة دايت 240 غ كوسكا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 271);

-- Product: مربى الكرز العضوي 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 275);

-- Product: مربى الفراولة العضوي 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 276);

-- Product: مربى الخوخ العضوي 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 278);

-- Product: مربى التوت البري العضوي 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 280);

-- Product: لوح شوفان مربع مقرمش بالقرفة 35 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 282

-- Product: لوح شوفان مربع بروتين بالفول السوداني 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 283);

-- Product: لوح شوفان مربع بروتين بالشوكولاتة 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 284);

-- Product: ماني مكسرات خلطة الكيتو 20 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 296);

-- Product: ليني و لاري كوكيز بروتين نكهة الفول السوداني 113 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 301);

-- Product: ليني و لاري كوكيز بروتين دبل شكولاتة 113 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 304);

-- Product: لين بودي شراب بروتين نكهة الموز 500مل 40غرام بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 309);

-- Product: لين بودي شراب بروتين نكهة الكوكيز  500مل 40غرام بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 310);

-- Product: لين بودي شراب بروتين  نكهة الفراولة 500مل40غرام بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 311);

-- Product: لين بودي شراب بروتين  نكهة الفانيلا  250 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 312);

-- Product: لين بودي شراب بروتين كراميل مملح 500 مل 40غرام بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 313);

-- Product: لين بودي شراب بروتين فانيلا 500 مل 40غرام بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 315);

-- Product: لين بودي شراب بروتين  شوكولاتة وزبدة الفول السوداني  500مل40غرام بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 316);

-- Product: لين بودي شراب بروتين شوكولاتة 500 مل 40غرام بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 317);

-- Product: لين بودي شراب بروتين شوكولاتة 250 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 318);

-- Product: لوح شوفان بروتين شوكلاتة 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 343);

-- Product: لوح شوفان بروتين زبدة الفول السوداني 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 344);

-- Product: لوح شوفان بروتين جوز هند 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 345);

-- Product: لوح شوفان بروتين 15 غ توت
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 346);

-- Product: لايت اند سويت هوت دوج 585 غ عدد 5 حبة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 360);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 360);

-- Product: لايت اند سويت مربى الفراولة 350 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 361);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 361);

-- Product: لايت اند سويت محلي مركز بخاخ 100 بخة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 362);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 362);

-- Product: لايت اند سويت مايونيز لايت 500غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 363);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 363);

-- Product: لايت اند سويت لانشون دجاج 800 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 364);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 364);

-- Product: لايت اند سويت لانشون بقري 800 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 365);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 365);

-- Product: لايت اند سويت كنافة  منخفضة الكربوهيدرات  2 * 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 366);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 366);

-- Product: لايت اند سويت كعك بالألياف 440غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 367);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 367);

-- Product: لايت اند سويت قطر للحلويات 500 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 369);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 369);

-- Product: لايت اند سويت شوكلاتة لوز كرات 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 370);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 370);
-- WARNING: Category 'حليب نباتي' not found in database for product 370

-- Product: لايت اند سويت شوكلاتة فستق كرات 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 371);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 371);

-- Product: لايت اند سويت شوكلاتة بندق كرات 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 372);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 372);

-- Product: لايت اند سويت شكولاتة دهن فستق وكراميل 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 374);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 374);

-- Product: لايت اند سويت شكولاتة دهن جوز هند 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 375);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 375);
-- WARNING: Category 'حليب نباتي' not found in database for product 375

-- Product: لايت اند سويت شكولاتة دهن بيضاء 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 376);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 376);

-- Product: لايت اند سويت شكولاتة دهن بندق 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 377);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 377);

-- Product: لايت اند سويت شكولاتة بار قهوة 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 378);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 378);

-- Product: لايت اند سويت شكولاتة بار بيضاء بالهيل والفستق 100غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 379);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 379);

-- Product: لايت اند سويت شكولاتة بار بيضاء 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 380);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 380);

-- Product: لايت اند سويت شكولاتة بار بالحليب 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 381);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 381);
-- WARNING: Category 'حليب نباتي' not found in database for product 381

-- Product: لايت اند سويت شكولاتة بار 100 غ كراميل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 382);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 382);

-- Product: لايت اند سويت شوكولاتة  بار دارك 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 383);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 383);

-- Product: لايت اند سويت شراب تمر هندي مركز محلى 975 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 385);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 385);

-- Product: لايت اند سويت شراب التوت مركز محلى 975 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 386);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 386);

-- Product: لايت اند سويت زعتر دقة 500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 387);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 387);

-- Product: لايت اند سويت زعتر  500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 388);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 388);

-- Product: لايت اند سويت خليط كيك شكولاتة 400غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 392);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 392);

-- Product: لايت اند سويت خبز عادي كيتو عدد 10 ارغفة تنور
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 393);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 393);

-- Product: لايت اند سويت خبز حمام كيتو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 394);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 394);

-- Product: لايت اند سويت خبز توست كيتو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 395);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 395);

-- Product: لايت اند سويت خبز برغر كيتو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 396);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 396);

-- Product: لايت اند سويت حلاوة فستق حلبي 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 397);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 397);

-- Product: لايت اند سويت حلاوة شكولاتة 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 398);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 398);

-- Product: لايت اند سويت حلاوة سادة 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 399);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 399);

-- Product: لايت اند سويت بسكويت دايجستف 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 401);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 401);

-- Product: لاجو بسكويت ويفر محشو بكريمة الكاكاو 180 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 402);

-- Product: لاجو بسكويت ويفر محشو بكريمة البندق 180غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 403);

-- Product: كويست بروتين شيبس رانش 32 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 410);

-- Product: كويست بروتين شيبس حار لايم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 411);

-- Product: كويست بروتين شيبس حار حلو 32 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 412);

-- Product: كويست بروتين شيبس جبنة 32 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 413);

-- Product: كويست بروتين شيبس تاكو 32 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 414);

-- Product: كويتا حليب عضوي جوز هند غير محلى  1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 427

-- Product: كويتا حليب شوفان 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 431

-- Product: كويتا حليب خالي لاكتوز منزوع الدسم 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 432

-- Product: كويتا حليب خالي لاكتوز كامل الدسم 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 433

-- Product: كويتا حليب خالي لاكتوز قليل الدسم 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 434

-- Product: كوسكا مربى فراولة دايت 20 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 445);

-- Product: كوتارا دايجستف بدون سكر 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 457);

-- Product: كليرسبرينج زبدة اللوز العضوية كرنشي 170غ
-- WARNING: Category 'حليب نباتي' not found in database for product 467

-- Product: كليرسبرينج زبدة اللوز العضوية الناعمة 170غ
-- WARNING: Category 'حليب نباتي' not found in database for product 468

-- Product: لعبة + حلوى PEZ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 477);

-- Product: باديا بابريكا مدخن  56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 508

-- Product: باديا بابريكا مدخن 453.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 509

-- Product: باديا بابريكا اسبانية 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 510

-- Product: باديا بابريكا 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 511

-- Product: باديا النكهة الفرنسية 70.9 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 514

-- Product: باديا اكليل الجبل 28 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 515

-- Product: اوشي مشروب فيتامين مغنيسيوم + b6
-- WARNING: Category 'فيتامينات' not found in database for product 577
-- WARNING: Category 'معادن' not found in database for product 577

-- Product: كريش بسكويت خالي من السكر 270غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 581);

-- Product: فيورنتيني اقراص نخالة الشوفان 100 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 609

-- Product: فيدال سوس نكهة الكولا 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 639);

-- Product: فيدال سوس نكهة التوت الاسود 90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 642);

-- Product: فيدال سوس  بطعم البطيخ 90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 645);

-- Product: فيدال سوس جيلي بينز  85 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 646);

-- Product: فيدال سوس اسباني نكهة الموز  100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 647);

-- Product: فيدال سوس اسباني شكل قرش نكهة التوت  100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 649);

-- Product: فيدال سوس اسباني شكل دب  90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 652);

-- Product: فيدال سوس اسباني شكل جمجمة نكهة الفراولة    100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 653);

-- Product: فيدال سوس اسباني شكل بيتزا 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 654);

-- Product: فيتاريز حليب الارز واللوز العضوي 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 658

-- Product: فروفيا مربى المشمش 330 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 676);

-- Product: فروفيا مربى الكرز 330 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 677);

-- Product: فروفيا مربى الفراولة 330 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 678);

-- Product: فروفيا مربى العنب البري 330 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 679);

-- Product: طحين اللوز امريكي 500 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 697

-- Product: طحين عالي البروتين عالي الالياف معد للخبيز 750 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 698);

-- Product: جابانيز شويس صويا صوص خالي جلوتين  200مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 700);

-- Product: شار معكرونة بيني 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 714);

-- Product: شار كوكيز برقائق الشوكولاتة 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 718);

-- Product: شار كريسب رولز 150غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 719);

-- Product: شار قرشلة 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 722);

-- Product: شار طحين فارينا متعدد الاستعمالات 500غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 725);

-- Product: شار طحين فارينا متعدد الاستعمالات 1كيلو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 728);

-- Product: شار طحين حلويات Mix C 1000g
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 729);

-- Product: شور حليب جوز الهند لايت 400 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 732

-- Product: شور حليب جوز الهند 400 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 733

-- Product: شار شيبس بطاطا باربكيو 170 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 734);

-- Product: شاي كرك يالهيل بدون سكر بكيت 8 أظراف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 736);
-- WARNING: Category 'شاي' not found in database for product 736

-- Product: شار شوكولاتة توين  بار 64.5 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 737);

-- Product: كلير سبرينج شاي سينشا الياباني العضوي 20 مغلف
-- WARNING: Category 'شاي' not found in database for product 740

-- Product: شاي الماتشا مع الكركم العضوي 20 مغلف
-- WARNING: Category 'شاي' not found in database for product 744

-- Product: شاي الماتشا العضوي 20مغلف
-- WARNING: Category 'شاي' not found in database for product 748

-- Product: شاي احمد  هضمي بطعم النعناع 20مغلف
-- WARNING: Category 'شاي' not found in database for product 749

-- Product: شاي احمد  مناعي  بطعم الليمون والزنجبيل  20مغلف
-- WARNING: Category 'شاي' not found in database for product 750

-- Product: شاي احمد ديتوكس بطعم الفاكهة ولاأعشاب  20 مغلف
-- WARNING: Category 'شاي' not found in database for product 752

-- Product: شار سولتي كراكر 175 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 753);

-- Product: شاي احمد النوم  بطعم االبابونج وعسل  20*أكياس شاي
-- WARNING: Category 'شاي' not found in database for product 754

-- Product: شاي احمد الطاقة بطعم الجريب فروت 20مغلف
-- WARNING: Category 'شاي' not found in database for product 755

-- Product: شاي احمد  الجمال بطعم الخوخ والخروب  20 مغلف
-- WARNING: Category 'شاي' not found in database for product 756

-- Product: شاي احمد أعشاب طبيعية  20مغلف
-- WARNING: Category 'شاي' not found in database for product 757

-- Product: شار ويفر مغطى بالشوكولاتة 40 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 758);

-- Product: شار ويفر سناك 105 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 759);

-- Product: شار ويفر بالبندق 63 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 760);

-- Product: شار ويفر بالبندق 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 761);

-- Product: شار حبوب الافطار 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 763);

-- Product: شار ميني سوريسي 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 764);

-- Product: شار اندول بالبندق 90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 765);

-- Product: شار معكرونة فوسيلي 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 767);

-- Product: شار  بسكويت ويفر بالكاكاو 125 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 768);

-- Product: شار بسكويت ويفر بالبندق 125غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 776);

-- Product: سباركلنك  ايس نكهة اناناس وجوز هند 502 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 786

-- Product: شار بسكويت شاي 165 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 787);
-- WARNING: Category 'شاي' not found in database for product 787

-- Product: شار بسكويت دايجستف 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 788);

-- Product: شار بسكويت ( خبز هش ) 260 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 789);

-- Product: شار بسكويت بيتيت الكيوكولاتو 130 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 790);

-- Product: شار بسكويت الشوفان 130 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 791);
-- WARNING: Category 'حليب نباتي' not found in database for product 791

-- Product: شار بسكوت شاي ماريا 125 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 794);
-- WARNING: Category 'شاي' not found in database for product 794

-- Product: سيسيني شوكولاتة دهن بالبروتين 320 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 797);

-- Product: ريد ميل نخالة الشوفان 454 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 800

-- Product: سيربونا عصيدة الشوفان بطعم الشوكولاتة والفراولة 50 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 814

-- Product: سيربونا طحين شوفان 500 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 818

-- Product: ريد ميل طحين اللوز الكامل 453 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 819

-- Product: ريد ميل طحين اللوز 453 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 820

-- Product: سيربونا عصيدة الشوفان بالكرز والفانيلا 50 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 822

-- Product: ريد ميل طحين الشوفان 510 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 824

-- Product: ريد ميل شوفان ملفوف 907 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 839

-- Product: ريد ميل شوفان سريع  التحضير عضوي 794 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 841

-- Product: ريد ميل سكر جوز الهند العضوي 369 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 843);

-- Product: ريد ميل بديل البيض 340 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 866

-- Product: سيربونا كورن فليكس خالي سكر 500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 867);

-- Product: سيربونا موسلي بروتين بار شوكولاتة بالكراميل 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 872);

-- Product: سيربونا بروتين بار شوفان بالشوكولاتة الداكنة والتوت 40 غ  20
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 876);

-- Product: سيربونا بار شوفان بالبندق 20 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 878

-- Product: سويت ليف محلي مونك فروت سائل عضوي 50مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 886);

-- Product: سويت ليف محلي مونك فروت بالبرتقال والباشن فروت 50 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 888);

-- Product: سويت ليف محلي مونك فروت العضوي 80 مغلف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 889);

-- Product: سويت ليف محلي مونك فروت العضوي 800 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 890);

-- Product: سويت ليف محلي مونك فروت العضوي 40 مغلف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 891);

-- Product: سويت ليف محلي مونك فروت العضوي 240 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 892);

-- Product: سويت ليف محلي ستيفيا عضوي 92غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 893);

-- Product: سويت ليف محلي ستيفيا العضوي 70 مغلف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 894);

-- Product: سويت ليف محلي ستيفيا العضوي 35 مغلف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 895);

-- Product: سويت ليف محلي سائل استيفيا 120 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 900);

-- Product: سويت ليف محلي سائل 60 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 901);

-- Product: سويت لو بديل السكر 50مغلف 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 906);
-- WARNING: Category 'بديل ماجي' not found in database for product 906

-- Product: ذا بريدج حليب لوز عضوي 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 928

-- Product: ذا بريدج حليب لوز عضوي 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 929

-- Product: ذا بريدج حليب عضوي ارز بالكاكاو 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 930

-- Product: جيلو جلي برتقال خالي سكر 8.5 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 931);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 931);

-- Product: ذا بريدج حليب صويا مع كاكاو 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 932

-- Product: جيلو جلي فراولة خالي سكر 8.5 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 933);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 933);

-- Product: ذا بريدج حليب صويا باريستا 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 934

-- Product: ذا بريدج حليب جوز الهند العضوي خالي سكر 1 لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 936);
-- WARNING: Category 'حليب نباتي' not found in database for product 936

-- Product: ذا بريدج حليب جوز الهند العضوي 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 938

-- Product: ذا بريدج حليب اللوز العضوي خالي سكر 1 لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 941);
-- WARNING: Category 'حليب نباتي' not found in database for product 941

-- Product: ذا بريدج حليب اللوز العضوي 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 943

-- Product: ذا بريدج حليب الصويا العضوي خالي سكر 1 لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 944);
-- WARNING: Category 'حليب نباتي' not found in database for product 944

-- Product: حلوى مايك اند لايك النكهة الاصلية 22غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 945);

-- Product: ذا بريدج حليب الشوفان بالفانيلا العضوي 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 948

-- Product: ذا بريدج حليب الشوفان العضوي خالي سكر 1 لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 950);
-- WARNING: Category 'حليب نباتي' not found in database for product 950

-- Product: ذا بريدج حليب الشوفان العضوي باريستا  1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 951

-- Product: حليبنا حليب خالي لاكتوز 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 953

-- Product: ذا بريدج حليب الارز بالفانيلا العضوي خالي سكر 1 لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 956);
-- WARNING: Category 'حليب نباتي' not found in database for product 956

-- Product: ذا بريدج حليب الارز العضوي الغني بالكالسيوم 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 959
-- WARNING: Category 'معادن' not found in database for product 959

-- Product: ذا بريدج حليب الارز العضوي 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 960

-- Product: ذا بريدج حلوى عضوية من الشوفان والشوكولاتة 130*2
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 961);
-- WARNING: Category 'حليب نباتي' not found in database for product 961

-- Product: ذا بريدج حلوى عضوية من الارز والكاكاو 130 غ*2 130 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 962);

-- Product: ذا بريدج حلوى عضوية من الارز والفانيلا 130*2
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 964);

-- Product: دراجون بروتين البازيلاء العضوية 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 983);

-- Product: دراجون خليط البروتين بالفراولة وجوز الهند العضوي 450 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 989);

-- Product: دراجون خليط البروتين الكاكاو والفانيلا العضوي 500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 990);

-- Product: دراجون سكر جوز الهند العضوي 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 994);

-- Product: باديا شاي بالبابونج 25 مغلف1غ
-- WARNING: Category 'شاي' not found in database for product 1019
-- WARNING: Category 'بديل ماجي' not found in database for product 1019

-- Product: باديا شاي بالبابونج واليانسون 25 مغلف
-- WARNING: Category 'شاي' not found in database for product 1021
-- WARNING: Category 'بديل ماجي' not found in database for product 1021

-- Product: باديا بذور القنب 35.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1023

-- Product: باديا بصل شرائح 155.9 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1027

-- Product: باديا بصل مطحون 141.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1028

-- Product: رومو معكرونة لينجويني 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1085);

-- Product: ذا بريدج حلوى عضوية  شوفان وفانيلا 130*2
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 1094);
-- WARNING: Category 'حليب نباتي' not found in database for product 1094

-- Product: دي دي حليب جوز الهند 400مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1097

-- Product: توراس شوكولاتة داكنة بالحليب واللوز75غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1137

-- Product: جولون ويفر فانيلا 60غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1139);

-- Product: جولون ويفر شوكولاتة 60غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1141);

-- Product: جولون ويفر شوكولاتة 180غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1143);

-- Product: جولون كوكيز الشوكولاتة 200غ خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1144);

-- Product: جولون كوكيز الشوكولاتة 130غ خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1146);

-- Product: جولون كوكيز الشوكولاتة 125غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1148);

-- Product: جولون دايجستف مطلي شكولاتة 270غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1152);

-- Product: جولون دايجستف زيرو الشوفان 410غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1153

-- Product: جولون دايجستف 400غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1155);

-- Product: جولون تويست ساندويتش كاكاو خالي سكر 210 غ 5*42
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1157);

-- Product: جولون بسكويت مغطى بالشوكولاته  150غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1160);

-- Product: جولون بسكويت مغطى بالشوكولاتة 150غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1161);

-- Product: جولون بسكويت كراكرز مالح 200غ خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1164);

-- Product: جولون بسكويت فايبر خالي من السكر 170 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1166);

-- Product: جولون بسكويت شوفان مغطى بالشوكولاتة 150غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1167);
-- WARNING: Category 'حليب نباتي' not found in database for product 1167

-- Product: جولون بسكويت سناك مغطى  شوكولاتة 150غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1168);

-- Product: جولون بسكويت رونديتاس 32% شوكولاتة 186غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1172);

-- Product: جولون بسكويت رقائق الشوفان 280غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1173);
-- WARNING: Category 'حليب نباتي' not found in database for product 1173

-- Product: جولون بسكويت بحشوة شوكولاتة 225غ خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1176);

-- Product: جولون بسكويت الفطور 216غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1177);

-- Product: جولون بسكويت الشوفان بالشوكولاتة الداكنة 275غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1178

-- Product: جولون بسكويت الشاي توستادا 400غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1179);
-- WARNING: Category 'شاي' not found in database for product 1179

-- Product: جولون بسكوت ساندويش بكريمة الزبادي 220غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1180);

-- Product: جولون بسكوت ساندويتش شوكولاته 250غ خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1181);

-- Product: جولون بسكوت الشوفان والبرتقال 180غ خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1182);
-- WARNING: Category 'حليب نباتي' not found in database for product 1182

-- Product: تيب تيب حليب جوز الهند 400 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1184

-- Product: جود داي كابتشينو بدون سكر13 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1188);

-- Product: جود داي كابتشينو بدون سكر مضاف  13غ *20
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1189);

-- Product: جنتي معمول مخبوز بالشوفان 16 قطعة400 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1199

-- Product: جنتي معمول 400 غ بدون سكر  جوز الهند 16 قطعة 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1204);

-- Product: جرين شوب مونك فروت محلي طبيعي 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1217);

-- Product: جرين شوب بودرة حليب جوز الهند العضوي 100 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1236

-- Product: جرين شوب اريثريتول بديل السكر 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1237);
-- WARNING: Category 'بديل ماجي' not found in database for product 1237

-- Product: جريناد بروتين شيك كوكيز وكريما 330 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1256);

-- Product: جريناد  بروتين شيك كراميل مملح 330 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1258);

-- Product: جريناد بروتين شيك شكولاته بيضاء 330 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1259);

-- Product: جريناد بروتين شيك شكولاتة براوني 330 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1262);

-- Product: جريناد بروتين شيك بالفراولة 330مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1264);

-- Product: جريناد بروتين دهن شوكولاته بيضاء 360 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1265);

-- Product: جريناد بروتين دهن شوكلاتة بالكراميل المملح 360 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1267);

-- Product: جريناد بروتين دهن بشوكولاته البندق 360 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1268);

-- Product: جريناد بروتين دهن الشوكولاته بالحليب 360 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1271);

-- Product: جريناد بروتين بار كوكي شوكولاتة بيضاء 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1272);

-- Product: جريناد بروتين بار كوكي دو  60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1274);

-- Product: جريناد بروتين بار فول سوداني 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1276);

-- Product: جريناد بروتين بار فادجد اب 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1278);

-- Product: جريناد بروتين بار شوكولاته التوت البري 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1279);

-- Product: جريناد بروتين بار اوريو 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1282);

-- Product: 1 جرانورو بيني خالي جلوتين 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1283);

-- Product: 1 جرانورو سباغيتي خالي جلوتين 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1284);

-- Product: جريناد بروتين بار الكراميل المملح 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1285);

-- Product: جريناد بروتين بار الكراميل 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1287);

-- Product: 1 جرانورو لازانيا خالي جلوتين 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1288);

-- Product: جريناد بروتين بار الفول السوداني المملح 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1290);

-- Product: توراس شوكولاتة بالحليب مع البندق 75غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1308

-- Product: توراس شوكولاتة بالحليب  75غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1309

-- Product: توراس ستيفيا شوكولاتة داكنة مع الفواكة 125غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1310);

-- Product: توراس ستيفيا شوكولاتة داكنة بالقرفة 125غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1311);

-- Product: توراس ستيفيا شوكولاتة داكنة بالبندق  125غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1312);

-- Product: توراس ستيفيا شوكولاتة داكنة 60%   100غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1314);

-- Product: توراس ستيفيا شوكولاتة بالحليب مع اللوز 125غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1316);
-- WARNING: Category 'حليب نباتي' not found in database for product 1316

-- Product: توراس ستيفيا شوكولاتة بالحليب 100غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1317);
-- WARNING: Category 'حليب نباتي' not found in database for product 1317

-- Product: تودي شوكولاته بالحليب واللوز ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1324);
-- WARNING: Category 'حليب نباتي' not found in database for product 1324

-- Product: تودي شوكولاته بالحليب والفستق الحلبي ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1325);
-- WARNING: Category 'حليب نباتي' not found in database for product 1325

-- Product: تودي شوكولاته بالبندق ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1326);

-- Product: تودي شوكولاتة دراجية بالحليب واللوز 60 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1327

-- Product: تودي شوكولاتة دراجية بالحليب والارز المحمص 60 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1328

-- Product: تودي شوكولاتة داكنة دراجية لوز 60 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1330

-- Product: تودي شوكولاتة داكنة بدون سكر 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1333);

-- Product: تودي شوكولاتة داكنة باللوز  ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1334);
-- WARNING: Category 'حليب نباتي' not found in database for product 1334

-- Product: تودي شوكولاتة داكنة باللوز  65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1335

-- Product: تودي شوكولاتة داكنة بالقهوة ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1336);

-- Product: تودي شوكولاتة داكنة بالفستق الحلبي  ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1337);

-- Product: تودي شوكولاتة داكنة بالبندق ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1340);

-- Product: تودي شوكولاتة بيضاء بالفانيلا ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1344);

-- Product: تودي شوكولاتة بالحليب والليمون 65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1345

-- Product: تودي شوكولاتة بالحليب واللوز بدون سكر 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1346);
-- WARNING: Category 'حليب نباتي' not found in database for product 1346

-- Product: تودي شوكولاتة بالحليب والكاشو بدون سكر 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1347);
-- WARNING: Category 'حليب نباتي' not found in database for product 1347

-- Product: تودي شوكولاتة بالحليب والقهوة ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1348);
-- WARNING: Category 'حليب نباتي' not found in database for product 1348

-- Product: تودي شوكولاتة بالحليب والقهوة 65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1349

-- Product: تودي شوكولاتة بالحليب والفتسق الحلبي 65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1350

-- Product: تودي  شوكولاتة بالحليب والتوت الازرق 65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1351

-- Product: تودي شوكولاتة بالحليب والبندق 65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1352

-- Product: تودي شوكولاتة بالحليب كلاسيك بدون سكر 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1353);
-- WARNING: Category 'حليب نباتي' not found in database for product 1353

-- Product: تودي شوكولاتة بالحليب دراجية بندق 60 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1354

-- Product: تودي شوكولاتة بالحليب بالفراولة 65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1355

-- Product: تودي شوكولاتة  الحليب  بالبرتقال 65 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1356

-- Product: تودي شكولاته داكنة ستيفيا   65 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1357);

-- Product: توبس مكس شوكولاته دراجية خالي سكر 500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1360);

-- Product: توبس شوكولاته ستيفيا داكنة 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1368);

-- Product: توبس شوكولاته ستيفيا بالبندق والحليب 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1369);
-- WARNING: Category 'حليب نباتي' not found in database for product 1369

-- Product: توبس شوكولاته دراجية لوز غامق 250 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1370

-- Product: توبس شوكولاته دراجية جوز هند 250 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1372

-- Product: توبس شوكولاته دراجية باللوز 250 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1374

-- Product: توبس شوكولاته بالحليب واللوز 50 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1376

-- Product: توبس شوكولاته بالحليب مع بندق  لوح 50 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1377

-- Product: توبس شوكولاته بالحليب 50 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1378

-- Product: توبس شوكولاتة غامقة لوح 60 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1380);

-- Product: توبس ستيك شوكولاته حليب 10غ *18حبة
-- WARNING: Category 'حليب نباتي' not found in database for product 1382

-- Product: توبس ستيك شوكلاته لوز 10غ * 18
-- WARNING: Category 'حليب نباتي' not found in database for product 1383

-- Product: توبس ستيك شوكلاته بالحليب والبندق 10غ * 18
-- WARNING: Category 'حليب نباتي' not found in database for product 1384

-- Product: توبس ستيفيا لوز وحليب 60 غ4
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1385);
-- WARNING: Category 'حليب نباتي' not found in database for product 1385

-- Product: توبس ستيفيا شوكولاته بالحليب  60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1386);
-- WARNING: Category 'حليب نباتي' not found in database for product 1386

-- Product: توبس دراجية شوكولاته داكنة مع اللوز 150 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1388

-- Product: توبس دراجية شوكولاته بالحليب والبندق 175 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1389

-- Product: توبس دراجية  شوكلاته بالحليب واللوز 150 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1390

-- Product: توبس حبيبات شوكولاته مع حليب 200 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1391

-- Product: توبس 95% شوكولاتة غامقة لوح 50 غ بدون سكر1.25
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1393);

-- Product: توبس 85%  شوكولاتة غامقة 85 % لوح 60 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1394);

-- Product: توبس 75% شوكولاتة غامقة   لوح 60 غ بدون سكر .
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1395);

-- Product: تروبيكانا سلم ستيفيا مغلفات 100 مغلف 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1398);

-- Product: تروبيكانا سلم محلي قليل السعرات الحرارية 50 مغلف 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1401);

-- Product: تروبيكانا سلم محلي قليل السعرات الحرارية 100  مغلف 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1402);

-- Product: تروبيكانا سلم ستيفيا مع الكروميوم 50 مغلف 125 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1403);

-- Product: تروبيكانا سلم ستيفيا مع الكروميوم 100 مغلف 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1404);

-- Product: تروبيكانا سلم ستيفيا اقراص محلي 100 حبة 6 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1405);

-- Product: تروبيكانا سلم ستيفيا مغلفات 50  مغلف 75 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1406);

-- Product: بيور بروتين شكولاتة وكراميل وفول سوداني 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1426);

-- Product: بيور بروتين شكولاتة و فول سوداني 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1427);

-- Product: بيور بروتين بار شوكولاته ديلوكس 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1428);

-- Product: بينليان رايس كيك حبوب الذرة بالفشار100غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1484);

-- Product: بومو رايس كيك أقراص الأرز مع الشوفان145غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1566

-- Product: بلو دايموند حليب لوز وجوز هند بالفانيلا غير محلى 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1597

-- Product: بلو دايموند حليب لوز غير محلى 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1598

-- Product: بلو دايموند حليب لوز بالفانيلا غير محلى 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1599

-- Product: بلو دايموند حليب اللوز مع الشوكولاتة غير محلى 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1601

-- Product: بلدنا حليب خالي من اللاكتوز 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1602

-- Product: بلدنا حليب خالي لاكتوز 6*125غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1603

-- Product: بريمير بروتين شراب كافيه لاتيه 325 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1606);

-- Product: بريمير بروتين شراب فانيلا 325 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1608);

-- Product: بريمير بروتين شراب شوكولاتة 325 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1610);

-- Product: بروبيوس سكر الفاكهة الفركتوز 500غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1614);

-- Product: برو بروتين بار مع مع رقائق الشوكولاتة 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1615);

-- Product: برو بروتين بار مع القهوة 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1616);

-- Product: برو بروتين بار كوكيز شوكولاتة 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1617);

-- Product: برو بروتين بار شوكولاتة مع النعناع 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1618);

-- Product: برو بروتين بار شوكولاتة بالفستق 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 1619);

-- Product: بردى جيلي خالي سكر نكهةالكرز  10.5 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1624);

-- Product: بردى جيلي خالي سكر نكهة الفراولة 10.5 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1625);

-- Product: براو هوم حليب جوز الهند 250 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1627

-- Product: باهار صدر الديك الرومي كيتو 155 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 1672);

-- Product: بالفيتن براوني خالي جلوتين 37 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1716);

-- Product: باسيفيك حليب صويا باريستا 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1718

-- Product: باسيفيك حليب جوز الهند غير محلى العضوي 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1720

-- Product: باسيفيك حليب جوز الهند العضوي 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1721

-- Product: باسيفيك حليب اللوز العضوي 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1722

-- Product: باسيفيك حليب اللوز فانيلا غير محلى 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1723

-- Product: باسيفيك حليب الصويا العضوي الغير محلى 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1724

-- Product: باسيفيك حليب الصويا الترا الطبيعي 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1725

-- Product: باريلا معكرونة فوسيلي 400 غ - خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1727);

-- Product: باديا سيزون ملح 453.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1728

-- Product: باديا شكولاتة قوس وقزح 85 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1730

-- Product: باديا شوكلاتة رش 85 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1731

-- Product: باديا عشبة الشبت 14.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1732

-- Product: باديا فلفل احمر مجروش 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1733

-- Product: باديا فلفل اسود 198.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1734

-- Product: باسيفيك باريستا حليب جوز الهند4.50 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1735

-- Product: باديا فلفل اسود 453.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1736

-- Product: باريلا معكرونة سباغيتي 400 غ - خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1737);

-- Product: باديا فلفل اسود 56 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1738

-- Product: باريلا معكرونة بيني 400 غ - خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1739);

-- Product: باديا فلفل اسود 99 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1743

-- Product: باسيفيك حليب اللوز باريستا 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1748

-- Product: باسيفيك حليب اللوز غير محلى 946 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 1749

-- Product: باديا فلفل اسود حب مع مطحنة 63 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1750

-- Product: باديا بصل مطحون 269.3 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1756

-- Product: باديا ورق غار مطحون 49.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1758

-- Product: باديا مينودو ميكس 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1759

-- Product: باديا بصل مطحون 78 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1760

-- Product: باديا ملح الهيمالايا الزهري مع مطحنة 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1761

-- Product: باديا مسحوق الخردل 85 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1762

-- Product: باديا ميرامية ناعم 35.4غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1763

-- Product: باديا ملح ليمون 198.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1765

-- Product: باديا مطري لحوم 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1767

-- Product: باديا ملح بحر وخل 170.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1768

-- Product: باديا بصل مع ملح 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1769

-- Product: باديا ملح البحر المدخن 255.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1770

-- Product: باديا بصل مقطع عضوي 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1771

-- Product: باديا ملح البحر 283.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1772

-- Product: باديا مسحوق الخردل 56.7g
-- WARNING: Category 'بديل ماجي' not found in database for product 1773

-- Product: باديا كيان ( فلفل احمر مطحون ) 49.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1774

-- Product: باديا بقدونس خشن 14.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1775

-- Product: باديا كيان ( فلفل احمر مطحون ) 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1776

-- Product: باديا كمون مطحون 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1777

-- Product: باديا كمون مطحون 198.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1778

-- Product: باديا كمون مطحون 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1779

-- Product: باديا بهارات 14 بهار 120.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1780

-- Product: باديا كركم مطحون عضوي 226.8g
-- WARNING: Category 'بديل ماجي' not found in database for product 1781

-- Product: باديا كركم مطحون 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1782

-- Product: باديا شاي كركديه 25 مغلف 1.5 غ
-- WARNING: Category 'شاي' not found in database for product 1783
-- WARNING: Category 'بديل ماجي' not found in database for product 1783

-- Product: باديا كبش قرنفل مطحون 49.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1784

-- Product: باديا بهارات البرتقال والفلفل 184.3 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1785

-- Product: باديا كبش قرنفل 35.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1786

-- Product: باديا قرفة مطحونة 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1787

-- Product: باديا فلفل افرنجي مطحون 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1788

-- Product: باديا قرفة مطحونة 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1789

-- Product: باديا قرفة عيدان 35.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1790

-- Product: باديا فلفل شيبوتلي مطحون 70.8 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1791

-- Product: باديا فلفل سادة حب 42.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1792

-- Product: باديا بهارات الخلطة الايطالية 35.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1793

-- Product: باديا سيزون ملح 127 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1794

-- Product: باديا سيزون مع كزبرة وناتو 907.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1795

-- Product: باديا سيزون بدون اناتو 198.1غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1797

-- Product: باديا سمسم أبيض 127.6غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1798

-- Product: باديا بهارات الشواء 99.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1799

-- Product: باديا سماق 134 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1800

-- Product: باديا سكر قوس القزح 113.4 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1801);
-- WARNING: Category 'بديل ماجي' not found in database for product 1801

-- Product: باديا بهارات الفلفل الاحمر والبصل 163غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1802

-- Product: باديا سكر اخضر 113.4 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1803);
-- WARNING: Category 'بديل ماجي' not found in database for product 1803

-- Product: باديا سكر احمر 113.4 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1804);
-- WARNING: Category 'بديل ماجي' not found in database for product 1804

-- Product: باديا بهارات الكاري 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1805

-- Product: باديا شاي زنجبيل وكركم 25 مغلف
-- WARNING: Category 'شاي' not found in database for product 1806
-- WARNING: Category 'بديل ماجي' not found in database for product 1806

-- Product: باديا زنجبيل مطحون 42.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1807

-- Product: باديا زعتر اورغانو ناعم 42.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1808

-- Product: باديا بهارات الكاري 198.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1809

-- Product: باديا زعتر اورغانو اورجانيك 21 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1810

-- Product: باديا زعتر اورغانو 63.8 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1811

-- Product: باديا بهارات الكاري 453.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1812

-- Product: باديا ريحان 21 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1813

-- Product: باديا خمس نكهات حار 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1814

-- Product: باديا خلطة فرنسية 42.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1815

-- Product: باديا بهارات الكاري 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1816

-- Product: باديا جوزة الطيب حب 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1817

-- Product: باديا جوزة الطيب 56 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1818

-- Product: باديا بهارات الكاري حار 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1819

-- Product: باديا جمايكان ستايل جيرك 141غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1820

-- Product: باديا بهارات الكيجين 652.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1821

-- Product: باديا ثوم مع ملح 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1822

-- Product: باديا ثوم معمر 7.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1823

-- Product: باديا بهارات الكيجين 78 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1824

-- Product: باديا ثوم مع بقدونس 141.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1825

-- Product: باديا بهارات المتكاملة 155.9 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1826

-- Product: باديا ثوم مطحون اورجانيك 85.04 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1827

-- Product: باديا ثوم مطحون 85 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1828

-- Product: باديا ثوم مطحون 453.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1829

-- Product: باديا بهارات المتكاملة 170 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1830

-- Product: باديا ثوم مطحون 297.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1831

-- Product: باديا ثوم مطحون 155.9 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1832

-- Product: باديا بهارات المتكاملة 340.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1833

-- Product: باديا ثوم محمص مطحون 170.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1834

-- Product: باديا ثوم اسود مطحون 170.1 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1835

-- Product: باديا بهارات المتكاملة 99.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1836

-- Product: باديا تروبيكال سيزون لحوم 99.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1837

-- Product: باديا تروبيكال سيزون لحوم  191
-- WARNING: Category 'بديل ماجي' not found in database for product 1838

-- Product: باديا بهارات جراما ماسالا 120.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1839

-- Product: باديا تروبيكال سيزون دجاج 99 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1840

-- Product: باديا تروبيكال سيزون دجاج 200 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1841

-- Product: باديا سيزون مع زعفران 198.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1842

-- Product: باديا تروبيكال سيزون دجاج 191.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1843

-- Product: باديا تاكو 78 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1844

-- Product: باديا بيجل 156 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1845

-- Product: باديا بهارات ستيك 184.3 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1846

-- Product: باديا بهارات نترو ولايم 226.8 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1848

-- Product: باديا بهارات سمك 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1849

-- Product: باديا بهارات مغربية 113.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1850

-- Product: باديا بهارات فاهيتا 269.3 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1851

-- Product: باديا بهارات ماكسيكان فيزتا 127.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1852

-- Product: باديا بهارات فاهيتا 595 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1853

-- Product: باديا بهارات ليمون و فلفل 184.3 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1854

-- Product: باديا بهارات ليمون اخضر والفلفل 184.3غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1855

-- Product: باديا بهارات فاهيتا 78 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1856

-- Product: باديا بهارات كعكة القرع 56.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1857

-- Product: باديا بهارات فلفل حار اورجانيك 2 انص
-- WARNING: Category 'بديل ماجي' not found in database for product 1858

-- Product: باديا بهارات فطر 99.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 1859

-- Product: اوت فارمر شوفان جرانولا مع دبس التمر 500 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1860

-- Product: اوت فارمر رقائق الشوفان الكاملة 1 كغم
-- WARNING: Category 'حليب نباتي' not found in database for product 1861

-- Product: اوشي مشروب الأيزوتونيك نكهة الليمون والنعناع (خالي سكر) 750 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1862);

-- Product: اوشي مشروب الايزوتونيك نكهة الليمون (خالي سكر) 750 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1863);

-- Product: اوت فارمر طحين الشوفان حبة كاملة 1كيلو
-- WARNING: Category 'حليب نباتي' not found in database for product 1864

-- Product: اوت فارمر طحين الشوفان الحبة الكاملة 500 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1865

-- Product: اوت فارمر رقائق الشوفان الكاملة  500 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 1866

-- Product: امي كب كيك خالي من السكر 40 غ*8
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1874);

-- Product: امي كب كيك خالي من السكر 40 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1875);

-- Product: اركو مارشملو خالي سكر سلندر 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1883);

-- Product: اركو مارشملو خالي سكر مكعب 69 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1884);

-- Product: امريكان جاردن سيرب  524 غ شوكلاتة خالي م السكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1889);

-- Product: النخلة حلاوة طحينية بدون سكر 500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 1902);

-- Product: الكسيح بوشار الميكرويف ملح 247 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1911);

-- Product: الكسيح بوشار الميكرويف لايت 247 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1912);

-- Product: الكسيح بوشار الميكرويف جبنة 247 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1913);

-- Product: الكسيح بوشار الميكرويف الزبدة 247 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1915);

-- Product: اطرميز زبدة اللوز الطبيعية
-- WARNING: Category 'حليب نباتي' not found in database for product 1955

-- Product: اركو مارشميلو مصاص 40 غم بوب
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 1958);

-- Product: سليستيال شاي الماتشا الاخضر 29 غ
-- WARNING: Category 'شاي' not found in database for product 1968

-- Product: سليستيال شاي اخضر مضاد للاكسدة 41 غ
-- WARNING: Category 'شاي' not found in database for product 1972

-- Product: سكوتي حليب صويا 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1980

-- Product: سكوتي حليب شوفان مع كالسيوم 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1981
-- WARNING: Category 'معادن' not found in database for product 1981

-- Product: سكوتي حليب شوفان بريستا 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1983

-- Product: سكوتي حليب شوفان اورجينال 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1984

-- Product: سكوتي حليب شوفان 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1985

-- Product: سكوتي حليب اللوز غير محلى 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1987

-- Product: سكوتي حليب اللوز اورجينال 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 1988

-- Product: شار معكرونة سباغيتي 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1989);

-- Product: شار كيك الكاكاو الأسفنجي 350غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1991);

-- Product: شار كوكيز بالزبدة 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1993);

-- Product: ريد ميل شوفان خالي جلوتين 1470 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1995);
-- WARNING: Category 'حليب نباتي' not found in database for product 1995

-- Product: شار دايجستيف مع الشوكولاتة 13.5050 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 1996);

-- Product: شارخبز  سياباتا روستيكا براون رولز  200 جرام
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2001);

-- Product: شار خبز سياباتا 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2003);

-- Product: شار خبز حمام كبير 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2005);

-- Product: ريتشارج كرات الشوفان والعسل 40 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2009);
-- WARNING: Category 'حليب نباتي' not found in database for product 2009

-- Product: ريتشارج كرات اللوز والرمان 40 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2011);
-- WARNING: Category 'حليب نباتي' not found in database for product 2011

-- Product: ريتشارج كرات بذور الشيا والفستق 40 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2012);

-- Product: ريتشارج كرات جوز الهند والكاجو 40 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2013);

-- Product: شار خبز توست اسمر بالبذور 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2017);

-- Product: شار خبز توست سادة 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2019);

-- Product: شار خبز تورتيلا 160 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2021);

-- Product: شار خبز برغر 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2024);

-- Product: شار خبز سيزريشيو  240g
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2025);

-- Product: شار جريسيني - اصابع الخبز 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2027);

-- Product: شار بسكويت محشي بالشوكلاتة 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2029);

-- Product: شار بسكويت خبز هش بني 260 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2031);

-- Product: شار بسكوت اوريو 165 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2032);

-- Product: زايلو سويت محلي اكسيليتول 1360 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2039);

-- Product: زايلو سويت محلي اكسيليتول 2270 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2040);

-- Product: زايلو سويت محلي اكسيليتول 454 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2041);

-- Product: سكوتي حليب الارز وجوز الهند 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2046

-- Product: سكوتي حليب الارز واللوز 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2047

-- Product: سكوتي حليب الارز مع بندق 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2048

-- Product: سكوتي حليب الارز مع اللوز 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2049

-- Product: سكوتي حليب الارز مع الكالسيوم 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2050
-- WARNING: Category 'معادن' not found in database for product 2050

-- Product: سكوتي حليب الارز مع الشوكولاتة 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2051

-- Product: سكوتي حليب الارز الطبيعي 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2052

-- Product: ستوليستل بسكويت الشوفان الكامل والحنطة السوداء العضوي 250 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2062

-- Product: ستوليستل بسكويت الحنطة السوداء مع البندق واللوز العضوي 250 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2066

-- Product: ستوليستل بديل الماجي العضوي 10 مكعب
-- WARNING: Category 'بديل ماجي' not found in database for product 2068

-- Product: سازون جويا بهارات التتبيل 40 غم
-- WARNING: Category 'بديل ماجي' not found in database for product 2103

-- Product: شار اصابع سيكو 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2106);

-- Product: زيرو بروتين بار تفاح 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2114);

-- Product: زيرو بار بروتين كراميل 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2115);

-- Product: زيرو بار جوز الهند  بروتين بار 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2116);

-- Product: زلوتوكلوس كوكيز بالشوكولاته والبندق خالي سكر مضاف  120 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2127);

-- Product: شار معكرونة لازانيا 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2129);

-- Product: شار شيبس بطاطا اوريجينال 170 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2130);

-- Product: شار ستيكس بسكوت مع شوكولاتة 52 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2131);

-- Product: شار بسكوت كون كيوكولاتو بالشوكولاتة 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2134);

-- Product: سيسيني زبدة ( كريمة ) اللوز دهن 380 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2145

-- Product: سيسيني زبدة الفول السوداني سوفت بدون سكر  380غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2148);

-- Product: سيربونا شوفان بار باللوز 40 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2152

-- Product: سيرا دروبس عرق سوس نعنع 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2165);

-- Product: سويت اند لو بديل السكر 100 مغلف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2179);
-- WARNING: Category 'بديل ماجي' not found in database for product 2179

-- Product: فيدال حلوى السوس تو هيدز 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2190);

-- Product: شاي احمد بابونج وليمون 20 فتلة
-- WARNING: Category 'شاي' not found in database for product 2195

-- Product: شاي احمد ثمر الورد والكركديه والكرز 20 مغلف
-- WARNING: Category 'شاي' not found in database for product 2197

-- Product: شاي احمد ليمون وزنجبيل 20 مغلف
-- WARNING: Category 'شاي' not found in database for product 2200

-- Product: شاي كرك بالهيل  بدون سكر 1 ظرف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2205);
-- WARNING: Category 'شاي' not found in database for product 2205

-- Product: لاكاسا شوكولاتة دربس اسطوانة بالحليب ملونة 20 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2254

-- Product: يم ايرث حلوى كرات عضوية بالفراولة 93.6 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2311);

-- Product: يم ايرث حلوى كرات عضوية بالحمضيات 93.6 غيو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2312);

-- Product: ستوليستل بسكويت الشوفان والكينوا العضوي 250 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2328

-- Product: ذا بريدج حليب والارز واللوز 250 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 2334

-- Product: ذا بريدج حليب شوفان عضوي 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2335

-- Product: ذا بريدج حليب الصويا العضوي بالفانيليا 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2336

-- Product: ذا بريدج حليب الارز ولوز العضوي خالي سكر 1 لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2337);
-- WARNING: Category 'حليب نباتي' not found in database for product 2337

-- Product: ذا بريدج حليب الارز وجوز الهند العضوي 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2338

-- Product: ذا بريدج حليب الارز مع الحنطة السوداء عضوي 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2339

-- Product: تودي شوكولاتة بالحليب ستيفيا 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2385);
-- WARNING: Category 'حليب نباتي' not found in database for product 2385

-- Product: بروبيوس سكر جوز الهند العضوي 500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2402);

-- Product: باديا ملح البحر مع مطحنة 120.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2404

-- Product: خل براج التفاح العضوي مع العسل والشاي الاخضر 473 مل
-- WARNING: Category 'شاي' not found in database for product 2406

-- Product: دراجون جرانولا كاكاو بروتين 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2409);

-- Product: بتر بودي محلي مونك فروت 454 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2417);

-- Product: باديا سكر قرفة 99.2 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2442);
-- WARNING: Category 'بديل ماجي' not found in database for product 2442

-- Product: باديا زعتر اورغانو خشن 28.3 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2443

-- Product: باديا بهارات خلطة الدجاج 155.9 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2444

-- Product: اوشي مشروب فيتامين زيرو بالفواكه 0.75 ل
-- WARNING: Category 'فيتامينات' not found in database for product 2449

-- Product: اوشي قهوة اسبريسو بالفيتامينات 250 مل
-- WARNING: Category 'فيتامينات' not found in database for product 2455

-- Product: اوشي بروتين  بار نكهة فانيلا 45 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2460);

-- Product: اوشي بروتين  بار نكهة الكراميل  45 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2461);

-- Product: اوشي بروتين بار نكهة جوز الهند 45 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2462);

-- Product: ذا بريدج حليب شوفان عضوي 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2478

-- Product: شيخ الكار حلاوة سادة بدون سكر 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2485);

-- Product: شاي احمد خالي من الكافيين 20 مدالية
-- WARNING: Category 'شاي' not found in database for product 2491

-- Product: شاي احمد مناعي بالليمون والزنجبيل 20 مدالية
-- WARNING: Category 'شاي' not found in database for product 2492

-- Product: شاي احمد الليمون و النعناع 20 مدالية
-- WARNING: Category 'شاي' not found in database for product 2493

-- Product: شاي احمد بهارات الشاي الاسود 20 ميدالة
-- WARNING: Category 'شاي' not found in database for product 2494
-- WARNING: Category 'بديل ماجي' not found in database for product 2494

-- Product: شاي احمد اسود معطر بدون كافيين 20 مدالية
-- WARNING: Category 'شاي' not found in database for product 2495

-- Product: شاي احمد الحمضيات 20 مدالية
-- WARNING: Category 'شاي' not found in database for product 2496

-- Product: سكوتي حليب الارز مع الكينوا 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2497

-- Product: تودي شوكولاته بالحليب والتوت البري بدون سكر مضاف 65غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2513);
-- WARNING: Category 'حليب نباتي' not found in database for product 2513

-- Product: جولون بسكوت ساندويش لبن بالشوفان خ سكر 220 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2519);
-- WARNING: Category 'حليب نباتي' not found in database for product 2519

-- Product: فيدال علكة  اكياس 100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2520);

-- Product: دوكتور اوتكر نشا ذرة خالي جلوتين 150غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2534);

-- Product: لايت اند سويت محلي سكر 160 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2551);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 2551);

-- Product: ابلايد نيوترشن شيك نكهة الفانيلا 500 مل 42غ بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2587);

-- Product: ابلايد نيوترشن شيك نكهة  الشوكولاتة 500مل  40 غ بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2588);

-- Product: يابلايد شوفان نكهة الحلوى الذهبية 60غ 23غ بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2608);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2608);

-- Product: يابلايد شوفان بنكهة الشوكولاتة 60غ 23غ بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2609);

-- Product: ابلايد نيوترشن  كرانش شوكولاتة بيضاء وكراميل غ62 21غ بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2614);

-- Product: ابلايد نيوترشن بروتين بار كرانش شوكولاتة الحليب والكراميل 62 غ 21 غ بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2615);

-- Product: ابلايد نيوترشن بروتين بار كرانش شوكولاتة الحليب والفول السوداني 65 غ 21 غ بروتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2616);

-- Product: ستاش شاي الاعشاب نكهة الكركم 36 غ
-- WARNING: Category 'شاي' not found in database for product 2646

-- Product: ستاش شاي الاعشاب نكهة النعناع 20 غ
-- WARNING: Category 'شاي' not found in database for product 2647

-- Product: ستاش شاي الاعشاب نكهة القرفة و التفاح 40 غ
-- WARNING: Category 'شاي' not found in database for product 2648

-- Product: ستاش شاي اسود 36 غ
-- WARNING: Category 'شاي' not found in database for product 2649

-- Product: ستاش شاي اخضر 40 غ
-- WARNING: Category 'شاي' not found in database for product 2651

-- Product: فيدال سوس كياس 90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2673);

-- Product: ينجوين مربى الفراولة العضوي 290غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2687);

-- Product: ينجوين مربى المشمش العضوي 290غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2689);

-- Product: باديا سيزون مع الكزبرة و الاناتو 85 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2690

-- Product: بـ باديا ادوبو بديل الماجي بدون فلفل 106.3 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2691

-- Product: باديا بهارات التروبيكال 793.8 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2692

-- Product: باديا رانش باودر 141.7 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2714

-- Product: باديا تروبيكال سيزون لحوم 200 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 2717

-- Product: مينتوس علكة خالي سكر نكهة الفراولة 56غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2733);

-- Product: جريناد بروتين بار نكهة وايت اوريو 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2749);

-- Product: غالبوسيرا كراكرز خالي جلوتين 320 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2773);

-- Product: بايورال شاي الماتشا 200 غ
-- WARNING: Category 'شاي' not found in database for product 2795

-- Product: فلافو شاي اخضر بإكليل الجبل 120 غ
-- WARNING: Category 'شاي' not found in database for product 2796

-- Product: فلافو شاي اخضر بالميرامية 120 غ
-- WARNING: Category 'شاي' not found in database for product 2797

-- Product: فلافو شاي اخضر بالكركديه 120 غ
-- WARNING: Category 'شاي' not found in database for product 2798

-- Product: فلافو شاي اخضر بالقرفة 120 غ
-- WARNING: Category 'شاي' not found in database for product 2799

-- Product: فلافو شاي اخضر بالنعناع 120 غ
-- WARNING: Category 'شاي' not found in database for product 2800

-- Product: فلافو شاي اخضر  120 غ
-- WARNING: Category 'شاي' not found in database for product 2801

-- Product: فلافو شاي اخضر بالكركم 120 غ
-- WARNING: Category 'شاي' not found in database for product 2802

-- Product: فلافو شاي اخضر بالزعتر 120 غ
-- WARNING: Category 'شاي' not found in database for product 2818

-- Product: ذا بريدج حليب اللوز باريستا عضوي 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 2823

-- Product: ابو عوف بروتين بار قهوة كاكاو وشوكولاته 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2827);

-- Product: فيدال سوس كياس توفي  100 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 2844);

-- Product: باهار صدر ديك رومي مناسب للكيتو 155*2
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 2848);

-- Product: ترابا الواح شوكلاتة بالحليب واللوز الكامل 175 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2849);
-- WARNING: Category 'حليب نباتي' not found in database for product 2849

-- Product: ترابا الواح شوكلاتة 80% دارك باللوز 100غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2851);
-- WARNING: Category 'حليب نباتي' not found in database for product 2851

-- Product: ترابا الواح شوكلاتة بالحليب واللوز 100 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2852);
-- WARNING: Category 'حليب نباتي' not found in database for product 2852

-- Product: ترابا الواح شوكلاتة بالحليب والبندق 100 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2853);
-- WARNING: Category 'حليب نباتي' not found in database for product 2853

-- Product: ترابا الواح شوكلاتة بالحليب 80 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2855);
-- WARNING: Category 'حليب نباتي' not found in database for product 2855

-- Product: ترابا الواح شوكلاتة 80% دارك 80 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2856);

-- Product: ترابا الواح شوكلاتة بالحليب 90 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2860

-- Product: ترابا الواح شوكلاتة بالحليب البندق الكامل 175 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2862

-- Product: ترابا الواح شوكلاتة دارك باللوز الكامل 175 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2864

-- Product: ترابا الواح شوكلاتة بالحليب واللوز الكامل. 175 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 2867

-- Product: ترابا ستيفيا الواح شوكلاتة بالحليب واللوز 75 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2868);
-- WARNING: Category 'حليب نباتي' not found in database for product 2868

-- Product: ترابا ستيفيا الواح شوكلاتة بالحليب والارز 75 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2869);
-- WARNING: Category 'حليب نباتي' not found in database for product 2869

-- Product: ترابا ستيفيا الواح شوكلاتة 80% دارك 75 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2870);

-- Product: ترابا ستيفيا الواح شوكلاتة دارك 50% 75 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2871);

-- Product: ترابا ستيفيا الواح شوكلاتة بالحليب 75 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2872);
-- WARNING: Category 'حليب نباتي' not found in database for product 2872

-- Product: باور هورس مشروب طاقة خالي من السكر 250مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2888);

-- Product: بيتي كروكر خليط كيك الفانيلا خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2894);

-- Product: بيتي كروكر خليط كيك شوكولاته خالي سكر 450غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2895);

-- Product: بيتي كروكر خليط كيك شوكولاته خالي جلوتين 450 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 2896);

-- Product: شاي احمد الكشمش الاسود خالي كافيين *20
-- WARNING: Category 'شاي' not found in database for product 2897

-- Product: دراجون محلي ايرثتول عضوي 250غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2904);

-- Product: سويت ليف محلي طبيعي *70
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2905);

-- Product: سويت ليف محلي طبيعي * 35مغلف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2906);

-- Product: باد اس انابوليك امينو 200 حبة
-- WARNING: Category 'امينو' not found in database for product 2909

-- Product: يابلايد كرياتين 250 غ 50 حصة ايسي بلو راز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 2910);

-- Product: يابلايد كرياتين 250 غ 50 حصة فراولة وتوت
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 2911);

-- Product: يابلايد كرياتين 250 غ 50 حصة كرز وتفاح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 2912);

-- Product: ايه بي اي بامب 500غ 40حصة ريد هاواي
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2926);

-- Product: يابلايد بروتين شوفان 3كغم 50حصة سيرب ذهبي
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2930);

-- Product: باد اس واي 2كغم 60 حصة  فراولة وموز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2933);

-- Product: يابلايد دايت واي 1.8كغم 72حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2941);

-- Product: يابلايد دايت واي 1.8كغم 72حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2942);

-- Product: يابلايد واي 2كغم 67حصة كوكيز و كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2945);

-- Product: يابلايد دايت واي 1كغم 40حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2956);

-- Product: يابلايد كلير واي 875غ  35حصة فراولة وتوت
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2957);

-- Product: يابلايد واي 900غ 30حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2962);

-- Product: يابلايد واي 900غ 30حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2963);

-- Product: سوبريور كواترو بروتين 3كغم 85حصة شوكولاتة مع البندق
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2973);

-- Product: سوبريور كواترو بروتين 3كغم 85حصة مانجا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2974);

-- Product: سوبريور بروتين 2.27كغم 70حصة شوكولاتة مع البندق
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2975);

-- Product: سوبريور بروتين 2.27كغم 70حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2979);

-- Product: سوبريور بروتين 5كغم 156حصة شوكولاتة وبندق
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2980);

-- Product: سوبريور دبليو ام بي امينو 6300 350حبة
-- WARNING: Category 'امينو' not found in database for product 2983

-- Product: سوبريور امينو 300غ 23حصة علكة
-- WARNING: Category 'امينو' not found in database for product 2984

-- Product: ريد ميل بروتين اللوز 397 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 2988);

-- Product: كوبيكو ملبس بدون سكر 75 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 2999);

-- Product: 1 جرانورو فوسيلي خالي جلوتين 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3002);

-- Product: يابلايد كلير واي 875غ 35حصة توت بري ورمان
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3008);

-- Product: يابلايد دايت واي 1كغم 40حصة فراولة ميلك شيك
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3009);

-- Product: تيراميل نوغة اللوز و العسل 250 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3023

-- Product: سوبريور بروتين 5كغم 156حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3025);

-- Product: ياسمين معمول مون بدون سكر 12*35غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3035);

-- Product: تودي كريمة اللوز 350 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3036

-- Product: زايلو سويت محلي اكسيليتول 100 * 4 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3058);

-- Product: شار بسكويت سافوياردي المقرمش 200غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3110);

-- Product: بتر بودي فودز سكر جوز الهند العضوي 680غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3113);

-- Product: بتر بودي فودز شراب  شوفان العضوي لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 3115

-- Product: شاي احمد توت و كركديه 40 غ
-- WARNING: Category 'شاي' not found in database for product 3127

-- Product: باديا بهارات المتكاملة 793.8 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 3129

-- Product: باديا قرفة مطحونة 453.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 3130

-- Product: اوليمب واي 700غ / 20 حصة - كوكيز اند كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3147);

-- Product: اوليمب واي 700غ / 20 حصة - كراميل مملح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3148);

-- Product: اوليمب واي 700غ / 20 حصة - فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3150);

-- Product: اوليمب واي  2.27 كغم / 64 حصة - كوكيز و كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3152);

-- Product: اوليمب امينو EAAاكسبلود 520غ 43حصة برتقال
-- WARNING: Category 'امينو' not found in database for product 3156

-- Product: اوليمب انابوليك امينو 400حبة
-- WARNING: Category 'امينو' not found in database for product 3157

-- Product: اوليمب بلاك وايلر شريد 480غ 80حصة برتقال
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3172);

-- Product: محبوبة لاتيه بدون سكر 10 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3183);

-- Product: محبوبة لاتيه بدون سكر 10 غ1*24
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3184);

-- Product: بايوتيك بروتين 4كغم 133حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3185);

-- Product: بايوتيك واي 2.27كغم 81حصة كوكيز&كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3194);

-- Product: بايوتيك واي 2.27كغم 81حصة كراميل مملح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3195);

-- Product: بايوتيك واي 2.27كغم 81حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3196);

-- Product: بايوتيك واي 1كغم 35حصة كراميل مملح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3210);

-- Product: بايوتيك واي 1كغم 35حصة كوكيز&كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3211);

-- Product: بايوتيك واي 1كغم 35حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3212);

-- Product: يابلايد دايت واي 1كغم 40حصة فانيلا ايسكريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3216);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3216);

-- Product: يابلايد دايت واي 1.8كغم 72حصة موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3227);

-- Product: يابلايد واي 2كغم 67حصة كراميل مملح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3230);

-- Product: يابلايد واي 2كغم 67حصة وايت شوكو بوينو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3231);

-- Product: باد اس واي 2كغم 60حصة سنيكرز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3236);

-- Product: ستوليستل مايونيز كلاسيك نباتي خالي حليب وبيض 240مل
-- WARNING: Category 'حليب نباتي' not found in database for product 3274

-- Product: بليس شيبس بروتين 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3276);

-- Product: بليس شيبس بروتين 50 غ فلفل حا ر وحلو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3277);

-- Product: بليس شيبس بروتين 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3278);

-- Product: بايوتيك بروتين 1كغم 33حصة موز و فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3289);

-- Product: بايوتيك بروتين 1كغم 33حصة شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3290);

-- Product: بايوتيك واي 1كغم 35حصة موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3323);

-- Product: فيدال سوس كياس 90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3343);

-- Product: يابلايد واي 2كغم 67حصة فانيلا ايس كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3359);

-- Product: يابلايد نيوترشن BCAA غ450 32حصة فواكه
-- WARNING: Category 'امينو' not found in database for product 3365

-- Product: يابلايد واي 450غ 15حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3372);

-- Product: يابلايد واي 450غ 15حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3373);

-- Product: يابلايد واي 450غ 15حصة فانيلا ايس كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3374);

-- Product: يابلايد دايت واي 450غ 18حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3375);

-- Product: يابلايد دايت واي 450غ 18حصة كراميل مملح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3377);

-- Product: يابلايد دايت واي 450غ 18حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3378);

-- Product: سوبر دوبر مصاص خالي من السكر بالفيتامينات والمعادن
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3390);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3390);
-- WARNING: Category 'فيتامينات' not found in database for product 3390

-- Product: ترابا ستيفيا الواح شوكلاتة بالحليب والبندق 75غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3395);
-- WARNING: Category 'حليب نباتي' not found in database for product 3395

-- Product: ترابا الواح شوكولاته بالحليب وقطع البندق 95غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3398

-- Product: ترابا لوح شوكولاته بالحليب وقطع اللوز 95غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3399

-- Product: ايفر بلد واي 2.27 كغم 72 حصة كوكيز & كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3406);

-- Product: باد اس واي 908غ 30حصة فراولة و موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3466);

-- Product: باد اس واي 2 كغم 60حصة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3467);

-- Product: لوفج حليب شوفان خالي سكر مضاف 1لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3470);
-- WARNING: Category 'حليب نباتي' not found in database for product 3470

-- Product: جو اون كريسب بروتين بار كوكيز & كراميل 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3479);

-- Product: جو ان بروتين بارفانيلا وشكولاتة 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3480);

-- Product: جو ان بروتين بار كاكاو 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3481);

-- Product: جو ان بروتين بار توت بري 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3482);

-- Product: جو اون كريسب بروتين بار فول سوداني & كراميل 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3483);

-- Product: جو ان فيتامين بار جوز الهند 50 غ
-- WARNING: Category 'فيتامينات' not found in database for product 3484

-- Product: اوليمب امينو EAA اكسبلود 520غ 43حصة فواكه
-- WARNING: Category 'امينو' not found in database for product 3500

-- Product: اوليمب امينو تارجيت 275غ 25حصة ليمون
-- WARNING: Category 'امينو' not found in database for product 3501

-- Product: بايوتيك ميجا امينو 100حبة 12حصة
-- WARNING: Category 'امينو' not found in database for product 3512

-- Product: بايوتيك واي 2.27كغم 81حصة موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3522);

-- Product: ذابريدج حليب الارز 500مل
-- WARNING: Category 'حليب نباتي' not found in database for product 3553

-- Product: ذا بريدج حليب شوفان 500مل
-- WARNING: Category 'حليب نباتي' not found in database for product 3554

-- Product: بايوتيك واي 2.27كغم 81حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3632);

-- Product: سوكوفين محلي اقراص 1200 حبة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3633);

-- Product: باديا بهارات مانجا وفلفل اسود 184غ
-- WARNING: Category 'بديل ماجي' not found in database for product 3682

-- Product: فيدال سوس كولا 90غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3689);

-- Product: فيدال دايبر XXL 15غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3690);

-- Product: فيدال سوس موز 90غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3691);

-- Product: باديا تروبيكال مع الناتو 793.8 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 3693

-- Product: القوقا حلاوة طحينية بدون سكر 30 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3694);

-- Product: لايكينج ملبس عرق السوس 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3713);

-- Product: سايتك واي 30 غ شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3721);

-- Product: لازار اسينشيال امينو 390غ 55حصة مانجو وماركوجا
-- WARNING: Category 'امينو' not found in database for product 3729

-- Product: لازار فيتامين / امينو 300غ 20حصة اجاص
-- WARNING: Category 'امينو' not found in database for product 3730
-- WARNING: Category 'فيتامينات' not found in database for product 3730

-- Product: لازار فيتامين/ امينو 300غ 20حصة عنب اسود
-- WARNING: Category 'امينو' not found in database for product 3731
-- WARNING: Category 'فيتامينات' not found in database for product 3731

-- Product: لازار ايزو 1.6كغم 64حصة شوكولاتة بالحليب
-- WARNING: Category 'حليب نباتي' not found in database for product 3732

-- Product: لازار واي 1كغم 33حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3735);

-- Product: لازار واي 1كغم 33حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3736);

-- Product: لازار واي 2.27كغم 75حصة شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3737);

-- Product: لازار واي 2.27كغم 75حصة فراولة و موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3738);

-- Product: برو بروتين بار مع كراميل  70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3749);

-- Product: ريل نيوترشن شيبس بروتين باربكيو 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3752);

-- Product: ريل نيوترشن شيبس بروتين رانش 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3753);

-- Product: ريل نيوترشن شيبس بروتين لبن و خيار 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3754);

-- Product: ريل نيوترشن شيبس بروتين جبنة 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3755);

-- Product: ريل نيوترشن شيبس بروتين عسل و خردل 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3756);

-- Product: ريل نيوترشن شيبس بروتين سويت تشيلي 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3757);

-- Product: شار بسكويت كراكرز 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3763);

-- Product: ذا بريدج حليب ارز اللوز العضوي 200 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 3764

-- Product: ميوتنت واي 2.27كغم 63حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3781);

-- Product: توبس دراجيه شوكولاته بالحليب لوز مغبر 250غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3787

-- Product: توبس دراجيه شوكولاته بالحليب والكروكان 250غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3789

-- Product: توبس دراجيه بالحليب والتمر 250غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3790

-- Product: توبس دراجيه خالي سكر مضاف 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3791);

-- Product: توبس دراجيه شوكولاته بيضاء بالتوت واللوز 250غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3794

-- Product: توبس شوكولاته بالحليب والبستاشيو 50غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3795

-- Product: فيدال سوس كياس 90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3797);

-- Product: بالانس شيبس بروتين ليمون حلو 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3802);

-- Product: بالانس شيبس بروتين كريمة وبصل 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3803);

-- Product: فاربو ملبس عرق سوس 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3807);

-- Product: هابي فيت ويفر بروتين فانيلا 95غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3810);

-- Product: هابي تايم شوكولاته بروتين محشو بالفول السوداني 86غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3813);

-- Product: باد اس واي 908غ 27حصة سنيكرز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3814);

-- Product: ابو عوف كرات بروتين فول سوداني 42غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3839);

-- Product: ابو عوف كرات بروتين كوكيز & كريم 42غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3840);

-- Product: ريتشارج بروتين بار فول سوداني و عسل 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3878);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3878);

-- Product: ريتشارج بروتين بار قرفة 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3879);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3879);

-- Product: ريتشارج بروتين بار كاشو 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3880);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3880);

-- Product: ريتشارج بروتين بار بندق 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3881);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3881);

-- Product: بايوتيك واي 28غ حصة واحدة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3885);

-- Product: بايوتيك واي 28غ حصة واحدة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3886);

-- Product: بايوتيك واي 28غ حصة واحدة موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3887);

-- Product: بودي  بيلدر واي 907غ 27حصة كوكيز&كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3894);

-- Product: بودي  بيلدر واي 1.8كغم 54حصة كوكيز&كريم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3896);

-- Product: لابيرفا ترو لين CLA &كارنتين &شاي اخضر &قهوة خضراء 210غ 30حصة مانجا
-- WARNING: Category 'شاي' not found in database for product 3922

-- Product: بيو&مي جرانولا قليل السكر 360غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3940);

-- Product: بيو&مي جرانولا كاجو ولوز 350غ
-- WARNING: Category 'حليب نباتي' not found in database for product 3944

-- Product: دون سيمون حليب الصويا بالكاكاو 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 3948

-- Product: دون سيمون حليب الشوفان 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 3949

-- Product: زومبي مصاص خالي جلوتين
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 3950);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3950);

-- Product: كاندي فينس مصاص خالي سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3951);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3951);

-- Product: هاي فايف مصاص خالي من الجلوتين 20 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 3952);

-- Product: فلافو شاي اخضر بالزنجبيل 120غ
-- WARNING: Category 'شاي' not found in database for product 3957

-- Product: جوست واي 924غ 26حصة فول سوداني & سيريال ميلك
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3960);

-- Product: جوست واي 1014غ 26حصة كوكيز تشوكليت شيب
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3961);

-- Product: يابلايد واي 2كغم 67حصة شوكلت ميلك شيك
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3972);

-- Product: يابلايد بروتين شوفان 600غ 10حصص شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3976);

-- Product: يابلايد كرياتين 250 غ 50 حصة مايكرونايزد
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 3980);

-- Product: ينجوين مربى الكرز بدون سكر مضاف 290 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 3990);

-- Product: يابلايد بروتين شوفان 600غ 10حصص جولد سيرب
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 3991);

-- Product: باديا بابونج 7.1غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4010

-- Product: باديا اورغانو 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4011

-- Product: باديا كريم التارتار 42.5غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4012

-- Product: باديا زنجبيل مطحون 21غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4013

-- Product: باديا قرنفل 7.1غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4014

-- Product: باديا ثوم وبقدونس مطحن 42.5غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4017

-- Product: باديا بذور اليانسون 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4018

-- Product: باديا بذور الكتان 42.6غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4019

-- Product: باديا فلفل مطحون 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4020

-- Product: باديا مطري لحوم 56.7غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4021

-- Product: باديا ورق غار 5.67غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4022

-- Product: باديا اورغانو مطحون 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4023

-- Product: باديا قرفة مطحونة 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4024

-- Product: باديا ورق غار مطحون 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4025

-- Product: باديا نعنع 7.1غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4026

-- Product: باديا زعتر 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4027

-- Product: باديا كزبرة 7.1غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4028

-- Product: باديا بابريكا 28غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4029

-- Product: باديا بذور الاناتو 28غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4030

-- Product: باديا فلفل حلو حب 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4031

-- Product: باديا ريحان 14غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4032

-- Product: باديا روزماري 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4033

-- Product: باديا ثوم مطحون 28غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4034

-- Product: باديا بقدونس 7.1غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4035

-- Product: باديا كاري باودر 28غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4036

-- Product: باديا فلفل ابيض مطحون 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4037

-- Product: باديا بهارات المتكاملة 49.6غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4038

-- Product: باديا ريد بيبر 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4039

-- Product: باديا كمون حبوب 28غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4040

-- Product: باديا كمون مطحون 28غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4041

-- Product: باديا بصل باودر 28غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4042

-- Product: باديا ورق المردقوش 7.1غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4043

-- Product: باديا فلفل اسود حب 14.2غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4044

-- Product: ياسمين معمول تمر بدون سكر 500غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4047);

-- Product: كوسكا راحة ورد & ليمون خالي جلوتين 250غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4048);

-- Product: كوسكا راحة مشكلة خالي جلوتين 250غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4049);

-- Product: كوسكا راحة بالمكسرات خالي جلوتين 250غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4050);

-- Product: جريناد بروتين نكهة شوكولاتة وايت اوريو 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4052);

-- Product: جريناد بروتين نكهة شوكولاتة اوريو 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4053);

-- Product: نوتري بايت لوح توت وفستق وجوز هند 40 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4056

-- Product: يابلايد واي 2كغم 67حصة سكويشز درمستيك
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4061);

-- Product: توبس دراجيه جوز هند بالنعنع 250غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4063

-- Product: باديا كيان فلفل احمر 453.6غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4075

-- Product: اوليمب واي  2.27 كغم / 64 حصة - فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4079);

-- Product: اوليمب واي  2.27 كغم / 64 حصة - شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4085);

-- Product: اوليمب واي  2.27 كغم / 64 حصة - جوز هند
-- WARNING: Category 'حليب نباتي' not found in database for product 4087
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4087);

-- Product: فيدال سوس ميجا جيلي ميكس 90ف
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4121);

-- Product: باسيفيك حليب شوفان بريستا 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 4127

-- Product: باسيفيك حليب الشوفان عضوي 946مل
-- WARNING: Category 'حليب نباتي' not found in database for product 4128

-- Product: ريد ميل قطع شوفان كامل عضوي 680غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4134

-- Product: خل فيرشايلد التفاح العضوي 473مل
-- WARNING: Category 'شاي' not found in database for product 4137

-- Product: سليستيال شاي اعشاب منزوع الكافيين 36غ
-- WARNING: Category 'شاي' not found in database for product 4144

-- Product: ستاش شاي اسود بالبهارات 38غ
-- WARNING: Category 'شاي' not found in database for product 4149
-- WARNING: Category 'بديل ماجي' not found in database for product 4149

-- Product: ستاش شاي اخضر 38غ
-- WARNING: Category 'شاي' not found in database for product 4150

-- Product: ستاش شاي اسود للافطار 36غ
-- WARNING: Category 'شاي' not found in database for product 4151

-- Product: ستاش شاي اسود ايرل جراي 38غ
-- WARNING: Category 'شاي' not found in database for product 4152

-- Product: ستاش شاي البابونج 18غ
-- WARNING: Category 'شاي' not found in database for product 4153

-- Product: ستاش شاي الافطار الانجليزي 40غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4155);
-- WARNING: Category 'شاي' not found in database for product 4155

-- Product: ارماندو معكرونة خالي جلوتين ال كيفرو 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4180);

-- Product: ارماندو معكرونة خالي جلوتين بينا 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4181);

-- Product: ارماندو معكرونة خالي جلوتين ال توبيتو ريجاتو 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4182);

-- Product: ارماندو معكرونة خالي جلوتين سباغيتي 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4183);

-- Product: يابلايد واي 2كغم 67حصة شوكو بوينو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4198);

-- Product: سيربونا شوفان عالي البروتين موز و شوكولاتة 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4205);

-- Product: سيربونا شوفان عالي البروتين كراميل 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4206);

-- Product: رايدر بروتين بار توت و فول سوداني 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4209);

-- Product: رايدر بروتين بار برتقال و فول سوداني 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4210);

-- Product: ايفولف زيرو بروتين بايتس لوز بالتمر ستيفيا 30غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4224);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4224);

-- Product: ايفولف زيرو بروتين بايتس دبل تشوكلت ستيفيا 30غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4225);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4225);

-- Product: ايفولف زيرو بروتين بايتس لوتس ستيفيا 30غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4229);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4229);

-- Product: ايفولف زيرو بروتين بايتس موكا ستيفيا 30غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4230);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4230);

-- Product: ايفولف زيرو بروتين بايتس كوكيز اند كريم ستيفيا 30غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4231);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4231);

-- Product: ايفولف زيرو بروتين بايتس كاجو كراميل ستيفيا 30غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4232);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4232);

-- Product: توبس الواح شوكولاته بالحليب 100غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4235

-- Product: توبس الواح شوكولاته بالحليب والبندق 100غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4236

-- Product: توبس الواح شوكولاته بالحليب واللوز 100غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4238

-- Product: هوراس واي 1.6كغم 40حصة موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4250);

-- Product: هوراس واي 1.6كغم 40حصة بلوبري
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4251);

-- Product: هوراس واي 1.6كغم 40حصة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4252);

-- Product: دون سيمون حليب الصويا 1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 4264

-- Product: ملبس كافندش خ سكر مشكل 175 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4265);

-- Product: ملبس كافندش خ سكر مشكل 175 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4266);

-- Product: سوبريور بروتين2.27كغم 70حصة ايس كوفي
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4270);

-- Product: سيريرا كورن فليكس خالي سكر 425غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4276);

-- Product: سوبريور واي 2.27كغم 70حصة شوكولاتة و موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4293);

-- Product: بالانس شيبس بروتين حار 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4294);

-- Product: بالانس شيبس بروتين جبنة 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4295);

-- Product: بالانس شيبس بروتين ذرة 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4296);

-- Product: باد اس انابوليك واي 908غ 27حصة شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4322);

-- Product: شار خبز بانيني رولز 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4327);

-- Product: اوشي بروتين بار لوز وتوت 49غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4328);

-- Product: اوشي بروتين بار بندق 37غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4329);

-- Product: اوشي بروتين بار تيراميسو 37غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4330);

-- Product: ياسمين دايجستف الشوفان بدون سكر 12×2
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4331);
-- WARNING: Category 'حليب نباتي' not found in database for product 4331

-- Product: فيزو مشروب غازي بنكهه اناناس وجوز هند  500 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 4338

-- Product: يابلايد كرياتين حلاوة جلي 400 غ مونهيدرات 20 حصة فيمتو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4348);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 4348);

-- Product: يابلايد كرياتين حلاوة جلي 400 غ مونهيدرات 20 حصة توت
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4349);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 4349);

-- Product: يابلايد كرياتين سائل كريافلو 500 مل توت ازرق
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 4352);

-- Product: ووريور كرانشي بروتين بار فول سوداني 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4373);

-- Product: ووريور كرانشي بروتين بار براوني 65 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4374);

-- Product: لاكانتو محلي مونك فروت 800غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4376);

-- Product: لاكانتو محلي مونك فروت 30مغلف 90غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4380);

-- Product: لاكانتو محلي مونك فروت عضوي 454غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4381);

-- Product: تروبيكانا سلم محلي ستيفيا 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4387);

-- Product: بوموس بروتين كرنشي موز 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4391);

-- Product: بومبوس سوس فراولة 35غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4402);

-- Product: بومبوس سوس كرز 35غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4403);

-- Product: ايفولف زيرو بروتين بار مع الاشوجندا 70 غ فول سوداني
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4404);

-- Product: ايفولف زيرو بروتين بار مع الاشوجندا 70 غ لوتس
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4405);

-- Product: ايفولف زيرو بروتين بار مع الاشوجندا 70 غ لاتيه
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4406);

-- Product: ايفولف زيرو بروتين بار مع الاشوجندا 70 غ كراميل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4407);

-- Product: ايفولف زيرو بروتين بار مع الاشوجندا 70 غ كوكيز و كريمة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4408);

-- Product: ايفولف زيرو بروتين بار مع الاشوجندا 70 غ شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4409);

-- Product: ايفولف زيرو شيبس بروتين 40 غ جبنة الناتشو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4414);

-- Product: ايفولف زيرو شيبس بروتين 40 غ بندورة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4415);

-- Product: ايفولف زيرو شيبس بروتين 40 غ كريمة و بصل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4416);

-- Product: ايفولف زيرو شيبس بروتين 40 غ باربيكيو و عسل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4417);

-- Product: ايفولف زيرو شيبس بروتين 40 غ جبنة يوناني
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4418);

-- Product: ايمكو جرانولا بدون سكر 500 غ شوكولاتة و جوز هند
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4431);
-- WARNING: Category 'حليب نباتي' not found in database for product 4431

-- Product: ايمكو جرانولا بدون سكر 500 غ مكسرات و لوز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4433);
-- WARNING: Category 'حليب نباتي' not found in database for product 4433

-- Product: جود دي كابتشينو بدون سكر *5 مغلفات
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4441);

-- Product: كوكو لايف حليب جوز هند بودرة 300غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4445

-- Product: كوكو لايف طحين جوز هند عضوي 500غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4446

-- Product: هيراو بروتين بار جوز هند 55غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4455);

-- Product: هيراو  بروتين بار زبدة اللوز 55غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4456);

-- Product: كوكو لايف ماء جوز هند 350مل
-- WARNING: Category 'حليب نباتي' not found in database for product 4459

-- Product: كوكو لايف سكر جوز هند 500غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4460);
-- WARNING: Category 'حليب نباتي' not found in database for product 4460

-- Product: لوح شوفان بروتين 60غ بندق شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4461);

-- Product: نوتري بايت لوح شوكولاتة وكرانبري  40 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4467);

-- Product: بومبوس سوس خوخ 35غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4474);

-- Product: بومبوس سوس مانجا 35غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4518);

-- Product: بوست بروتين بار كوكيز وكريمة 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4519);

-- Product: بوست بروتين بار فول سوداني  60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4520);

-- Product: بوست بروتين بار كراميل وشوكولاتة  60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4521);

-- Product: بوست بروتين بار كابتشينو  60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4522);

-- Product: بوست بروتين بار تشيز كيك فراولة  60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4523);

-- Product: بوست بروتين بار براوني 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4524);

-- Product: وريار امينو 360غ 30حصة ليمون
-- WARNING: Category 'امينو' not found in database for product 4527

-- Product: وريار امينو 360غ 30حصة بلو راز
-- WARNING: Category 'امينو' not found in database for product 4531

-- Product: الابا رولز ويفر جوز هند 8قطع 140غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4542

-- Product: كيركلاند حليب اللوز الغيز محلى 746 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 4544

-- Product: جولون بسكويت ماريا خالي جلوتين 380غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4546);

-- Product: سويت جوي كاندي فواكة 180 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4547);

-- Product: سويت جوي كاندي كراميل 180 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4548);

-- Product: يوك طحين خالي جلوتين 500غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4552);

-- Product: ابو عوف بروتين بار نكهة الموز و الكاجو 70 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4553);

-- Product: ايفولف زيرو شوكولاتة دارك بالتمر ستيفيا 85غ للحصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4563);

-- Product: جالو سباغتي خالي جلوتين 450غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4568);

-- Product: ريل نيوترشن شوكو بوبس 30 غ حليب
-- WARNING: Category 'حليب نباتي' not found in database for product 4583

-- Product: يابلايد واي 2كغم 67حصة فراولة ميلك شيك
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4585);

-- Product: جوست واي 1014غ 26حصة سيريال ميلك
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4587);

-- Product: جوست واي 1014غ 26حصة سينابون
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4588);

-- Product: سويت اند لو محلي 100 حبة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4599);

-- Product: فيتاريز بيو باريستا لوز  1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 4603

-- Product: فيتاريز بيو باريستا جوز هند1 لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 4605

-- Product: كوتارا بسكويت بدون سكر 175غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4610);

-- Product: اينير ارمور  واي 907غ 28حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4613);

-- Product: جولون  شوكو بوم خالي جلوتين 120غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4616);

-- Product: جريناد بروتين نكهة الليمون 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4618);

-- Product: ماجور جراين جوز هند 40 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4655

-- Product: هوراس واي 1.6كغم 40حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4658);

-- Product: محبوبة شاي ديتوكس 30 مغلف
-- WARNING: Category 'شاي' not found in database for product 4659

-- Product: هوراس واي 39غ 1حصة بلوبيري
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4660);

-- Product: هوراس واي 39غ 1حصة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4661);

-- Product: هوراس واي 39غ 1حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4662);

-- Product: لايت اند سويت كاتشب خالي سكر 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4663);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 4663);

-- Product: باديا فلفل اسود خشن 453.6 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4679

-- Product: كور باور شراب البروتين شوكولاتة 414 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4680);

-- Product: سيربونا شوفان بالشوكلاتة والبسكويت  450غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4690

-- Product: سيربونا شوفان بالشوكلاتة والبسكويت  450غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4691

-- Product: سيربونا شوفان بالشوكولاتة  450غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4692

-- Product: بيو فاكتور بوشار مايكرويف اورجانيك مملح 3*90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4698);

-- Product: بيو فاكتور بوشار مايكرويف مملح 3*90 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4699);

-- Product: دراجون بروتين الارز العضوي 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4703);

-- Product: سيرا دروبس البرتقال والليمون مع فيتامين سي 50 غ
-- WARNING: Category 'فيتامينات' not found in database for product 4704

-- Product: سيرا دروبس اعشاب والليمون مع فيتامين سي 50 غ
-- WARNING: Category 'فيتامينات' not found in database for product 4705

-- Product: سيرا دروبس النعنع والكينا مع فيتامين سي 50 غ
-- WARNING: Category 'فيتامينات' not found in database for product 4706

-- Product: سيرا دروبس النعنع والكينا مع فيتامين سي 80 غ
-- WARNING: Category 'فيتامينات' not found in database for product 4707

-- Product: سيرا دروبس الاعشاب والليمون مع فيتامين سي 80 غ
-- WARNING: Category 'فيتامينات' not found in database for product 4708

-- Product: تي في ان بروتين بار 60 غ فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4711);

-- Product: تي في ان بروتين بار 60 غ بندق
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4712);

-- Product: تي في ان بروتين بار 60 غ دوانتس
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4714);

-- Product: تي في ان بروتين بار 60 غ موكا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4715);

-- Product: تي في ان بروتين بار 60 غ كراميل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4716);

-- Product: ايفولف زيرو بروتين بار بستاشيو  50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4718);

-- Product: ايفولف زيرو بروتين بار بندق 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4719);

-- Product: ايفولف زيرو بروتين بار فستق 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4720);

-- Product: ايفولف زيرو بروتين بار لوتس 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4721);

-- Product: ايفولف زيرو بروتين بار جو الهند 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4722);

-- Product: ايفولف زيرو شوكولاتة بالحليب و التمر 85غ للحصة
-- WARNING: Category 'حليب نباتي' not found in database for product 4723

-- Product: فيدال دايبر توت فراولة 15غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4725);

-- Product: باديا حبوب لقاح 34.4 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4727

-- Product: باديا حبيبات العسل 262.2 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4728

-- Product: باديا حبوب لقاح 283.5 غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4729

-- Product: جرين شوب بديل السكر اكسيليتول 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4736);
-- WARNING: Category 'بديل ماجي' not found in database for product 4736

-- Product: ارمي واي 2.27كغم 70حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4760);

-- Product: ارمي واي 2.27كغم 70حصة شوكولاته بيضاء بالفراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4761);

-- Product: واو هايدريت بروتين برو 500مل فواكه
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4763);

-- Product: واو هايدريت بروتين الكولاجين 500مل فواكه
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4764);

-- Product: بالفيتن عجينة بيتزا كيتو 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 4771);

-- Product: بالفيتن خبز كيتو بيتزا 30 غ * 4
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 4778);

-- Product: يابلايد مياه بروتين 330مل برتقال
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4806);

-- Product: يابلايد مياه بروتين 330مل تفاح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4807);

-- Product: يابلايد مياه بروتين 330مل تروبيكال بيرست
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4808);

-- Product: ابلايد نيوترشن وجبة شوفان بروتين 60غ كوكيز و كريمة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4815);

-- Product: شاي احمد اسود نكهة الكراميل ، القرفة بدون كافيين 20 مدالية
-- WARNING: Category 'شاي' not found in database for product 4830

-- Product: كري كري لبن يوناني 21غ بروتين 205غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4835);

-- Product: ذا بريدج بديل البيض نباتي 500غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4837

-- Product: ذا بريدج حليب الشوفان بريستا عضوي 500 ملم
-- WARNING: Category 'حليب نباتي' not found in database for product 4838

-- Product: 1 بيج لاين ويفر حمضيات خالي من السكر 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4839);

-- Product: 1 بيج لاين ويفر شوكولاتة خالي من السكر 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4841);

-- Product: 1 بيج لاين ويفر جوز الهند خالي من السكر 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4842);

-- Product: توبس اينيرجي بار لوز غامقة بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4844);
-- WARNING: Category 'حليب نباتي' not found in database for product 4844

-- Product: توبس اينيرجي بار جوز هند غامقة بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4845);
-- WARNING: Category 'حليب نباتي' not found in database for product 4845

-- Product: توبس اينيرجي بار قرفة غامقة بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4846);

-- Product: توبس اينيرجي بار باللوز و الحليب بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4847);
-- WARNING: Category 'حليب نباتي' not found in database for product 4847

-- Product: توبس اينيرجي بار جوز هند بالحليب بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4848);
-- WARNING: Category 'حليب نباتي' not found in database for product 4848

-- Product: توبس اينيرجي بار توت غامقة بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4849);

-- Product: توبس اينيرجي بار توت بالحليب بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4850);
-- WARNING: Category 'حليب نباتي' not found in database for product 4850

-- Product: توبس اينيرجي بار قرفة بالحليب بدون سكر 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 4851);
-- WARNING: Category 'حليب نباتي' not found in database for product 4851

-- Product: ريتشارج بروتين بار فول سوداني 60غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4859);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4859);

-- Product: ريتشارج بروتين بارجوز هند 60 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4860);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4860);

-- Product: بالانس شيبس بروتين عسل و زبدة 70غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4861);

-- Product: هوراس ايس كريم بروتين 74غ حصة واحدة شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4862);

-- Product: هوراس ايس كريم بروتين 74غ حصة واحدة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4863);

-- Product: داكولونيا زبدة الفول السوداني مع الحليب المكثف 450غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4876

-- Product: داكولونيا حلوى فول سوداني زيرو علبة 170غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4881);

-- Product: داكولونيا حلوى فول سوداني 210غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4882);

-- Product: داكولونيا حلوى فول سوداني مستطيل 180غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4891);

-- Product: داكولونيا حلوى الموز مع الاكاي 150غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4894);

-- Product: داكولونيا حلوى الموز العضوي 100غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4895);

-- Product: داكولونيا حلوى فول سودانية مستطيل  14غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 4898);

-- Product: ماتشا بريميوم كبسولات اللكارناتين مع الشاي الاخضر 30كبسولة
-- WARNING: Category 'شاي' not found in database for product 4902

-- Product: ماتشا بريميوم اقراص اوراق المتة والشاي الابيض وفيتامين سي 30حبة
-- WARNING: Category 'شاي' not found in database for product 4903
-- WARNING: Category 'فيتامينات' not found in database for product 4903

-- Product: ماتشا بريميوم شاي اخضر مع شاي الاعشاب بالمشمش 20كيس
-- WARNING: Category 'شاي' not found in database for product 4904

-- Product: ماتشا بريميوم شاي الاعشاب مع الشاي الاخضر 20كيس
-- WARNING: Category 'شاي' not found in database for product 4905

-- Product: ماتشا بريميوم شاي اخضر مسحوق بالقهوة 20كيس
-- WARNING: Category 'شاي' not found in database for product 4906

-- Product: ماتشا بريميوم شاي اعشاب مع شاي اخضر و بروميلي 20كيس
-- WARNING: Category 'شاي' not found in database for product 4907

-- Product: تسلا نيوترشن هايدرو واي 2.27كغم 66حصة شوكولاته
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4911);

-- Product: باديا فلفل مانجا 680غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4912

-- Product: باديا بهارات تشيلي باودر 453غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4913

-- Product: ارماندو معكرونة خالي جلوتين فوسيلي 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 4914);

-- Product: باديا ادوبو مع فلفل 361غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4915

-- Product: باديا ادوبو بدون فلفل 361غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4916

-- Product: باديا اورغانو 14غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4917

-- Product: سوبريور واي 5كغم 156حصة شوكلاته بالحليب
-- WARNING: Category 'حليب نباتي' not found in database for product 4918
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4918);

-- Product: باديا ادوبو مع فلفل 106غ
-- WARNING: Category 'بديل ماجي' not found in database for product 4922

-- Product: ايمكو بروتين بار 40 غ جوز هند و لوز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4925);

-- Product: ايمكو بروتين بار 40 غ بيستاشيو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4926);

-- Product: باديا شاي اخضر 10مغلفات
-- WARNING: Category 'شاي' not found in database for product 4927
-- WARNING: Category 'بديل ماجي' not found in database for product 4927

-- Product: باديا شاي اوراق الزيزفون 10مغلفات
-- WARNING: Category 'شاي' not found in database for product 4928
-- WARNING: Category 'بديل ماجي' not found in database for product 4928

-- Product: باديا شاي بابونج 10مغلفات
-- WARNING: Category 'شاي' not found in database for product 4929
-- WARNING: Category 'بديل ماجي' not found in database for product 4929

-- Product: شاي باديا بابونج ويانسون 10مغلفات
-- WARNING: Category 'شاي' not found in database for product 4930
-- WARNING: Category 'بديل ماجي' not found in database for product 4930

-- Product: كاندريل شوكولاته بالحليب والكراميل المملح 30غ
-- WARNING: Category 'حليب نباتي' not found in database for product 4933

-- Product: ايمكو جرانولا بروتين شوكولاتة 500 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4936);

-- Product: باد اس انابوليك واي 908غ 27حصة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4943);

-- Product: اوليمب واي 700غ / 20 حصة - فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4946);

-- Product: اوليمب واي 700غ / 20 حصة - شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4947);

-- Product: اوليمب واي 700غ / 20 حصة - جوز هند
-- WARNING: Category 'حليب نباتي' not found in database for product 4948
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4948);

-- Product: ايمكو بروتين بار 40 غ شوكولاتة و لوز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4954);

-- Product: ايمكو بروتين بار 40 غ كراميل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4955);

-- Product: تي في ان بروتين بار 60 غ شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4958);

-- Product: بريمير بروتين شراب كوكيز 325 مل
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4967);

-- Product: ايفولف زيرو شيبس بروتين 40 غ خل البلسمك والزعتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4969);

-- Product: بيرفورم بروتين بار 62 غ كراميل مملح
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4973);

-- Product: بيرفورم بروتين بار 62 غ كوكي دو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4974);

-- Product: بيرفورم بروتين بار 62 غ فول سوداني
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4975);

-- Product: بيرفورم بروتين بار 62 غ شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4976);

-- Product: بيرفورم بروتين بار 62 غ كوكيز و كريمة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4977);

-- Product: بيرفورم بروتين بار 62 غ براوني
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4978);

-- Product: بيرفورم بروتين بار 62 غ كراميل و بسكويت
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4979);

-- Product: نيوتري ناتس بروتين كاب 42 غ دبل تشوكليت زبدة البندق
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4980);

-- Product: نيوتري ناتس بروتين كاب 42 غ دارك شوكليت زبدة الفول السوداني
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4991);

-- Product: نيوتري ناتس بروتين كاب 42 غ شوكولاتة بالحليب زبدة الفول السوداني
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 4992);

-- Product: هوراس واي 39غ 1حصة موز
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5001);

-- Product: يابلايد دايت واي 1.8كغم 72حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5006);

-- Product: يابلايد امينو فيول 390غ 30حصة ايس بلو
-- WARNING: Category 'امينو' not found in database for product 5010

-- Product: يابلايد امينو فيول 390غ 30حصة كاندي
-- WARNING: Category 'امينو' not found in database for product 5015

-- Product: يابلايد امينو فيول 390غ 30حصة فواكة استوائية
-- WARNING: Category 'امينو' not found in database for product 5016

-- Product: يابلايد امينو فيول 390غ 30حصة فواكة
-- WARNING: Category 'امينو' not found in database for product 5017

-- Product: يابلايد اوميغا3 100حبة
-- WARNING: Category 'اوميغا' not found in database for product 5019

-- Product: يابلايد ال كارنتين ومستخلص شاي اخضر 50 حصة 100حبة
-- WARNING: Category 'شاي' not found in database for product 5020

-- Product: ايه كب فانيلا و تمر سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5026);

-- Product: ايه كب دبل شوكولاته سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5027);

-- Product: ايه كب تشيز كيك سناك بروتين 66 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5028);

-- Product: ايه كب كوفي دريم سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5029);

-- Product: ايه كب كوكيز و كريم سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5030);

-- Product: ايه كب قنبلة بروتين تريو سناك بروتين 125 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5031);

-- Product: ايه كب قنبلة بروتين انفاجين سناك بروتين 125 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5032);

-- Product: ايه كب فانيلا ايس كريم سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5033);

-- Product: ايه كب عسل السنديان سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5034);

-- Product: ايه كب كنافة سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5035);

-- Product: ايه كب ريد بيريز سناك بروتين 80 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5036);

-- Product: ايه كب فانيلا مارفل سناك بروتين 66 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5037);

-- Product: ايه كب كريسبي شوكولاته سناك بروتين 66 غم
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5038);

-- Product: سيرياليتليا بروتين بار فول سوداني و شوكولاتة *3
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5046);

-- Product: سيرياليتليا بروتين بار فول سوداني و كراميل *3
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5047);

-- Product: ترابا الواح شوكلاتة بالحليب والكراميل المملح 90 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5051

-- Product: بومبوس اينيرجي ليمون و جوز هند 50 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5052

-- Product: ذا بيغيننغز جرانولا شوفان بالمانجا 200غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5055

-- Product: ذا بيغيننغز جرانولا شوفان بالكرانبيري 200غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5056

-- Product: ذا بيغيننغز جرانولا شوفان بالجوز 200غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5057

-- Product: ذا بيغيننغز كوكيز شوفان بالكراميل 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5058

-- Product: ذا بيغيننغز كوكيز شوفان بالفراولة 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5059

-- Product: ذا بيغيننغز كوكيز شوفان بالكاكاو 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5060

-- Product: ذا بيغيننغز كراكرز باللوز 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5064

-- Product: ذا بيغيننغز كوكيز اللوز والبرتقال 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5069

-- Product: ذا بيغيننغز كوكيز اللوز بحبوب القرع والشيا والكينوا 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5070

-- Product: ذا بيغيننغز كوكيز لوز بالكاكاو 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5071

-- Product: ذا بيغيننغز كوكيز اللوز والجوز 80غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5073

-- Product: ماجيستيك محلي سكرالوز 50ضرف 100غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5076);
-- WARNING: Category 'حليب نباتي' not found in database for product 5076
-- WARNING: Category 'بديل ماجي' not found in database for product 5076

-- Product: اورجانيكا محلي الالوز عضوي 250غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5079);
-- WARNING: Category 'حليب نباتي' not found in database for product 5079

-- Product: اورجانيكا محلي مونك فروت و الالوز عضوي 500غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5080);
-- WARNING: Category 'حليب نباتي' not found in database for product 5080

-- Product: بالانس شيبس بروتين شوت ذرة 70 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5082);

-- Product: سارتشيو بسكويت الشوفان 200غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5091

-- Product: سارتشيو نخالة الشوفان 250غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5097

-- Product: سارتشيو بسكويت مغطى بشكولاته الحليب 130غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5102

-- Product: فيتال ناتشر حليب الارز 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 5104

-- Product: فيتال ناتشر حليب اللوز خالي سكر 1لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5105);
-- WARNING: Category 'حليب نباتي' not found in database for product 5105

-- Product: فيتال ناتشر حليب الشوفان 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 5106

-- Product: فيتال ناتشر حليب الصويا 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 5107

-- Product: فيتال ناتشر حليب جوز الهند خالي سكر 1لتر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5108);
-- WARNING: Category 'حليب نباتي' not found in database for product 5108

-- Product: فيتال ناتشر حليب حليب الشوفان خالي جلوتين 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 5109

-- Product: فيتال ناتشر حليب الشوفان وجوز الهند 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 5110

-- Product: فيتال ناتشر حليب الارز والبندق 1لتر
-- WARNING: Category 'حليب نباتي' not found in database for product 5111

-- Product: بونيلي حلوى هلامية فواكه 120غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5112);

-- Product: بونيلي حلوى هلامية فراولة وتوت اسود وازرق 120غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5113);

-- Product: بونيلي حلوى هلامية ليمون وماندلينا خالي سكر 90غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5114);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5114);

-- Product: بونيلي حلوى هلامية ليمون وزنجبيل 120غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5115);

-- Product: بونيلي حلوى هلامية عرق سوس 120غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5116);

-- Product: بايوتيك واي 28غ حصة واحدة كوكيز و كريمة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5117);

-- Product: بالانس شيبس بروتين شوت جبنة 70 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5124);

-- Product: ريد ريكس واي 2040 غ 60 حصة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5130);

-- Product: ريد ريكس واي 2040 غ 60 حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5131);

-- Product: ريد ريكس واي 2040 غ 60 حصة شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5132);

-- Product: ريد ريكس كرياتين 300 غ 60 حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5133);

-- Product: بونيلي حلوى هلامية فراولة وتوت اسود خالي سكر 90غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5137);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5137);

-- Product: كاستيللو نوغا خالي سكر 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5140);

-- Product: كاستيللو نوجا خالي جلوتين 150 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5141);

-- Product: كاستيللو نوغا خالي سكر 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5142);

-- Product: اوت فارمر بروتين بار فول سوداني 120غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5149);

-- Product: ايفولف بروتين ترافل بيستاشيو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5150);

-- Product: ايفولف بروتين ترافل جوز الهند
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5151);

-- Product: ارمي امينو 300غ 23حصة مانجا و باشن فروت
-- WARNING: Category 'امينو' not found in database for product 5159

-- Product: سوبريور بروتين 908غ 28حصة شوكولاتة بالحليب
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5164);

-- Product: مسل لابس كرياتين 150غ 30حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5170);

-- Product: شار كيك الليمون 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5174);

-- Product: 1 جرانورو توبيتي خالي جلوتين 400غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5175);

-- Product: شار ماربل كيك 250 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5177);

-- Product: يابلايد كرياتين 500 غ 100 حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5178);

-- Product: اوشي مشروب فيتامين ليمون وبرتقال  555 مل
-- WARNING: Category 'فيتامينات' not found in database for product 5184

-- Product: اوشي مشروب فيتامين عنب احمر مع فاكهة التنين  555 مل
-- WARNING: Category 'فيتامينات' not found in database for product 5185

-- Product: فري لايف كاندي بروتين 32غ بطيخ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5186);

-- Product: كاستيللو نوغا خالي جلوتين 200 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5188);

-- Product: ناكيونال كورن فليكس خالي جلوتين 375 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5191);

-- Product: لازار انجلو كرياتين 300 غ 60حصة بدون نكهة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5192);

-- Product: مسل لابس كرياتين 150غ 30حصة برتقال
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5193);

-- Product: فري لايف كاندي بروتين 32غ اناناس
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5195);

-- Product: فري لايف كاندي بروتين 32غ فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5196);

-- Product: باديا ادوبو اوجانيك 361غ
-- WARNING: Category 'بديل ماجي' not found in database for product 5197

-- Product: لوح شوفان مربع بروتين بالتوت 35 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5199);

-- Product: بتر رقائق الشوفان العضوي 300غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5200

-- Product: ايفولف زيرو بروتين بار كوكيز 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5201);

-- Product: ايفولف زيرو بروتين بار اسبريسو 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5202);

-- Product: ايفولف زيرو بروتين بار قرفة 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5203);

-- Product: ايفولف زيرو بروتين بار كراميل مملح 50غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5204);

-- Product: كاميليشيس حليب الابل 210 مل
-- WARNING: Category 'حليب نباتي' not found in database for product 5212

-- Product: فيت فيوجين واي 2.22 ك 60 حصة كابتشينو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5214);

-- Product: فيت فيوجين واي 2.22 ك 60 حصة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5215);

-- Product: فيت فيوجين واي 2.22 ك 60 حصة شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5216);

-- Product: فيت فيوجين واي 2.22 ك 60 حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5217);

-- Product: فيت فيوجين كرياتين 300 غ 30 حصة فواكة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5218);

-- Product: فيت فيوجين واي 1 حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5227);

-- Product: فيت فيوجين واي 1 حصة فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5231);

-- Product: فيت فيوجين واي 1 حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5232);

-- Product: فيت فيوجين واي 1 حصة شوكولاتة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5233);

-- Product: فيت فيوجين واي 1 حصة كابتشينو
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5234);

-- Product: يابلايد كرياتين هايدريشن 330 غ 30 حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5239);

-- Product: يابلايد كرياتين هايدريشن 360 غ 30 حصة توت ازرق
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5245);

-- Product: يابلايد كرياتين هايدريشن 330 غ 30 حصة توت
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5246);

-- Product: جولون دايجستف خالي جلوتين 150غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5250);

-- Product: كوكو لايف حليب جوز الهند 400 مل 50%
-- WARNING: Category 'حليب نباتي' not found in database for product 5255

-- Product: كوكو لايف حليب جوز الهند 400 مل 25%
-- WARNING: Category 'حليب نباتي' not found in database for product 5256

-- Product: سمايل مصاص خالي سكر 5.6 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5265);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5265);

-- Product: لاكانتو محلي مونك فروت 235 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5268);

-- Product: لاكانتو مونك فروت مع الالوز 454 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5269

-- Product: لاكانتو مونك فروت مع الالوز 227 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5270

-- Product: كاستيللو نوغا لوز 60 غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5275);
-- WARNING: Category 'حليب نباتي' not found in database for product 5275

-- Product: كاستيللو نوغا لوز 60 غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5277

-- Product: داكولونيا حلوى الفول السوداني مع سكر بني 180 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5291);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5291);

-- Product: داكولونيا حلوى الفول السوداني بدون سكر 18 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5292);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5292);

-- Product: داكولونيا حلوى الفول السوداني مع السكر البني 18 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5293);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5293);

-- Product: داكولونيا حلوى الموز بدون سكر 25 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5294);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5294);

-- Product: داكولونيا حلوى الفول السوداني مع الشوكولاتة 30 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5295);

-- Product: داكولونيا حلوى الموز 22 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5296);

-- Product: داكولونيا حلوى الفول السوداني مع الحليب المكثف 25 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5297);
-- WARNING: Category 'حليب نباتي' not found in database for product 5297

-- Product: داكولونيا حلوى الجوافة 25 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (141, 5298);

-- Product: بايسكس واي بروتين 2.25 كغم نكهة فانيلا
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5302);

-- Product: بايسكس واي بروتين 2.25 كغم نكهة كراميل مملح 70حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5303);

-- Product: بايسكس واي بروتين 2.25 كغم نكهة شكولاتة 66 حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5304);

-- Product: بايسكس كرياتين 300 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5305);

-- Product: بايسكس واي بروتين 2.25 كغم نكهة فراولة 70 حصة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5307);

-- Product: كاستيللو نوغا 150 غ لوز و عسل
-- WARNING: Category 'حليب نباتي' not found in database for product 5309

-- Product: رايدر بروتين بار فول سوداني و كراميل مملح 50 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5315);

-- Product: لايت اند سويت سابليه 400 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5317);
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (86, 5317);

-- Product: تشوبا تشوبس علكة خالي سكر 64 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5323);

-- Product: سمينت ملبس خالي سكر 35 غ نعناع
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5324);

-- Product: سمينت ملبس خالي سكر 35 غ نعناع حار
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5325);

-- Product: سمينت ملبس خالي سكر 35 غ فراولة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5326);

-- Product: سمينت ملبس خالي سكر 35 غ ببل فريش
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5327);

-- Product: بالانس شيبس بروتين شوت حار 70 غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (159, 5335);

-- Product: ترابا نوغا شوكولاتة بالحليب المقرمش 110غ بدون سكر
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (85, 5341);
-- WARNING: Category 'حليب نباتي' not found in database for product 5341

-- Product: ترابا نوغا شوكولاتة بالحليب المقرمش 140غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5342

-- Product: ترابا نوغا شوكولاتة بالحليب و البندق 175غ
-- WARNING: Category 'حليب نباتي' not found in database for product 5343

-- Product: شار كراكرز روزماري 210غ
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (84, 5345);

-- Product: ابلايد كرياتين كبسولات 120 حبة
INSERT IGNORE INTO category_product (category_id, product_id) VALUES (163, 5351);

COMMIT;

-- End of corrections