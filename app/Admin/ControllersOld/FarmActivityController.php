<?php

namespace App\Admin\Controllers;

use App\Models\FarmActivity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

class FarmActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'FarmActivity';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FarmActivity());

        $grid->model()->orderBy('updated_at', 'desc');

         //show a user only their records if they are not an admin
         if (!auth()->user()->inRoles(['administrator','ldf_admin'])) {
            $grid->model()->where('user_id', auth()->user()->id);
        }
        
        $grid->column('farm_id', __('Farm id'))->display(function ($farm_id) {
            return \App\Models\Farm::find($farm_id)?->name;
        });
        $grid->column('name', __('Activity title'));
        $grid->column('scheduled_at', __('Scheduled for'))->display(function ($x) {
            $c = Carbon::parse($x);
        if ($x == null) {
            return $x;
        }
        return $c->format('d M, Y');
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
        $show = new Show(FarmActivity::findOrFail($id));

        $show->field('farm_id', __('Farm id'))->as(function ($farm_id) {
            return \App\Models\Farm::find($farm_id)?->name;
        });
        $show->field('name', __('Activity title'));
        $show->field('scheduled_at', __('Scheduled for'));
        $show->field('description', __('Description'));
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
        $form = new Form(new FarmActivity());
        //get users farms
        $user_id = auth()->user()->id;
        $farms = \App\Models\Farm::where('owner_id', $user_id)->pluck('name', 'id');

        $form->select('farm_id', __('Select Farm'))->options($farms);
        $form->text('name', __('Activity title'));
        $form->datetime('scheduled_at', __('Scheduled at'))->default(date('Y-m-d H:i:s'));
        $form->textarea('description', __('Description'));
        $form->hidden('user_id')->default(auth()->user()->id);

        
        return $form;
    }
}
