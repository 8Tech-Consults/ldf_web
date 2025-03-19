<?php

namespace App\Admin\Controllers;

use App\Models\VectorAndDisease;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;


class VectorAndDiseaseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pests And Disease';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VectorAndDisease());

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('farm_id', 'Farm')->select(\App\Models\Farm::pluck('name', 'id'));
            $filter->equal('animal_id', 'Animal')->select(\App\Models\Animal::pluck('tag_number', 'id'));
            $filter->between('date', 'Reported On')->date();
        });

        $grid->model()->orderBy('updated_at', 'desc');

        $grid->column('date', __('Reported On'));
        $grid->farm()->name('Farm');
        $grid->animal()->tag_number('Animal');
        // $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        // $grid->column('image', __('Image'));
        // $grid->column('description', __('Description'));
        // $grid->column('created_at', __('Created at'))->display(function ($x) {
        //     $c = Carbon::parse($x);
        // if ($x == null) {
        //     return $x;
        // }
        // return $c->format('d M, Y');
        // });
        // $grid->column('updated_at', __('Updated at'))->display(function ($x) {
        //     $c = Carbon::parse($x);
        // if ($x == null) {
        //     return $x;
        // }
        // return $c->format('d M, Y');
        // });

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
        $show = new Show(VectorAndDisease::findOrFail($id));

        $show->field('date');
        $show->field('farm_id', __('Farm'))->as(function ($farm_id) {
            return \App\Models\Farm::find($farm_id)?->name;
        });
        // $show->field('animal_id', __('Animal'))->as(function ($animal_id) {
        //     return \App\Models\Animal::find($animal_id)?->tag_number;
        // });
        // $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->image()->image();
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
        $form = new Form(new VectorAndDisease());

         //get users farms
         $user_id = auth()->user()->id;
         $farms = \App\Models\Farm::where('owner_id', $user_id)->pluck('name', 'id');

        $form->date('date', __('Date'))->default(date('Y-m-d'))->rules('required');
        $form->select('farm_id', __('Farm'))->options($farms)->rules('required');
       // $form->select('animal_id', __('Animal'))->options(\App\Models\Animal::pluck('tag_number', 'id'));
        $form->text('name', __('Name'))->rules('required');
        $form->image('image', __('Image'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
