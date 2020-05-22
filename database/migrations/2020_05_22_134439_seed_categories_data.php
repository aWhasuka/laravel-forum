<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     * up() 方法中使用 DB 类的 insert() 批量往数据表 categories 里插入数据 $categories
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => '分享',
                'description' => '分享创造，分享发现',
            ],
            [
                'name'        => '教程',
                'description' => '开发技巧、推荐扩展包等',
            ],
            [
                'name'        => '问答',
                'description' => '请保持友善，互帮互助',
            ],
            [
                'name'        => '公告',
                'description' => '站点公告',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     * down() 在回滚迁移时会被调用，是 up() 方法的逆反操作。truncate() 方法为清空 categories 数据表里的所有数据
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
