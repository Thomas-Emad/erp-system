<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    /**
     * List of applications to add.
     */
    private $permissions = [
        'login',
        'users',
        'worker-dashboard',
        'role',
        'factory',
        'store',
        'customer',
        'supplier',
        'holiday',
        'attendance',
        'vacation'
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HolidaysTableSeeder::class
        ]);

        $user = User::create([
            'name' => 'Owner Erp System',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('123456'),
            'national_id' => '1231212122313',
            'phone' => fake()->phoneNumber(),
            'sallary' => fake()->numberBetween(1000, 5000),
            'wallet' => fake()->randomNumber(),
            'bus_id' => 1,
            'today_price' => 100,
        ]);

        // permissions
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Owner
        $role = Role::create([
            'name' => 'Owner',
            'start_work' => '10:00',
            'end_work' => '20:00',
        ]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        // worker
        $role = Role::create([
            'name' => 'worker',
            'start_work' => '10:00',
            'end_work' => '20:00',
        ]);
        $role->syncPermissions(Permission::where('name', 'worker-dashboard')->first()->id);
    }
}
