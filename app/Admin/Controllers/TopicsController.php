<?php

namespace App\Admin\Controllers;

use App\Models\Topic;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TopicsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '帖子';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Topic());

        $grid->filter(function($filter){
        });


        $grid->id('ID')->sortable();
        $grid->title('商品标题');
        $grid->user_id('用户');
        $grid->category()->name('分类');
        $grid->reply_count('回复数')->totalRow(function ($e) {
            return "<span class='text-primary text-bold'> {$e} </span>";
        });
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Topic::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('body', __('Body'));
        $show->field('user_id', __('User id'));
        $show->field('category_id', __('Category id'));
        $show->field('reply_count', __('Reply count'));
        $show->field('view_count', __('View count'));
        $show->field('last_reply_user_id', __('Last reply user id'));
        $show->field('order', __('Order'));
        $show->field('excerpt', __('Excerpt'));
        $show->field('slug', __('Slug'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Topic());

        $form->text('title', __('Title'));
        $form->tinymce('body');
//        $form->quill('body', '帖子内容')->rules('required');
//        $form->textarea('body', __('Body'));
        $form->number('user_id', __('User id'));
        $form->number('category_id', __('Category id'));
        $form->number('reply_count', __('Reply count'));
        $form->number('view_count', __('View count'));
        $form->number('last_reply_user_id', __('Last reply user id'));
        $form->number('order', __('Order'));
        $form->textarea('excerpt', __('Excerpt'));
        $form->text('slug', __('Slug'));

        return $form;
    }
}
