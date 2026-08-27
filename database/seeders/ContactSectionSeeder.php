<?php

namespace Database\Seeders;

use App\Models\ContactSection;
use Illuminate\Database\Seeder;

class ContactSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSection::updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'phone' => '+91 99081 17712',
                'email' => 'info@openskyholidays.com',
                'address' => '#1-11-110, Shyamlal Building, Begumpet, Hyderabad - 500018',
                'map_link' => 'https://www.google.com/maps/search/?api=1&query=Shyamlal+Building+Begumpet+Hyderabad+500018',
                'whatsapp_number' => '+91 99081 17712',
                'map_embed_url' => 'https://maps.google.com/maps?q=Shyamlal%20Building%20Begumpet%20Hyderabad%20500018&t=&z=15&ie=UTF8&iwloc=&output=embed',
                'status' => true,
            ]
        );
    }
}
