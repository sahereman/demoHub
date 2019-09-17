<?php

namespace App\Admin\Controllers;

// use App\Admin\Models\Demo;
use App\Models\Demo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DemosController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Demo';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Demo);
        $grid->model()->orderBy('sort', 'desc'); // 设置初始排序条件

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIDFilter(); // 去掉默认的id过滤器
            $filter->like('name', 'Name');
        });

        $grid->column('id', 'ID')->sortable();
        // $grid->column('designer_id', 'Designer id');
        // $grid->column('client_id', 'Client id');
        // $grid->column('designer_name', 'Designer');
        // $grid->column('client_name', 'Client');
        $grid->column('designer', 'Designer')->display(function ($designer) {
            return $designer['name'];
        });
        $grid->column('client', 'Client')->display(function ($client) {
            return $client['name'];
        });
        $grid->column('name', 'Name');
        // $grid->column('slug', 'Slug');
        // $grid->column('description', 'Description');
        // $grid->column('content', 'Content');
        $grid->column('thumb', 'Thumb')->image('', 40);
        // $grid->column('photos', 'Photos');
        $grid->column('is_index', 'Is index');
        $grid->column('sort', '排序值')->sortable();
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
        $show = new Show(Demo::findOrFail($id));

        // $show->field('id', 'ID');
        $show->field('designer_id', 'Designer id');
        $show->field('client_id', 'Client id');
        $show->field('name', 'Name');
        $show->field('slug', 'Slug');
        $show->field('description', 'Description');
        $show->field('content', 'Content');
        $show->field('thumb', 'Thumb')->image('', 120);
        $show->field('photos', 'Photos');
        $show->field('is_index', 'Is index');
        $show->field('sort', '排序值');
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
        $form = new Form(new Demo);

        $form->number('designer_id', 'Designer id');
        $form->number('client_id', 'Client id');
        $form->text('name', 'Name');
        $form->text('slug', 'Slug');
        $form->textarea('description', 'Description');
        $form->textarea('content', 'Content');
        $form->text('thumb', 'Thumb');
        $form->text('photos', 'Photos');
        $form->switch('is_index', 'Is index');
        // $form->number('sort', '排序值')->default(9);
        $form->number('sort', '排序值')->default(9)->rules('required|integer|min:0')->help('默认倒序排列：数值越大越靠前');

        return $form;
    }
}
