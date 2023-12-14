<?php

namespace App\Admin\Controllers;

use App\Models\ServiceProvider;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Utils;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;


class ServiceProviderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Input Providers';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ServiceProvider());

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name', 'Name');
            $filter->like('owner_name', 'Owner name');
            $filter->like('class_of_service', 'Class of service');
            $filter->between('date_of_registration', 'Date of registration')->date();
            $filter->like('physical_address', 'Physical address');
            $filter->like('email', 'Email');
            $filter->like('postal_address', 'Postal address');
            $filter->like('other_services', 'Other services');
            $filter->like('distroict_of_operation', 'District of operation');
            $filter->like('tin_number_business', 'Tin number business');
            $filter->like('tin_number_owner', 'Tin number owner');
            $filter->between('created_at', 'Filter by date registered')->date();
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
        Utils::disable_buttons('ServiceProvider', $grid);

        $grid->column('logo', __('Logo'))->image();
        $grid->column('name', __('Name'));
        $grid->column('class_of_service', __('Class of service'));
        $grid->column('physical_address', __('Physical address'));
        $grid->column('primary_phone_number', __('Primary phone number'));
        $grid->column('email', __('Email'));
      
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
        $show = new Show(ServiceProvider::findOrFail($id));
         //delete notification after viewing the form
         Utils::delete_notification('ServiceProvider', $id);

     
        $show->field('name', __('Name'));
        $show->field('owner_name', __('Owner name'));
        $show->field('owner_profile', __('Owner profile'));
        $show->field('class_of_service', __('Class of service'));
        $show->field('date_of_registration', __('Date of registration'));
        $show->field('physical_address', __('Physical address'));
        $show->field('primary_phone_number', __('Primary phone number'));
        $show->field('secondary_phone_number', __('Alternative phone number'));
        $show->field('email', __('Email'));
        $show->field('postal_address', __('Postal address'));
        $show->field('other_services', __('Other services'));
        $show->field('logo', __('Logo'));
        $show->field('distroict_of_operation', __('Distroict of operation'));
        $show->field('NDA_registration_number', __('NDA registration number'))->file();
        $show->field('tin_number_business', __('Tin number business'));
        $show->field('tin_number_owner', __('Tin number owner'));
        $show->field('license', __('License'))->file();
        $show->field('other_documents', __('Other documents'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        
        //disable tools
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
        $form = new Form(new ServiceProvider());
        if($form->isCreating()){
            $form->hidden('status')->default('Pending');
            $form->hidden('user_id')->default(Admin::user()->id);
        }
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
           
        });


        $form->text('name', __('Name'))->rules('required');
        $form->text('owner_name', __('Owner name'))->rules('required');
        $form->textarea('owner_profile', __('Owner profile'))->rules('required');
        $form->textarea('class_of_service', __('Class of service'))->rules('required');
        $form->date('date_of_registration', __('Date of registration'))->rules('required|before_or_equal:today');
        $form->text('physical_address', __('Physical address'))->rules('required');
        $form->text('primary_phone_number', __('Primary phone number'))->rules('required');
        $form->text('secondary_phone_number', __('Alternative phone number'));
        $form->email('email', __('Email'));
        $form->text('postal_address', __('Postal address'));
        $form->text('other_services', __('Other services'));
        $form->image('logo', __('Logo'));
        $form->text('distroict_of_operation', __('District of operation'))->help('District of operation - sub county')->rules('required');
        $form->text('tin_number_business', __('Tin number business'))->rules('required');
        $form->text('tin_number_owner', __('Tin number owner'))->rules('required');
        $form->file('NDA_registration_number', __('NDA registration number'))->rules('required');
        $form->file('license', __('License'))->rules('required');
        $form->multipleFile('other_documents', __('Other documents'));

        //check if the user is an admin and show the status field
        if (Admin::user()->inRoles(['administrator','ldf_admin'])) {
        $form->radioCard('status', __('Status'))->options(['halted' => 'Halted', 'approved' => 'Approved', 'rejected' => 'Rejected'])->rules('required');
        }

        return $form;
    }
}
