<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Administrator;
use App\Admin\Models\Demo;

// use App\Http\Requests\Request;
// use App\Models\Demo;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Form\Builder;
use Encore\Admin\Form\NestedForm;
// use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
// use Encore\Admin\Grid\Tools;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
// use Encore\Admin\Show\Tools;
use Encore\Admin\Widgets\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CategoriesController extends AdminController
{
    protected $mode = 'create';
    protected $demo_id;
    protected $category_id;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '素材分类';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $request = request();
        $this->mode = 'index';
        if ($request->has('demo_id') && Demo::where('id', $request->input('demo_id'))->exists()) {
            $this->demo_id = $request->input('demo_id');
        } else {
            $this->demo_id = Demo::first()->id;
        }

        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->grid($request));
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        $this->mode = 'show';
        $this->category_id = $id;
        $this->demo_id = Category::find($id)->demo_id;

        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $this->mode = Builder::MODE_EDIT;
        $this->category_id = $id;
        $this->demo_id = Category::find($id)->demo_id;

        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        $request = request();
        $this->mode = Builder::MODE_CREATE;
        if ($request->has('demo_id') && Demo::where('id', $request->input('demo_id'))->exists()) {
            $this->demo_id = $request->input('demo_id');
        } else {
            $this->demo_id = Demo::first()->id;
        }

        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @param Request $request
     *
     * @return Grid
     */
    protected function grid(Request $request)
    {
        if ($request->has('demo_id') && Demo::where('id', $request->input('demo_id'))->exists()) {
            $this->demo_id = $request->input('demo_id');
        } else {
            $this->demo_id = Demo::first()->id;
        }

        $grid = new Grid(new Category);
        $grid->model()->with('drafts')->where('demo_id', $this->demo_id)->orderBy('sort', 'desc'); // 设置初始排序条件

        /*禁用*/
        // $grid->disableActions();
        // $grid->disableRowSelector();
        // $grid->disableExport();
        // $grid->disableFilter();
        $grid->disableCreateButton();
        // $grid->disablePagination();

        $demo_id = $this->demo_id;
        $grid->actions(function (Grid\Displayers\Actions $actions) use ($demo_id) {
            // $actions->disableView();
            // $actions->disableEdit();
            // $actions->disableDelete();
            /*$actions->prepend('<li>'
                . '<a href="' . route('categories.edit', ['category' => $actions->getKey(), 'demo_id' => $demo_id]) . '">编辑</a>'
                . '</li>&nbsp;'
                . '<li>'
                . '<a href="' . route('categories.show', ['category' => $actions->getKey(), 'demo_id' => $demo_id]) . '">显示</a>'
                . '</li>');*/
        });

        $grid->tools(function (Grid\Tools $tools) use ($demo_id) {
            /*$tools->batch(function ($batch) {
                $batch->disableDelete();
            });*/
            $tools->append('<div class="btn-group pull-right" style="margin-right: 10px">'
                . '<a href="' . route('categories.create', ['demo_id' => $demo_id]) . '" class="btn btn-sm btn-success">'
                . '<i class="fa fa-save"></i>&nbsp;&nbsp;新增'
                . '</a>'
                . '</div>');
        });

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIDFilter(); // 去掉默认的id过滤器
            $filter->like('name', 'Name');
        });

        $grid->column('id', 'ID')->sortable();
        // $grid->column('demo_id', 'Demo id');
        $grid->column('name', 'Name')->sortable();
        // $grid->column('slug', 'Slug');
        $grid->column('sort', 'Sort')->sortable();
        // $grid->column('created_at', 'Created at');
        // $grid->column('updated_at', 'Updated at');
        $grid->column('drafts', '素材')->display(function ($drafts) {
            return count($drafts);
        });

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
        $show = new Show(Category::findOrFail($id));

        $this->category_id = $id;
        $this->demo_id = $show->getModel()->demo_id;
        $demo_id = $this->demo_id;

        $show->panel()->tools(function (Show\Tools $tools) use ($id, $demo_id) {
            $tools->disableEdit();
            $tools->disableList();
            // $tools->disableDelete();
            $tools->append('<div class="btn-group pull-right" style="margin-right: 5px">'
                . '<a href="' . route('categories.edit', ['category' => $id, 'demo_id' => $demo_id]) . '" class="btn btn-sm btn-primary">'
                . '<i class="fa fa-edit"></i>&nbsp;编辑'
                . '</a>'
                . '</div>&nbsp;'
                . '<div class="btn-group pull-right" style="margin-right: 5px">'
                . '<a href="' . route('categories.index', ['demo_id' => $demo_id]) . '" class="btn btn-sm btn-default">'
                . '<i class="fa fa-list"></i>&nbsp;列表'
                . '</a>'
                . '</div>');
        });

        $show->field('id', 'ID');
        // $show->field('demo_id', 'Demo id');
        $show->field('name', 'Name');
        $show->field('slug', 'Slug');
        $show->field('sort', 'Sort');
        $show->field('created_at', 'Created at');
        $show->field('updated_at', 'Updated at');

        $show->divider();
        $show->drafts('素材 - 列表', function ($draft) {
            /*禁用*/
            $draft->disableActions();
            $draft->disableRowSelector();
            $draft->disableExport();
            $draft->disableFilter();
            $draft->disableCreateButton();
            $draft->disablePagination();

            // $draft->resource('/admin/drafts');

            $draft->column('name', '素材名称');
            $draft->column('thumb', '缩略图')->image('', 60);
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category);
        $form->html('<button class="btn btn-primary"><i class="fa fa-send"></i>&nbsp;提交</button>');

        if ($this->mode == Builder::MODE_CREATE) {
            if (request()->has('demo_id') && Demo::where('id', request()->input('demo_id'))->exists()) {
                $this->demo_id = request()->input('demo_id');
            } else {
                $this->demo_id = Demo::first()->id;
            }
        }
        if ($this->mode == Builder::MODE_EDIT) {
            $this->category_id = Route::current()->parameter('category');
            $this->demo_id = Category::find($this->category_id)->demo_id;
        }

        $demo_id = $this->demo_id;
        $demo = Demo::find($demo_id);
        if ($this->mode == Builder::MODE_CREATE) {
            $form->tools(function (Form\Tools $tools) use ($demo_id) {
                // $tools->disableDelete();
                $tools->disableList();
                $tools->disableView();
                $tools->append('<div class="btn-group pull-right" style="margin-right: 5px">'
                    . '<a href="' . route('categories.index', ['demo_id' => $demo_id]) . '" class="btn btn-sm btn-default">'
                    . '<i class="fa fa-list"></i>&nbsp;列表'
                    . '</a>'
                    . '</div>');
            });
        }
        if ($this->mode == Builder::MODE_EDIT) {
            $category_id = $this->category_id;
            $form->tools(function (Form\Tools $tools) use ($demo_id, $category_id) {
                // $tools->disableDelete();
                $tools->disableList();
                $tools->disableView();
                $tools->append('<div class="btn-group pull-right" style="margin-right: 5px">'
                    . '<a href="' . route('categories.show', ['category' => $category_id, 'demo_id' => $demo_id]) . '" class="btn btn-sm btn-primary">'
                    . '<i class="fa fa-eye"></i>&nbsp;查看'
                    . '</a>'
                    . '</div>&nbsp;'
                    . '<div class="btn-group pull-right" style="margin-right: 5px">'
                    . '<a href="' . route('categories.index', ['demo_id' => $demo_id]) . '" class="btn btn-sm btn-default">'
                    . '<i class="fa fa-list"></i>&nbsp;列表'
                    . '</a>'
                    . '</div>');
            });
        }

        // $form->number('demo_id', 'Demo id');
        $form->hidden('demo_id', 'Demo id')->default($demo_id);
        $form->display('Demo')->default($demo->name);
        $form->text('name', 'Name')->rules('required|string');
        // $form->text('slug', 'Slug');
        // $form->number('sort', 'Sort')->default(9);
        $form->number('sort', '排序值')->default(9)->rules('required|integer|min:0')->help('默认倒序排列：数值越大越靠前');

        $form->divider();
        $form->hasMany('drafts', '素材 - 列表', function (NestedForm $form) {
            $form->text('name', '素材名称');
            // $form->image('thumb', '缩略图')->move('draft/thumbs' . date('Ym', now()->timestamp));
            $form->image('photo', '图片')->move('draft/photos' . date('Ym', now()->timestamp));
            $form->number('sort', '排序值')->default(9)->rules('required|integer|min:0')->help('默认倒序排列：数值越大越靠前');
        });

        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function (Form $form) {
            //
        });

        $form->saved(function (Form $form) {
            //
        });

        return $form;
    }
}
