<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::query()->create([
            'name'           => 'Biya Transit',
            'acronym'        => 'Biya-Transit',
            'logo'           => 'settings/logo.png',
            'signature'      => null, //'settings/signature.jpg',
            'phone1'         => '(+224) 622 76 27 38',
            'phone2'         => '(+224) 620 39 30 53',
            'phone3'         => '(+224) 621 20 77 08',
            'email'          => 'bnjguinee@gmail.com',
            'address'        => 'Nongo 4135 , Conakry Rep - Guinee',
            //'postcode'       => 'Nongo 4135 , Conakry Rep - Guinee',
            //'exchange_rate'  => 10500,
            //'vat_no'         => 'SGI/N 9D-CODE',
            //'nif'            => '831646351',
            //'bank_code'      => '005',
            //'agency_code'    => '001',
            //'account_number' => '5665590010',
            //'cie'            => '84',
            //'iban'           => 'GN79 0050 0156 6559 0010 84',
            //'bic'            => 'ORBKGNGN',
        ]);

        $this->call(RolesAndPermissionsSeeder::class);
    }
}
