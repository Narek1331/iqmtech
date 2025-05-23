<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'ЛИД',
                'slug' => 'lead',
                'color' => 'success',
            ],
            [
                'name' => 'Диалог',
                'slug' => 'dialogue',
                'color' => 'primary',
            ],
            [
                'name' => 'Перезвонить позже',
                'slug' => 'call_back_later',
                'color' => 'warning',
            ],
            [
                'name' => 'Нет ответа/Недоступен',
                'slug' => 'no_answer_unavailable',
                'color' => 'warning',
            ],
            [
                'name' => 'НО/НД - 2 день',
                'slug' => 'no_answer_day_2',
                'color' => 'warning',
            ],
            [
                'name' => 'НО/НД - 3 день',
                'slug' => 'no_answer_day_3',
                'color' => 'danger',
            ],
            [
                'name' => 'Повторный лид',
                'slug' => 'repeat_lead',
                'color' => 'danger',
            ],
            [
                'name' => 'Не интересно/сброс',
                'slug' => 'not_interested_drop',
                'color' => 'gray',
            ],
            [
                'name' => 'Другое',
                'slug' => 'other',
                'color' => 'gray',
            ],
        ];

        foreach($datas as $data)
        {
            Status::create($data);
        }



    }
}
