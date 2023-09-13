<?php

namespace App\Models\Build\SystemBuild;

trait SystemConfigBuild
{

    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }

}
