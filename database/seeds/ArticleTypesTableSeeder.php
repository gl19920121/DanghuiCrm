<?php

use Illuminate\Database\Seeder;
use App\Models\ArticleType;

class ArticleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articleTypes = [[
            'no' => 'N01',
            'type' => 'career',
            'level' => 0,
            'name' => '职场攻略',
        ], [
            'no' => 'N02',
            'type' => 'company',
            'level' => 0,
            'name' => '公司动态',
        ], [
            'no' => 'N0001',
            'type' => 'graduate',
            'level' => 1,
            'name' => '应届生求职',
            'pno' => 'N01',
        ], [
            'no' => 'N0002',
            'type' => 'working_people',
            'level' => 1,
            'name' => '职场技巧',
            'pno' => 'N01',
        ]];

        foreach ($articleTypes as $articleType) {
            ArticleType::create($articleType);
        }
    }
}
