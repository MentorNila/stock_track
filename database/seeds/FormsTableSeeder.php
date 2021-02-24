<?php

use App\Models\Multitenancy\MultitenancyHelper;
use App\Modules\Form\Models\Forms;
use Illuminate\Database\Seeder;
use App\Modules\Company\Models\Company;
use App\Modules\Plans\Models\PlanForm;

class FormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forms = [
            [
                'id'             => 1,
                'name'           => 'S-1',
                'type'           => 'S1',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 2,
                'name'           => 'S-3',
                'type'           => 'S3',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 3,
                'name'           => 'SF-1',
                'type'           => 'SF1',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 4,
                'name'           => 'SF-3',
                'type'           => 'SF3',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 5,
                'name'           => 'S-4',
                'type'           => 'S4',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 6,
                'name'           => 'S-8',
                'type'           => 'S8',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 7,
                'name'           => 'S-11',
                'type'           => 'S11',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 8,
                'name'           => 'F-1',
                'type'           => 'F1',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 9,
                'name'           => 'F-3',
                'type'           => 'F3',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 10,
                'name'           => 'F-4',
                'type'           => 'F4',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 12,
                'name'           => '8-K',
                'type'           => '8K',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 13,
                'name'           => '10-D',
                'type'           => '10D',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 14,
                'name'           => '10-Q',
                'type'           => '10Q',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 15,
                'name'           => '10-K',
                'type'           => '10K',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 16,
                'name'           => 'ABS-EE',
                'type'           => 'ABSEE',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 17,
                'name'           => '3',
                'type'           => 'Form3',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 18,
                'name'           => '4',
                'type'           => 'Form4',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 19,
                'name'           => '5',
                'type'           => 'Form5',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 20,
                'name'           => 'DEF 14A',
                'type'           => 'DEF14A',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
              'id'             => 21,
              'name'           => 'D',
              'type'           => 'FormD',
              'created_at'     => '2019-10-04 15:02:42',
              'updated_at'     => '2019-10-04 15:02:42',
              'deleted_at'     => null,
            ],
            [
                'id'             => 22,
                'name'           => 'SC 13G/A',
                'type'           => 'SC13GA',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
                'id'             => 23,
                'name'           => '13F-HR',
                'type'           => '13FHR',
                'created_at'     => '2019-10-04 15:02:42',
                'updated_at'     => '2019-10-04 15:02:42',
                'deleted_at'     => null,
            ],
            [
            'id'             => 24,
            'name'           => '6-K',
            'type'           => 'Form6-K',
            'created_at'     => '2019-10-04 15:02:42',
            'updated_at'     => '2019-10-04 15:02:42',
            'deleted_at'     => null,
        ]
        ];
        Forms::insert($forms);

    }
}
