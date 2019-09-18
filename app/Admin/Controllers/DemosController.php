<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Administrator;
use App\Admin\Models\Demo;
// use App\Models\Demo;
use App\Http\Requests\Request;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DemosController extends AdminController
{
    use ValidatesRequests;

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
        $admin_user = Admin::user();
        if ($admin_user->isAdministrator()) {
            $grid->model()->orderBy('created_at', 'desc'); // 设置初始排序条件
        } else if ($admin_user->isRole(Administrator::ROLE_DESIGNER)) {
            $demo_ids = Administrator::find($admin_user->id)->demos->pluck('id')->toArray();
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

        $designers = Administrator::designers()->pluck('name', 'id')->toArray();
        $form->checkbox('designer_ids', 'Designers')->options($designers)->rules('required')->disable();
        $form->switch('scenario', 'Scenario')->states([
            'on' => ['value' => Demo::DEMO_SCENARIO_PC, 'text' => Demo::$demoScenarioMap[Demo::DEMO_SCENARIO_PC], 'color' => 'primary'],
            'off' => ['value' => Demo::DEMO_SCENARIO_MOBILE, 'text' => Demo::$demoScenarioMap[Demo::DEMO_SCENARIO_MOBILE], 'color' => 'default'],
        ])->default(Demo::DEMO_SCENARIO_PC);
        $form->text('name', 'Name')->rules('required|string');
        // $form->text('slug', 'Slug');
        // $form->textarea('description', 'Description')->rules('required|string');
        $form->editor('description', 'Description')->rules('required|string');
        $form->textarea('memo', '备注信息')->rules('string');

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
            ->header('发送站内信')
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
            ->row("<center><a href='/admin/demos'>返回 Demo 列表</a></center>");
    }
}
