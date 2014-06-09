<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin'    => 'Admin\Controller\AdminController',
            'Admin\Controller\Content'  => 'Admin\Controller\ContentController',
            'Admin\Controller\Alias'  => 'Admin\Controller\AliasController',
        	'Admin\Controller\Options'  => 'Admin\Controller\OptionsController',
            'Admin\Controller\Slideshow'  => 'Admin\Controller\SlideshowController',
            'Admin\Controller\Modules'  => 'Admin\Controller\ModulesController',
            'Admin\Controller\Utils'  => 'Admin\Controller\UtilsController',
            'Admin\Controller\Menus'  => 'Admin\Controller\MenusController',
            'Admin\Controller\Product'  => 'Admin\Controller\ProductController',
            'Admin\Controller\Destination'  => 'Admin\Controller\DestinationController',
            'Admin\Controller\Information'  => 'Admin\Controller\InformationController',
            'Admin\Controller\Orphanproduct'  => 'Admin\Controller\OrphanproductController',
            'Admin\Controller\Site'          => 'Admin\Controller\SiteController',
            'Admin\Controller\Test'          => 'Admin\Controller\TestController',
            'Admin\Controller\Manualmatchdestination' => 'Admin\Controller\ManualmatchdestinationController',
            'Admin\Controller\Viewdestination' => 'Admin\Controller\ViewdestinationController',
            'Admin\Controller\Gethotelinformation' => 'Admin\Controller\GethotelinformationController',
            'Admin\Controller\Updatetask' => 'Admin\Controller\UpdatetaskController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'options' => array(
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                	'updatetask' => array(
                		'type' => 'literal',
        				'options' => array(
    						'route' => '/updatetask',
    						'defaults' => array(
    							'controller' => 'Admin\Controller\Updatetask',
								'action'     => 'update',
    						),
        				), 
					),
            		'dashboard' => array(
        				'type' => 'literal',
        				'options' => array(
    						'route' => '/dashboard',
    						'defaults' => array(
								'action'     => 'dashboard',
    						),
        				),
            		),
                    'logout' => array(
                		'type' => 'literal',
                		'options' => array(
            				'route' => '/logout',
            				'defaults' => array(
        						'action'     => 'logout',
            				),
                		),
                    ),
                	'settings' => array(
                		'type' => 'Literal',
                		'options' => array(
                			'route' => '/settings',
                			'defaults' => array(
                				'controller' => 'Admin\Controller\Options',
        						'action'     => 'list',
                			),                			               			
                		),
                		'may_terminate' => true,
                		'child_routes' => array(
                			'options' => array(
                				'type' => 'segment',
                				'options' => array(
                					'route' => '/options[/:action/:id]',
                					'defaults' => array(
                						'controller' => 'Admin\Controller\Options',
                						'action'     => 'list',
                					),
                					'constraints' => array(
                						'id'  => '[0-9]+',
                					)
                				),
                			),
                            'providers' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/providers[/:action/:id]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'providers',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),
                            'site' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/site',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'site',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),

                            'providers' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/providers[/:action/:id]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'providers',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),
                            'blog' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/blog[/:action/:id]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'blog',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),
                            'themes' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/themes[/:action/:id]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'themes',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),
                            'status' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/status[/:action/:id]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'status',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),
                            'seo' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/seo[/:action/:id]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'seo',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),
                            'services' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/services[/:action/:id]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Options',
                                        'action'     => 'services',
                                    ),
                                    'constraints' => array(
                                        'id'  => '[0-9]+',
                                    )
                                ),
                            ),

                		),
                	),
                    'content' => array(
                        'type' => 'literal',
                		'options' => array(
            				'route' => '/content',
            				'defaults' => array(
            				    'controller' => 'Admin\Controller\Content',
        						'action'     => 'listPages',
            				),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                        		'type'    => 'Segment',
                        		'options' => array(
                    				'route'    => '/:action[/:id]',
                    				'constraints' => array(
                						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                    				    'id'      => '[0-9]+',
                    				),
                        		),
                            ),
                            'alias' => array(
                        		'type' => 'segment',
                        		'options' => array(
                    				'route' => '/aliases[/:action/:id]',
                    				'defaults' => array(
                						'action'     => 'list',
                    				    'controller' => 'Admin\Controller\Alias',
                    				),
                        		    'constraints' => array(
                        		        'id'  => '[0-9]+',
                        		    )
                        		),                                
                            ),
                        ),
                    ),
                    
					'utils' => array(
                        'type' => 'literal',
                		'options' => array(
            				'route' => '/utils',
            				'defaults' => array(
            				    'controller' => 'Admin\Controller\Utils',
        						'action'     => 'cropImage',
            				),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                        		'type'    => 'Segment',
                        		'options' => array(
                    				'route'    => '/:action[/:id]',
                    				'constraints' => array(
                						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                    				    'id'      => '[0-9]+',
                    				),
                        		),
                            ),                            
                        ),
                    ),
                    
                    'menus' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/menus[/:action][/:id]',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Menus',
                                'action'     => 'index',
                            ),
                            'constraints' => array(
                                'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'      => '[0-9]+',
                            ),
                        ),
                    ),
                    
                    'localdata' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/localdata',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Product',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'product' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/product[/:action/:id][/page/:page]',
                                    'defaults' => array(
                                        'action'     => 'index',
                                        'controller' => 'Admin\Controller\Product',
                                    ),
                                    'constraints' => array(
                                        'action' => '(?!\bpage\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'  => '[0-9]+',
                                        'page' => '[0-9]+',
                                    )
                                ),
                            ),
                            'destination' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/destination[/:action][/:id][/page/:page]',
                                    'defaults' => array(
                                        'action'     => 'index',
                                        'controller' => 'Admin\Controller\Destination',
                                    ),
                                    'constraints' => array(
                                        'action' => '(?!\bpage\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'  => '[0-9]+',
                                        'page' => '[0-9]+',
                                    )
                                ),
                            ),                            
                            'information' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/information',
                                    'defaults' => array(
                                        'action'     => 'index',
                                        'controller' => 'Admin\Controller\Information',
                                    ),
                                    'constraints' => array(
                                    )
                                ),
                            ),
                            'orphanproduct' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/orphanproduct[/:action/:id][/page/:page]',
                                    'defaults' => array(
                                        'action'     => 'index',
                                        'controller' => 'Admin\Controller\Orphanproduct',
                                    ),
                                    'constraints' => array(
                                        'action' => '(?!\bpage\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'  => '[0-9]+',
                                        'page' => '[0-9]+',
                                    )
                                ),
                            ),
                        ),
                    ),
					
                    'modules' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/modules',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Modules',
                                'action'     => 'listModules',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'      => '[0-9]+',
                                    ),
                                ),
                            ), 
                            'slideshow' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/slideshow',
                                    'defaults' => array(
                                        'action'     => 'listSlideshow',
                                        'controller' => 'Admin\Controller\Slideshow',
                                    ),                                    
                                ),
                                'may_terminate' => true,
		                        'child_routes' => array(
		                            'default' => array(
		                        		'type'    => 'Segment',
		                        		'options' => array(
		                    				'route'    => '/:action[/:id]',
		                    				'constraints' => array(
		                						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
		                    				    'id'      => '[0-9]+',
		                    				),
		                        		),
		                            ),
		                        ),                                
                            ),                           
                        ),
                    ),
                    
					'centraldb' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/centraldb',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Site',
                                'action'     => 'listWebsites',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'      => '[0-9]+',
                                    ),
                                ),
                            ), 
                            'site' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/site',
                                    'defaults' => array(
                                        'action'     => 'listWebsites',
                                        'controller' => 'Admin\Controller\Site',
                                    ),                                    
                                ),
                                'may_terminate' => true,
		                        'child_routes' => array(
		                            'default' => array(
		                        		'type'    => 'Segment',
		                        		'options' => array(
		                    				'route'    => '/:action[/:id]',
		                    				'constraints' => array(
		                						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
		                    				    'id'      => '[0-9]+',
		                    				),
		                        		),
		                            ),
		                        ),                                
                            ), 
                            'manualmatchdestination' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/manualmatchdestination',
                                    'defaults' => array(
                                        'action'     => 'index',
                                        'controller' => 'Admin\Controller\Manualmatchdestination',
                                    ),                                    
                                ),
                                'may_terminate' => true,
		                        'child_routes' => array(
		                            'default' => array(
		                        		'type'    => 'Segment',
		                        		'options' => array(
		                    				'route'    => '/:action[/:id]',
		                    				'constraints' => array(
		                						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
		                    				    'id'      => '[0-9]+',
		                    				),
		                        		),
		                            ),
		                        ),                                
                            ),
                            'viewdestination' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/viewdestination',
                                    'defaults' => array(
                                        'action'     => 'index',
                                        'controller' => 'Admin\Controller\Viewdestination',
                                    ),                                    
                                ),
                                'may_terminate' => true,
		                        'child_routes' => array(
		                            'default' => array(
		                        		'type'    => 'Segment',
		                        		'options' => array(
		                    				'route'    => '/:action[/:id]',
		                    				'constraints' => array(
		                						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
		                    				    'id'      => '[0-9]+',
		                    				),
		                        		),
		                            ),
		                        ),                                
                            ), 
                            'gethotelinformation' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/gethotelinformation',
                                    'defaults' => array(
                                        'action'     => 'import',
                                        'controller' => 'Admin\Controller\Gethotelinformation',
                                    ),                                    
                                ),
                                'may_terminate' => true,
		                        'child_routes' => array(
		                            'default' => array(
		                        		'type'    => 'Segment',
		                        		'options' => array(
		                    				'route'    => '/:action[/:id]',
		                    				'constraints' => array(
		                						'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
		                    				    'id'      => '[0-9]+',
		                    				),
		                        		),
		                            ),
		                        ),                                
                            ), 
                            'geonames' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/geonames',
		                            'defaults' => array(
		                                'controller' => 'Admin\Controller\Geonames',
		                                'action'     => 'listDestinations',
		                            ),
		                        ),
		                        'may_terminate' => true,
		                        'child_routes' => array(
		                            'default' => array(
		                                'type'    => 'Segment',
		                                'options' => array(
		                                    'route'    => '/:action[/:id]',
		                                    'constraints' => array(
		                                        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
		                                        'id'      => '[0-9]+',
		                                    ),
		                                ),
		                            ),            
		                        ),
		                    ),
		                                           
                        ),
                    ),
					'test' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/test',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Test',
                                'action'     => 'testQueueModel',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'      => '[0-9]+',
                                    ),
                                ),
                            ),                         
                        ),
                    ),
                    
					'geonames' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/geonames',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Geonames',
                                'action'     => 'listDestinations',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'      => '[0-9]+',
                                    ),
                                ),
                            ),            
                        ),
                    ),
                    
                    /*'geonames' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/geonames',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Geonames',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'      => '[0-9]+',
                                    ),
                                ),
                            ),                         
                        ),
                    ),*/
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'product-paginator' 		  => __DIR__ . '/../view/admin/product/product_pagination.phtml',
            'destination-paginator'       => __DIR__ . '/../view/admin/destination/destination_pagination.phtml',
            'orphanproduct-download-csv'  => __DIR__ . '/../view/admin/orphanproduct/download_csv.phtml',
        ),
    ),
    'zfcadmin' => array(
    	'use_admin_layout'      => false,
        'admin_login_template'  => 'layout/login',
        'admin_layout_template' => 'layout/admin',
        'remember_me_time'      => 60 * 60 * 24 * 30, //30 days
    ),
);
