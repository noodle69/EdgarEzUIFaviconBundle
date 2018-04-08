<?php

namespace Edgar\EzUIFavicon\Form\Data;

use Edgar\EzUISites\Data\SiteData;

class FaviconData
{
    /** @var SiteData $site */
    private $site;

    private $image;

    public function __construct(
        ?SiteData $site = null,
        $image = null
    ) {
        $this->site = $site;
        $this->image = $image;
    }

    public function setSite(?SiteData $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function setImage($image): self
    {
        $this->image  = $image;

        return $this;
    }

    public function getSite(): ?SiteData
    {
        return $this->site;
    }

    public function getImage()
    {
        return $this->image;
    }
}
