<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OptionTablesSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $optionGroupTable = 'mst_option_group';

    /**
     * @var string
     */
    protected $optionValueTable = 'mst_option_value';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->optionGroupTable)->delete();

        $now = now();
        $options = [
            [
                'id' => Str::uuid(), 'name' => 'display_per_page', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '5', 'value' => '5', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '10', 'value' => '10', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '15', 'value' => '15', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '25', 'value' => '25', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '50', 'value' => '50', 'sequence' => 5,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '100', 'value' => '100', 'sequence' => 6,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'All', 'value' => 'All', 'sequence' => 7,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'bool_decision', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 0, 'value' => __('label.no'), 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => __('label.yes'), 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'char_decision', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 'N', 'value' => __('label.no'), 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'Y', 'value' => __('label.yes'), 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'visibility', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 0, 'value' => 'Hidden', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'Visible', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'auth_method', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 'local', 'value' => 'Local', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'uim', 'value' => 'UIM', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 0, 'value' => __('label.inactive'), 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => __('label.active'), 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_user', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 0, 'value' => 'Tidak Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 9, 'value' => 'Blokir', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'tipe_transaksi', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'ITA', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 2, 'value' => 'AGI', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_validasi_posting', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'Validasi Sukses', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 2, 'value' => 'Posting Sukses', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 3, 'value' => 'Posting Gagal', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_approval', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'Menunggu Approval', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 2, 'value' => 'Transaksi Disetujui', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 3, 'value' => 'Transaksi Ditolak', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
        ];

        foreach ($options as $option) {
            $values = $option['values'];
            \Illuminate\Support\Arr::forget($option, 'values');

            DB::table($this->optionGroupTable)->insert($option);

            foreach ($values as $value) {
                $value['option_group_id'] = $option['id'];
                DB::table($this->optionValueTable)->insert($value);
            }
        }
    }
}
