<?php

namespace App\Admin\Controllers;

use App\Models\AnimalHealthRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;


class AnimalHealthController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Animal Health Record';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AnimalHealthRecord());

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('diagnosis', 'Diagnosis');
            $filter->like('treatment', 'Treatment');
            $filter->equal('record_type', 'Record Type')->select(['Treatment' => 'Treatment', 'Diagnosis' => 'Diagnosis']);
            $filter->equal('animal_id', 'Animal')->select(\App\Models\Animal::pluck('tag_number','id'));
            $filter->equal('recorded_by', 'Recorded By')->select(\App\Models\User::pluck('name','id'));
            $filter->between('date', 'Date')->date();
        });

        $grid->model()->orderBy('date', 'desc');

        //show a user only their records if they are not an admin
        if (!auth()->user()->inRoles(['administrator','ldf_admin'])) {
            $grid->model()->where('owner_id', auth()->user()->id);
        }

        // $grid->column('id', __('Id'));
        $grid->column('date', __('Date'));
        $grid->column('record_type', __('Record type'));
        $grid->animal()->tag_number('Animal');
        $grid->column('diagnosis', __('Diagnosis'));
        $grid->column('treatment', __('Treatment'));
        $grid->recordedBy()->name('Recorded by');
        

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
        $show = new Show(AnimalHealthRecord::findOrFail($id));

        // $show->field('id', __('Id'));
        $show->field('date', __('Date'));
        $show->field('record_type', __('Record type'));
        $show->field('animal_id', __('Animal id'));
        $show->field('diagnosis', __('Diagnosis'));
        $show->field('treatment', __('Treatment'));
        $show->field('recorded_by', __('User id'));
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
        $form = new Form(new AnimalHealthRecord());
        $user_id = auth()->user()->id;
        $users_animals = \App\Models\Animal::where('owner_id', $user_id)->pluck('tag_number','id');
        

        $form->text('record_type', __('Record type'))->rules('required');
        $form->date('date', __('Date'))->default(date('Y-m-d'))->rules('required');
        $form->select('animal_id', __('Select Animal'))->options($users_animals)->rules('required');
        $form->textarea('diagnosis', __('Diagnosis'));
        $form->textarea('treatment', __('Treatment'));
        $form->select('status', __('Status'))->options(
            ['Sick' => 'Sick', 
            'Healthy' => 'Healthy',
            'Recovered' => 'Recovered',
            'Under Observation' => 'Under Observation',
            'Euthanized' => 'Euthanized',
            'Dead' => 'Dead',
            'Unknown' => 'Unknown'

            ])->rules('required');
        $form->hidden('recorded_by');
        $form->hidden('owner_id');

        $form->saving(function (Form $form) {
            $form->recorded_by = auth()->user()->id;
            //get the owner of the animal
            $animal = \App\Models\Animal::find($form->animal_id);
            $owner_id = $animal->owner_id;
            $form->owner_id = $owner_id;
        });

        return $form;
    }
}
