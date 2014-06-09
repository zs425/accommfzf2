<?php
namespace AceLibrary\Service;

/**
 * @author n3ziniuka5
 * @property array                                    $cacheArray
 */
class CacheService
{
    protected $cacheArray = array();

    const FIVE_MINUTES   = 300;
    const TEN_MINUTES    = 600;
    const THIRTY_MINUTES = 1800;
    const ONE_HOUR       = 3600;
    const SIX_HOURS      = 21600;
    const TWELVE_HOURS   = 43200;
    const ONE_DAY        = 86400;
    const THREE_DAYS     = 259200;
    const ONE_WEEK       = 604800;
    const TWO_WEEKS      = 1209600;
    const FOUR_WEEKS     = 2419200;

    /**
     * @param     $namespace
     * @param int $ttl
     * @return \Zend\Cache\Storage\StorageInterface
     */
    public function getCache($namespace, $ttl = self::FIVE_MINUTES)
    {
        $arrayKey = $namespace . '-' . $ttl;
        if (!array_key_exists($arrayKey, $this->cacheArray)) {
            $this->cacheArray[$arrayKey] = \Zend\Cache\StorageFactory::factory(array(
                'adapter' => array(
                    'name'    => 'filesystem',
                    'options' => array(
                        'namespace'   => $namespace,
                        'ttl'         => $ttl,
                        'cache_dir'   => 'data/cache',
                        'key_pattern' => '/^[\\a-z0-9_\+\-\[\]\$]*$/Di' //
                    ),
                ),
                'plugins' => array(
                    'exception_handler' => array(
                        'throw_exceptions' => false
                    ),
                    'Serializer',
                )
            ));
        }
        return $this->cacheArray[$arrayKey];
    }
}