<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Event;
use App\Models\Farm;
use App\Models\FarmActivity;
use App\Models\FinanceAccount;
use App\Models\FinancialRecord;
use App\Models\Gen;
use App\Models\Location;
use App\Models\Meeting;
use App\Models\Product;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Utils;
use Carbon\Carbon;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('dummy', function () {

    die('done');
    $max = 200;
    $famer_ids = User::where('category', 'Farmer')->pluck('id')->toArray();
    $faker = Faker\Factory::create();
    $types = ['Cattle', 'Goats', 'Sheep', 'Pigs', 'Poultry', 'Fish', 'Others'];
    $production_types = ['Milk', 'Meat', 'Eggs', 'Fish', 'Others'];
    $land_ownership = ['Yes', 'No'];
    $land_ownership_reasons = ['Lease', 'Rent', 'Other'];
    $locations =  Location::where([
        'details' => 'Subcounty'
    ])->orderby('id', 'desc')
        ->get()
        ->pluck('id')
        ->toArray();

    //finanzial accounts
    $max = 1000;
    $famer_ids = User::where('category', 'Farmer')->pluck('id')->toArray();
    $financial_accounts_ids = FinanceAccount::pluck('id')->toArray();
    /* 

id
created_at
updated_at
farm_id
transaction_type
transaction_date
description
amount
payment_method
party
party_tin
payment_reference
reciept_file
remarks
created_by_id
farmer_id


*/

    //financial record

    $amounts  = [
        25000,
        50000,
        1000,
        2000,
        10000,
        5000,
        20000,
        30000,
        40000,
        60000,
        70000,
        80000,
        90000,
        100000,
        150000,
        120000,
        130000,
        200000,
        250000,
        300000,
        350000,
    ];

    $tasks = [
        'Vaccination',
        'Treatment',
        'Training',
        'Other',
        'Consultation',
        'Feed Supply',
        'Animal Health Monitoring',
        'Breeding Services',
        'Farm Management Support',
        'Other'
    ];

    /* 
  
id
provider_id
farmer_id
name
description
manufacturer
price
quantity_available
expiry_date
storage_conditions
usage_instructions
warnings
status
image
stock
category
created_at
updated_at

 */
    //ptoducts
    $names = [
        'Animal Vaccines',
        'Veterinary Drugs',
        'Livestock Feeds',
        'Farming Equipment',
        'Agricultural Services',
        'Miscellaneous Products'
    ];

    die();
    for ($i = 0; $i < $max; $i++) {
        $gen = new Product();
        $gen->provider_id = $famer_ids[rand(0, count($famer_ids) - 1)];
        $gen->farmer_id = $famer_ids[rand(0, count($famer_ids) - 1)];
        $gen->name = $names[rand(0, count($names) - 1)];
        $gen->description = $faker->text;
        $gen->manufacturer = $faker->company;
        $gen->price = $amounts[rand(0, count($amounts) - 1)];
        $gen->quantity_available = rand(1, 100);
        $gen->expiry_date = Carbon::now()->subMonth(rand(1, 100));
        $gen->storage_conditions = $faker->text;
        $gen->usage_instructions = $faker->text;
        $gen->warnings = $faker->text;
        $gen->status = ['Available', 'Available', 'Available', 'Available', 'Out of Stock', 'Available', 'Available', 'Out of Stock'][rand(0, 4)];
        $gen->image = "images/product-" . rand(1, 20) . ".jpg";
        $gen->stock = rand(1, 100);
        $gen->category = $name = $names[rand(0, count($names) - 1)];
        $gen->save();
        echo $gen->id . ". " . $gen->name . " created<br>";
    }

    die();
    for ($i = 0; $i < $max; $i++) {
        $gen = new FinancialRecord();
        $gen->farm_id = $financial_accounts_ids[rand(0, count($financial_accounts_ids) - 1)];
        $gen->transaction_type = ['Income', 'Expense'][rand(0, 1)];
        $gen->transaction_date = Carbon::now()->subMonth(rand(1, 100));
        $gen->description =  $tasks[rand(0, count($tasks) - 1)];
        $gen->amount = $amounts[rand(0, count($amounts) - 1)];
        $gen->payment_method = ['Cash', 'Mobile Money', 'Bank'][rand(0, 2)];
        $gen->party = $faker->company;
        $gen->party_tin = $faker->creditCardNumber;
        $gen->payment_reference = $faker->creditCardNumber;
        $gen->reciept_file = "images/receipt-" . rand(1, 20) . ".jpg";
        $gen->remarks = $faker->text;
        $gen->created_by_id = $famer_ids[rand(0, count($famer_ids) - 1)];
        $gen->farmer_id = $famer_ids[rand(0, count($famer_ids) - 1)];
        $gen->save();
        echo $gen->id . ". " . $gen->name . " created<br>";
    }

    die();


    for ($i = 0; $i < $max; $i++) {
        $gen = new FinanceAccount();
        $gen->owner_id = $famer_ids[rand(0, count($famer_ids) - 1)];
        $gen->name = $faker->company;
        $gen->balance = 0;
        $gen->detail = $faker->text;
        $gen->save();
        echo $gen->id . ". " . $gen->name . " created<br>";
    }



    /* 
farm activities


id
created_at
updated_at
farm_id
farm_text
name
scheduled_at
description
user_id
user_text
type
status
outcome
photos


 

         */
    $max = 1000;
    $farm_ids = Farm::pluck('id')->toArray();
    $famer_ids = User::where('category', 'Farmer')->pluck('id')->toArray();
    $faker = Faker\Factory::create();
    $breeds = Breed::pluck('id')->toArray();
    $animal_ids = Animal::pluck('id')->toArray();

    $farm_activities = [
        'Vaccination',
        'Treatment',
        'Training',
        'Other',
        'Consultation',
        'Feed Supply',
        'Animal Health Monitoring',
        'Breeding Services',
        'Farm Management Support'
    ];

    $max = 500;

    for ($i = 0; $i < $max; $i++) {
        $activity = new FarmActivity();
        $activity->farm_id = $farm_ids[rand(0, count($farm_ids) - 1)];
        $farm = Farm::find($activity->farm_id);
        if ($farm == null) {
            die("Farm not found");
        }
        $activity->farm_text = $farm->name;
        $activity->name = $faker->text;
        $activity->scheduled_at = Carbon::now()->subMonth(rand(1, 100));
        $activity->description = $faker->text;
        $activity->user_id = $famer_ids[rand(0, count($famer_ids) - 1)];
        $activity->user_text = $faker->name;
        $activity->type = $farm_activities[rand(0, count($farm_activities) - 1)];
        $activity->status = ['Done', 'Not Done', 'Not Attended To'][rand(0, 2)];
        $activity->outcome = ['Positive', 'Negative', 'Neutral'][rand(0, 2)];
        $activity->photos = "images/activity-" . rand(1, 20) . ".jpg";
        $activity->save();
        echo $activity->id . ". " . $activity->name . " created<br>";
    }

    die();

    for ($i = 0; $i < $max; $i++) {
        $event = new Event();
        $event->animal_id = $animal_ids[rand(0, count($animal_ids) - 1)];
        $animal = Animal::find($event->animal_id);
        if ($animal == null) {
            die("Animal not found");
        }
        $event->owner_id = $animal->owner_id;
        $event->district_id = rand(1, 100);
        $event->sub_county_id = $locations[rand(0, count($locations) - 1)];
        $event->disease_id = rand(1, 100);
        $event->farm_id = $animal->farm_id;
        $event->weight = rand(30, 700);
        $event->milk = rand(1, 12);
        $event->type =  [
            "Birth",
            "Death",
            "Vaccination",
            "Treatment",
            "Sale",
            "Purchase",
            "Other",
        ][rand(0, 6)];
        $event->detail = $faker->text;
        $event->description = $faker->text;
        $event->drug = $faker->text;
        $event->vaccine = $faker->text;
        $event->photo = "images/event-" . rand(1, 20) . ".jpg";
        $event->save();
        echo $event->id . ". " . $event->name . " created<br>";
    }


    for ($i = 0; $i < $max; $i++) {
        die();
        $animal = new Animal();
        $animal->tag_number = $faker->creditCardNumber;
        $animal->farm_id = $farm_ids[rand(0, count($farm_ids) - 1)];
        $farm = Farm::find($animal->farm_id);
        $animal->farm_text = $farm->name;
        $animal->owner_id = $farm->owner_id;
        $animal->owner_text = $faker->name;
        $animal->breed_id = $breeds[rand(0, count($breeds) - 1)];
        $breed = Breed::find($animal->breed_id);
        $animal->breed_text = $breed->name;
        $animal->parents = $animal->tag_number;
        $animal->dob = Carbon::now()->subMonth(rand(1, 100));
        $animal->date_of_weaning = Carbon::now()->subMonth(rand(1, 100));
        $animal->name = $animal->tag_number;
        $animal->photo = "images/animal-" . rand(1, 20) . ".jpg";
        $animal->sex =  ['Male', 'Female'][rand(0, 1)];
        $animal->district_id = rand(1, 100);
        $animal->district_text = $faker->city;
        $animal->sub_county_id = $locations[rand(0, count($locations) - 1)];
        $animal->sub_county_text = $faker->city;
        $animal->weight = rand(1, 100) . " kg";
        $animal->type = ['Cattle', 'Goat', 'Sheep', 'Pig', 'Others'][rand(0, 4)];
        $animal->status = ['Alive', 'Alive', 'Alive', 'Alive', 'Dead', 'Alive', 'Alive', 'Dead'][rand(0, 4)];
        $animal->general_remarks = $faker->text;
        $animal->health_status = $faker->text;
        $animal->save();
        echo $animal->id . ". " . $animal->name . " created<br>";
    }

    die();

    for ($i = 0; $i < $max; $i++) {
        $farm = new Farm();
        $farm->name = $faker->company . ' - Farm';
        $farm->coordinates = $faker->latitude . "," . $faker->longitude;
        $farm->livestock_type = $types[rand(0, count($types) - 1)];
        $farm->production_type = $production_types[rand(0, count($production_types) - 1)];
        $farm->date_of_establishment = Carbon::now()->subMonth(rand(1, 100));
        $farm->size = rand(1, 100) . " acres";
        $farm->profile_picture = "images/" . rand(1, 50) . ".jpg";
        $farm->number_of_animals = rand(1, 100);
        $farm->farm_structures = ['Barn', 'Silo', 'Pen'][rand(0, 2)];
        $farm->general_remarks = $faker->text;
        $farm->added_by = $famer_ids[rand(0, count($famer_ids) - 1)];
        $farm->owner_id =  $famer_ids[rand(0, count($famer_ids) - 1)];
        $farm->location_id = rand(1, 100);
        $farm->location_text = $faker->city;
        $farm->village = $faker->city;
        $farm->parish = $faker->city;
        $farm->zone = $faker->city;
        $farm->number_of_livestock = rand(1, 100);
        $farm->number_of_workers = rand(1, 100);
        $farm->land_ownership = $land_ownership[rand(0, 1)];
        $farm->no_land_ownership_reason = $land_ownership_reasons[rand(0, count($land_ownership_reasons) - 1)];
        $farm->owner_text = $faker->name;
        $farm->district_id = rand(1, 100);
        $farm->district_text = $faker->city;
        $loc = $locations[rand(0, count($locations) - 1)];
        $farm->sub_county_id = $loc;
        $farm->save();
        echo $farm->id . ". " . $farm->name . " created<br>";
    }
    die();


    die('done');
    $users = User::all();
    $faker = Faker\Factory::create();
    $cats = ['Farmer', 'Vet', 'Admin',  'Input'];
    $marital_status = ['Single', 'Married', 'Divorced', 'Widowed'];
    $highest_level_of_education = ['Primary', 'Secondary', 'Tertiary', 'Masters', 'PhD', 'None'];
    $services_offered = [
        'Artificial Insemination',
        'Vaccination',
        'Treatment',
        'Training',
        'Other',
        'Consultation',
        'Feed Supply',
        'Animal Health Monitoring',
        'Breeding Services',
        'Farm Management Support'
    ];
    $max = 200;
    //create new
    for ($i = 0; $i < $max; $i++) {
        $user = new User();
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->name = $user->first_name . " " . $user->last_name;
        $user->marital_status = $marital_status[rand(0, count($marital_status) - 1)];
        $user->date_started_farming = Carbon::now()->subMonth(rand(1, 100));
        $user->credit_institution = $faker->company;
        $user->farmer_group = $faker->company;
        $user->access_to_credit = rand(0, 1) == 1 ? 'Yes' : 'No';
        $user->production_scale = ['Small', 'Medium', 'Large'][rand(0, 2)];
        $user->land_ownership = ['Yes', 'No'][rand(0, 1)];
        $user->is_land_owner = $user->land_ownership;
        $user->secondary_phone_number = $faker->phoneNumber;
        $user->primary_phone_number = $faker->phoneNumber;
        $user->number_of_dependants = rand(1, 10);
        $user->status = 1;
        $user->gender = ['Male', 'Female'][rand(0, 1)];
        $user->email = $faker->email;
        $user->services_offered = implode(",", array_slice($services_offered, 0, rand(1, count($services_offered) - 1)));
        $user->highest_level_of_education = $highest_level_of_education[rand(0, count($highest_level_of_education) - 1)];
        $user->postal_address = $faker->address;
        $user->username = $user->email;
        $user->phone_number_1 = $user->primary_phone_number;
        $user->nin = $faker->creditCardNumber;
        $user->avatar =  "images/" . rand(1, 50) . ".jpg";
        $user->license_photo = $user->avatar;
        $user->business_phone_number = $faker->phoneNumber;
        $user->brief_profile = $faker->text;
        $user->date_of_registration = Carbon::now()->subMonth(rand(1, 100));
        $user->license_expiry_date = Carbon::now()->subMonth(rand(1, 100));
        $user->license_number = $faker->creditCardNumber;
        $user->group_or_practice = $faker->company;
        $user->village = $faker->city;
        $user->coordinates = $faker->latitude . "," . $faker->longitude;
        $user->sub_county_text = $faker->city;
        $user->sub_county_id = rand(1, 10);
        $user->district_text = $faker->city;
        $user->category = $cats[rand(0, count($cats) - 1)];
        $user->title = ['Mr', 'Mrs', 'Dr', 'Prof'][rand(0, 3)];
        $user->password = '4321';
        $user->save();
        echo $user->id . ". " . $user->name . " created<br>";
    }
    //update existing
    die();
    foreach ($users as $key => $user) {
        if ($user->id == 1) {
            $user->avatar = "images/muhindo.png";
            // $user->save();
            continue;
        }
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->name = $user->first_name . " " . $user->last_name;
        $user->marital_status = $marital_status[rand(0, count($marital_status) - 1)];
        $user->date_started_farming = Carbon::now()->subMonth(rand(1, 100));
        $user->credit_institution = $faker->company;
        $user->farmer_group = $faker->company;
        $user->access_to_credit = rand(0, 1) == 1 ? 'Yes' : 'No';
        $user->production_scale = ['Small', 'Medium', 'Large'][rand(0, 2)];
        $user->land_ownership = ['Yes', 'No'][rand(0, 1)];
        $user->is_land_owner = $user->land_ownership;
        $user->secondary_phone_number = $faker->phoneNumber;
        $user->primary_phone_number = $faker->phoneNumber;
        $user->number_of_dependants = rand(1, 10);
        $user->status = 1;
        $user->gender = ['Male', 'Female'][rand(0, 1)];
        $user->email = $faker->email;
        //shuffle
        shuffle($services_offered);
        $user->services_offered = implode(",", array_slice($services_offered, 0, rand(1, count($services_offered) - 1)));
        $user->highest_level_of_education = $highest_level_of_education[rand(0, count($highest_level_of_education) - 1)];
        $user->postal_address = $faker->address;
        $user->username = $user->email;
        $user->phone_number_1 = $user->primary_phone_number;
        $user->nin = $faker->creditCardNumber;
        $user->avatar =  "images/" . rand(1, 50) . ".jpg";
        $user->license_photo = $user->avatar;
        $user->business_phone_number = $faker->phoneNumber;
        $user->brief_profile = $faker->text;
        $user->date_of_registration = Carbon::now()->subMonth(rand(1, 100));
        $user->license_expiry_date = Carbon::now()->subMonth(rand(1, 100));
        $user->license_number = $faker->creditCardNumber;
        $user->group_or_practice = $faker->company;
        $user->village = $faker->city;
        $user->coordinates = $faker->latitude . "," . $faker->longitude;
        $user->sub_county_text = $faker->city;
        $user->sub_county_id = rand(1, 10);
        $user->district_text = $faker->city;
        $user->category = $cats[rand(0, count($cats) - 1)];
        $user->title = ['Mr', 'Mrs', 'Dr', 'Prof'][rand(0, 3)];
        $user->password = '4321';
        $user->save();
        echo $user->id . ". " . $user->name . " updated<br>";
    }
});


