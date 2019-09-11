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
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->model()->orderBy('created_at', 'desc'); // 设置初始排序条件

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIdFilter(); // 去掉默认的id过滤器
            $filter->like('name', '用户名');
        });

        $grid->column('id', 'Id')->sortable();
        $grid->column('name', 'Name');
        $grid->column('email', 'Email');
        // $grid->column('email_verified_at', 'Email verified at');
        // $grid->column('password', 'Password');
        // $grid->column('remember_token', 'Remember token');
        // $grid->column('created_at', 'Created at');
        // $grid->column('updated_at', 'Updated at');

        // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
        // $grid->disableCreation(); // Deprecated
        $grid->disableCreateButton();

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
        $show = new Show(User::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            $tools->disableDelete();
        });;

        $show->field('id', 'Id');
        $show->field('name', 'Name');
        $show->field('email', 'Email');
        $show->field('email_verified_at', 'Email verified at');
        // $show->field('password', 'Password');
        // $show->field('remember_token', 'Remember token');
        // $show->field('created_at', 'Created at');
        // $show->field('updated_at', 'Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });

        $form->display('name', 'Name');
        $form->display('email', 'Email');
        //  $form->text('name', 'Name');
        // $form->email('email', 'Email');
        // $form->datetime('email_verified_at', 'Email verified at')->default(date('Y-m-d H:i:s'));
        // $form->password('password', 'Password');
        // $form->text('remember_token', 'Remember token');

        return $form;
    }
}
