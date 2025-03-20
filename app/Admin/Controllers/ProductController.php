<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Products';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());
        $grid->model()->latest();
        $grid->disableCreateButton();
        $grid->disableBatchActions();

        $grid->column('id', __('Id'))->sortable();
        $grid->column('provider_id', __('Provider id'))->sortable();
        $grid->column('farmer_id', __('Farmer id'))->sortable();
        $grid->column('name', __('Name'))->filter('like');
        $grid->column('description', __('Description'))->limit(50);
        $grid->column('manufacturer', __('Manufacturer'))->filter('like');
        $grid->column('price', __('Price'))->sortable()->filter('range');
        $grid->column('quantity_available', __('Quantity available'))->sortable()->filter('range');
        $grid->column('expiry_date', __('Expiry date'))->sortable()->filter('range', 'date');
        $grid->column('storage_conditions', __('Storage conditions'))->limit(50);
        $grid->column('usage_instructions', __('Usage instructions'))->limit(50);
        $grid->column('warnings', __('Warnings'))->limit(50);
        $grid->column('status', __('Status'))->filter([
            'Active' => 'Active',
            'Inactive' => 'Inactive',
        ]);
        $grid->column('image', __('Image'))->image('', 50, 50);
        $grid->column('stock', __('Stock'))->sortable()->filter('range');
        $grid->column('category', __('Category'))->filter('like');
        $grid->column('created_at', __('Created at'))->sortable()->filter('range', 'date');
        $grid->column('updated_at', __('Updated at'))->sortable()->filter('range', 'date');

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('name', __('Name'));
            $filter->like('manufacturer', __('Manufacturer'));
            $filter->equal('status', __('Status'))->select([
                'Active' => 'Active',
                'Inactive' => 'Inactive',
            ]);
            $filter->between('price', __('Price'));
            $filter->between('quantity_available', __('Quantity available'));
            $filter->between('expiry_date', __('Expiry date'))->date();
            $filter->between('created_at', __('Created at'))->date();
            $filter->between('updated_at', __('Updated at'))->date();
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('provider_id', __('Provider id'));
        $show->field('farmer_id', __('Farmer id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('manufacturer', __('Manufacturer'));
        $show->field('price', __('Price'));
        $show->field('quantity_available', __('Quantity available'));
        $show->field('expiry_date', __('Expiry date'));
        $show->field('storage_conditions', __('Storage conditions'));
        $show->field('usage_instructions', __('Usage instructions'));
        $show->field('warnings', __('Warnings'));
        $show->field('status', __('Status'));
        $show->field('image', __('Image'));
        $show->field('stock', __('Stock'));
        $show->field('category', __('Category'));
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
        $form = new Form(new Product());

        $form->number('provider_id', __('Provider id'));
        $form->number('farmer_id', __('Farmer id'));
        $form->textarea('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->text('manufacturer', __('Manufacturer'));
        $form->number('price', __('Price'));
        $form->number('quantity_available', __('Quantity available'));
        $form->textarea('expiry_date', __('Expiry date'));
        $form->textarea('storage_conditions', __('Storage conditions'));
        $form->textarea('usage_instructions', __('Usage instructions'));
        $form->textarea('warnings', __('Warnings'));
        $form->text('status', __('Status'))->default('Active');
        $form->image('image', __('Image')); // Corrected this line
        $form->number('stock', __('Stock'));
        $form->textarea('category', __('Category'));

        return $form;
    }
}
