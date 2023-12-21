<?php

namespace App\Admin\Controllers;

use App\Models\Animal;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;


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

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('tag_number', 'Tag Number');
            $filter->equal('farm_id', 'Farm')->select(\App\Models\Farm::pluck('name','id'));
            $filter->equal('breed_id', 'Breed')->select(\App\Models\Breed::pluck('name','id'));
            $filter->between('dob', 'Date of Birth')->date();
            $filter->between('date_of_weaning', 'Date of Weaning')->date();
        });

        $grid->model()->orderBy('updated_at', 'desc');

        //show a user only their records if they are not an admin
        if (!auth()->user()->inRoles(['administrator','ldf_admin'])) {
            $grid->model()->where('owner_id', auth()->user()->id);
        }

        // $grid->column('id', __('Id'));
        $grid->column('tag_number', __('Tag Number'));
        $grid->farm()->name('Farm');
        $grid->breed()->name('Breed');
        $grid->column('parents', __('Parents'));
        $grid->column('dob', __('Dob'));
        $grid->column('date_of_weaning', __('Date of weaning'));
        $grid->column('created_at', __('Created at'))->display(function ($x) {
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
        $show = new Show(Animal::findOrFail($id));

        
        $show->field('tag_number', __('Tag Number'));
        $show->field('farm_id', __('Farm id'))->as(function ($farm_id) {
            return \App\Models\Farm::find($farm_id)->name;
        });
        $show->field('breed_id', __('Breed id'))->as(function ($breed_id) {
            return \App\Models\Breed::find($breed_id)->name;
        });
        $show->field('parents', __('Parents'));
        $show->field('dob', __('Dob'));
        $show->field('date_of_weaning', __('Date of weaning'));
      

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
       
        //get users farms
        $user_id = auth()->user()->id;
        $farms = \App\Models\Farm::where('owner_id', $user_id)->pluck('name', 'id');
     
        $form->select('farm_id', __('Select Farm'))->options($farms)->rules('required');
        $form->text('tag_number', __('Tag Number'));
        $form->select('breed_id', __('Select Breed'))->options(\App\Models\Breed::pluck('name', 'id'))->rules('required');
        $form->text('parents', __('Parents')); //TODO: Add a select2 dropdown for this
        $form->datetime('dob', __('Date Of Birth'));
        $form->date('date_of_weaning', __('Date of weaning'));
        $form->hidden('owner_id')->default($user_id);

        $form->saving(function (Form $form) {
            // Check if the tag number, breed and farm combination already exists
            if(Animal::where('tag_number', $form->tag_number)->where('breed_id', $form->breed_id)->where('farm_id', $form->farm_id)->exists()) {
                admin_error('Animal already exists', 'Please check the tag number, breed and farm combination.');
                return back();
            }
            
        });

        return $form;
    }
}
