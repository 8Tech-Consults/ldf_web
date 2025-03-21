<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Farmer\ApproveOrDeny;
use App\Admin\Actions\Farmer\Inspect;
use App\Models\Farmer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Support\Facades\Auth;

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
        
        $current_user = Auth::user();

        $grid->actions(function ($actions) use ($current_user) {
            if($current_user->isRole('ldf_admin') || $current_user->isRole('administrator')) {
                if ($actions->row->is_verified == 0 && $actions->row->agent_id == null) {
                    $actions->add(new Inspect);
                }
                if ($actions->row->is_verified == 0 && $actions->row->agent_remarks != null) {
                    $actions->add(new ApproveOrDeny);
                }
            }
            if ($current_user->isRole('agent')) {
                if ($actions->row->is_verified == 0 && $actions->agent_remarks == null && $actions->row->agent_id == $current_user->id) {
                    $actions->add(new ApproveOrDeny);
                }
            }

        });

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


        if($current_user->isRole('agent')) {
            $grid->model()->where('agent_id', $current_user->id)->latest();
        }else if($current_user->isRole('administrator')  || $current_user->isRole('ldf_admin')) {
            $grid->model()->latest();
        }else {
            $grid->model()->where('applicatant_id', $current_user->id)->latest();
        }

        $grid->column('id', __('Id'));
        $grid->column('is_verified', __('Is verified'))->display(function ($is_verified) {
            return $is_verified == 1 ? 'Yes' : 'No';
        });
        $grid->inspectingAgent()->name('Inspecting Agent');

        $grid->column('profile_picture', __('Profile picture'))->image();
        $grid->column('surname', __('Surname'));
        $grid->column('given_name', __('Given name'));
        $grid->column('date_of_birth', __('Date of birth'));
        $grid->column('nin', __('Nin'));
        $grid->location()->name('SubCounty');
        $grid->column('village', __('Village'));
        $grid->column('parish', __('Parish'));
        $grid->column('zone', __('Zone'));
        $grid->column('gender', __('Gender'));
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
        $grid->column('number_of_dependants', __('Number of dependants'));
        $grid->column('farmer_group', __('Farmer group'));
        $grid->column('primary_phone_number', __('Primary phone number'));
        $grid->column('secondary_phone_number', __('Alternative phone number'));
        $grid->column('is_land_owner', __('Is land owner'))->display(function ($is_land_owner) {
            return $is_land_owner == 1 ? 'Yes' : 'No';
        });
        $grid->column('production_scale', __('Production type'));
        $grid->column('access_to_credit', __('Access to credit'))->display(function ($access_to_credit) {
            return $access_to_credit == 1 ? 'Yes' : 'No';
        });
        $grid->column('date_started_farming', __('Date started farming'));
        $grid->column('highest_level_of_education', __('Highest level of education'));
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
        $show = new Show(Farmer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('profile_picture', __('Profile picture'));
        $show->field('surname', __('Surname'));
        $show->field('given_name', __('Given name'));
        $show->field('date_of_birth', __('Date of birth'));
        $show->field('nin', __('Nin'));
        $show->field('location_id', __('SubCounty'));
        $show->field('village', __('Village'));
        $show->field('parish', __('Parish'));
        $show->field('zone', __('Zone'));
        $show->field('gender', __('Gender'));
        $show->field('marital_status', __('Marital status'));
        $show->field('number_of_dependants', __('Number of dependants'));
        $show->field('farmer_group', __('Farmer group'));
        $show->field('primary_phone_number', __('Primary phone number'));
        $show->field('secondary_phone_number', __('Alternative phone number'));
        $show->field('is_land_owner', __('Is land owner'));
        $show->field('production_scale', __('Production type'));
        $show->field('access_to_credit', __('Access to credit'));
        $show->field('date_started_farming', __('Date started farming'));
        $show->field('highest_level_of_education', __('Highest level of education'));
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
        $form = new Form(new Farmer());

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
        $form->hidden('applicatant_id')->default(auth()->user()->id);


        $form->saving(function (Form $form) {
            if($form->isCreating()) {
                $form->applicatant_id = auth()->user()->id;
            }
        });
        return $form;
    }
}
