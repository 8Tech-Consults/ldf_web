<?php

namespace App\Admin\Controllers;

use App\Models\Farm;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FarmController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Farm';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Farm());
        $grid->disableCreateButton();
        $grid->disableBatchActions();
        $grid->model()->latest();
        $grid->quickSearch('name')->placeholder('Search by farm name');
        $grid->column('name', __('Farm Name'));
        $grid->column('coordinates', __('GPS Coordinates'))->display(function ($coordinates) {
            return "<a href='https://www.google.com/maps/search/?api=1&query=$coordinates' target='_blank'>$coordinates</a>";
        })->sortable()->copyable();
        $grid->column('livestock_type', __('Livestock Type'))
            ->display(function ($livestock_type) {
                //check if is json
                if (json_decode($livestock_type)) {
                    $livestock_type = json_decode($livestock_type);
                    $livestock_type = implode(", ", $livestock_type);
                }
                return $livestock_type;
            })
            ->sortable();

        $grid->column('date_of_establishment', __('Date of establishment'))
            ->display(function ($date_of_establishment) {
                return date('d M, Y', strtotime($date_of_establishment));
            })
            ->sortable();
        $grid->column('size', __('Size'))
            ->display(function ($size) {
                return $size . ' Acres';
            })
            ->sortable();

        $grid->column('number_of_animals', __('Number of animals'))
            ->display(function ($number_of_animals) {
                return number_format($number_of_animals);
            })
            ->sortable();
        $grid->column('number_of_workers', __('Number of workers'))
            ->display(function ($number_of_workers) {
                return number_format($number_of_workers);
            })
            ->sortable();
        //rent or own
        $grid->column('land_ownership', __('Land ownership'))
            ->display(function ($land_ownership) {
                return $land_ownership;
            })
            ->sortable();
        $grid->column('farm_structures', __('Farm structures'))->hide();
        $grid->column('general_remarks', __('General remarks'))->hide();
        $grid->column('added_by', __('Added by'))->hide();
        $grid->column('owner_id', __('Owner'))
            ->display(function ($owner_id) {
                $u = \App\Models\User::find($owner_id);
                if ($u) {
                    return $u->name;
                }
                return "#$owner_id";
            })
            ->sortable();
        $grid->column('sub_county_text', __('Subcounty'))
            ->sortable()
            ->filter('like');
        $grid->column('village', __('Village'))->sortable()->filter('like');
        $grid->column('created_at', __('Registered'))
            ->display(function ($created_at) {
                return date('d M, Y', strtotime($created_at));
            })
            ->sortable()
            ->filter('range');


 

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
        $show = new Show(Farm::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('coordinates', __('Coordinates'));
        $show->field('livestock_type', __('Livestock type'));
        $show->field('production_type', __('Production type'));
        $show->field('date_of_establishment', __('Date of establishment'));
        $show->field('size', __('Size'));
        $show->field('profile_picture', __('Profile picture'));
        $show->field('number_of_animals', __('Number of animals'));
        $show->field('farm_structures', __('Farm structures'));
        $show->field('general_remarks', __('General remarks'));
        $show->field('added_by', __('Added by'));
        $show->field('owner_id', __('Owner id'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('location_id', __('Location id'));
        $show->field('location_text', __('Location text'));
        $show->field('village', __('Village'));
        $show->field('parish', __('Parish'));
        $show->field('zone', __('Zone'));
        $show->field('number_of_livestock', __('Number of livestock'));
        $show->field('number_of_workers', __('Number of workers'));
        $show->field('land_ownership', __('Land ownership'));
        $show->field('no_land_ownership_reason', __('No land ownership reason'));
        $show->field('owner_text', __('Owner text'));
        $show->field('district_id', __('District id'));
        $show->field('district_text', __('District text'));
        $show->field('sub_county_id', __('Sub county id'));
        $show->field('sub_county_text', __('Sub county text'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Farm());

        $form->textarea('name', __('Name'));
        $form->textarea('coordinates', __('Coordinates'));
        $form->textarea('livestock_type', __('Livestock type'));
        $form->textarea('production_type', __('Production type'));
        $form->textarea('date_of_establishment', __('Date of establishment'));
        $form->textarea('size', __('Size'));
        $form->textarea('profile_picture', __('Profile picture'));
        $form->number('number_of_animals', __('Number of animals'));
        $form->text('farm_structures', __('Farm structures'));
        $form->textarea('general_remarks', __('General remarks'));
        $form->number('added_by', __('Added by'));
        $form->number('owner_id', __('Owner id'));
        $form->textarea('location_id', __('Location id'));
        $form->textarea('location_text', __('Location text'));
        $form->textarea('village', __('Village'));
        $form->textarea('parish', __('Parish'));
        $form->textarea('zone', __('Zone'));
        $form->textarea('number_of_livestock', __('Number of livestock'));
        $form->textarea('number_of_workers', __('Number of workers'));
        $form->textarea('land_ownership', __('Land ownership'));
        $form->textarea('no_land_ownership_reason', __('No land ownership reason'));
        $form->textarea('owner_text', __('Owner text'));
        $form->textarea('district_id', __('District id'));
        $form->textarea('district_text', __('District text'));
        $form->textarea('sub_county_id', __('Sub county id'));
        $form->textarea('sub_county_text', __('Sub county text'));

        return $form;
    }
}
