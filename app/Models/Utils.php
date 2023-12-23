<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Zebra_Image;

class Utils extends Model
{
    use HasFactory;
    //delete notification after the form has been viewed
    public static function delete_notification($model_name, $id)
    {

        $model = "App\\Models\\" . ucfirst($model_name);
        $user = auth('admin')->user();
        $form = $model::findOrFail($id);
        //delete the notification from the database once a user views the form
        if (!$user->inRoles(['administrator', 'ldf_admin'])) {

            if ($form->status == 'approved' || $form->status == 'halted' || $form->status == 'rejected') {

                \App\Models\Notification::where(['receiver_id' => $user->id, 'model_id' => $id, 'model' => $model_name])->delete();
            }
        }
    }

    //disable action buttons depending on the status of the form
    public static function disable_buttons($model, $grid)
    {
        $user = auth('admin')->user();
        if ($user->inRoles(['administrator', 'ldf_admin'])) {
            //disable create button and delete
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {

                if ($actions->row->status == 'approved') {
                    $actions->disableDelete();
                    $actions->disableEdit();
                } else {

                    $actions->disableDelete();
                }
            });
        }

        if ($user->isRole('basic-user')) {

            $grid->actions(function ($actions) {
                if ($actions->row->status == 'halted') {
                    $actions->disableDelete();
                }
                if (
                    $actions->row->status == 'rejected' ||
                    $actions->row->status == 'approved'
                ) {
                    $actions->disableDelete();
                    $actions->disableEdit();
                }
            });
        }
    }


    //get date when this week started
    public static function week_started($date)
    {
        $date = Carbon::parse($date);
        $date->startOfWeek();
        return $date;
    }
    //get date when this week ended
    public static function week_ended($date)
    {
        $date = Carbon::parse($date);
        $date->endOfWeek();
        return $date;
    }

    //manifest
    public static function manifest($u)
    {
        $week_start = Utils::week_started(Carbon::now());
        $week_end = Utils::week_ended(Carbon::now());
        $ob = new \stdClass();


        $ob->tasks_pending = $ob->tasks_pending_items->count();

        $tasks_missed = [
            'assigned_to' => $u->id,
            'is_submitted' => 'Yes',
            'company_id' => $u->company_id,
            'manager_submission_status' => 'Not Attended To',
        ];
        $tasks_done = [
            'assigned_to' => $u->id,
            'is_submitted' => 'Yes',
            'manager_submission_status' => 'Done',
            'company_id' => $u->company_id,
        ];
        if ($u->can('admin')) {
            unset($tasks_missed['assigned_to']);
            unset($tasks_done['assigned_to']);
        }


        return $ob;
    }

    public static function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }



    //mail sender
    public static function mail_sender($data)
    {
        try {
            Mail::send('mail', ['body' => $data['body'], 'title' => $data['subject']], function ($m) use ($data) {
                $m->to($data['email'], $data['name'])
                    ->subject($data['subject']);
                $m->from('noreply@excellentiaeastafrica.com', 'TaskEase East Africa');
            });
        } catch (\Throwable $th) {
            $msg = 'failed';
            throw $th;
        }
    }


    public static function response($data = [])
    {
        header('Content-Type: application/json; charset=utf-8');
        $resp['status'] = "1";
        $resp['code'] = "1";
        $resp['message'] = "Success";
        $resp['data'] = null;
        if (isset($data['status'])) {
            $resp['status'] = $data['status'] . "";
            $resp['code'] = $data['status'] . "";
        }
        if (isset($data['message'])) {
            $resp['message'] = $data['message'];
        }
        if (isset($data['data'])) {
            $resp['data'] = $data['data'];
        }
        return $resp;
    }

    //static php fuction that greets the user according to the time of the day
    public static function greet()
    {
        $hour = date('H');
        if ($hour > 0 && $hour < 12) {
            return "Good Morning";
        } else if ($hour >= 12 && $hour < 17) {
            return "Good Afternoon";
        } else if ($hour >= 17 && $hour < 19) {
            return "Good Evening";
        } else {
            return "Good Night";
        }
    }


    public static function success($data = [], $message = "")
    {
        return (response()->json([
            'code' => 1,
            'message' => $message,
            'data' => $data
        ]));
    }

    public static function error($message = "")
    {
        return response()->json([
            'code' => 0,
            'message' => $message,
            'data' => ""
        ]);
    }

    public static function phone_number_is_valid($phone_number)
    {
        $phone_number = Utils::prepare_phone_number($phone_number);
        if (substr($phone_number, 0, 4) != "+256") {
            return false;
        }

        if (strlen($phone_number) != 13) {
            return false;
        }

        return true;
    }
    public static function prepare_phone_number($phone_number)
    {
        $original = $phone_number;
        //$phone_number = '+256783204665';
        //0783204665
        if (strlen($phone_number) > 10) {
            $phone_number = str_replace("+", "", $phone_number);
            $phone_number = substr($phone_number, 3, strlen($phone_number));
        } else {
            if (substr($phone_number, 0, 1) == "0") {
                $phone_number = substr($phone_number, 1, strlen($phone_number));
            }
        }
        if (strlen($phone_number) != 9) {
            return $original;
        }
        return "+256" . $phone_number;
    }

    public static function docs_root()
    {
        $r = $_SERVER['DOCUMENT_ROOT'] . "";

        if (!str_contains($r, 'home/')) {
            $r = str_replace('/public', "", $r);
            $r = str_replace('\public', "", $r);
        }

        if (!(str_contains($r, 'public'))) {
            $r = $r . "/public";
        }


        /* 
             "/home/ulitscom_html/public/storage/images/956000011639246-(m).JPG
            
            public_html/public/storage/images
            */
        return $r;
    }

    public static function upload_images_2($files, $is_single_file = false)
    {

        ini_set('memory_limit', '-1');
        if ($files == null || empty($files)) {
            return $is_single_file ? "" : [];
        }
        $uploaded_images = array();
        foreach ($files as $file) {

            if (
                isset($file['name']) &&
                isset($file['type']) &&
                isset($file['tmp_name']) &&
                isset($file['error']) &&
                isset($file['size'])
            ) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_name = time() . "-" . rand(100000, 1000000) . "." . $ext;
                $destination = Utils::docs_root() . '/storage/images/' . $file_name;

                $res = move_uploaded_file($file['tmp_name'], $destination);
                if (!$res) {
                    continue;
                }
                //$uploaded_images[] = $destination;
                $uploaded_images[] = $file_name;
            }
        }

        $single_file = "";
        if (isset($uploaded_images[0])) {
            $single_file = $uploaded_images[0];
        }


        return $is_single_file ? $single_file : $uploaded_images;
    }


    public static function create_thumbail($params = array())
    {

        ini_set('memory_limit', '-1');

        if (
            !isset($params['source']) ||
            !isset($params['target'])
        ) {
            return [];
        }



        if (!file_exists($params['source'])) {
            $img = url('assets/images/cow.jpeg');
            return $img;
        }


        $image = new Zebra_Image();

        $image->auto_handle_exif_orientation = true;
        $image->source_path = "" . $params['source'];
        $image->target_path = "" . $params['target'];


        if (isset($params['quality'])) {
            $image->jpeg_quality = $params['quality'];
        }

        $image->preserve_aspect_ratio = true;
        $image->enlarge_smaller_images = true;
        $image->preserve_time = true;
        $image->handle_exif_orientation_tag = true;

        $img_size = getimagesize($image->source_path); // returns an array that is filled with info





        $image->jpeg_quality = 50;
        if (isset($params['quality'])) {
            $image->jpeg_quality = $params['quality'];
        } else {
            $image->jpeg_quality = Utils::get_jpeg_quality(filesize($image->source_path));
        }
        if (!$image->resize(0, 0, ZEBRA_IMAGE_CROP_CENTER)) {
            return $image->source_path;
        } else {
            return $image->target_path;
        }
    }

    public static function get_jpeg_quality($_size)
    {
        $size = ($_size / 1000000);

        $qt = 50;
        if ($size > 5) {
            $qt = 10;
        } else if ($size > 4) {
            $qt = 10;
        } else if ($size > 2) {
            $qt = 10;
        } else if ($size > 1) {
            $qt = 11;
        } else if ($size > 0.8) {
            $qt = 11;
        } else if ($size > .5) {
            $qt = 12;
        } else {
            $qt = 15;
        }

        return $qt;
    }


    public static function system_boot()
    {
    }

    public static function start_session()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }



    public static function month($t)
    {
        $c = Carbon::parse($t);
        if ($t == null) {
            return $t;
        }
        return $c->format('M - Y');
    }
    public static function my_day($t)
    {
        $c = Carbon::parse($t);
        if ($t == null) {
            return $t;
        }
        return $c->format('d M');
    }


    public static function my_date_1($t)
    {
        $c = Carbon::parse($t);
        if ($t == null) {
            return $t;
        }
        return $c->format('D - d M');
    }

    public static function my_date($t)
    {
        $c = Carbon::parse($t);
        if ($t == null) {
            return $t;
        }
        return $c->format('d M, Y');
    }

    public static function my_date_time_1($t)
    {
        $c = Carbon::parse($t);
        if ($t == null) {
            return $t;
        }
        //return date and 24 hours format time
        return $c->format('d M, Y - H:m');
    }

    public static function my_date_time($t)
    {
        $c = Carbon::parse($t);
        if ($t == null) {
            return $t;
        }
        return $c->format('d M, Y - h:m a');
    }

    public static function to_date_time($raw)
    {
        $t = Carbon::parse($raw);
        if ($t == null) {
            return  "-";
        }
        $my_t = $t->toDateString();

        return $my_t . " " . $t->toTimeString();
    }
}
