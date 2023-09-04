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
use Porygon\Organization\Admin\Repositories\Post;
use Porygon\Organization\Models\Post as ModelsPost;

class PostController extends AdminController
{
    protected $translation = "p-organization::post";

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description(trans('admin.list'))
            ->body(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new WidgetsForm();
                    $form->action(admin_route('organization.posts.store'));

                    $form->row(function (Form\Row $row) {
                        $row->select('parent_id')->options(ModelsPost::selectOptions())->saving(function ($val) {
                            return $val ?? 0;
                        });
                        $row->width(8)->text('title');
                        $row->width(4)->switch('enable')->default(true);
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

        return new Tree(new Post(), function (Tree $tree) {
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
                $payload = "<strong>{$branch['title']}</strong>";

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
        return Grid::make(new Post(), function (Grid $grid) {
            $grid->enableDialogCreate();
            $grid->column('title')->tree();
            $grid->order->orderable();
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
        return Show::make($id, new Post(), function (Show $show) {
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
        return Form::make(new Post(), function (Form $form) {
            $form->row(function (Form\Row $row) {
                $row->width(6)->text('title');
                $row->width(6)->switch('enable')->default(true);

                $row->select('parent_id')->options(ModelsPost::selectOptions())->saving(function ($val) {
                    return $val ?? 0;
                });
            });
        });
    }
}
