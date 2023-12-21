<?php

namespace App\Admin\Controllers;

use App\Models\Breed;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;

class BreedController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Breed';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Breed());

        // $grid->column('id', __('Id'));
        $grid->livestockType()->name('Livestock Type');
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        // $grid->column('image', __('Image'));
        $grid->column('created_at', __('Created at'))->display(function ($x) {
            $c = Carbon::parse($x);
        if ($x == null) {
            return $x;
        }
        return $c->format('d M, Y');
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($x) {
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
        $show = new Show(Breed::findOrFail($id));

        // $show->field('id', __('Id'));
        $show->field('livestock_type_name', __('Livestock Type'))->as(function ($livestock_type_name) {
            return $this->livestockType->name;
        });
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'));
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
        $form = new Form(new Breed());

        $form->select('livestock_type_id', __('Livestock Type'))->options(\App\Models\LivestockType::all()->pluck('name', 'id'))->rules('required');
        $form->text('name', __('Name'))->rules('required');
        $form->textarea('description', __('Description'));
        $form->image('image', __('Image'));

        return $form;
    }
}
