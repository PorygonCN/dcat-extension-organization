<?php

namespace Porygon\Organization\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Tree;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form as WidgetsForm;
use Porygon\Organization\Admin\Repositories\Department;
use Porygon\Organization\Models\Department as ModelsDepartment;
use Porygon\Organization\Models\Post;
use Porygon\User\Admin\Renderable\UserTable;
use Porygon\User\Models\User;

class DepartmentController extends AdminController
{

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description(trans('admin.list'))
            ->body(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new WidgetsForm();
                    $form->action(admin_route('organization.departments.store'));

                    $form->row(function (Form\Row $row) {
                        $row->width(6)->text('title');
                        $row->width(6)->icon('icon');
                    });
                    $form->row(function (Form\Row $row) {
                        $row->select('parent_id')->options(ModelsDepartment::selectOptions())->saving(function ($val) {
                            return $val ?? 0;
                        });
                    });
                    $form->row(function (Form\Row $row) {
                        $row->width(4)->switch('enable')->default(true);
                        $row->width(4)->switch('is_company');
                        $row->width(4)->switch('autonomy');
                    });

                    $column->append(Box::make(trans('admin.new'), $form));
                });
            });
    }

    /**
     * @return \Dcat\Admin\Tree
     */
    protected function treeView()
    {

        return new Tree(new Department(), function (Tree $tree) {
            $tree->disableCreateButton();
            $tree->disableQuickCreateButton();
            $tree->disableEditButton();
            $tree->maxDepth(30);

            $tree->actions(function (Tree\Actions $actions) {
                if ($actions->getRow()->extension) {
                    $actions->disableDelete();
                }
            });

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                return $payload;
            });
        });
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Department(), function (Grid $grid) {
            $grid->enableDialogCreate();
            $grid->column('title')->tree();
            $grid->order->orderable();
            $grid->column('is_company')->switch();
            $grid->column('autonomy')->switch();
            $grid->column('enable')->switch();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Department(), function (Show $show) {
            $show->field('id');
            $show->field('icon');
            $show->field('title');
            $show->field('parent_id');
            $show->field('order');
            $show->field('is_company');
            $show->field('autonomy');
            $show->field('enable');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(Department::with(["in_charge_persons"]), function (Form $form) {
            $form->row(function (Form\Row $row) {
                $row->width(6)->text('title');
                $row->width(6)->icon('icon');
            });
            $form->row(function (Form\Row $row) {
                $row->select('parent_id')->options(ModelsDepartment::selectOptions())->saving(function ($val) {
                    return $val ?? 0;
                });
            });
            $form->row(function (Form\Row $row) {
                $row->width(4)->switch('enable')->default(true);
                $row->width(4)->switch('is_company');
                $row->width(4)->switch('autonomy');
            });
            if ($form->isEditing()) {
                $form->row(function (Form\Row $row) {
                    $row->hasMany("in_charge_persons", "负责人", function (Form\NestedForm $form) {
                        $form->selectTable("user_id", "负责人")->required()
                            ->title('请选择负责人')
                            ->dialogWidth('70%') // 弹窗宽度，默认 800px
                            ->from(UserTable::make(['id' => $form->getKey()])) // 设置渲染类实例，并传递自定义参数
                            ->model(User::class, 'id', 'name');       // 设置编辑数据显示
                        $form->select("post_id", "职务")->options(Post::selectOptions())->required();
                    });
                });
            }
        });
    }
}
