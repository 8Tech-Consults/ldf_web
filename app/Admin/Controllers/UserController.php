<?php

namespace App\Admin\Controllers;

use App\Models\Location;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    // Function to override title
    public function title()
    {
        $segs = request()->segments();
        if (in_array('vets', $segs)) {
            return 'Vets';
        } else if (in_array('farmers', $segs)) {
            return 'Farmers';
        } else if (in_array('inputs', $segs)) {
            return 'Input Providers';
        } else {
            return 'Users';
        }
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $is_vet = false;
        $is_farmer = false;
        $is_input_provider = false;
        $slugs = request()->segments();

        // Handle categories
        if (in_array('vets', $slugs)) {
            $is_vet = true;
            $grid->model()->where('category', 'vet');
        }
        if (in_array('farmers', $slugs)) {
            $is_farmer = true;
            $grid->model()->where('category', 'farmer');
        }
        if (in_array('inputs', $slugs)) {
            $is_input_provider = true;
            $grid->model()->where('category', 'input');
        }

        $grid->disableBatchActions();
        $grid->column('avatar', __('Photo'))
            ->lightbox(['width' => 50, 'height' => 50]);

        $grid->quickSearch('name', 'email', 'phone_number_1', 'first_name', 'last_name')
            ->placeholder('Search by name, email, phone number, first name, last name');
        $grid->column('name', __('Name'))->sortable();
        $grid->column('email', __('Email'))->sortable();
        $grid->column('gender', __('Gender'))
            ->filter([
                'Male' => 'Male',
                'Female' => 'Female',
            ])->sortable()
            ->dot([
                'Male' => 'success',
                'Female' => 'danger',
            ]);
        $grid->column('phone_number_1', __('Phone Number'))->sortable();

        if ($is_farmer) {
            $grid->column('date_started_farming', __('Date started farming'))
                ->display(function ($date) {
                    return date('d-m-Y', strtotime($date));
                })->sortable();
            $grid->column('farmer_group', __('Farmer Group'))->sortable();
            $grid->column('land_ownership', __('Land Ownership'))->sortable();
            $grid->column('production_scale', __('Production Scale'))->sortable();
            $grid->column('access_to_credit', __('Access to credit'))
                ->label([
                    'Yes' => 'success',
                    'No' => 'danger',
                ])->sortable();
        }

        if ($is_vet) {
            $grid->column('license_number', __('License Number'))->sortable();
            $grid->column('license_expiry_date', __('License Expiry Date'))
                ->display(function ($date) {
                    return date('d-m-Y', strtotime($date));
                })->sortable();
            $grid->column('services_offered', __('Services Offered'))->sortable();
        }

        if ($is_input_provider) {
            $grid->column('business_phone_number', __('Business Phone Number'))->sortable();
            $grid->column('services_offered', __('Services Offered'))->sortable();
        }

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());
        $is_vet = false;
        $is_farmer = false;
        $is_input_provider = false;
        $slugs = request()->segments();

        if (in_array('vets', $slugs)) {
            $is_vet = true;
        } else if (in_array('farmers', $slugs)) {
            $is_farmer = true;
        } else if (in_array('inputs', $slugs)) {
            $is_input_provider = true;
        }

        if ($form->isCreating()) {
            if ($is_vet) {
                $form->hidden('category')->value('vet');
            } else if ($is_farmer) {
                $form->hidden('category')->value('farmer');
            } else if ($is_input_provider) {
                $form->hidden('category')->value('input');
            }
        }

        $form->text('first_name', __('First name'))->rules('required');
        $form->text('last_name', __('Last name'))->rules('required');
        $form->radio('marital_status', __('Marital status'))
            ->options(['married' => 'Married', 'single' => 'Single', 'divorced' => 'Divorced', 'widowed' => 'Widowed'])
            ->rules('required');
        $form->radio('highest_level_of_education', __('Highest level of education'))
            ->options(['primary' => 'Primary', 'secondary' => 'Secondary', 'tertiary' => 'Tertiary', 'none' => 'None'])
            ->rules('required');

        $form->text('phone_number_1', __('Phone number'))->rules('required');
        $form->text('secondary_phone_number', __('Alternative phone number'));
        $form->radio('gender', __('Gender'))->options(['Male' => 'Male', 'Female' => 'Female'])->rules('required');

        if ($is_vet) {
            $form->text('license_number', __('License number'));
            $form->date('license_expiry_date', __('License expiry date'));
            $form->text('services_offered', __('Services offered'));
        }

        if ($is_farmer) {
            $form->date('date_started_farming', __('Date started farming'));
            $form->radio('access_to_credit', __('Access to credit'))->options(['Yes' => 'Yes', 'No' => 'No'])->rules('required');
            $form->text('land_ownership', __('Land ownership'));
            $form->text('production_scale', __('Production scale'));
        }

        if ($is_input_provider) {
            $form->text('business_phone_number', __('Business phone number'));
            $form->text('services_offered', __('Services offered'));
        }

        $locations = [];
        foreach (
            Location::where(['details' => 'Subcounty'])
                ->orderby('name', 'asc')
                ->get() as $district
        ) {
            $locations[$district->id] = $district->name;
        }

        $form->select('sub_county_id', __('Sub county'))->options($locations)->rules('required')->required();

        return $form;
    }
}
