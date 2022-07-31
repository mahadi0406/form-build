<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FormStatus;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','user_id','hash_code','schema_path','respose_csv_path','status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', FormStatus::ACTIVE->value);
    }

}
