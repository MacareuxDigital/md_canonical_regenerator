<?php
/**
 * @author: Biplob Hossain <biplob.ice@gmail.com>
 */

namespace Concrete\Package\MdCanonicalRegenerator;

use Concrete\Core\Application\Application;
use Concrete\Core\Package\Package;
use Macareux\CanonicalRegenerator\Console\Command\CanonicalRegeneratorCommand;

class Controller extends Package
{
    /**
     * @var string package handle
     */
    protected $pkgHandle = 'md_canonical_regenerator';

    /**
     * @var string required concrete5 version
     */
    protected $appVersionRequired = '8.0.0';

    /**
     * @var string package version
     */
    protected $pkgVersion = '0.0.1';

    /**
     * @var array Autoload custom classes
     */
    protected $pkgAutoloaderRegistries = [
        'src' => '\Macareux\CanonicalRegenerator',
    ];

    /**
     * @return string Package name
     */
    public function getPackageName(): string
    {
        return t('Macareux Canonical Regenerator');
    }

    /**
     * @return string Package description
     */
    public function getPackageDescription(): string
    {
        return t('Enhance SEO with Canonical Regenerator for Concrete CMS.');
    }

    public function on_start(): void
    {
        $this->registerCommands();
    }

    /**
     * Package installation process.
     */
    public function install(): void
    {
        parent::install();
    }

    /**
     * Package upgrade process.
     */
    public function upgrade(): void
    {
        parent::upgrade();
    }

    private function registerCommands(): void
    {
        if (Application::isRunThroughCommandLineInterface()) {
            $console = $this->app->make('console');
            $console->add(new CanonicalRegeneratorCommand());
        }
    }
}
