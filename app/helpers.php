<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

if (!function_exists('getDataForSelect2')) {
    function getDataForSelect2($request, $model, $column): JsonResponse
    {
        $query = $model::orderby($column)->select('id', $column)->limit(5);

        $search = $request->search;
        if ($search != '') {
            $query->where(function($query) use ($search, $column) {
                $query->whereNotNull($column)->where($column, 'LIKE', $search . '%');
            });
        }
        $models = $query->get();

        $response = array();
        foreach ($models as $model) {
            $response[] = array(
                "id" => $model->id,
                "text" => $model->$column
            );
        }
        return response()->json($response);
    }
}

if (!function_exists('menuOpen')) {
  function menuOpen($children)
  {
      foreach ($children as $child) {
          if(Route::currentRouteNamed($child['route'])) return 'menu-open';
          //if(Str::contains($child['route'], explode('.', Route::currentRouteName())[0])) return 'menu-open';
      }
  }
}

if (!function_exists('currentChildActive')) {
    function currentChildActive($children)
    {
        foreach ($children as $child) {
            if(Route::currentRouteNamed($child['route'])) return 'active';
            //if(Str::contains($child['route'], explode('.', Route::currentRouteName())[0])) return 'active';
        }
    }
}

if (!function_exists('currentRouteActive')) {
    function currentRouteActive(...$routes)
    {
        foreach ($routes as $route) {
            if(Route::currentRouteNamed($route)) return 'active';
            //if(Str::contains($route, explode('.', Route::currentRouteName())[0])) return 'active';
        }
    }
}

if (!function_exists('currentRoute')) {
    function currentRoute($route): string
    {
        return Route::currentRouteNamed($route) ? ' class=current' : '';
        //return Str::contains($route, explode('.', Route::currentRouteName())[0]) ? ' class=current' : '';
    }
}

if (!function_exists('getUrlSegment')) {
    function getUrlSegment($url, $segment)
    {
        $url_path = parse_url(request()->url(), PHP_URL_PATH);
        $url_segments = explode('/', $url_path);
        return $url_segments[$segment];
    }
}

if (!function_exists('isRole')) {
    function isRole($role): bool
    {
        return auth()->user()->role === $role;
    }
}

if (!function_exists('getProfilePhotoUrlAttribute')) {
    function getProfilePhotoUrlAttribute($profilePhotoPath): string
    {
        //return Storage::disk('public')->exists($profilePhotoPath) ? Storage::disk('public')->url($profilePhotoPath) : asset('img/avatar.png');
        return $profilePhotoPath == null || $profilePhotoPath == '' ? asset('img/avatar.png') : asset('storage/'.$profilePhotoPath);
    }
}

if (!function_exists('getImage')) {
    function getPhotoUrlAttribute($imagePath = null): string
    {
        //if (is_null($imagePath)) return asset('img/default.jpg');
        //return Storage::disk('public')->exists($imagePath) ? Storage::disk('public')->url($imagePath) : asset('img/default.jpg');
        return $imagePath == null || $imagePath == '' ? asset('img/default.png') : asset('storage/'.$imagePath);
    }
}

if (!function_exists('getImage2')) {
    function getImage2($post, $thumb = false): string
    {
        $url = "storage/photos/{$post->user->id}";
        if($thumb) $url .= '/thumbs';
        return asset("{$url}/{$post->image}");
    }
}

if (!function_exists('getDateFormat')) {
    function getDateFormat(): string
    {
        return App::isLocale('en') ? "m/d/Y" : "d/m/Y";
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'd/m/Y'): ?string
    {
        if (is_null($date)) return null;
        if (is_string($date)) $date = Date::create($date);
        return $date->format($format);
    }
}

