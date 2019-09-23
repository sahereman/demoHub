<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Administrator;
use App\Admin\Models\Demo;
use App\Http\Requests\Request;
// use App\Models\Demo;
use App\Models\Category;
use Encore\Admin\Actions\Response;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Form\Builder;
use Encore\Admin\Form\NestedForm;
// use Encore\Admin\Form\Tools;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
// use Encore\Admin\Show\Tools;
use Encore\Admin\Widgets\Table;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DemosController extends AdminController
{
    use ValidatesRequests;

    protected $mode = 'create';
    protected $demo_id;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Demo';

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
        $this->demo_id = $id;
        $demo = Demo::find($id);
        $admin_user = Admin::user();
        // $admin_user = Administrator::find($admin_user->id);
        if (!$admin_user->isAdministrator() && !$admin_user->hasAccessToDemo($demo)) {
            // $response = new Response();
            // return $response->swal()->error(trans('admin.deny'))->send();
            // return $response->toastr()->error(trans('admin.deny'))->send();
            // response(Admin::content()->withError(trans('admin.deny')));
            abort(403, trans('admin.deny'));
        }

        $this->mode = Builder::MODE_EDIT;

        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Demo);

        $admin_user = Admin::user();
        if ($admin_user->isAdministrator()) {
            $grid->model()->orderBy('created_at', 'desc'); // 设置初始排序条件
        } else if ($admin_user->isRole(Administrator::ROLE_DESIGNER)) {
            // $demo_ids = Administrator::find($admin_user->id)->demos->pluck('id')->toArray();
            $demo_ids = $admin_user->demos->pluck('id')->toArray();
            $grid->model()->orderBy('created_at', 'desc')->whereIn('id', $demo_ids); // 设置初始排序条件
        }

        /*筛选*/
        $grid->filter(function ($filter) {
            $filter->disableIDFilter(); // 去掉默认的id过滤器
            $filter->like('name', 'Name');
        });

        $grid->column('id', 'ID')->sortable();
        $grid->column('scenario', 'Scenario')->switch([
            'on' => ['value' => Demo::DEMO_SCENARIO_PC, 'text' => Demo::$demoScenarioMap[Demo::DEMO_SCENARIO_PC], 'color' => 'primary'],
            'off' => ['value' => Demo::DEMO_SCENARIO_MOBILE, 'text' => Demo::$demoScenarioMap[Demo::DEMO_SCENARIO_MOBILE], 'color' => 'default'],
        ])->sortable();
        $grid->column('name', 'Name')->sortable();
        // $grid->column('slug', 'Slug');
        // $grid->column('description', 'Description');
        // $grid->column('memo', '备注信息');
        // $grid->column('created_at', 'Created at');
        // $grid->column('updated_at', 'Updated at');
        $grid->column('designers', 'Designers')->display(function ($designers) {
            return count($designers);
        });
        $grid->column('categories', '素材分类')->display(function ($categories) {
            return count($categories);
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
        $show = new Show(Demo::findOrFail($id));

        $demo = Demo::find($id);
        $admin_user = Admin::user();
        // $admin_user = Administrator::find($admin_user->id);
        if (!$admin_user->isAdministrator() && !$admin_user->hasAccessToDemo($demo)) {
            // $response = new Response();
            // return $response->swal()->error(trans('admin.deny'))->send();
            // return $response->toastr()->error(trans('admin.deny'))->send();
            // response(Admin::content()->withError(trans('admin.deny')));
            abort(403, trans('admin.deny'));
        }

        $show->panel()->tools(function (Show\Tools $tools) use ($id) {
            // $tools->disableList();
            // $tools->disableEdit();
            // $tools->disableDelete();
            // $tools->prepend('<div class="btn-group pull-right" style="margin-right: 5px">'
            $tools->append('<div class="btn-group pull-right" style="margin-right: 5px">'
                // . '<a href="/admin/categories?demo_id=' . $id . '" class="btn btn-sm btn-success">'
                . '<a href="' . route('categories.index', ['demo_id' => $id]) . '" class="btn btn-sm btn-success">'
                . '<i class="fa fa-archive"></i>&nbsp;素材管理'
                . '</a>'
                . '</div>&nbsp;');
        });

        // $show->field('id', 'ID');
        $show->field('designers', 'Designers')->as(function ($designers) {
            $designer_names = '';
            foreach ($designers as $designer) {
                $designer_names .= $designer['name'] . ' & ';
            }
            return substr($designer_names, 0, -3);
        });
        $show->field('scenario', 'Scenario')->using(Demo::$demoScenarioMap)->setWidth(1);
        $show->field('name', 'Name')->setWidth(3);
        // $show->field('slug', 'Slug');
        $show->field('description', 'Description');
        $show->field('memo', '备注信息');
        $show->field('created_at', 'Created at');
        $show->field('updated_at', 'Updated at');

        $show->divider();
        $show->categories('素材分类 - 列表', function ($category) {
            /*禁用*/
            $category->disableActions();
            $category->disableRowSelector();
            $category->disableExport();
            $category->disableFilter();
            $category->disableCreateButton();
            $category->disablePagination();

            // $category->resource('/admin/categories');

            $category->column('name', '素材分类名称');
            $category->column('drafts', '素材')->display(function ($drafts) {
                return count($drafts);
            });
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
        $form = new Form(new Demo);
        $form->html('<button class="btn btn-primary"><i class="fa fa-send"></i>&nbsp;提交</button>');

        if ($this->mode == Builder::MODE_EDIT) {
            $demo_id = $this->demo_id;
            $form->tools(function (Form\Tools $tools) use ($demo_id) {
                // $tools->disableList();
                // $tools->disableView();
                // $tools->disableDelete();
                // $tools->prepend('<div class="btn-group pull-right" style="margin-right: 5px">'
                $tools->append('<div class="btn-group pull-right" style="margin-right: 5px">'
                    // . '<a href="/admin/categories?demo_id=' . $id . '" class="btn btn-sm btn-success">'
                    . '<a href="' . route('categories.index', ['demo_id' => $demo_id]) . '" class="btn btn-sm btn-success">'
                    . '<i class="fa fa-archive"></i>&nbsp;素材管理'
                    . '</a>'
                    . '</div>&nbsp;');
            });
            $demo = Demo::with('designers')->find($this->demo_id);
            $admin_user = Admin::user();
            // $admin_user = Administrator::find($admin_user->id);
            if ($admin_user->isAdministrator()) {
                $designers = Administrator::designers()->pluck('name', 'id')->toArray();
                $form->checkbox('designer_ids', 'Designers')->options($designers)->rules('nullable');
            } else if ($admin_user->hasAccessToDemo($demo)) {
                $designers = $demo->designers->pluck('name', 'id')->toArray();
                $form->checkbox('designer_ids', 'Designers')->options($designers)->rules('nullable')->disable();
            } else {
                abort(403, trans('admin.deny'));
            }
        } else if ($this->mode == Builder::MODE_CREATE) {
            $admin_user = Admin::user();
            // $admin_user = Administrator::find($admin_user->id);
            if ($admin_user->isAdministrator()) {
                $designers = Administrator::designers()->pluck('name', 'id')->toArray();
                $form->checkbox('designer_ids', 'Designers')->options($designers)->rules('nullable');
            }
        } else {
            abort(403, trans('admin.deny'));
        }

        $form->switch('scenario', 'Scenario')->states([
            'on' => ['value' => Demo::DEMO_SCENARIO_PC, 'text' => Demo::$demoScenarioMap[Demo::DEMO_SCENARIO_PC], 'color' => 'primary'],
            'off' => ['value' => Demo::DEMO_SCENARIO_MOBILE, 'text' => Demo::$demoScenarioMap[Demo::DEMO_SCENARIO_MOBILE], 'color' => 'default'],
        ])->default(Demo::DEMO_SCENARIO_PC);
        $form->text('name', 'Name')->rules('required|string');
        // $form->text('slug', 'Slug');
        // $form->textarea('description', 'Description')->rules('required|string');
        $form->editor('description', 'Description')->rules('required|string');
        $form->textarea('memo', '备注信息')->rules('string');

        $form->divider();
        $form->hasMany('categories', '素材分类 - 列表', function (NestedForm $form) {
            $form->text('name', '商品参数名称');
            $form->number('sort', '排序值')->default(9)->rules('required|integer|min:0')->help('默认倒序排列：数值越大越靠前');
        });

        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function (Form $form) {
            //
        });

        $form->saved(function (Form $form) {
            /*$demo_id = $form->model()->id;
            $demo = Demo::with('designers')->find($demo_id);
            $designer_ids = request()->input('designer_ids', []);
            $key = array_search(NULL, $designer_ids, true);
            if ($key !== false) {
                unset($designer_ids[$key]);
            }
            $demo->designers()->sync($designer_ids);*/
        });

        return $form;
    }

    // GET: Demo Assignment 页面
    public function assignmentShow(Content $content)
    {
        return $content
            ->header('Demo Assignment')
            ->body($this->assignmentForm());
    }

    protected function assignmentForm()
    {
        $form = new Form(new Administrator());

        $form->setAction(route('admin.demos.assignment.store'));

        $form->tools(function (Form\Tools $tools) {
            $tools->disableList();
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->select('demo_id')->options(Demo::all()->pluck('name', 'id'));

        $form->listbox('designer_ids', '选择设计师')->options(Administrator::designers()->pluck('name', 'id'));

        return $form;
    }

    // POST: Demo Assignment 请求处理
    public function assignmentStore(Request $request, Content $content)
    {
        $data = $this->validate($request, [
            'designer_ids' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (Administrator::whereIn('id', request()->input($attribute))->count() == 0) {
                        $fail('请选择设计师');
                    }
                },
            ],
            'demo_id' => 'required|integer'
        ], [], [
            'designer_ids' => '设计师 IDs',
            'demo_id' => 'Demo'
        ]);

        $demo_id = $data['demo_id'];
        $designer_ids = $data['designer_ids'];
        $key = array_search(NULL, $designer_ids, true);
        if ($key !== false) {
            unset($designer_ids[$key]);
        }
        $demo = Demo::find($demo_id);
        $demo->designers()->sync($designer_ids);

        return $content
            ->row("<center><h3>Demo Assigned Successfully</h3></center>")
            // ->row("<center><a href='/admin/demos'>返回 Demo 列表</a></center>");
            ->row("<center><a href='" . route('demos.index') . "'>返回 Demo 列表</a></center>");
    }
}
