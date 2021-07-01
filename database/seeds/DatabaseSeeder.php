<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        // $this->call(CompanysTableSeeder::class);
        // $this->call(JobsTableSeeder::class);
        // $this->call(ResumesTableSeeder::class);
        Model::reguard();
    }
}
