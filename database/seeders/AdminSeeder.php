<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', '=', 'admin')->firstOrFail();
        $adminUser = User::create([
            'name' => 'admin',
            'email'=>'admin'. rand(6,15).'@sndkcorp.com',
            'password'=>('Admin@123')
            ]);
        $adminUser->assignRole($adminRole);
    }
}
