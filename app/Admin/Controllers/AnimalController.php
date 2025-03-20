<?php

namespace App\Admin\Controllers;

use App\Models\Animal;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AnimalController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Animal';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Animal());
        $grid->model()->latest();
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->column('photo', __('Photo'))
            ->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('tag_number', __('Animal\'s Tag'))->sortable();
        $grid->column('farm_text', __('Farm'))->sortable();
        $grid->column('breed_text', __('Breed'))->sortable();
        $grid->column('dob', __('D.O.B'))->sortable();
        $grid->column('date_of_weaning', __('Date of weaning'));


        $grid->column('sex', __('Sex'))
            ->label([
                'Male' => 'info',
                'Female' => 'success'
            ])
            ->sortable();

        $grid->column('weight', __('Weight'))->sortable();
        $grid->column('type', __('Type'))->sortable()
            ->label([
                'Cattle' => 'info',
                'Goat' => 'success',
                'Sheep' => 'warning',
                'Pig' => 'danger',
                'Poultry' => 'primary',
            ]);
        $grid->column('status', __('Status'))
            ->dot([
                'Alive' => 'success',
                'Dead' => 'danger',
                'Sold' => 'info',
                'Stolen' => 'warning',
                'Lost' => 'danger',
            ])
            ->sortable()
            ->filter([
                'Alive' => 'Alive',
                'Dead' => 'Dead',
                'Sold' => 'Sold',
                'Stolen' => 'Stolen',
                'Lost' => 'Lost',
            ]);
        $grid->column('general_remarks', __('General remarks'))
            ->editable()
            ->sortable();
        $grid->column('health_status', __('Health status'))
            ->editable('select', [
                'Healthy' => 'Healthy',
                'Sick' => 'Sick',
                'Under treatment' => 'Under treatment',
                'Recovered' => 'Recovered',
                'Dead' => 'Dead',
            ])
            ->sortable();

        $grid->column('owner_text', __('Owner'));
        $grid->column('created_at', __('Registered On'))->display(function ($x) {
            $c = Carbon::parse($x);
            if ($x == null) {
                return $x;
            }
            return $c->format('d M, Y');
        })->sortable();

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
        $show = new Show(Animal::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('tag_number', __('Tag number'));
        $show->field('farm_id', __('Farm id'));
        $show->field('farm_text', __('Farm text'));
        $show->field('owner_id', __('Owner id'));
        $show->field('owner_text', __('Owner text'));
        $show->field('breed_id', __('Breed id'));
        $show->field('breed_text', __('Breed text'));
        $show->field('parents', __('Parents'));
        $show->field('dob', __('Dob'));
        $show->field('date_of_weaning', __('Date of weaning'));
        $show->field('name', __('Name'));
        $show->field('photo', __('Photo'));
        $show->field('sex', __('Sex'));
        $show->field('district_id', __('District id'));
        $show->field('district_text', __('District text'));
        $show->field('sub_county_id', __('Sub county id'));
        $show->field('sub_county_text', __('Sub county text'));
        $show->field('weight', __('Weight'));
        $show->field('type', __('Type'));
        $show->field('status', __('Status'));
        $show->field('general_remarks', __('General remarks'));
        $show->field('health_status', __('Health status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Animal());

        $form->textarea('tag_number', __('Tag number'));
        $form->textarea('farm_id', __('Farm id'));
        $form->textarea('farm_text', __('Farm text'));
        $form->textarea('owner_id', __('Owner id'));
        $form->textarea('owner_text', __('Owner text'));
        $form->textarea('breed_id', __('Breed id'));
        $form->textarea('breed_text', __('Breed text'));
        $form->textarea('parents', __('Parents'));
        $form->textarea('dob', __('Dob'));
        $form->textarea('date_of_weaning', __('Date of weaning'));
        $form->textarea('name', __('Name'));
        $form->textarea('photo', __('Photo'));
        $form->textarea('sex', __('Sex'));
        $form->textarea('district_id', __('District id'));
        $form->textarea('district_text', __('District text'));
        $form->textarea('sub_county_id', __('Sub county id'));
        $form->textarea('sub_county_text', __('Sub county text'));
        $form->textarea('weight', __('Weight'));
        $form->text('type', __('Type'))->default('Cattle');
        $form->text('status', __('Status'))->default('Alive');
        $form->textarea('general_remarks', __('General remarks'));
        $form->textarea('health_status', __('Health status'));

        return $form;
    }
}