Route::get('auth/login', function () {
    $u = Admin::user();
    if ($u != null) {
        return redirect(url('/'));
    }

    return view('auth.login');
})->name('login');

Route::get('app', function () {
    $APP_URL = url('app.apk');
    //set header to be for download
    header("Content-Type: application/vnd.android.package-archive");
    header("Content-Disposition: attachment; filename=app.apk");
    //readfile($APP_URL);
    return redirect($APP_URL);
});
Route::get('test', function () {
    $m = Meeting::find(1);
});
/* 
   "id" => 7
    "created_at" => "2023-10-30 22:09:08"
    "updated_at" => "2023-11-06 13:08:14"
    "company_id" => 2
    "project_id" => 1
    "project_section_id" => 1
    "assigned_to" => 30
    "created_by" => 2
 
    "name" => "Some info.."
    "task_description" => "Some details"
    "due_to_date" => "2023-12-05 05:30:30"
    "delegate_submission_status" => "Done"
    "delegate_submission_remarks" => "Some"
    "manager_submission_status" => "Not Attended To"
    "manager_submission_remarks" => "Some"
    "priority" => "Low"
    "meeting_id" => 1
    "rate" => -6
  ]
*/
Route::get('departmental-workplan', function () {

    $id = 0;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $u = User::find($id);
    if ($u == null) {
        die("User not found");
    }
    //set file name to name of department and date (dompdf) 

    $tasks_tot = 0;
    $tasks_not_submited = 0;
    $tasks_submited = 0;
    $tasks_done = 0;
    $tasks_done_late = 0;
    $tasks_missed = 0;
    $tasks_tot = count($u->tasks);
    foreach ($u->tasks as $key => $task) {
        if ($task->manager_submission_status == 'Not Submitted') {
            $tasks_not_submited++;
        } else {
            $tasks_submited++;
            if ($task->manager_submission_status == 'Done') {
                $tasks_done++;
            } else if ($task->manager_submission_status == 'Done Late') {
                $tasks_done_late++;
            } else if ($task->manager_submission_status == 'Not Attended To') {
                $tasks_missed++;
            }
        }
    }

    if ($tasks_submited > 0) {
        $tasks_done .= " (" . round(($tasks_done / $tasks_submited) * 100, 0) . "%)";
        $tasks_done_late .= " (" . round(($tasks_done_late / $tasks_submited) * 100, 0) . "%)";
        $tasks_missed .= " (" . round(($tasks_missed / $tasks_submited) * 100, 0) . "%)";
    }

    if ($tasks_tot > 0) {
        $tasks_not_submited .= " (" . round(($tasks_not_submited / $tasks_tot) * 100, 0) . "%)";
        $tasks_submited .= " (" . round(($tasks_submited / $tasks_tot) * 100, 0) . "%)";
    }



    /* 
        'Done' => 'Done',
        'Done Late' => '',
        'Not Attended To' => 'Not Attended To',

        "id" => 1
        "created_at" => "2023-10-25 23:23:14"
        "updated_at" => "2023-10-25 23:23:14"
        "company_id" => 1
        "project_id" => null
        "project_section_id" => null
        "assigned_to" => 1
        "created_by" => 1
        "manager_id" => 1
        "name" => "This is a simple tes"
        "task_description" => "Spome das'"
        "due_to_date" => "2023-10-09 00:00:00"
        "delegate_submission_status" => "Not Submitted"
        "delegate_submission_remarks" => null
        "manager_submission_status" => "Not Submitted"
        "manager_submission_remarks" => null
        "priority" => "Medium"
        "meeting_id" => 6


    
    */

    $title = $u->name . " " . date("Y-m-d H:i:s");
    $file_name = $title . ".pdf";
    $pdf = App::make('dompdf.wrapper', ['enable_remote' => true, 'enable_html5_parser' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);



    $pdf->setPaper('A4', 'portrait');
    $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'open-sans']);
    $pdf->setOptions(['isPhpEnabled' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

    $pdf->loadHTML(view('departmental-workplan', [
        'user' => $u,
        'title' => $title,
        'tasks_tot' => $tasks_tot,
        'tasks_missed' => $tasks_missed,
        'tasks_done_late' => $tasks_done_late,
        'tasks_done' => $tasks_done,
        'tasks_not_submited' => $tasks_not_submited,
        'tasks_submited' => $tasks_submited,
    ])->render());
    return $pdf->stream($file_name);
});
Route::get('project-report', function () {

    $id = 0;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $p = Project::find($id);
    if ($p == null) {
        die("User not found");
    }


    $title = $p->name . " " . date("Y-m-d H:i:s");
    $file_name = $title . ".pdf";
    $pdf = App::make('dompdf.wrapper', ['enable_remote' => true, 'enable_html5_parser' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

    $pdf->setPaper('A4', 'portrait');
    $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'open-sans']);
    $pdf->setOptions(['isPhpEnabled' => true, 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);


    $pdf->loadHTML(view('project-report', [
        'item' => $p,
        'title' => $title,
    ])->render());
    return $pdf->stream($file_name);
});



Route::get('policy', function () {
    return view('policy');
});

Route::get('/gen-form', function () {
    die(Gen::find($_GET['id'])->make_forms());
})->name("gen-form");


Route::get('generate-class', [MainController::class, 'generate_class']);
Route::get('/gen', function () {
    die(Gen::find($_GET['id'])->do_get());
})->name("register");
 

/* 
x
Route::get('generate-variables', [MainController::class, 'generate_variables']); 
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/about-us', [MainController::class, 'about_us']);
Route::get('/our-team', [MainController::class, 'our_team']);
Route::get('/news-category/{id}', [MainController::class, 'news_category']);
Route::get('/news-category', [MainController::class, 'news_category']);
Route::get('/news', [MainController::class, 'news_category']);
Route::get('/news/{id}', [MainController::class, 'news']);
Route::get('/members', [MainController::class, 'members']);
Route::get('/dinner', [MainController::class, 'dinner']);
Route::get('/ucc', function(){ return view('chair-person-message'); });
Route::get('/vision-mission', function(){ return view('vision-mission'); }); 
Route::get('/constitution', function(){ return view('constitution'); }); 
Route::get('/register', [AccountController::class, 'register'])->name('register');

Route::get('/login', [AccountController::class, 'login'])->name('login')
    ->middleware(RedirectIfAuthenticated::class);

Route::post('/register', [AccountController::class, 'register_post'])
    ->middleware(RedirectIfAuthenticated::class);

Route::post('/login', [AccountController::class, 'login_post'])
    ->middleware(RedirectIfAuthenticated::class);


Route::get('/dashboard', [AccountController::class, 'dashboard'])
    ->middleware(Authenticate::class);


Route::get('/account-details', [AccountController::class, 'account_details'])
    ->middleware(Authenticate::class);

Route::post('/account-details', [AccountController::class, 'account_details_post'])
    ->middleware(Authenticate::class);

Route::get('/logout', [AccountController::class, 'logout']);
 */