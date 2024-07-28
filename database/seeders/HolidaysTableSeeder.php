<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Holiday;

class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $holidays = [
            [
                'title' => "رأس السنة الميلادية",
                'start' => "01-01",
                'end' => "01-01"
            ],
            [
                'title' => "عيد الميلاد المجيد",
                'start' => "01-07",
                'end' => "01-07"
            ],
            [
                'title' => "عيد الشرطة وعيد ثورة 25 يناير",
                'start' => "01-25",
                'end' => "01-25"
            ],
            [
                'title' => "عيد تحرير سيناء",
                'start' => "04-25",
                'end' => "04-25"
            ],
            [
                'title' => "عيد العمال",
                'start' => "05-01",
                'end' => "05-01"
            ],
            [
                'title' => "عيد الفطر المبارك",
                'start' => "04-10",
                'end' => "04-12"
            ],
            [
                'title' => "ثورة 30 يونيو",
                'start' => "06-30",
                'end' => "06-30"
            ],
            [
                'title' => "عيد الأضحى المبارك",
                'start' => "06-16",
                'end' => "06-19"
            ],
            [
                'title' => "رأس السنة الهجرية",
                'start' => "07-08",
                'end' => "07-08"
            ],
            [
                'title' => "عيد ثورة 23 يوليو",
                'start' => "07-23",
                'end' => "07-23"
            ],
            [
                'title' => "عيد القوات المسلحة (نصر 6 أكتوبر)",
                'start' => "10-06",
                'end' => "10-06"
            ],
            [
                'title' => "عيد المولد النبوي الشريف",
                'start' => "09-16",
                'end' => "09-16"
            ],
            [
                'title' => "عيد القيامة المجيد",
                'start' => "04-28",
                'end' => "04-28"
            ]
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }
}
