<?php
namespace AceLibrary\View\Helper;

class ThisRouteHelper extends AbstractViewHelper
{
    private $routeName;

    public function __construct($e)
    {
        $route = $e->getRouteMatch();
        if ($route) {
            $this->routeName = $route->getMatchedRouteName();
        }
        else {
            $this->routeName = '';
        }
    }

    public function __invoke()
    {
        return $this->routeName;
    }
}