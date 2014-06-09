<?php
use AceLibrary\Service\CacheService;
use DoctrineORMModule\Service\DBALConnectionFactory;
use DoctrineORMModule\Service\ConfigurationFactory;
use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineModule\Service\DriverFactory;
use DoctrineModule\Service\EventManagerFactory;
use DoctrineORMModule\Service\SQLLoggerCollectorFactory;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineORMModule\Service\MappingCollectorFactory;
return array(
    'service_manager' => array(
        'factories' => array(
            'doctrine.cache.central-metadata-cache' => function ($sm) {
                $zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('central-doctrine-metadata', CacheService::ONE_WEEK); //1 week
                $doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
                return $doctrineCache;
            },
            'doctrine.cache.central-query-cache' => function ($sm) {
                $zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('central-doctrine-query', CacheService::ONE_WEEK); //1 week
                $doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
                return $doctrineCache;
            },
            'doctrine.cache.central-driver-cache' => function ($sm) {
                $zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('central-doctrine-driver', CacheService::ONE_WEEK); //1 week
                $doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
                return $doctrineCache;
            },
            'doctrine.cache.central-result-cache' => function ($sm) {
                $zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('central-doctrine-result');
                $doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
                return $doctrineCache;
            },
            'doctrine.connection.central'           => new DBALConnectionFactory('central'),
            'doctrine.configuration.central'        => new ConfigurationFactory('central'),
            'doctrine.entitymanager.central'        => new EntityManagerFactory('central'),

            'doctrine.driver.central'               => new DriverFactory('central'),
            'doctrine.eventmanager.central'         => new EventManagerFactory('central'),
            'doctrine.entity_resolver.central'      => new EntityManagerFactory('central'),
            'doctrine.sql_logger_collector.central' => new SQLLoggerCollectorFactory('central'),
            'doctrine.mapping_collector.central'    => new MappingCollectorFactory('central'),
            'DoctrineORMModule\Form\Annotation\AnnotationBuilder' => function($sl) {
                return new AnnotationBuilder($sl->get('doctrine.entitymanager.central'));
            },
        ),
    ),
    'doctrine' => array(
        'connection' => array(
            'central' => array(
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'charset'  => 'utf8',
                ),
                'configuration' => 'central',
                'eventmanager'  => 'central',
            ),
        ),
        'driver' => array(
            'central_application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'central-driver-cache',
                'paths' => array('module/CentralDB/src/CentralDB/Entity'),
            ),
            'central' => array(
                'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => array(
                    'CentralDB\Entity' => 'central_application_entities',
                ),
            ),
        ),
        'configuration' => array(
            'central' => array(
                'driver'            => 'central',
                // metadata cache instance to use. The retrieved service name will
                // be `doctrine.cache.$thisSetting`
                'metadata_cache'    => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'central-metadata-cache',
                	
                // DQL queries parsing cache instance to use. The retrieved service
                // name will be `doctrine.cache.$thisSetting`
                'query_cache'       => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'central-query-cache',
                	
                // ResultSet cache to use.  The retrieved service name will be
                // `doctrine.cache.$thisSetting`
                'result_cache'      => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'central-result-cache',
                	
                // Generate proxies automatically (turn off for production)
                'generate_proxies'  => getenv('APPLICATION_ENV') == 'development',
            ),
        ),
        'entitymanager' => array(
            'central' => array(
                'connection'    => 'central',
                'configuration' => 'central',
            )
        ),
    
        'eventmanager' => array(
            'central' => array(),
        ),
    
        'sql_logger_collector' => array(
            'central' => array(
                'name'          => 'central',
                'configuration' => 'doctrine.configuration.central',
            ),
        ),
    
        'entity_resolver' => array(
            'central' => array(),
        ),
        
    ),
    'zenddevelopertools' => array(

        'profiler' => array(
            'collectors' => array(
                'doctrine.sql_logger_collector.central' => 'doctrine.sql_logger_collector.central',
                'doctrine.mapping_collector.central'    => 'doctrine.mapping_collector.central',
            ),
        ),

        'toolbar' => array(
            'entries' => array(
                'doctrine.sql_logger_collector.central' => 'zend-developer-tools/toolbar/doctrine-orm-queries',
                'doctrine.mapping_collector.central'    => 'zend-developer-tools/toolbar/doctrine-orm-mappings',
            ),
        ),
    ),
);