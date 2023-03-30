<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeoSMSInfo extends Model
{
    use HasFactory;

    protected $table = 'neo_sms_info';
    // protected $primaryKey = 'verification_id';
    public $timestamps = false;
}
