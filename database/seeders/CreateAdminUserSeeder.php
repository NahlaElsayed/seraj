<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'phone' =>'0000000000',
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('12341234')
        ]);

    }
}
