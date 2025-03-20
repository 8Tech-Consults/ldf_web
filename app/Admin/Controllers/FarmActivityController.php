<?php

namespace App\Admin\Controllers;

use App\Models\FarmActivity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FarmActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Farm Activities';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FarmActivity());

        $grid->model()->latest();
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->quickSearch('name')->placeholder('Search by activity');
        $grid->column('created_at', __('Date'))
            ->display(function ($created_at) {
                return date('d M, Y', strtotime($created_at));
            })
            ->sortable();

        $grid->column('name', __('Activity'))
            ->sortable();
        $grid->column('scheduled_at', __('Scheduled at'))
            ->display(function ($scheduled_at) {
                return date('d M, Y', strtotime($scheduled_at));
            })->sortable();
        $grid->column('farm_text', __('Farm'))
            ->sortable();

        $grid->column('description', __('Details'))->limit(30)->sortable();
        $grid->column('user_text', __('Assigned to'))->sortable();
        $grid->column('type', __('Activity Type'))->sortable();
        $grid->column('status', __('Status'))->sortable()
            ->label([
                'Pending' => 'info',
                'In Progress' => 'warning',
                'Completed' => 'success',
                'Cancelled' => 'danger',
            ]);
        $grid->column('outcome', __('Outcome'));
        $grid->column('photos', __('Photos'));

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
        $show = new Show(FarmActivity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('farm_id', __('Farm id'));
        $show->field('farm_text', __('Farm text'));
        $show->field('name', __('Name'));
        $show->field('scheduled_at', __('Scheduled at'));
        $show->field('description', __('Description'));
        $show->field('user_id', __('User id'));
        $show->field('user_text', __('User text'));
        $show->field('type', __('Type'));
        $show->field('status', __('Status'));
        $show->field('outcome', __('Outcome'));
        $show->field('photos', __('Photos'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FarmActivity());

        $form->textarea('farm_id', __('Farm id'));
        $form->textarea('farm_text', __('Farm text'));
        $form->textarea('name', __('Name'));
        $form->textarea('scheduled_at', __('Scheduled at'));
        $form->textarea('description', __('Description'));
        $form->textarea('user_id', __('User id'));
        $form->textarea('user_text', __('User text'));
        $form->textarea('type', __('Type'));
        $form->textarea('status', __('Status'));
        $form->textarea('outcome', __('Outcome'));
        $form->textarea('photos', __('Photos'));

        return $form;
    }
}
