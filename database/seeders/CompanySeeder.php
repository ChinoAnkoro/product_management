<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(['company_name' => 'サントリー']);
        Company::create(['company_name' => 'Coca-Cola']);
        Company::create(['company_name' => 'キリン']);
    }
}
