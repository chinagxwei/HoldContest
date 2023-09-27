<?php

namespace App\Models\Build\AdminBuild;

trait AdminBuild{

    public function setRemark($remark){
        $this->remark = $remark;
        return $this;
    }

    public function setNickname($nickname){
        $this->nickname = $nickname;
        return $this;
    }

    public function setMobile($mobile){
        $this->mobile = $mobile;
        return $this;
    }

    public static function generate($user_id)
    {
        $model = new static();
        $model->setCreatedBy($user_id)->save();
        return $model;
    }
}
