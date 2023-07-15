<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Area;
use App\Models\Vet;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create super admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123qweasd'),
            'administrator' => true,
        ]);

        User::create([
            'name' => 'user_1',
            'email' => 'user_1@example.com',
            'password' => bcrypt('123qweasd'),
            'administrator' => false,
        ]);

        User::create([
            'name' => 'user_2',
            'email' => 'user_2@example.com',
            'password' => bcrypt('123qweasd'),
            'administrator' => false,
        ]);

        // Areas
        foreach ([1, 2] as $item) {
            Area::create([
                'name' => 'Area ' . $item,
            ]);
        };

        $areas = Area::all();

        // Vets
        for ($i = 1; $i <= 10; $i++) {
            $vet = new Vet();
            $vet->user_id = $admin->id;
            $vet->area_id = $areas->random()->id;
            $vet->name = 'Vet ' . $i;
            $vet->telephone = '123456789';
            $vet->whatsapp = '123456789';
            $vet->save();
            
            // Membuat jadwal untuk Vet
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            
            foreach ($days as $day) {
                $schedule = [
                    'open_day' => true, // Ganti dengan logika validasi Anda
                    'open_hour' => '09:00',
                    'close_hour' => '17:00',
                    'fullday' => false, // Ganti dengan logika validasi Anda
                ];
                
                $scheduleModel = new Schedule();
                $scheduleModel->vet_id = $vet->id;
                $scheduleModel->day_name = $day;
                $scheduleModel->open_hour = $schedule['open_hour'];
                $scheduleModel->close_hour = $schedule['close_hour'];
                $scheduleModel->fullday = $schedule['fullday'];
                $scheduleModel->save();
            }
        }
    }
}
