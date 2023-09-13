<?php

namespace App\Models\Trait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


trait SignData
{

    abstract function setSign();
}
