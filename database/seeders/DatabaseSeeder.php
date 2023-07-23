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
            'acronym'        => 'Transit Maritime - Aérien - Transport',
            'logo'           => 'settings/logo.png',
            'signature'      => null, //'settings/signature.jpg',
            'phone1'         => '00224 622 25 68 34',
            'phone2'         => '00224 657 22 35 10',
            'phone3'         => null,
            'email'          => 'biyamemoire@yahoo.fr',
            'address'        => 'Siège Boulevard du Commerce en face du Siège ORANGE GUINEE, Quartier Almamya Commune de Ratoma',
            'postcode'       => '4436',
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
