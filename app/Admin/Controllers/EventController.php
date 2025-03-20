<?php

namespace App\Admin\Controllers;

use App\Models\Event;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EventController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Animal Events';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Event());

        $grid->model()->latest();
        $grid->disableCreateButton();
        $grid->disableBatchActions();
        $grid->column('created_at', __('Date'))
            ->display(function ($created_at) {
                return date('d M, Y', strtotime($created_at));
            })
            ->sortable();
        $grid->column('animal_text', __('Animal'))
            ->sortable();
        $grid->column('type', __('Event Type'))
            ->label([
                'Birth' => 'info',
                'Death' => 'danger',
                'Sale' => 'success',
                'Vaccination' => 'warning',
                'Treatment' => 'primary',
                'Weighing' => 'default',
                'Milked' => 'success',
            ])
            ->filter([
                'Birth' => 'Birth',
                'Death' => 'Death',
                'Sale' => 'Sale',
                'Vaccination' => 'Vaccination',
                'Treatment' => 'Treatment',
                'Weighing' => 'Weighing',
                'Milked' => 'Milked',
            ]);

        $grid->column('farm_id', __('Farm id'));
        $grid->column('weight', __('Weight'));
        $grid->column('milk', __('Milk'));

        $grid->column('disease_text', __('Disease'))
            ->display(function ($disease_text) {
                if ($this->type == 'Treatment') {
                    return $disease_text;
                }
                return 'N/A';
            });


        $grid->column('drug', __('Drug'))
            ->display(function ($drug) {
                if ($this->type == 'Treatment') {
                    return $drug;
                }
                return 'N/A';
            });
        $grid->column('vaccine', __('Vaccine'))
            ->display(function ($vaccine) {
                if ($this->type == 'Vaccination') {
                    return $vaccine;
                }
                return 'N/A';
            });
        $grid->column('photo', __('Photo'))
            ->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('animal_text', __('Owner'))
            ->sortable()
            ->hide();
        $grid->column('detail', __('Details'));
        $grid->column('description', __('Description'))->hide();
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
        $show = new Show(Event::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('animal_id', __('Animal id'));
        $show->field('owner_id', __('Owner id'));
        $show->field('district_id', __('District id'));
        $show->field('sub_county_id', __('Sub county id'));
        $show->field('disease_id', __('Disease id'));
        $show->field('farm_id', __('Farm id'));
        $show->field('weight', __('Weight'));
        $show->field('milk', __('Milk'));
        $show->field('type', __('Type'));
        $show->field('detail', __('Detail'));
        $show->field('description', __('Description'));
        $show->field('drug', __('Drug'));
        $show->field('vaccine', __('Vaccine'));
        $show->field('photo', __('Photo'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Event());

        $form->number('animal_id', __('Animal id'));
        $form->textarea('owner_id', __('Owner id'));
        $form->textarea('district_id', __('District id'));
        $form->textarea('sub_county_id', __('Sub county id'));
        $form->textarea('disease_id', __('Disease id'));
        $form->textarea('farm_id', __('Farm id'));
        $form->textarea('weight', __('Weight'));
        $form->number('milk', __('Milk'));
        $form->text('type', __('Type'));
        $form->textarea('detail', __('Detail'));
        $form->textarea('description', __('Description'));
        $form->textarea('drug', __('Drug'));
        $form->textarea('vaccine', __('Vaccine'));
        $form->textarea('photo', __('Photo'));

        return $form;
    }
}
