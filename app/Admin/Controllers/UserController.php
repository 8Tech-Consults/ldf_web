<?php

namespace App\Admin\Controllers;

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

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('marital_status', __('Marital status'));
        $grid->column('highest_level_of_education', __('Highest level of education'));
        $grid->column('date_started_farming', __('Date started farming'));
        $grid->column('credit_institution', __('Credit institution'));
        $grid->column('access_to_credit', __('Access to credit'));
        $grid->column('production_scale', __('Production scale'));
        $grid->column('land_ownership', __('Land ownership'));
        $grid->column('is_land_owner', __('Is land owner'));
        $grid->column('secondary_phone_number', __('Secondary phone number'));
        $grid->column('primary_phone_number', __('Primary phone number'));
        $grid->column('farmer_group', __('Farmer group'));
        $grid->column('number_of_dependants', __('Number of dependants'));
        $grid->column('gender', __('Gender'));
        $grid->column('status', __('Status'));
        $grid->column('other_documents', __('Other documents'));
        $grid->column('nin_photo', __('Nin photo'));
        $grid->column('license_photo', __('License photo'));
        $grid->column('services_offered', __('Services offered'));
        $grid->column('postal_address', __('Postal address'));
        $grid->column('business_phone_number', __('Business phone number'));
        $grid->column('brief_profile', __('Brief profile'));
        $grid->column('date_of_registration', __('Date of registration'));
        $grid->column('license_expiry_date', __('License expiry date'));
        $grid->column('license_number', __('License number'));
        $grid->column('group_or_practice', __('Group or practice'));
        $grid->column('village', __('Village'));
        $grid->column('coordinates', __('Coordinates'));
        $grid->column('sub_county_text', __('Sub county text'));
        $grid->column('sub_county_id', __('Sub county id'));
        $grid->column('district_text', __('District text'));
        $grid->column('district_id', __('District id'));
        $grid->column('nin', __('Nin'));
        $grid->column('last_name', __('Last name'));
        $grid->column('first_name', __('First name'));
        $grid->column('category', __('Category'));
        $grid->column('title', __('Title'));
        $grid->column('phone_number_1', __('Phone number 1'));
        $grid->column('username', __('Username'));
        $grid->column('email', __('Email'));
        $grid->column('password', __('Password'));
        $grid->column('name', __('Name'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('marital_status', __('Marital status'));
        $show->field('highest_level_of_education', __('Highest level of education'));
        $show->field('date_started_farming', __('Date started farming'));
        $show->field('credit_institution', __('Credit institution'));
        $show->field('access_to_credit', __('Access to credit'));
        $show->field('production_scale', __('Production scale'));
        $show->field('land_ownership', __('Land ownership'));
        $show->field('is_land_owner', __('Is land owner'));
        $show->field('secondary_phone_number', __('Secondary phone number'));
        $show->field('primary_phone_number', __('Primary phone number'));
        $show->field('farmer_group', __('Farmer group'));
        $show->field('number_of_dependants', __('Number of dependants'));
        $show->field('gender', __('Gender'));
        $show->field('status', __('Status'));
        $show->field('other_documents', __('Other documents'));
        $show->field('nin_photo', __('Nin photo'));
        $show->field('license_photo', __('License photo'));
        $show->field('services_offered', __('Services offered'));
        $show->field('postal_address', __('Postal address'));
        $show->field('business_phone_number', __('Business phone number'));
        $show->field('brief_profile', __('Brief profile'));
        $show->field('date_of_registration', __('Date of registration'));
        $show->field('license_expiry_date', __('License expiry date'));
        $show->field('license_number', __('License number'));
        $show->field('group_or_practice', __('Group or practice'));
        $show->field('village', __('Village'));
        $show->field('coordinates', __('Coordinates'));
        $show->field('sub_county_text', __('Sub county text'));
        $show->field('sub_county_id', __('Sub county id'));
        $show->field('district_text', __('District text'));
        $show->field('district_id', __('District id'));
        $show->field('nin', __('Nin'));
        $show->field('last_name', __('Last name'));
        $show->field('first_name', __('First name'));
        $show->field('category', __('Category'));
        $show->field('title', __('Title'));
        $show->field('phone_number_1', __('Phone number 1'));
        $show->field('username', __('Username'));
        $show->field('email', __('Email'));
        $show->field('password', __('Password'));
        $show->field('name', __('Name'));
        $show->field('avatar', __('Avatar'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User());
        $is_vet = false;
        $slugs = request()->segments();
        //if contains vets
        if (in_array('vets', $slugs)) {
            $is_vet = true;
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
        }
        return $form;
        $form->text('date_started_farming', __('Date started farming'));
        $form->text('credit_institution', __('Credit institution'));
        $form->text('access_to_credit', __('Access to credit'));
        $form->text('land_ownership', __('Land ownership'));
        $form->text('production_scale', __('Production scale'));
        $form->text('is_land_owner', __('Is land owner'));
        $form->text('number_of_dependants', __('Number of dependants'));
        $form->text('farmer_group', __('Farmer group'));


        $form->text('status', __('Status'));
        $form->text('other_documents', __('Other documents'));
        $form->text('nin_photo', __('Nin photo'));
        $form->text('license_photo', __('License photo'));
        $form->text('services_offered', __('Services offered'));
        $form->text('postal_address', __('Postal address'));
        $form->text('business_phone_number', __('Business phone number'));
        $form->text('brief_profile', __('Brief profile'));
        $form->text('date_of_registration', __('Date of registration'));
        $form->text('license_expiry_date', __('License expiry date'));
        $form->text('license_number', __('License number'));
        $form->text('group_or_practice', __('Group or practice'));
        $form->text('village', __('Village'));
        $form->text('coordinates', __('Coordinates'));
        $form->text('sub_county_text', __('Sub county text'));
        $form->text('sub_county_id', __('Sub county id'));
        $form->text('district_text', __('District text'));
        $form->text('district_id', __('District id'));
        $form->text('nin', __('Nin'));

        $form->text('category', __('Category'));
        $form->text('title', __('Title'));


        $form->text('username', __('Username'));
        $form->email('email', __('Email'));
        $form->password('password', __('Password'));
        $form->text('name', __('Name'));
        $form->image('avatar', __('Avatar'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
