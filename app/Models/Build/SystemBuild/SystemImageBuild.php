<?php

namespace App\Models\Build\SystemBuild;

trait SystemImageBuild
{

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }
}
