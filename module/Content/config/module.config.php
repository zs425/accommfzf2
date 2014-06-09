<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Content\Controller\Content' => 'Content\Controller\ContentController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'content' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/content/:id',
                    'defaults' => array(
                        'controller'    => 'Content\Controller\Content',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Content' => __DIR__ . '/../view',
        ),
    ),
);
