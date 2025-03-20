<?php

namespace App\Admin\Controllers;

use App\Models\ParavetRequest;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ParavetRequestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Paravet Requests';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ParavetRequest());

        $grid->model()->latest();
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->column('created_at', __('Date'))
            ->display(function ($created_at) {
                return date('d M, Y', strtotime($created_at));
            })
            ->sortable();
        $grid->column('paravet_id', __('Paravet'))
            ->display(function ($paravet_id) {
                $v = \App\Models\User::find($paravet_id);
                if ($v) {
                    return $v->name;
                }
                return 'N/A';
            })
            ->sortable();
        $grid->column('farmer_id', __('Farmer'))
            ->display(function ($farmer_id) {
                $v = \App\Models\User::find($farmer_id);
                if ($v) {
                    return $v->name;
                }
                return 'N/A';
            })
            ->sortable();
        $grid->column('activity_type', __('Activity Type'))
            ->dot([
                'Vaccination' => 'info',
                'Treatment' => 'success',
                'Training' => 'warning',
                'Other' => 'default',
            ])
            ->sortable();
        $grid->column('activity_description', __('Activity Description'));
        $grid->column('farmer_preferred_date', __('Farmer Preferred Date'))
            ->display(function ($farmer_preferred_date) {
                return date('d M, Y', strtotime($farmer_preferred_date));
            })
            ->sortable();
        $grid->column('status', __('Status'))
            ->label([
                'Pending' => 'info',
                'Approved' => 'success',
                'Rejected' => 'danger',
            ])
            ->sortable();

        $grid->column('farmer_message', __('Farmer message'))
            ->limit(30)
            ->sortable();
        $grid->column('paravet_message', __('Paravet Message'))
            ->limit(30)
            ->sortable();
        $grid->column('farmer_feedback_comment', __('Farmer feedback comment'))->sortable();
        $grid->column('farmer_feedback_rating', __('Farmer rating'))
            ->display(function ($farmer_feedback_rating) {
                return $farmer_feedback_rating . '/5';
            })
            ->sortable();

        $grid->column('activity_address', __('Address'))
            ->limit(30)
            ->sortable();
        $grid->column('gps', __('Gps'))->sortable()
            ->display(function ($gps) {
                return "<a href='https://www.google.com/maps/search/?api=1&query=$gps' target='_blank'>$gps</a>";
            })->copyable();

        $grid->column('activity_date', __('Activity date'))
            ->display(function ($activity_date) {
                return date('d M, Y', strtotime($activity_date));
            })
            ->sortable();
        $grid->column('activity_time', __('Activity time'))
            ->display(function ($activity_time) {
                return date('h:i A', strtotime($activity_time));
            })
            ->sortable();

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
        $show = new Show(ParavetRequest::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('paravet_id', __('Paravet id'));
        $show->field('farmer_id', __('Farmer id'));
        $show->field('district_id', __('District id'));
        $show->field('farmer_preferred_date', __('Farmer preferred date'));
        $show->field('status', __('Status'));
        $show->field('application_mail_sent_to_vet', __('Application mail sent to vet'));
        $show->field('review_mail_sent_to_farmer', __('Review mail sent to farmer'));
        $show->field('farmer_message', __('Farmer message'));
        $show->field('paravet_message', __('Paravet message'));
        $show->field('farmer_feedback_comment', __('Farmer feedback comment'));
        $show->field('farmer_feedback_rating', __('Farmer feedback rating'));
        $show->field('activity_type', __('Activity type'));
        $show->field('activity_address', __('Activity address'));
        $show->field('gps', __('Gps'));
        $show->field('activity_description', __('Activity description'));
        $show->field('activity_date', __('Activity date'));
        $show->field('activity_time', __('Activity time'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ParavetRequest());

        $form->number('paravet_id', __('Paravet id'));
        $form->number('farmer_id', __('Farmer id'));
        $form->number('district_id', __('District id'));
        $form->textarea('farmer_preferred_date', __('Farmer preferred date'));
        $form->text('status', __('Status'))->default('Pending');
        $form->text('application_mail_sent_to_vet', __('Application mail sent to vet'))->default('No');
        $form->text('review_mail_sent_to_farmer', __('Review mail sent to farmer'))->default('No');
        $form->textarea('farmer_message', __('Farmer message'));
        $form->textarea('paravet_message', __('Paravet message'));
        $form->textarea('farmer_feedback_comment', __('Farmer feedback comment'));
        $form->number('farmer_feedback_rating', __('Farmer feedback rating'));
        $form->textarea('activity_type', __('Activity type'));
        $form->textarea('activity_address', __('Activity address'));
        $form->textarea('gps', __('Gps'));
        $form->textarea('activity_description', __('Activity description'));
        $form->textarea('activity_date', __('Activity date'));
        $form->textarea('activity_time', __('Activity time'));

        return $form;
    }
}
