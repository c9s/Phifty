<?php
namespace crud_template;
use GenPHP\Flavor\BaseGenerator;
use Exception;
use Phifty\Inflector;

class Generator extends BaseGenerator
{
    public function brief() { return 'generate controller class'; }

    public function generate($ns,$crudId)
    {
        $bundle = kernel()->app($ns) ?: kernel()->bundle($ns,true);
        if (! $bundle) {
            throw new Exception("$ns application or plugin not found.");
        }

        $crudId = Inflector::getInstance()->underscore($crudId);
        $templateDir = $bundle->getTemplateDir() . DIRECTORY_SEPARATOR . $crudId;
        $this->copyDir( 'template' , $templateDir );
    }

}
