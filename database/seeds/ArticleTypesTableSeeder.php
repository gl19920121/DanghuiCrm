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
            'url' => 'yjs',
        ], [
            'no' => 'N0002',
            'type' => 'working_people',
            'level' => 1,
            'name' => '职场技巧',
            'pno' => 'N01',
            'url' => 'zcjq',
        ], [
            'no' => 'N0003',
            'type' => 'resume',
            'level' => 1,
            'name' => '简历',
            'pno' => 'N01',
            'url' => 'jl',
        ], [
            'no' => 'N0004',
            'type' => 'interview',
            'level' => 1,
            'name' => '面试',
            'pno' => 'N01',
            'url' => 'ms',
        ], [
            'no' => 'N0005',
            'type' => 'newcomer',
            'level' => 1,
            'name' => '职场新人',
            'pno' => 'N01',
            'url' => 'zcxr',
        ]];

        foreach ($articleTypes as $articleType) {
            if (ArticleType::where('no', $articleType['no'])->count() > 0) {
                ArticleType::where('no', $articleType['no'])->first()->update($articleType);
                // ArticleType::update($articleType);
            } else {
                ArticleType::create($articleType);
            }
        }
    }
}
