<?php
return array(
    'controllers'  => array(
        'invokables' => array(
            'Travel\Controller\Accommodation' => 'Travel\Controller\AccommodationController',
            'Travel\Controller\Tours' => 'Travel\Controller\ToursController',
            'Travel\Controller\Yelp' => 'Travel\Controller\YelpController'
        )
    ),

    'router'       => array(
        'routes' => array(
            'accommodationhome'  => array(
                'type'          => 'Literal',
                'options'       => array(
                    // Change this to something specific to your module
                    'route'    => '/accommodation',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Travel\Controller',
                        'controller'    => 'Accommodation',
                        'action'        => 'index',
                        'category'      => 'accommodation'
                    )
                ),
                'may_terminate' => true,
                'child_routes'  => array(

                    'definition' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/:slug',
                            'defaults' => array(
                                'category' => 'accommodationview',
                                'action'   => 'view'
                            )
                        )
                    )

                )
            ),
            'accommcity'         => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => '/:location3/accommodation[/:page]',
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__' => 'Travel\Controller',
                                                  'controller'    => 'Accommodation',
                                                  'action'        => 'index',
                                                  //  'category' => 'accommodation',
                                                  'category'      => 'ACCOMM',
                                                  'location3'     => 'springton',
                                                  'page'          => '1'
                                              )
                                          )
            ),
            'accommcategory'     => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => "/accommodation-:classification[/:page]",
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__'  => 'Travel\Controller',
                                                  'controller'     => 'Accommodation',
                                                  'action'         => 'index',
                                                  'category'       => 'ACCOMM',
                                                  'classification' => 'dining',
                                                  'page'           => '1'
                                              )
                                          )
            ),
			'accommcategorycity'     => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => "/:location3/accommodation-:classification[/:page]",
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__'  => 'Travel\Controller',
                                                  'controller'     => 'Accommodation',
                                                  'action'         => 'index',
                                                  'category'       => 'ACCOMM',
                                                  'classification' => 'dining',
                                                  'location3'      => 'springton',
                                                  'page'           => '1'
                                              )
                                          )
            ),
            'accommview'         => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => "/accommodation/:slug",
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__' => 'Travel\Controller',
                                                  'controller'    => 'Accommodation',
                                                  'action'        => 'view',
                                                  'category'      => 'ACCOMMODATION'
                                              )
                                          )
            ),
            'attractionshome'    => array(
                'type'          => 'Literal',
                'options'       => array(
                    // Change this to something specific to your module
                    'route'    => '/attractions',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Travel\Controller',
                        'controller'    => 'Accommodation',
                        'action'        => 'index',
                        'category'      => 'attractions'
                    )
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'definition' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/:slug',
                            'defaults' => array(
                                'category' => 'attractionsview',
                                'action'   => 'view'
                            )
                        )
                    )

                )
            ),
            'attractioncity'     => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => "/:location3/attractions[/:page]",
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__' => 'Travel\Controller',
                                                  'controller'    => 'Accommodation',
                                                  'action'        => 'index',
                                                  'category'      => 'ATTRACTION',
                                                  'location3'     => 'springton',
                                                  'page'          => '1'
                                              )
                                          )
            ),
            'attractioncategory' => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => "/attractions-:classification[/:page]",
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__'  => 'Travel\Controller',
                                                  'controller'     => 'Accommodation',
                                                  'action'         => 'index',
                                                  'category'       => 'ATTRACTION',
                                                  'classification' => 'dining',
                                                  'page'           => '1'
                                              )
                                          )
            ),
            'attractioncategorycity' => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => "/:location3/attractions-:classification[/:page]",
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__'  => 'Travel\Controller',
                                                  'controller'     => 'Accommodation',
                                                  'action'         => 'index',
                                                  'category'       => 'ATTRACTION',
                                                  'classification' => 'dining',
                                                  'location3'     => 'springton',
                                                  'page'           => '1'
                                              )
                                          )
            ),
            'attractionview'     => array('type'    => 'segment',
                                          'options' => array(
                                              // Change this to something specific to your module
                                              'route'    => "/attractions/:slug",
                                              'defaults' => array(
                                                  // Change this value to reflect the namespace in which
                                                  // the controllers for your module are found
                                                  '__NAMESPACE__' => 'Travel\Controller',
                                                  'controller'    => 'Accommodation',
                                                  'action'        => 'view',
                                                  'category'      => 'ATTRACTION'
                                              )
                                          )
            ),
            'eventshome'         => array(
                'type'          => 'Literal',
                'options'       => array(
                    // Change this to something specific to your module
                    'route'    => '/events',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Travel\Controller',
                        'controller'    => 'Accommodation',
                        'action'        => 'index',
                        'category'      => 'events'
                    )
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults'    => array()
                        )
                    )
                )
            ),
            'view'               => array(
                'type'          => 'Literal',
                'options'       => array(
                    // Change this to something specific to your module
                    'route'    => '/[:category]/view',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Travel\Controller',
                        'controller'    => 'Accommodation',
                        'action'        => 'view',
                        'category'      => 'attractions'
                    )
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults'    => array()
                        )
                    )
                )
            ),
            'accommodation'      => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/accommodation',
                    'defaults' => array(
                        'controller' => 'Travel\Controller\Accommodation',
                        'action'     => 'index',
                        'category'   => 'accommodation'
                    )
                )
            ),
            'tours'      => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/tours[/:action[/:id]][/:page]',
                    'defaults' => array(
                        'controller' => 'Travel\Controller\Tours',
                        'action'     => 'index'
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                        'page'   => '[0-9]+'
                    ),
                )
            ),
            'yelp'      => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/yelp[/:action[/:id]][/:page]',
                    'defaults' => array(
                        'controller' => 'Travel\Controller\Yelp',
                        'action'     => 'index'
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                        'page'   => '[0-9]+'
                    ),
                )
            )
        )
    )
,
    'view_manager' => array(
        'template_path_stack' => array(
            'Travel' => __DIR__ . '/../view'
        )
    )
,
);
