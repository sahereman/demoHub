<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ClientsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Client';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Client);
        $grid->model()->orderBy('created_at', 'desc'); // 设置初始排序条件

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIdFilter(); // 去掉默认的id过滤器
            $filter->like('name', 'Name');
        });

        $grid->column('id', 'Id')->sortable();
        $grid->column('name', 'Name');
        $grid->column('avatar', '头像')->image('', 40);
        $grid->column('email', 'Email');
        $grid->column('gender', 'Gender');
        $grid->column('qq', 'QQ');
        $grid->column('wechat', 'WeChat');
        $grid->column('phone', 'Phone');
        // $grid->column('created_at', 'Created at');
        // $grid->column('updated_at', 'Updated at');

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
        $show = new Show(Client::findOrFail($id));

        // $show->field('id', 'Id');
        $show->field('name', 'Name');
        $show->field('avatar', '头像')->image('', 120);
        $show->field('email', 'Email');
        $show->field('gender', 'Gender')->using(['male' => '男', 'female' => '女'], 'male');
        $show->field('qq', 'QQ');
        $show->field('wechat', 'WeChat');
        $show->field('phone', 'Phone');
        $show->field('created_at', 'Created at');
        $show->field('updated_at', 'Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Client);

        $form->text('name', 'Name');
        $form->image('avatar', '头像')->uniqueName()->move('avatar/clients/' . date('Ym', now()->timestamp))->rules('required|image');
        $form->email('email', 'Email');
        $form->switch('gender', 'Gender')->states([
            'on' => ['value' => 'male', 'text' => '男', 'color' => 'success'],
            'off' => ['value' => 'female', 'text' => '女', 'color' => 'danger'],
        ])->default('male');
        $form->text('qq', 'QQ');
        $form->text('wechat', 'WeChat');
        $form->mobile('phone', 'Phone');

        return $form;
    }
}
