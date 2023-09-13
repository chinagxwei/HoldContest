<?php

namespace App\Models\Build\AdminBuild;

trait AdminMessageBuild
{

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }
}