if (!function_exists('hourFormat')) {
    function hourFormat($date): ?string
    {
        if (is_null($date)) return null;
        if (is_string($date)) $date = Date::create($date);
        return $date->format('H:i');
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($amount): string
    {
        return App::isLocale('en') ? number_format($amount) : number_format($amount, 2, ',', ' ');
    }
}

if (!function_exists('moneyFormat')) {
    function moneyFormat($amount, $decimal = 0, $devise = 'GNF'): string
    {
        return App::isLocale('en') ? number_format($amount) : number_format($amount, $decimal, ',', ' ').' '.$devise;
    }
}

if (!function_exists('pluck')) {
    function pluck($collections, $columns, $separator = ' - '): array
    {
        $collections->map(function ($row) use ($columns,$separator) {
            if (is_string($columns)) {
                $row->name = $row->$columns;
            } else {
                $values = [];
                foreach ($columns as $column) {
                    array_push($values, $row->$column);
                }
                $row->name = implode($separator, $values);
            }
        });
        return $collections->pluck('name','id')->toArray();
    }
}

if (!function_exists('fullName')) {
    function fullName($collections, $key = null)
    {
        if (is_null($key))
            $results = $collections->each(function ($item) {
                $item->name = $item->name();
            })->pluck('name', 'id');
        else
            $results = $collections->each(function ($item) {
                $item->name = $item->name();
            })->pluck('name', $key);
        return $results->toArray();
    }
}

if (!function_exists('generateCode')) {
    function generateCode(string $type, int $id, $length = 6): string
    {
        return $type.date('y').str_pad($id, $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('vatAmount')) {
    function vatAmount(float $amount, float $vat = 18.00): float
    {
        // Montant TVA = (Prix HT * Taux de TVA)/100
        return ($amount * $vat) / 100;
    }
}

if (!function_exists('amountIncludeTax')) {
    function amountIncludeTax(float $amount, float $vat = 18.00): float
    {
        // Pix TTC = Prix HT + (Prix HT * Taux de TVA) 100
        return $amount + vatAmount($amount, $vat);
    }
}

if (!function_exists('amountExcludeTax')) {
    function amountExcludeTax(float $amount, float $vat = 18.00): float
    {
        // Prix HT = Prix TTC / (1 + Taux de TVA)
        return $amount / (1 * $vat);
    }
}

if (!function_exists('paymentMethods')) {
    function paymentMethods(): array
    {
        return [
            'espece' => 'Espèce',
            'cheque' => 'Chèque',
            'virement' => 'Virement',
        ];
    }
}

if (!function_exists('aPaymentMethods')) {
    function aPaymentMethods(): array
    {
        return [
            'espece' => 'Espèce',
            'cheque' => 'Chèque',
            'virement' => 'Virement',
            'terme' => 'A terme',

            //'virement' => 'Virement',
            //'transfer' => 'Virement bancaire',
            //'card' => 'Carte bancaire',
            //'cash' => 'Espèce',
            //'lcr' => 'LCR Lettre de Change Relevé',
            //'direct_debit' => 'Prélèvement',
            //'paypal' => 'PayPal',
            //'cheque' => 'Chèque',
            //'mandat' => 'Mandat',
            //'mobile money' => 'Mobile money',
            //'orange money' => 'Orange money',
        ];
    }
}

if (!function_exists('paymentDeadlines')) {
    function paymentDeadlines(): array
    {
        return [
            '5' => '5 jours',
            '10' => '10 jours',
            '15' => '15 jours',
            '30' => '30 jours',
            '45' => '45 jours',
            '60' => '60 jours',
            '0' => '0 jours',
            'a_reception' => 'A réception',
            'a_la_commande' => 'A la commande',
            'end_of_month' => 'Fin du mois',
            'end_of_next_m' => '30 jours fin de mois',
            '60_days_end_of_month' => '60 jours fin de mois',
            '90_days_end_of_month' => '90 jours fin de mois',
            '30_days_end_of_month_on_15th' => '30 jours fin de mois le 15 du mois',
            '30_days_end_of_10' => '30 jours fin de décade',
        ];
    }
}

if (!function_exists('unitMeasurements')) {
    function unitMeasurements(): array
    {
        $unitMeasurements = [
            'carton (c.)',
            'palette (p.)',
            'mètre (m)',
            'mètre linéaire (ML)',
            'kilogramme (kg)',
            'gramme (g)',
            'litre (l)',
            'mètre cube (m3)',
            'mètre carré (m²)',
            'heure (heure)',
            'jour (jour)',
            'forfait (forf)',
            'unité (unit)'
        ];
        return array_combine($unitMeasurements, $unitMeasurements);
    }
}

if (!function_exists('invoiceStates')) {
    function invoiceStates(): array
    {
        $states = [
            'issued' => 'Créé', 'paid' => 'Payé', 'partial' => 'Payé en partie',
            'rejected' => 'Rejeté', 'sent' => 'Envoyé', 'accepted' => 'Accepté',
        ];
        return $states;
    }
}

if (!function_exists('civilities')) {
    function civilities(): array
    {
        return [
            'M.' => 'M.',
            'Mme' => 'Mme',
            //'Mmes' => 'Mmes',
            //'Mrs' => 'Mrs',
            //'Autre' => 'Autre'
        ];
    }
}

if (!function_exists('nationalities')) {
    function nationalities(): array
    {
        $nationalities = [
            "Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Anguillan", "Antiguan", "Argentinian", "Armenian", "Aruban", "Australian", "Austrian", "Azerbaijani",
            "Bahamian", "Bahraini", "Bangladeshi", "Barbadian", "Belarusian", "Belgian", "Belizean", "Beninese", "Bermudian", "Bissau-Guinean", "Bhutanese", "Bolivian", "Bosnia and Herzegovina Nationality", "Botswanan", "Brazilian", "British", "British Virgin Islander", "Bruneian", "Bulgarian", "Burkinabe", "Burmese", "Burundian",
            "Cambodian", "Cameroonian", "Canadian", "Cape Verdean", "Cayman Islander", "Central African", "Chadian", "Chilean", "Chinese", "Christmas Islander", "Cocos Islander", "Colombian", "Comoran", "Congolese(Congo)", "Congolese(DRC)", "Cook Islander", "Costa Rican", "Croatian", "Cuban", "Cypriot", "Czech",
            "Danish", "Djiboutian", "Dominican", "Dutch",
            "East Timorese", "Ecuadorean", "Egyptian", "Emirati", "English", "Equatorial Guinean", "Eritrean", "Estonian", "Ethiopian",
            "Faroese", "Falkland Islander", "Fijian", "Filipino", "Finnish", "French", "French Guianese", "French Polynesian",
            "Gabonese", "Gambian", "Georgian", "German", "Ghanaian", "Gibraltarian", "Greek", "Greenlandic", "Grenadian", "Guadeloupean", "Guamanian", "Guatemalan", "Guernsey Nationality", "Guinean", "Guyanese",
            "Haitian", "Honduran", "Hong Konger", "Hungarian",
            "Icelandic", "Indian", "Indonesian", "Iranian", "Iraqi", "Irish", "Islander", "Israeli", "Italian", "Ivorian",
            "Jamaican", "Japanese", "Jersey Nationality", "Jordanian",
            "Kazakh", "Kenyan", "Kiribatian", "Kittsian", "Korean", "Kosovan", "Kuwaiti", "Kyrgyz",
            "Lao", "Latvian", "Lebanese", "Lesothan", "Liberian", "Libyan", "Liechtensteiner", "Lithuanian", "Luxembourger",
            "Macanese", "Macedonian", "Malagasy", "Malawian", "Malaysian", "Maldivian", "Malian", "Maltese", "Marshallese", "Martinican", "Mauritanian", "Mauritian", "Mexican", "Micronesian", "Moldovan", "Monegasque", "Mongolian", "Montenegrin", "Montserratian", "Moroccan", "Mosotho", "Mozambican",
            "Namibian", "Nauruan", "Nepalese", "Netherlander", "New Caledonian", "New Zealander", "Nicaraguan", "Nigerian", "Nigerien", "Niuean", "Norfolk Islander", "North Korean", "Northern Irish", "Norwegian",
            "Omani",
            "Pakistani", "Palauan", "Palestinian", "Panamanian", "Papua New Guinean", "Paraguayan", "Peruvian", "Pitcairn Islander", "Polish", "Portuguese", "Puerto Rican",
            "Qatari",
            "Reunionese", "Romanian", "Russian", "Rwandan",
            "Saint Helenian", "Saint Lucian", "Salvadorean", "Sammarinese", "Samoan", "San Marinese", "Sao Tomean", "Saudi Arabian", "Scottish", "Senegalese", "Serbian",
            "Seychellean", "Sierra Leonean", "Singaporean", "Slovak", "Slovenian", "Solomon Islander", "Somalian", "South African", "South  Korean", "South Sudanese",
            "Spanish", "Sri Lankan", "Stateless", "Sudanese", "Surinamese", "Swazi", "Swedish", "Swiss", "Syrian",
            "Taiwanese", "Tajik", "Tanzanian", "Thai", "Togolese", 'Tokelauan', "Tongan", "Trinidadian", "Tunisian", "Turkish", "Turkmen", "Turks and Caicos Islander", "Tuvaluan",
            "Ugandan", "Ukrainian", "Uruguayan", "Uzbek",
            "Vaticanian", "Vanuatuan", "Venezuelan", "Vietnamese", "Vincentian",
            "Wallisian", "Welsh",
            "Yemeni",
            "Zambian", "Zimbabwean",
        ];
        return array_combine($nationalities, $nationalities);
    }
}

if (!function_exists('countries')) {
    function countries(): array
    {
        $countries = [
            'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica (the territory South of 60 deg S)', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan',
            'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Bouvet Island (Bouvetoya)', 'Brazil', 'British Indian Ocean Territory (Chagos Archipelago)', 'British Virgin Islands', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi',
            'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote d\'Ivoire', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic',
            'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
            'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia',
            'Faroe Islands', 'Falkland Islands (Malvinas)', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Territories',
            'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana',
            'Haiti', 'Heard Island and McDonald Islands', 'Holy See (Vatican City State)', 'Honduras', 'Hong Kong', 'Hungary',
            'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy',
            'Jamaica', 'Japan', 'Jersey', 'Jordan',
            'Kazakhstan', 'Kenya', 'Kiribati', 'Korea', "Kosovo", 'Kuwait', 'Kyrgyz Republic',
            'Lao People\'s Democratic Republic', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libyan Arab Jamahiriya', 'Liechtenstein', 'Lithuania', 'Luxembourg',
            'Macao', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar',
            'Namibia', 'Nauru', 'Nepal', 'Netherlands Antilles', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway',
            'Oman',
            'Pakistan', 'Palau', 'Palestinian Territories', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico',
            'Qatar',
            'Reunion', 'Romania', 'Russian Federation', 'Rwanda',
            'Saint Barthelemy', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia (Slovak Republic)', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia and the South Sandwich Islands', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard & Jan Mayen Islands', 'Swaziland', 'Sweden', 'Switzerland', 'Syrian Arab Republic',
            'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu',
            'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States of America', 'United States Minor Outlying Islands', 'United States Virgin Islands', 'Uruguay', 'Uzbekistan',
            'Vanuatu', 'Venezuela', 'Vietnam',
            'Wallis and Futuna', 'Western Sahara',
            'Yemen',
            'Zambia', 'Zimbabwe',
        ];
        return array_combine($countries, $countries);
    }
}

if (!function_exists('generateNumber')) {
    function generateNumber(string $type, int $id, $length = 5): string
    {
        return $type.date('y').str_pad($id, $length, '0', STR_PAD_LEFT);
    }
}
