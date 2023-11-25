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



        // $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('image', __('Image'));
        $grid->column('description', __('Description'));
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
        $show = new Show(VectorAndDisease::findOrFail($id));

        // $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));
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

        $form->text('name', __('Name'));
        $form->image('image', __('Image'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
