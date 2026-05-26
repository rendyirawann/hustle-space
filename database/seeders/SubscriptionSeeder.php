<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Plans
        $starter = \App\Models\Plan::firstOrCreate(['slug' => 'starter'], [
            'name' => 'Starter',
            'price' => 99000,
            'features' => json_encode(['Basic Frames', 'Single & 4-Frame', 'Standard Res', 'Watermark'])
        ]);

        $pro = \App\Models\Plan::firstOrCreate(['slug' => 'pro-event'], [
            'name' => 'Pro Event',
            'price' => 299000,
            'features' => json_encode(['Premium Frames', 'Custom Upload', 'HD Res', 'No Watermark', 'Analytics'])
        ]);

        $enterprise = \App\Models\Plan::firstOrCreate(['slug' => 'enterprise'], [
            'name' => 'Enterprise',
            'price' => 0,
            'features' => json_encode(['Pro Event Features', 'White-label', 'Custom Domain', '24/7 Support'])
        ]);

        // 2. Create Pro User
        $user = \App\Models\User::firstOrCreate(['email' => 'pro@hustlespace.com'], [
            'name' => 'Hustle Pro User',
            'username' => 'hustlepro',
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        // 3. Create Subscription
        \App\Models\Subscription::firstOrCreate(['user_id' => $user->id], [
            'plan_id' => $pro->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addYear(),
        ]);
    }
}
