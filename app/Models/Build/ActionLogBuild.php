<?php

namespace App\Models\Build;

trait ActionLogBuild{

    public function setActionName($action_name){
        $this->action_name = $action_name;
        return $this;
    }

    public function setActionDescription($action_description){
        $this->action_description = $action_description;
        return $this;
    }

    public function setIP($ip){
        $this->ip = $ip;
        return $this;
    }
}
