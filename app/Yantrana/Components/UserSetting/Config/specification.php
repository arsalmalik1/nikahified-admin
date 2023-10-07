<?php

return [
    'groups' => [
        'looks' => [
            'title' => __tr('Looks'),
            'icon' => '<i class="far fa-smile text-primary"></i>',
            'items' => [
                'height' => [
                    'name' => __tr('Height'),
                    'input_type' => 'select',
                    'options' => [
                        '139' => '139 cm',
                        '140' => "140 cm (4' 7″)",
                        '141' => '141 cm',
                        '142' => "142 cm (4' 8″)",
                        '143' => '143 cm',
                        '144' => '144 cm',
                        '145' => "145 cm (4' 9″)",
                        '146' => '146 cm',
                        '147' => "147 cm (4' 10″)",
                        '148' => '148 cm',
                        '149' => '149 cm',
                        '150' => "150 cm (4' 11″)",
                        '151' => '151 cm',
                        '152' => "152 cm (5' 0″)",
                        '153' => '153 cm',
                        '154' => '154 cm',
                        '155' => "155 cm (5' 1″)",
                        '156' => '156 cm',
                        '157' => "157 cm (5' 2″)",
                        '158' => '158 cm',
                        '159' => '159 cm',
                        '160' => "160 cm (5' 3″)",
                        '161' => '161 cm',
                        '162' => '162 cm',
                        '163' => "163 cm (5' 4″)",
                        '164' => '164 cm',
                        '165' => "165 cm (5' 5″)",
                        '166' => '166 cm',
                        '167' => '167 cm',
                        '168' => "168 cm (5' 6″)",
                        '169' => '169 cm',
                        '170' => "170 cm (5' 7″)",
                        '171' => '171 cm',
                        '172' => '172 cm',
                        '173' => "173 cm (5' 8″)",
                        '174' => '174 cm',
                        '175' => "175 cm (5' 9″)",
                        '176' => '176 cm',
                        '177' => '177 cm',
                        '178' => "178 cm (5' 10″)",
                        '179' => '179 cm',
                        '180' => "180 cm (5' 11″)",
                        '181' => '181 cm',
                        '182' => '182 cm',
                        '183' => "183 cm (6' 0″)",
                        '184' => '184 cm',
                        '185' => "185 cm (6' 1″)",
                        '186' => '186 cm',
                        '187' => '187 cm',
                        '188' => "188 cm (6' 2″)",
                        '189' => '189 cm',
                        '190' => '190 cm',
                        '191' => "191 cm (6' 3″)",
                        '192' => '192 cm',
                        '193' => "193 cm (6' 4″)",
                        '194' => '194 cm',
                        '195' => '195 cm',
                        '196' => "196 cm (6' 5″)",
                        '197' => '197 cm',
                        '198' => "198 cm (6' 6″)",
                        '199' => '199 cm',
                        '200' => '200 cm',
                        '201' => "201 cm (6' 7″)",
                        '202' => '202 cm',
                        '203' => "203 cm (6' 8″)",
                        '204' => '204 cm',
                        '205' => '205 cm',
                        '206' => "206 cm (6' 9″)",
                        '207' => '207 cm',
                        '208' => "208 cm (6' 10″)",
                        '209' => '209 cm',
                        '210' => '210 cm',
                        '211' => "211 cm (6' 11″)",
                        '212' => '212 cm',
                        '213' => "213 cm (7' 0″)",
                        '214' => '214 cm',
                        '215' => '215 cm',
                        '216' => "216 cm (7' 1″)",
                        '217' => '217 cm',
                        '218' => '218 cm',
                        '220' => "220 cm (7' 3″)",
                    ],
                ],
                'ethnicity' => [
                    'name' => __tr('Ethnicity'),
                    'input_type' => 'select',
                    'options' => [
                        'white' => __tr('White'),
                        'black' => __tr('Black'),
                        'middle_eastern' => __tr('Middle Eastern'),
                        'north_african' => __tr('North African'),
                        'latin_american' => __tr('Latin American'),
                        'mixed' => __tr('Mixed'),
                        'asian' => __tr('Asian'),
                        'other' => __tr('Other'),
                    ],
                ],
                'body_type' => [
                    'name' => __tr('Body Type'),
                    'input_type' => 'select',
                    'options' => [
                        'slim' => __tr('Slim'),
                        'sporty' => __tr('Sporty'),
                        'curvy' => __tr('Curvy'),
                        'round' => __tr('Round'),
                        'supermodel' => __tr('Supermodel'),
                        'average' => __tr('Average'),
                        'other' => __tr('Other'),
                    ],
                ],
                'hair_color' => [
                    'name' => __tr('Hair Color'),
                    'input_type' => 'select',
                    'options' => [
                        'brown' => __tr('Brown'),
                        'black' => __tr('Black'),
                        'white' => __tr('White'),
                        'sandy' => __tr('Sandy'),
                        'gray_or_partially_gray' => __tr('Gray or Partially Gray'),
                        'red/auburn' => __tr('Red/Auburn'),
                        'blond/strawberry' => __tr('Blond/Strawberry'),
                        'blue' => __tr('Blue'),
                        'green' => __tr('Green'),
                        'orange' => __tr('Orange'),
                        'pink' => __tr('Pink'),
                        'purple' => __tr('Purple'),
                        'partly_or_completely_bald' => __tr('Partly or Completely Bald'),
                        'other' => __tr('Other'),
                    ],
                ],
                'islamic_dressing_type' => [
                    'name' => __tr('Islamic Dressing Type'),
                    'input_type' => 'select',
                    'options' => [
                        'hijab' => __tr('Hijab'),
                        'abaya' => __tr('Abaya'),
                        'niqab' => __tr('Niqab'),
                        'thobe_jalabiya:' => __tr('Thobe/Jalabiya:'),
                        'turban_imamah' => __tr('Turban/Imamah'),
                    ],
                ],
            ],
        ],
        'personality' => [
            'title' => __tr('Personality'),
            'icon' => '<i class="fas fa-child text-success"></i>',
            'items' => [
                'nature' => [
                    'name' => __tr('Nature'),
                    'input_type' => 'select',
                    'options' => [
                        'accommodating' => __tr('Accommodating'),
                        'adventurous' => __tr('Adventurous'),
                        'calm' => __tr('Calm'),
                        'careless' => __tr('Careless'),
                        'cheerful' => __tr('Cheerful'),
                        'demanding' => __tr('Demanding'),
                        'extroverted' => __tr('Extroverted'),
                        'honest' => __tr('Honest'),
                        'generous' => __tr('Generous'),
                        'humorous' => __tr('Humorous'),
                        'introverted' => __tr('Introverted'),
                        'liberal' => __tr('Liberal'),
                        'lively' => __tr('Lively'),
                        'loner' => __tr('Loner'),
                        'nervous' => __tr('Nervous'),
                        'possessive' => __tr('Possessive'),
                        'quiet' => __tr('Quiet'),
                        'reserved' => __tr('Reserved'),
                        'sensitive' => __tr('Sensitive'),
                        'shy' => __tr('Shy'),
                        'social' => __tr('Social'),
                        'spontaneous' => __tr('Spontaneous'),
                        'stubborn' => __tr('Stubborn'),
                        'suspicious' => __tr('Suspicious'),
                        'thoughtful' => __tr('Thoughtful'),
                        'proud' => __tr('Proud'),
                        'considerate' => __tr('Considerate'),
                        'friendly' => __tr('Friendly'),
                        'polite' => __tr('Polite'),
                        'reliable' => __tr('Reliable'),
                        'careful' => __tr('Careful'),
                        'helpful' => __tr('Helpful'),
                        'patient' => __tr('Patient'),
                        'optimistic' => __tr('Optimistic'),
                    ],
                ],
                'friends' => [
                    'name' => __tr('Friends'),
                    'input_type' => 'select',
                    'options' => [
                        'no_friends' => __tr('No friends'),
                        'some_friends' => __tr('Some friends'),
                        'many_friends' => __tr('Many friends'),
                        'only_good_friends' => __tr('Only good friends'),
                    ],
                ],
                'children' => [
                    'name' => __tr('Children'),
                    'input_type' => 'select',
                    'options' => [
                        'no_never' => __tr('No, never'),
                        'someday_maybe' => __tr('Someday, maybe'),
                        'expecting' => __tr('Expecting'),
                        'i_already_have_kids' => __tr('already have kids'),
                        "i_have_kids_and_don't_want_more" => __tr('have kids and don’t want more'),
                    ],
                ],
                'pets' => [
                    'name' => __tr('Pets'),
                    'input_type' => 'select',
                    'options' => [
                        'none' => __tr('None'),
                        'have_pets' => __tr('Have pets'),
                    ],
                ],                
                'praying' => [
                    'name' => __tr('Praying'),
                    'input_type' => 'select',
                    'options' => [
                        'Not Applicable' => __tr('Not Applicable'),
                        'regularly' => __tr('Regularly'),
                        'occasionally' => __tr('Occasionally'),
                        'weekly' => __tr('Weekly'),
                        'monthly' => __tr('Monthly'),
                        'rarely' => __tr('Rarely'),
                    ],
                ],
                'hobbies_interests' => [
                    'name' => __tr('Hobbies/Interests'),
                    'input_type' => 'select',
                    'options' => [
                        'reading' => __tr('Reading'),
                        'sports' => __tr('Sports'),
                        'cooking' => __tr('Cooking'),
                        'traveling' => __tr('Traveling'),
                        'photography' => __tr('Photography'),
                        'painting_drawing' => __tr('Painting/Drawing'),
                        'music' => __tr('Music (Playing or Listening)'),
                        'gardening' => __tr('Gardening'),
                        'dancing' => __tr('Dancing'),
                        'writing' => __tr('Writing'),
                        'gaming' => __tr('Gaming'),
                        'fitness_exercise' => __tr('Fitness/Exercise'),
                        'volunteer_work' => __tr('Volunteer Work'),
                        'collecting' => __tr('Collecting (e.g., stamps, coins, memorabilia)'),
                        'crafting' => __tr('Crafting (e.g., knitting, woodworking, pottery)'),
                    ],
                ],
            ],
        ],
        'lifestyle' => [
            'title' => __tr('Lifestyle'),
            'icon' => '<i class="fas fa-umbrella-beach text-warning"></i>',
            'items' => [
                'religion' => [
                    'name' => __tr('Religion'),
                    'input_type' => 'select',
                    'options' => [
                        'muslim' => __tr('Muslim'),
                        'atheist' => __tr('Atheist'),
                        'buddhist' => __tr('Buddhist'),
                        'catholic' => __tr('Catholic'),
                        'christian' => __tr('Christian'),
                        'hindu' => __tr('Hindu'),
                        'jewish' => __tr('Jewish'),
                        'agnostic' => __tr('Agnostic'),
                        'sikh' => __tr('Sikh'),
                        'other' => __tr('Other'),
                    ],
                ],
                'i_live_with' => [
                    'name' => __tr('I live with'),
                    'input_type' => 'select',
                    'options' => [
                        'alone' => __tr('Alone'),
                        'parents' => __tr('Parents'),
                        'friends' => __tr('Friends'),
                        'partner' => __tr('Partner'),
                        'children' => __tr('Children'),
                        'other' => __tr('Other'),
                    ],
                ],
                'car' => [
                    'name' => __tr('Car'),
                    'input_type' => 'select',
                    'options' => [
                        'none' => __tr('None'),
                        'my_own_car' => __tr('My Own Car'),
                    ],
                ],
                'travel' => [
                    'name' => __tr('Travel'),
                    'input_type' => 'select',
                    'options' => [
                        'yes_all_the_time' => __tr('Yes, all the time'),
                        'yes_sometimes' => __tr('Yes, sometimes'),
                        'not_very_much' => __tr('Not very much'),
                        'no' => __tr('No'),
                    ],
                ],
                'smoke' => [
                    'name' => __tr('Smoke'),
                    'input_type' => 'select',
                    'options' => [
                        'never' => __tr('Never'),
                        'i_some_sometimes' => __tr('I Smoke Sometimes'),
                        'chain_smoker' => __tr('Chain Smoker'),
                    ],
                ],
                'drink' => [
                    'name' => __tr('Drink'),
                    'input_type' => 'select',
                    'options' => [
                        'never' => __tr('Never'),
                        'i_drink_sometimes' => __tr('I Drink Sometimes'),
                    ],
                ],
                'praying' => [
                    'name' => __tr('Praying'),
                    'input_type' => 'select',
                    'options' => [
                        'Not Applicable' => __tr('Not Applicable'),
                        'regularly' => __tr('Regularly'),
                        'occasionally' => __tr('Occasionally'),
                        'weekly' => __tr('Weekly'),
                        'monthly' => __tr('Monthly'),
                        'rarely' => __tr('Rarely'),
                    ],
                ],
                'relocation_plan' => [
                    'name' => __tr('Relocation Plan'),
                    'input_type' => 'select',
                    'options' => [
                        'yes_moving_soon' => __tr('Yes, Moving Soon'),
                        'considering_no_decision' => __tr('Considering, No Firm Decision Yet'),
                        'not_planning' => __tr('No, Not Planning to Relocate'),
                        'uncertain' => __tr('Uncertain'),
                        'relocated_recently' => __tr('Relocated Recently'),
                    ],
                ],
                'profession' => [
                    'name' => __tr('Profession'),
                    'input_type' => 'select',
                    'options' => [
                        'teacher_educator' => __tr('Teacher/Educator'),
                        'engineer' => __tr('Engineer'),
                        'healthcare_professional' => __tr('Healthcare Professional (Doctor, Nurse, etc.)'),
                        'it_software_professional' => __tr('IT/Software Professional'),
                        'business_owner_entrepreneur' => __tr('Business Owner/Entrepreneur'),
                        'accountant_financial_analyst' => __tr('Accountant/Financial Analyst'),
                        'artist_designer' => __tr('Artist/Designer'),
                        'sales_marketing_professional' => __tr('Sales/Marketing Professional'),
                        'administrative_office_worker' => __tr('Administrative/Office Worker'),
                        'student' => __tr('Student'),
                        'homemaker' => __tr('Homemaker'),
                        'retail_worker' => __tr('Retail Worker'),
                        'construction_tradesperson' => __tr('Construction/Tradesperson'),
                        'scientist_researcher' => __tr('Scientist/Researcher'),
                        'legal_professional' => __tr('Legal Professional (Lawyer, Paralegal, etc.)'),
                    ],
                ],
                'country' => [
                    'name' => __tr('Country'),
                    'input_type' => 'select',
                    'options' => [
                        'Afghanistan' => __tr('Afghanistan'), 'Albania' => __tr('Albania'), 'Algeria' => __tr('Algeria'), 'American Samoa' => __tr('American Samoa'), 'Andorra' => __tr('Andorra'), 'Angola' => __tr('Angola'), 'Antigua and Barbuda' => __tr('Antigua And Barbuda'), 'Argentina' => __tr('Argentina'), 'Armenia' => __tr('Armenia'), 'Australia' => __tr('Australia'), 'Austria' => __tr('Austria'), 'Azerbaijan' => __tr('Azerbaijan'), 'Bahamas' => __tr('Bahamas'), 'Bahrain' => __tr('Bahrain'), 'Bangladesh' => __tr('Bangladesh'), 'Barbados' => __tr('Barbados'), 'Belarus' => __tr('Belarus'), 'Belgium' => __tr('Belgium'), 'Belize' => __tr('Belize'), 'Benin' => __tr('Benin'), 'Bermuda' => __tr('Bermuda'), 'Bhutan' => __tr('Bhutan'), 'Bolivia' => __tr('Bolivia'), 'Bosnia and Herzegovina' => __tr('Bosnia And Herzegovina'), 'Botswana' => __tr('Botswana'), 'Brazil' => __tr('Brazil'), 'Brunei' => __tr('Brunei'), 'Bulgaria' => __tr('Bulgaria'), 'Burkina Faso' => __tr('Burkina Faso'), 'Burundi' => __tr('Burundi'), 'Cambodia' => __tr('Cambodia'), 'Cameroon' => __tr('Cameroon'), 'Canada' => __tr('Canada'), 'Cape Verde' => __tr('Cape Verde'), 'Cayman Islands' => __tr('Cayman Islands'), 'Central African Republic' => __tr('Central African Republic'), 'Chad' => __tr('Chad'), 'Chile' => __tr('Chile'), 'China' => __tr('China'), 'Colombia' => __tr('Colombia'), 'Comoros' => __tr('Comoros'), 'Congo' => __tr('Congo'), 'Democratic Republic of the' => __tr('Democratic Republic Of The'), 'Congo' => __tr('Congo'), 'Republic of the' => __tr('Republic Of The'), 'Costa Rica' => __tr('Costa Rica'), 'Côte d Ivoire' => __tr('Côte D Ivoire'), 'Croatia' => __tr('Croatia'), 'Cuba' => __tr('Cuba'), 'Curaçao' => __tr('Curaçao'), 'Cyprus' => __tr('Cyprus'), 'Czech Republic' => __tr('Czech Republic'), 'Denmark' => __tr('Denmark'), 'Djibouti' => __tr('Djibouti'), 'Dominica' => __tr('Dominica'), 'Dominican Republic' => __tr('Dominican Republic'), 'East Timor' => __tr('East Timor'), 'Ecuador' => __tr('Ecuador'), 'Egypt' => __tr('Egypt'), 'El Salvador' => __tr('El Salvador'), 'Equatorial Guinea' => __tr('Equatorial Guinea'), 'Eritrea' => __tr('Eritrea'), 'Estonia' => __tr('Estonia'), 'Ethiopia' => __tr('Ethiopia'), 'Faroe Islands' => __tr('Faroe Islands'), 'Fiji' => __tr('Fiji'), 'Finland' => __tr('Finland'), 'France' => __tr('France'), 'French Polynesia' => __tr('French Polynesia'), 'Gabon' => __tr('Gabon'), 'Gambia' => __tr('Gambia'), 'Georgia' => __tr('Georgia'), 'Germany' => __tr('Germany'), 'Ghana' => __tr('Ghana'), 'Greece' => __tr('Greece'), 'Greenland' => __tr('Greenland'), 'Grenada' => __tr('Grenada'), 'Guam' => __tr('Guam'), 'Guatemala' => __tr('Guatemala'), 'Guinea' => __tr('Guinea'), 'Guinea-Bissau' => __tr('Guinea-Bissau'), 'Guyana' => __tr('Guyana'), 'Haiti' => __tr('Haiti'), 'Honduras' => __tr('Honduras'), 'Hong Kong' => __tr('Hong Kong'), 'Hungary' => __tr('Hungary'), 'Iceland' => __tr('Iceland'), 'India' => __tr('India'), 'Indonesia' => __tr('Indonesia'), 'Iran' => __tr('Iran'), 'Iraq' => __tr('Iraq'), 'Ireland' => __tr('Ireland'), 'Israel' => __tr('Israel'), 'Italy' => __tr('Italy'), 'Jamaica' => __tr('Jamaica'), 'Japan' => __tr('Japan'), 'Jordan' => __tr('Jordan'), 'Kazakhstan' => __tr('Kazakhstan'), 'Kenya' => __tr('Kenya'), 'Kiribati' => __tr('Kiribati'), 'North Korea' => __tr('North Korea'), 'South Korea' => __tr('South Korea'), 'Kosovo' => __tr('Kosovo'), 'Kuwait' => __tr('Kuwait'), 'Kyrgyzstan' => __tr('Kyrgyzstan'), 'Laos' => __tr('Laos'), 'Latvia' => __tr('Latvia'), 'Lebanon' => __tr('Lebanon'), 'Lesotho' => __tr('Lesotho'), 'Liberia' => __tr('Liberia'), 'Libya' => __tr('Libya'), 'Liechtenstein' => __tr('Liechtenstein'), 'Lithuania' => __tr('Lithuania'), 'Luxembourg' => __tr('Luxembourg'), 'Macedonia' => __tr('Macedonia'), 'Madagascar' => __tr('Madagascar'), 'Malawi' => __tr('Malawi'), 'Malaysia' => __tr('Malaysia'), 'Maldives' => __tr('Maldives'), 'Mali' => __tr('Mali'), 'Malta' => __tr('Malta'), 'Marshall Islands' => __tr('Marshall Islands'), 'Mauritania' => __tr('Mauritania'), 'Mauritius' => __tr('Mauritius'), 'Mexico' => __tr('Mexico'), 'Micronesia' => __tr('Micronesia'), 'Moldova' => __tr('Moldova'), 'Monaco' => __tr('Monaco'), 'Mongolia' => __tr('Mongolia'), 'Montenegro' => __tr('Montenegro'), 'Morocco' => __tr('Morocco'), 'Mozambique' => __tr('Mozambique'), 'Myanmar' => __tr('Myanmar'), 'Namibia' => __tr('Namibia'), 'Nauru' => __tr('Nauru'), 'Nepal' => __tr('Nepal'), 'Netherlands' => __tr('Netherlands'), 'New Zealand' => __tr('New Zealand'), 'Nicaragua' => __tr('Nicaragua'), 'Niger' => __tr('Niger'), 'Nigeria' => __tr('Nigeria'), 'Northern Mariana Islands' => __tr('Northern Mariana Islands'), 'Norway' => __tr('Norway'), 'Oman' => __tr('Oman'), 'Pakistan' => __tr('Pakistan'), 'Palau' => __tr('Palau'), 'Palestine' => __tr('Palestine'), 'State of' => __tr('State Of'), 'Panama' => __tr('Panama'), 'Papua New Guinea' => __tr('Papua New Guinea'), 'Paraguay' => __tr('Paraguay'), 'Peru' => __tr('Peru'), 'Philippines' => __tr('Philippines'), 'Poland' => __tr('Poland'), 'Portugal' => __tr('Portugal'), 'Puerto Rico' => __tr('Puerto Rico'), 'Qatar' => __tr('Qatar'), 'Romania' => __tr('Romania'), 'Russia' => __tr('Russia'), 'Rwanda' => __tr('Rwanda'), 'Saint Kitts and Nevis' => __tr('Saint Kitts And Nevis'), 'Saint Lucia' => __tr('Saint Lucia'), 'Saint Vincent and the Grenadines' => __tr('Saint Vincent And The Grenadines'), 'Samoa' => __tr('Samoa'), 'San Marino' => __tr('San Marino'), 'Sao Tome and Principe' => __tr('Sao Tome And Principe'), 'Saudi Arabia' => __tr('Saudi Arabia'), 'Senegal' => __tr('Senegal'), 'Serbia' => __tr('Serbia'), 'Seychelles' => __tr('Seychelles'), 'Sierra Leone' => __tr('Sierra Leone'), 'Singapore' => __tr('Singapore'), 'Sint Maarten' => __tr('Sint Maarten'), 'Slovakia' => __tr('Slovakia'), 'Slovenia' => __tr('Slovenia'), 'Solomon Islands' => __tr('Solomon Islands'), 'Somalia' => __tr('Somalia'), 'South Africa' => __tr('South Africa'), 'Spain' => __tr('Spain'), 'Sri Lanka' => __tr('Sri Lanka'), 'Sudan' => __tr('Sudan'), 'Sudan' => __tr('Sudan'), 'South' => __tr('South'), 'Suriname' => __tr('Suriname'), 'Swaziland' => __tr('Swaziland'), 'Sweden' => __tr('Sweden'), 'Switzerland' => __tr('Switzerland'), 'Syria' => __tr('Syria'), 'Taiwan' => __tr('Taiwan'), 'Tajikistan' => __tr('Tajikistan'), 'Tanzania' => __tr('Tanzania'), 'Thailand' => __tr('Thailand'), 'Togo' => __tr('Togo'), 'Tonga' => __tr('Tonga'), 'Trinidad and Tobago' => __tr('Trinidad And Tobago'), 'Tunisia' => __tr('Tunisia'), 'Turkey' => __tr('Turkey'), 'Turkmenistan' => __tr('Turkmenistan'), 'Tuvalu' => __tr('Tuvalu'), 'Uganda' => __tr('Uganda'), 'Ukraine' => __tr('Ukraine'), 'United Arab Emirates' => __tr('United Arab Emirates'), 'United Kingdom' => __tr('United Kingdom'), 'United States' => __tr('United States'), 'Uruguay' => __tr('Uruguay'), 'Uzbekistan' => __tr('Uzbekistan'), 'Vanuatu' => __tr('Vanuatu'), 'Vatican City' => __tr('Vatican City'), 'Venezuela' => __tr('Venezuela'), 'Vietnam' => __tr('Vietnam'), 'Virgin Islands' => __tr('Virgin Islands'), 'British' => __tr('British'), 'Virgin Islands' => __tr('Virgin Islands'), 'U.S.' => __tr('U.S.'), 'Yemen' => __tr('Yemen'), 'Zambia' => __tr('Zambia'), 'Zimbabwe' => __tr('Zimbabwe'),
                    ],
                ],
                                
            ],
        ],
        'favorites' => [
            'title' => __tr('Favorites'),
            'icon' => '<i class="far fa-heart text-danger"></i>',
            'items' => [
                'music_genre' => [
                    'name' => __tr('Music Genre'),
                    'input_type' => 'textbox',
                ],
                'singer' => [
                    'name' => __tr('Singer'),
                    'input_type' => 'textbox',
                ],
                'song' => [
                    'name' => __tr('Song'),
                    'input_type' => 'textbox',
                ],
                'hobby' => [
                    'name' => __tr('Hobby'),
                    'input_type' => 'textbox',
                ],
                'sport' => [
                    'name' => __tr('Sport'),
                    'input_type' => 'textbox',
                ],
                'book' => [
                    'name' => __tr('Book'),
                    'input_type' => 'textbox',
                ],
                'dish' => [
                    'name' => __tr('Dish'),
                    'input_type' => 'textbox',
                ],
                'color' => [
                    'name' => __tr('Color'),
                    'input_type' => 'textbox',
                ],
                'movie' => [
                    'name' => __tr('Movie'),
                    'input_type' => 'textbox',
                ],
                'show' => [
                    'name' => __tr('Show'),
                    'input_type' => 'textbox',
                ],
                'inspired_from' => [
                    'name' => __tr('Inspired From'),
                    'input_type' => 'textbox',
                ],
            ],
        ],
    ],
];
