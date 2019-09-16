<?php

namespace App\Admin\Controllers;

use App\Models\Designer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DesignersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Designer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Designer);
        $grid->model()->orderBy('created_at', 'desc'); // 设置初始排序条件

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIdFilter(); // 去掉默认的id过滤器
            $filter->like('name', 'Name');
        });

        // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
        // $grid->disableCreation(); // Deprecated
        $grid->disableCreateButton();

        // 关闭全部操作
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
            // 去掉查看
            // $actions->disableView();
            // 当前行的数据数组
            // $actions->row;
            // 获取当前行主键值
            // $actions->getKey();
            // 添加操作
            // $actions->append(new CheckRow($actions->getKey()));
        });
        // $grid->disableActions();

        // 去掉批量操作
        /*$grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });*/
        $grid->disableBatchActions();

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', 'Name');
        // $grid->column('avatar', 'Avatar');
        $grid->avatar('头像')->image('', 40);
        $grid->column('email', 'Email');
        // $grid->column('email_verified_at', 'Email verified at');
        $grid->column('gender', 'Gender')->using(['male' => '男', 'female' => '女'], 'male');
        $grid->column('qq', 'QQ');
        $grid->column('wechat', 'Wechat');
        $grid->column('phone', 'Phone');
        // $grid->column('password', 'Password');
        // $grid->column('remember_token', 'Remember token');
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
        $show = new Show(Designer::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            $tools->disableDelete();
        });;

        // $show->field('id', 'ID');
        $show->field('name', 'Name');
        $show->field('avatar', '头像')->image('', 120);
        $show->field('email', 'Email');
        $show->field('email_verified_at', 'Email verified at');
        // $show->field('gender', 'Gender');
        $show->field('gender', 'Gender')->using(['male' => '男', 'female' => '女'], 'male');
        $show->field('qq', 'QQ');
        $show->field('wechat', 'Wechat');
        $show->field('phone', 'Phone');
        // $show->field('password', 'Password');
        // $show->field('remember_token', 'Remember token');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Designer);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });

        $form->display('id', 'ID');
        $form->image('avatar', '头像')->uniqueName()->move('avatar/' . date('Ym', now()->timestamp))->rules('required|image');
        $form->text('name', 'Name');
        // $form->image('avatar', 'Avatar');
        $form->email('email', 'Email');
        // $form->datetime('email_verified_at', 'Email verified at')->default(date('Y-m-d H:i:s'));
        $form->display('email_verified_at', 'Email verified at');
        // $form->text('gender', 'Gender')->default('male');
        $form->switch('gender', 'Gender')->states([
            'on' => ['value' => 'male', 'text' => '男', 'color' => 'success'],
            'off' => ['value' => 'female', 'text' => '女', 'color' => 'danger'],
        ])->default('male');
        $form->text('qq', 'QQ');
        $form->text('wechat', 'Wechat');
        $form->mobile('phone', 'Phone');
        // $form->password('password', 'Password');
        // $form->text('remember_token', 'Remember token');

        $form->display('created_at', '创建时间');
        $form->display('updated_at', '更新时间');

        return $form;
    }
}
