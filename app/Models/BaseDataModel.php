<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseDataModel extends Model
{
    const DISABLE = 0;

    const ENABLE = 1;
}
