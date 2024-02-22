<?php

namespace App\Observers;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\UpdatedRelation;
use Illuminate\Database\Eloquent\Model;

class ActionObserver
{

    /**
     * @param CreatedRelation $model
     * @return void
     */
    public function creating($model){
//        var_dump('creating');
        $model->setCreatedBy();
    }

    //
    /**
     * 处理用户「创建」事件。
     *
     * @return void
     */
    public function created($model)
    {
        //
//        var_dump('created');
    }

    /**
     * 处理用户「更新」事件。
     *
     * @param UpdatedRelation $model
     * @return void
     */
    public function updated($model)
    {
//        $model->setUpdatedBy();
    }

    /**
     * 处理用户「删除」事件。
     *
     * @return void
     */
    public function deleted($model)
    {
        //
    }

    /**
     * 处理用户「强制删除」事件。
     *
     * @return void
     */
    public function forceDeleted($model)
    {
        //
    }
}
