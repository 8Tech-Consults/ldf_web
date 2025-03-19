<?php

namespace App\Admin\Controllers;

use App\Models\ProductionRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;


class ProductionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ProductionRecord';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductionRecord());

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('farm_id', 'Farm')->select(\App\Models\Farm::pluck('name','id'));
            $filter->equal('breed_id', 'Breed')->select(\App\Models\Breed::pluck('name','id'));
            $filter->equal('production_type', 'Production Type')->select(['Egg' => 'Egg', 'Meat' => 'Meat']);
            $filter->between('created_at', 'Filter by date registered')->date();
        });

        $grid->model()->orderBy('updated_at', 'desc');

         //show a user only their records if they are not an admin
         if (!auth()->user()->inRoles(['administrator','ldf_admin'])) {
            $grid->model()->where('owner_id', auth()->user()->id);
        }

        // $grid->column('id', __('Id'));
        $grid->breed()->name('Breed');
        $grid->farm()->name('Farm');
        $grid->column('production_type', __('Production type'));
        $grid->column('weight', __('Weight'));
        $grid->column('daily_weight_gain', __('Daily weight gain'));
        $grid->column('quantity', __('Quantity'));
        $grid->column('quality', __('Quality'));
        $grid->column('value_addition', __('Value addition'));
       
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
        $show = new Show(ProductionRecord::findOrFail($id));

    
        $show->field('breed_id', __('Breed id'))->as(function ($breed_id) {
            return \App\Models\Breed::find($breed_id)?->name;
        });
        $show->field('farm_id', __('Farm id'))->as(function ($farm_id) {
            return \App\Models\Farm::find($farm_id)?->name;
        });
        $show->field('production_type', __('Production type'));
        $show->field('weight', __('Weight'));
        $show->field('daily_weight_gain', __('Daily weight gain'));
        $show->field('quantity', __('Quantity'));
        $show->field('quality', __('Quality'));
        $show->field('input_ratios', __('Input ratios'));
        $show->field('value_addition', __('Value addition'));
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
        $form = new Form(new ProductionRecord());
          //get users farms
          $user_id = auth()->user()->id;
          $farms = \App\Models\Farm::where('owner_id', $user_id)->pluck('name', 'id');

        $form->select('farm_id', __('Select Farm'))->options($farms);
        $form->select('breed_id', __('Select Breed'))->options(\App\Models\Breed::pluck('name', 'id'));
        $form->text('production_type', __('Production type'));
        $form->text('weight', __('Weight'));
        $form->text('daily_weight_gain', __('Daily weight gain'));
        $form->text('quantity', __('Quantity'));
        $form->text('quality', __('Quality'));
        $form->number('input_ratios', __('Input ratios'));
        $form->text('value_addition', __('Value addition'));
        $form->hidden('owner_id')->default(auth()->user()->id);

        return $form;
    }
}
