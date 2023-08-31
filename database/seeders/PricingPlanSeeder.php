<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pricing_plans')->insert(
            [
                [
                    'plan_name' => 'Starter Plan',
                    'type' => 'Monthly',
                    'stripe_plan' => 'prod_OVLUau4vTpOqNh',
                    'stripe_price' => 'price_1NiKnkDOUW0TKaRzNrTPUoxV',
                    'min_smses' => '0',
                    'max_smses' => '500',
                    'price' => '50',
                ],



            ]
        );
    }
}
