<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class
UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create roles
//        $roles = [
//            'super_admin',
//            'admin',
//            'manager',
//            'supervisor',
//            'rso',
//            'bp',
//            'accountant',
//        ];

//        foreach ($roles as $roleName) {
//            Role::firstOrCreate(['name' => $roleName]);
//        }

        // Step 2: Define users
        $users = [
            ['Emil Sadekin Islam', '01732547755', 'sadekinislam6@gmail.com', '3213'],
            ['MD. ALI HOSSAIN', '01711000001', 'rso01@gmail.com', 'password'],
            ['Safiqul Islam', '01711000002', 'rso02@gmail.com', 'password'],
            ['Saddam', '01711000003', 'rso03@gmail.com', 'password'],
            ['Badiuzzaman', '01711000004', 'rso04@gmail.com', 'password'],
            ['Md. Golam Mostufa', '01711000005', 'rso05@gmail.com', 'password'],
            ['RIPON RANA', '01711000006', 'rso06@gmail.com', 'password'],
            ['MD. RASEL MIA', '01711000007', 'rso07@gmail.com', 'password'],
            ['Robin Mia', '01711000008', 'rso08@gmail.com', 'password'],
            ['Md. Thouhul Amin', '01711000009', 'rso09@gmail.com', 'password'],
            ['MD POROSH MIAH', '01711000010', 'rso10@gmail.com', 'password'],
            ['MD. Hasan Mia', '01711000011', 'rso11@gmail.com', 'password'],
            ['ABUL BASHER RANA', '01711000012', 'rso12@gmail.com', 'password'],
            ['MAHMUD HASAN EMON', '01711000013', 'rso13@gmail.com', 'password'],
            ['MD MIJANUR RAHMAN', '01711000014', 'rso14@gmail.com', 'password'],
            ['Hridoy Mia', '01711000015', 'rso15@gmail.com', 'password'],
            ['Md. Hridoy Mia', '01711000016', 'rso16@gmail.com', 'password'],
            ['SAHADAT HOSSAIN', '01711000017', 'rso17@gmail.com', 'password'],
            ['Mijan', '01711000018', 'rso18@gmail.com', 'password'],
            ['Hossain Bhuyan', '01711000019', 'rso19@gmail.com', 'password'],
            ['Md. Mamun Mia', '01711000020', 'rso20@gmail.com', 'password'],
            ['RIAZ AHMED', '01711000021', 'rso21@gmail.com', 'password'],
            ['FERDOUS MIA', '01711000022', 'rso22@gmail.com', 'password'],
            ['MD MOKHTAKIN', '01711000023', 'rso23@gmail.com', 'password'],
            ['Md. Shahin mia', '01711000024', 'rso24@gmail.com', 'password'],
            ['Opi Ahmed Shuvo', '01711000025', 'rso25@gmail.com', 'password'],
            ['Titu Mia', '01923909896', 'supervisor01@gmail.com', 'password'],
            ['Ruhul Amin', '01911266077', 'supervisor02@gmail.com', 'password'],
            ['Mobashir Ahmed', '01923909897', 'supervisor03@gmail.com', 'password'],
        ];

        // Step 3: Create users and assign roles
        foreach ($users as [$name, $phone, $email, $password]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'slug' => Str::random(10),
                    'avatar' => null,
                    'name' => $name,
                    'phone_number' => $phone,
                    'email_verified_at' => now(),
                    'password' => Hash::make($password),
                    'status' => 'active',
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Role assignment logic
//            if ($email === 'sadekinislam6@gmail.com') {
//                $user->assignRole('super_admin');
//            } elseif (str_starts_with($email, 'rso')) {
//                $user->assignRole('rso');
//            } elseif (str_starts_with($email, 'supervisor')) {
//                $user->assignRole('supervisor');
//            }
        }

        // Attach all houses to the super admin user
        $superAdmin = User::where('email', 'sadekinislam6@gmail.com')->first();

        if ($superAdmin) {
            $houses = House::where('status', 'active')->get();

            // Adjust depending on your actual relationship: belongsToMany or hasMany
            $superAdmin->house()->syncWithoutDetaching($houses->pluck('id'));
        }
    }
}
