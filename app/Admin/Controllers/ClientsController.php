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
    protected $title = 'App\Models\Client';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Client);

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('email', __('Email'));
        $grid->column('gender', __('Gender'));
        $grid->column('qq', __('Qq'));
        $grid->column('wechat', __('Wechat'));
        $grid->column('phone', __('Phone'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('avatar', __('Avatar'));
        $show->field('email', __('Email'));
        $show->field('gender', __('Gender'));
        $show->field('qq', __('Qq'));
        $show->field('wechat', __('Wechat'));
        $show->field('phone', __('Phone'));
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
        $form = new Form(new Client);

        $form->text('name', __('Name'));
        $form->image('avatar', __('Avatar'));
        $form->email('email', __('Email'));
        $form->text('gender', __('Gender'))->default('male');
        $form->text('qq', __('Qq'));
        $form->text('wechat', __('Wechat'));
        $form->mobile('phone', __('Phone'));

        return $form;
    }
}
