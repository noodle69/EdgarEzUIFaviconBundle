<?php

namespace Edgar\EzUIFaviconBundle\Templating\Twig;

use Edgar\EzUIFavicon\Generator\Generator;
use EzSystems\EzPlatformAdminUi\Component\Renderer\RendererInterface;
use Twig\Environment;
use Twig_Extension;
use Twig_SimpleFunction;

class FaviconsExtension extends Twig_Extension
{
    protected $twig;

    protected $rootDir;

    protected $varDir;

    protected $storageDir;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'edgarez_favicons',
                [$this, 'renderView'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function renderView(string $site): string
    {
        $faviconsDir = $this->rootDir . '/../web/' . $this->varDir . '/' . $this->storageDir. '/images/' . Generator::FAVICONS_DIR . '/' . $site;
        if (is_dir($faviconsDir) && file_exists($faviconsDir . '/favicons.html.twig')) {
            return $this->twig->render($site . '/favicons.html.twig');
        }

        return '';
    }

    public function setKernelRootDir(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function setVarDir(string $varDir)
    {
        $this->varDir = $varDir;
    }

    public function setStorageDir(string $storageDir)
    {
        $this->storageDir = $storageDir;
    }
}
