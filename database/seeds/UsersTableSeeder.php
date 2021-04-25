<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'account' => 'admin',
            'password' => bcrypt('admin123!@#'),
            'name' => '管理员',
            'email' => '694986534@qq.com',
            'phone' => '15001332305',
            'role_id' => 1,
            'is_admin' => true
        ]);
    }
}
