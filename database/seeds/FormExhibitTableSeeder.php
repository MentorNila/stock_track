<?php

use App\Models\Multitenancy\MultitenancyHelper;
use App\Modules\Form\Models\FormExhibits;
use Illuminate\Database\Seeder;

class FormExhibitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($clientId = 1)
    {
        MultitenancyHelper::run(function($client) {
            $data = [
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 9,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 16,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 1,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 2,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 38,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 39,
                ],
                [
                    'form_id'             => 3,
                    'exhibit_id'           => 40,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 33,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 38,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 39,
                ],
                [
                    'form_id'             => 4,
                    'exhibit_id'           => 40,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 9,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 13,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 16,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 5,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 6,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 6,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 6,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 6,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 6,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 6,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 9,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 16,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 7,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 9,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 8,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 9,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 6,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 8,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 9,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 25,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 10,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 9,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 16,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 11,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 1,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 7,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 14,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 16,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 17,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 20,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 40,
                ],
                [
                    'form_id'             => 12,
                    'exhibit_id'           => 42,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 38,
                ],
                [
                    'form_id'             => 13,
                    'exhibit_id'           => 39,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 13,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 15,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 18,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 27,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 29,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 34,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 14,
                    'exhibit_id'           => 42,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 2,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 3,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 4,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 5,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 9,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 10,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 13,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 14,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 16,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 18,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 21,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 23,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 24,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 27,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 28,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 29,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 30,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 31,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 32,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 34,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 35,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 37,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 41,
                ],
                [
                    'form_id'             => 15,
                    'exhibit_id'           => 42,
                ],
                [
                    'form_id'             => 16,
                    'exhibit_id'           => 38,
                ],
                [
                    'form_id'             => 16,
                    'exhibit_id'           => 39,
                ],
            ];
        }, $clientId);



    }
}
