<?php

namespace Database\Factories;

use App\Models\Warrant;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarrantFactory extends Factory
{
    protected $model = Warrant::class;

    public function definition(): array
    {
        $zambian_officers = [
            'D/SGT. MULENGA BLESSMORE', 'INSP. BANDA JOSEPH', 'SGT. PHIRI BEAUTY',
            'D/INSP. MWANZA PATRICK', 'SGT. TEMBO GRACE', 'INSP. LUNGU CHARLES',
            'D/SGT. CHANDA MERCY', 'SGT. ZULU EMMANUEL', 'INSP. MBEWE FAITH'
        ];

        $stations = [
            'ANTI-FRAUDS AND CYBER CRIME UNIT', 'LUSAKA CENTRAL POLICE',
            'KABWE CENTRAL POLICE', 'NDOLA CENTRAL POLICE', 'KITWE CENTRAL POLICE',
            'LIVINGSTONE POLICE', 'KASAMA POLICE', 'SOLWEZI POLICE'
        ];

        $suspects = [
            'UNKNOWN SUSPECT', 'JOHN BANDA', 'MARY MWANZA', 'PETER PHIRI',
            'GRACE TEMBO', 'MOSES LUNGU', 'FAITH CHANDA', 'EMMANUEL ZULU',
            'BEAUTY MBEWE', 'PATRICK SICHONE'
        ];

        $phone_count = $this->faker->numberBetween(1, 4);
        $phone_numbers = [];

        for ($i = 0; $i < $phone_count; $i++) {
            // Generate Zambian phone numbers
            $phone_numbers[] = '+260' . $this->faker->randomElement(['97', '96', '95', '77', '76', '75']) . $this->faker->numerify('#######');
        }

        $period_from = $this->faker->dateTimeBetween('-6 months', '-1 month');
        $period_to = $this->faker->dateTimeBetween($period_from, 'now');

        $descriptions = [
            "Investigation into suspected fraudulent activities involving mobile money transactions and unauthorized access to victim's account.",
            "Cyber crime investigation regarding unauthorized SIM card cloning and fraudulent mobile banking transactions.",
            "Investigation of suspected phone theft and subsequent unauthorized use for criminal activities.",
            "Cyber fraud investigation involving social media impersonation and financial fraud schemes.",
            "Investigation into suspected mobile money fraud and unauthorized account access through social engineering.",
            "Cyber crime investigation regarding fake loan applications and identity theft using stolen phone numbers.",
            "Investigation of suspected romance scam operations conducted through messaging applications.",
            "Fraud investigation involving fake business proposals and advance fee fraud schemes conducted via mobile communications."
        ];

        return [
            'warrant_number' => 'WR/' . date('Y') . '/' . $this->faker->unique()->numberBetween(1000, 9999),
            'officer_name' => $this->faker->randomElement($zambian_officers),
            'station' => $this->faker->randomElement($stations),
            'phone_numbers' => $phone_numbers,
            'suspect_name' => $this->faker->optional(0.7)->randomElement($suspects),
            'description' => $this->faker->randomElement($descriptions),
            'period_from' => $period_from,
            'period_to' => $period_to,
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed']),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    public function withFiles(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'cdr_file_path' => 'cdr_files/sample_cdr_' . $this->faker->uuid() . '.xlsx',
                'kyc_file_path' => 'kyc_files/sample_kyc_' . $this->faker->uuid() . '.xlsx',
            ];
        });
    }

    public function pending(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }

    public function processing(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'processing',
            ];
        });
    }

    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
            ];
        });
    }
}
