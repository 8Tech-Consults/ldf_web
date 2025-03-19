<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Farmer\ApproveOrDeny;
use App\Admin\Actions\Farmer\Inspect;
use App\Models\Farmer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Utils;
use Encore\Admin\Facades\Admin;


class FarmerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Farmer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Farmer());
     
        $grid->filter(function ($f) {
            $f->disableIdFilter();
            $f->between('created_at', 'Filter by date')->date();
            $f->where(function ($query) {
                $query->where('surname', 'like', "%{$this->input}%")
                    ->orWhere('given_name', 'like', "%{$this->input}%")
                    ->orWhere('nin', 'like', "%{$this->input}%")
                    ->orWhere('primary_phone_number', 'like', "%{$this->input}%")
                    ->orWhere('secondary_phone_number', 'like', "%{$this->input}%");
            }, 'Search by name, nin, phone number');
            $f->equal('is_verified', 'Is verified')->select([0 => 'No', 1 => 'Yes']);

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

        $grid->column('profile_picture', __('Profile picture'))->image();
        $grid->column('surname', __('Surname'));
        $grid->column('given_name', __('Given name'));
        $grid->location()->name('SubCounty');
        $grid->column('marital_status', __('Marital status'))->display(function ($marital_status) {
            switch ($marital_status) {
                case 'S':
                    return 'Single';
                    break;
                case 'M':
                    return 'Married';
                    break;
                case 'D':
                    return 'Divorced';
                    break;
                case 'W':
                    return 'Widowed';
                    break;
                default:
                    return 'Unknown';
                    break;
            }
        });
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
        $show = new Show(Farmer::findOrFail($id));
         //delete notification after viewing the form
         Utils::delete_notification('Farmer', $id);

      
        $show->field('profile_picture', __('Profile picture'));
        $show->field('surname', __('Surname'));
        $show->field('given_name', __('Given name'));
        $show->field('date_of_birth', __('Date of birth'));
        $show->field('nin', __('Nin'));
        $show->field('location_id', __('SubCounty'));
        $show->field('village', __('Village'));
        $show->field('parish', __('Parish'));
        $show->field('zone', __('Zone'));
        $show->field('gender', __('Gender'))->as(function($gender){
            switch ($gender) {
                case 'F':
                    return 'Female';
                    break;
                case 'M':
                    return 'Male';
                    break;
                }

        });
        $show->field('marital_status', __('Marital status'))->as(function ($marital_status) {
            switch ($marital_status) {
                case 'S':
                    return 'Single';
                    break;
                case 'M':
                    return 'Married';
                    break;
                case 'D':
                    return 'Divorced';
                    break;
                case 'W':
                    return 'Widowed';
                    break;
                default:
                    return 'Unknown';
                    break;
            }
        });
        $show->field('number_of_dependants', __('Number of dependants'));
        $show->field('farmer_group', __('Farmer group'));
        $show->field('primary_phone_number', __('Primary phone number'));
        $show->field('secondary_phone_number', __('Alternative phone number'));
        $show->field('is_land_owner', __('Is land owner'))->as(function ($is_land_owner) {
            switch ($is_land_owner) {
                case 1:
                    return 'Yes';
                    break;
                case 0:
                    return 'No';
                    break;
                default:
                    return 'Unknown';
                    break;
            }
        });
        $show->field('production_scale', __('Production type'));
        $show->field('access_to_credit', __('Access to credit'))->as(function ($access_to_credit) {
            switch ($access_to_credit) {
                case 1:
                    return 'Yes';
                    break;
                case 0:
                    return 'No';
                    break;
                default:
                    return 'Unknown';
                    break;
            }
        });
        $show->field('date_started_farming', __('Date started farming'));
        $show->field('highest_level_of_education', __('Highest level of education'));
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
        $form = new Form(new Farmer());
        if($form->isCreating()){
            $form->hidden('status')->default('Pending');
            $form->hidden('user_id')->default(Admin::user()->id);
        }
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
           
        });

        $form->image('profile_picture', __('Profile picture'));
        $form->text('surname', __('Surname'))->rules('required');
        $form->text('given_name', __('Given name'))->rules('required');
        $form->date('date_of_birth', __('Date of birth'))->rules('required|before:today');
        $form->text('nin', __('Nin'))->rules('required');
        $form->select('location_id', __('SubCounty'))->options(\App\Models\Location::where('parent','!=',0)->pluck('name', 'id'))->rules('required');
        $form->text('village', __('Village'))->rules('required');
        $form->text('parish', __('Parish'))->rules('required');
        $form->text('zone', __('Zone'))->rules('required');
        $form->radio('gender', __('Gender'))->options(['M'=> 'Male', 'F' => 'Female'])->rules('required');
        $form->radio('marital_status', __('Marital status'))->options(['S'=> 'Single', 'M' => 'Married', 'D' => 'Divorced', 'W' => 'Widowed'])->rules('required');
        $form->text('number_of_dependants', __('Number of dependants'))->rules('required|numeric');
        $form->text('farmer_group', __('Farmer group'))->rules('required');
        $form->text('primary_phone_number', __('Phone number'))->rules('required');
        $form->text('secondary_phone_number', __('Other phone number'));
        $form->radio('is_land_owner', __('Do you own land ?'))->options([1=> 'Yes', 0 => 'No'])
            ->when(0, function (Form $form) {
                $form->select('land_ownership', __('Land ownership'))->options([
                    'Lease' => 'Lease',
                    'Rent' => 'Rent',
                    'Own' => 'Own',
                    'Other' => 'Other'
                ]);
            })
            ->rules('required');
        $form->select('production_scale', __('Production Type'))->options([
            'Small scale' => 'Small scale',
            'Medium scale' => 'Medium scale',
            'Large scale' => 'Large scale',
            'Commercial scale' => 'Commercial scale',
            'Other' => 'Other'
        ]);
        $form->radio('access_to_credit', __('Have you ever gotten credit?'))->options(['1'=> 'Yes', '0' => 'No'])
            ->when(1, function (Form $form) {
                $form->text('credit_institution', __('Credit institution'))->rules('required');
            })
        ->rules('required');
        $form->date('date_started_farming', __('Which year did you start farming?'))->default(date('Y'))->format('YYYY')->rules('required');
        $form->select('highest_level_of_education', __('Highest level of education'))
            ->options([
                'None' => 'None',
                'Primary' => 'Primary',
                'Secondary' => 'Secondary',
                'Tertiary' => 'Tertiary',
                'Bachelor' => 'Bachelor',
                'Masters' => 'Masters',
                'PhD' => 'PhD',
            ])->rules('required');

             //check if the user is an admin and show the status field
         if (Admin::user()->inRoles(['administrator','ldf_admin'])) {
            $form->radioCard('status', __('Status'))->options(['halted' => 'Halted', 'approved' => 'Approved', 'rejected' => 'Rejected'])->rules('required');
        }

      
        return $form;
    }
}
