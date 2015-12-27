<?php

namespace Phifty\View;

use Phifty\FileUtils;

abstract class Engine
{
    public $kernel;
    public $options = array();
    public $templateDirs = array();

    private $renderer;

    /*
     * Contructor
     *   template_dirs
     *   cache_dir
     */
    public function __construct( $options = array() )
    {
        $this->kernel = kernel();

        /* save options */
        $this->options = $options;

        /* preprocess options */
        if ( isset( $options['template_dirs'] ) )
            $this->templateDirs = (array) $options['template_dirs'];

        if ( empty( $this->templateDirs) ) {
            $this->templateDirs = $this->getDefaultTemplateDirs();
        }
    }

    public function getDefaultTemplateDirs()
    {
        // when we move all bundles into applications, we take off the PH_APP_ROOT and PH_ROOT from paths
        $dirs = array(
            $this->kernel->rootAppDir,
            $this->kernel->frameworkAppDir,
            $this->kernel->rootBundleDir,
            $this->kernel->frameworkBundleDir,
            $this->kernel->rootDir,
            $this->kernel->frameworkDir,
        );

        if ( $configDirs = $this->kernel->config->get('framework','View.TemplateDirs') ) {
            foreach ($configDirs as $dir) {
                $dirs[] = PH_APP_ROOT . '/' . $dir;
            }
        }

        return $dirs;
    }

    /*
     * Method for creating new renderer object
     */
    abstract public function newRenderer();

    /*
     * Return Renderer object, statical
     */
    public function getRenderer()
    {
        if ( $this->renderer )

            return $this->renderer;
        return $this->renderer = $this->newRenderer();
    }

    /* refactor to Phifty\View\Smarty and Phifty\View\Twig */
    public static function createEngine( $backend , $opts = array() )
    {
        switch ($backend) {
            case "twig":
                return new \Phifty\View\Twig( $opts );
            case "php":
                return new \Phifty\View\Php( $opts );
            default:
                throw new \Exception("Engine type $backend is not supported.");
        }
    }


    /* render method should be defined,
     * we should just call render method by default. */
    public function display( $template , $args = null )
    {
        echo $this->render( $template , $args );
    }

}
