<?php

namespace App\Admin\Controllers;

use App\Models\Cooperative;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Models\Utils;

class CooperativeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Cooperative';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Cooperative());
        
        $grid->filter(function ($f) {
            $f->disableIdFilter();
            $f->like('name', 'Name');
            $f->like('production_type', 'Production type');
            $f->between('created_at', 'Filter by date')->date();
        });

          //show a user only their records if they are not an admin
          if (!Admin::user()->inRoles(['administrator','ldf_admin'])) {
            $grid->model()->where('user_id', Admin::user()->id);
        }
        //disable batch actions
        $grid->disableBatchActions();

         //order of table
         $grid->model()->orderBy('id', 'desc');

         //disable action buttons appropriately
         Utils::disable_buttons('Vet', $grid);

      
        $grid->column('name', __('Name'));
        $grid->location()->name('SubCounty');
        $grid->column('village', __('Village'));
        $grid->column('parish', __('Parish'));
        $grid->column('zone', __('Zone'));
        $grid->column('production_type', __('Production type'));
        $grid->column('date_of_establishment', __('Date of establishment'));
        $grid->column('status', __('Status'));
                                                                                                                                           

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
        $show = new Show(Cooperative::findOrFail($id));
            //delete notification after viewing the form
            Utils::delete_notification('Cooperative', $id);
       
        $show->field('name', __('Name'));
        $show->field('location_id', __('SubCounty'));
        $show->field('village', __('Village'));
        $show->field('parish', __('Parish'));      
        $show->field('date_of_establishment', __('Date of establishment'));
        $show->field('certification', __('Certification'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        //disable edit and delete buttons
        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Cooperative());

        if($form->isCreating()){
            $form->hidden('status')->default('Pending');
            $form->hidden('user_id')->default(Admin::user()->id);
        }

        $form->text('name', __('Name'));
        $form->select('location_id', __('SubCounty'))->options(\App\Models\Location::where('parent','!=',0)->pluck('name', 'id'))->rules('required');
        $form->text('village', __('Village'))->rules('required');
        $form->text('parish', __('Parish'))->rules('required');
        $form->text('zone', __('Zone'))->rules('required');       
        $form->date('date_of_establishment', __('Date of establishment'))->rules('required');
        $form->file('certification', __('Certification'));
        $form->textarea('description', __('Description'));

         //check if the user is an admin and show the status field
         if (Admin::user()->inRoles(['administrator','ldf_admin'])) {
            $form->radioCard('status', __('Status'))->options(['halted' => 'Halted', 'approved' => 'Approved', 'rejected' => 'Rejected'])->rules('required');
        }
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
           
        });


        return $form;
    }
}
