<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    use HasFactory;

    //boot
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $acc = FinanceAccount::find($model->farm_id);
            if ($acc == null) {
                throw new \Exception("Farm not found");
            }
            $model->farmer_id = $acc->owner_id; 
            if ($model->transaction_type == "Expense") {
                $model->amount = -1 * abs($model->amount);
            } else if ($model->transaction_type == "Income") {
                $model->amount = abs($model->amount);
            } else {
                throw new \Exception("Invalid transaction type");
            }
            $model->transaction_date = Carbon::parse($model->transaction_date);
        });
    }


    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
