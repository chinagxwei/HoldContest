<?php

namespace App\Models\Trait;

use App\Models\System\Unit;

/**
 * @property int unit_id
 * @property Unit unit
 */
trait UnitRelation
{
    public function setUnit($unit_id)
    {
        $this->unit_id = $unit_id;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
}
