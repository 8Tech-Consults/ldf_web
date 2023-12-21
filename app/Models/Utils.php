<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    use HasFactory;
    //delete notification after the form has been viewed
    public static function delete_notification($model_name, $id)
    {
       
        $model = "App\\Models\\" .ucfirst($model_name);
        $user =auth('admin')->user();
        $form = $model::findOrFail($id);
        //delete the notification from the database once a user views the form
        if(!$user->inRoles(['administrator','ldf_admin']) )
        {
            
            if($form->status == 'approved'|| $form->status =='halted' || $form->status == 'rejected' )
            {
                
                \App\Models\Notification::where(['receiver_id' => $user->id, 'model_id' => $id, 'model' => $model_name])->delete();
        
            }

        }

      
    }

    //disable action buttons depending on the status of the form
    public static function disable_buttons($model, $grid)
    {
        $user = auth('admin')->user();
        if ($user->inRoles(['administrator','ldf_admin'])) 
        {
                //disable create button and delete
                $grid->disableCreateButton();
                $grid->actions(function ($actions) {
                    
                if ($actions->row->status == 'approved') {
                    $actions->disableDelete();
                    $actions->disableEdit();
                }else{
                    
                    $actions->disableDelete();
                }
                });
        }

        if ($user->isRole('basic-user'))
        {
                 
            $grid->actions(function ($actions) 
            {
                if ($actions->row->status == 'halted') {
                    $actions->disableDelete();
                }
                if($actions->row->status == 'rejected' || 
                 $actions->row->status == 'approved')
                {
                    $actions->disableDelete();
                    $actions->disableEdit();
                }
         
            });
                    
                
        }
    
    
    }
}
