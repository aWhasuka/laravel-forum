<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        // 创建一个列名为 ID 的列，内容是用户的 id 字段
        $grid->id('ID')->sortable();;
        $grid->avatar('头像')->image('',50,50);

        // 创建一个列名为 用户名 的列，内容是用户的 name 字段。下面的 email() 和 created_at() 同理
        $grid->name('用户名');
        $grid->phone('手机号');
        $grid->email('邮箱');

        $grid->email_verified_at('已验证邮箱')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->introduction('简介');
        $grid->notification_count('未读数');
        $grid->created_at('注册时间');

        // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
//        $grid->disableCreateButton();
        // 同时在每一行也不显示 `编辑` 按钮
//        $grid->disableActions();

        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('姓名'));
        $form->mobile('phone', __('手机'));
        $form->email('email', __('邮箱'));
        $form->image('avatar', __('头像'));
        $form->text('introduction', __('简介'));

        return $form;
    }
}
