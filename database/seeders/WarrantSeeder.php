<?php

namespace Database\Seeders;

use App\Models\Warrant;
use Illuminate\Database\Seeder;

class WarrantSeeder extends Seeder
{
    public function run(): void
    {
        // Create a mix of warrants with different statuses

        // 5 pending warrants
        Warrant::factory(5)->pending()->create();

        // 8 processing warrants (some with files)
        Warrant::factory(5)->processing()->create();
        Warrant::factory(3)->processing()->withFiles()->create();

        // 7 completed warrants (most with files)
        Warrant::factory(2)->completed()->create();
        Warrant::factory(5)->completed()->withFiles()->create();

        // Create a few specific examples with realistic data
        Warrant::create([
            'warrant_number' => 'WR/2025/0001',
            'officer_name' => 'D/SGT. MULENGA BLESSMORE',
            'station' => 'ANTI-FRAUDS AND CYBER CRIME UNIT',
            'phone_numbers' => ['+260977209848', '+260972980291', '+260774900773'],
            'suspect_name' => 'BEAUTY HAMAYANGWE',
            'description' => "Investigation into suspected mobile money fraud involving unauthorized transactions from victim's account. Suspect allegedly used social engineering techniques to obtain victim's PIN and conducted multiple unauthorized transfers totaling K15,000. Investigation period covers December 2024 to August 2025 as per court warrant.",
            'period_from' => '2024-12-01',
            'period_to' => '2025-08-05',
            'status' => 'processing',
            'cdr_file_path' => 'cdr_files/beauty_hamayangwe_cdr.xlsx',
            'kyc_file_path' => 'kyc_files/beauty_hamayangwe_kyc.xlsx',
            'created_at' => now()->subDays(15),
        ]);

        Warrant::create([
            'warrant_number' => 'WR/2025/0002',
            'officer_name' => 'INSP. BANDA JOSEPH',
            'station' => 'ANTI-FRAUDS AND CYBER CRIME UNIT',
            'phone_numbers' => ['+260972980291'],
            'suspect_name' => 'JOSEPH BANDA',
            'description' => "Cyber crime investigation regarding suspected SIM swap fraud and subsequent unauthorized mobile banking activities. Victim reported that suspect gained control of their phone number and accessed mobile banking services without authorization.",
            'period_from' => '2024-12-01',
            'period_to' => '2025-08-05',
            'status' => 'completed',
            'cdr_file_path' => 'cdr_files/joseph_banda_cdr.xlsx',
            'kyc_file_path' => 'kyc_files/joseph_banda_kyc.xlsx',
            'created_at' => now()->subDays(30),
        ]);

        $this->command->info('Created ' . Warrant::count() . ' sample warrants');
    }
}
