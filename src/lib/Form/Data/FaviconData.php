<?php

namespace Edgar\EzUIFavicon\Form\Data;

use Edgar\EzUISites\Data\SiteData;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FaviconData
{
    /** @var null|SiteData $site */
    private $site;

    /** @var null|UploadedFile $file */
    private $file;

    public function __construct(
        ?SiteData $site = null,
        ?UploadedFile $file = null
    ) {
        $this->site = $site;
        $this->file = $file;
    }

    public function setSite(?SiteData $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function setFile(UploadedFile $file): self
    {
        $this->file  = $file;

        return $this;
    }

    public function getSite(): ?SiteData
    {
        return $this->site;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }
}
