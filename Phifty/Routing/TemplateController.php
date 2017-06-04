<?php
namespace Phifty\Routing;
use Pux\Controller\Controller;

class TemplateController extends Controller
{
    public $template;

    public $args = array();

    public function __construct(array $environment = array(), array $response = array(), array $matchedRoute = array())
    {
        parent::__construct($environment, $response, $matchedRoute);
        list($pcre, $path, $callback, $options ) = $matchedRoute;

        $args = $options['args'];
        $this->template = $args['template'];
        $this->args = isset($args['template_args']) ? $args['template_args'] : array();
    }

    public function run()
    {
        $template   = $this->template;
        $args       = $this->args;
        $view = kernel()->getObject('view', [kernel(), kernel()->config->get('framework','View.Class') ?: \Phifty\View::class]);
        if ($args) {
            $view->assign($args);
        }
        return $view->render( $template );
    }
}
