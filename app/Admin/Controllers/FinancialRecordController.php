<?php

namespace App\Admin\Controllers;

use App\Models\FinancialRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;


class FinancialRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'FinancialRecord';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FinancialRecord());

        $grid->model()->orderBy('updated_at', 'desc');

         //show a user only their records if they are not an admin
         if (!auth()->user()->inRoles(['administrator','ldf_admin'])) {
            $grid->model()->where('farmer_id', auth()->user()->id);
        }

    
        $grid->column('farm_id', __('Farm'))->display(function ($farm_id) {
            return \App\Models\Farm::find($farm_id)?->name;
        });
    
        $grid->column('transaction_type', __('Transaction type'));
        $grid->column('transaction_date', __('Transaction date'));
        $grid->column('amount', __('Amount'));
        $grid->column('payment_method', __('Payment method'));
     
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
        $show = new Show(FinancialRecord::findOrFail($id));

        $show->field('farm_id', __('Farm id'))->as(function ($farm_id) {
            return \App\Models\Farm::find($farm_id)?->name;
        });

        $show->field('transaction_type', __('Transaction type'));
        $show->field('transaction_date', __('Transaction date'));
        $show->field('description', __('Description'));
        $show->field('amount', __('Amount'));
        $show->field('payment_method', __('Payment method'));
        $show->field('party', __('Party'));
        $show->field('party_tin', __('Party tin'));
        $show->field('payment_reference', __('Payment reference'));
        $show->field('reciept_file', __('Reciept file'));
        $show->field('remarks', __('Remarks'));
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
        $form = new Form(new FinancialRecord());

        $form->hidden('farmer_id', __('Farm id'))->default(auth()->user()->id);
        $form->select('farm_id', __('Select Farm'))->options(\App\Models\Farm::pluck('name', 'id'));
        $form->select('transaction_type', __('Transaction type'))->options(['Income' => 'Income', 'Expense' => 'Expense']);
        $form->date('transaction_date', __('Transaction date'))->default(date('Y-m-d'));
        $form->textarea('description', __('Description'));
        $form->decimal('amount', __('Amount'));
        $form->text('payment_method', __('Payment method'));
        $form->text('party', __('Party'));
        $form->text('party_tin', __('Party tin'));
        $form->text('payment_reference', __('Payment reference'));
        $form->text('reciept_file', __('Reciept file'));
        $form->textarea('remarks', __('Remarks'));

        

        return $form;
    }
}
