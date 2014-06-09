<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Weather\Controller\Weather' => 'Weather\Controller\WeatherController',
            'Weather\Controller\Ajax' => 'Weather\Controller\AjaxController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'weather' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/weather',
                    'defaults' => array(
                        'controller'    => 'Weather\Controller\Weather',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'ajax' => array(
                		'type' => 'segment',
                		'options' => array(
            				'route' => '/ajax/:action/:slug',
                		    'constraints' => array(
                		        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
            		            'slug'    => '[a-zA-Z-/]+',
                		    ),
            				'defaults' => array(
            				    'controller'    => 'Weather\Controller\Ajax',
            				),
                		),
                    ),
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Weather' => __DIR__ . '/../view',
        ),
    ),
);
