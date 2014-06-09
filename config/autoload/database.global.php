<?php
use AceLibrary\Service\CacheService;
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        	'doctrine.cache.metadata-cache' => function ($sm) {
        		$zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('doctrine-metadata', CacheService::ONE_WEEK); //1 week
        		$doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache); 
        		return $doctrineCache;
        	},
        	'doctrine.cache.query-cache' => function ($sm) {
        		$zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('doctrine-query', CacheService::ONE_WEEK); //1 week
        		$doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
        		return $doctrineCache;
        	},
        	'doctrine.cache.driver-cache' => function ($sm) {
        		$zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('doctrine-driver', CacheService::ONE_WEEK); //1 week
        		$doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
        		return $doctrineCache;
        	},
        	'doctrine.cache.result-cache' => function ($sm) {
        		$zendCache = $sm->get('AceLibrary\Service\CacheService')->getCache('doctrine-result');
        		$doctrineCache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
        		return $doctrineCache;
        	},
        ),
    ),
    'db' => array(
        'driver' => 'pdo',
    ),
    'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
				'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => array(
					'host'     => 'localhost',
					'port'     => '3306',
					'charset'  => 'utf8',
                ),
			),
		),
		'driver' => array(
			'application_entities' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'driver-cache',
				'paths' => array('module/Travel/src/Travel/Entity'),
			),
			'orm_default' => array(
				'drivers' => array(
					'Travel\Entity' => 'application_entities',
				),
			),
		),
    	'configuration' => array(
    		// Configuration for service `doctrine.configuration.orm_default` service
    		'orm_default' => array(
    			// metadata cache instance to use. The retrieved service name will
    			// be `doctrine.cache.$thisSetting`
    			'metadata_cache'    => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'metadata-cache',
    		
    			// DQL queries parsing cache instance to use. The retrieved service
    			// name will be `doctrine.cache.$thisSetting`
    			'query_cache'       => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'query-cache',
    		
    			// ResultSet cache to use.  The retrieved service name will be
    			// `doctrine.cache.$thisSetting`
    			'result_cache'      => getenv('APPLICATION_ENV') == 'development' ? 'array' : 'result-cache',
    		
    			// Generate proxies automatically (turn off for production)
    			'generate_proxies'  => getenv('APPLICATION_ENV') == 'development',
    		),
    	),
    ),
);