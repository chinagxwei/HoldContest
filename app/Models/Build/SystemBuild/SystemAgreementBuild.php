<?php

namespace App\Models\Build\SystemBuild;

trait SystemAgreementBuild
{
    public function setTitle( $title)
    {
        $this->title = $title;
        return $this;
    }

    public function setContent( $content)
    {
        $this->content = $content;
        return $this;
    }

    public function setType( $type)
    {
        $this->type = $type;
        return $this;
    }
}
