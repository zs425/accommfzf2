<?php
namespace Weather\Service;

use AceLibrary\Service\CacheService;
use Travel\Service\AbstractService;
use Zend\Db\Sql\Where;

/**
 * @author n3ziniuka5
 * @property \Zend\Cache\Storage\StorageInterface   $cache
 */
class WeatherService extends AbstractService
{

    const SERVICE_URL = 'http://rss.weather.com.au/';
    const WEBSITE_URL = 'http://weather.com.au';

    protected $cache;

    protected function getCache()
    {
        if (!$this->cache) {
            $this->cache = $this->getServiceManager()->get('AceLibrary\Service\CacheService')->getCache('weather', CacheService::THIRTY_MINUTES);
        }
        return $this->cache;
    }

    public function getForecast($location)
    {
        $url     = \Zend\Uri\UriFactory::factory(self::SERVICE_URL . $location);
        $cacheId = md5($url);
        $result  = $this->getCache()->getItem($cacheId, $success);
        if (!$success) {
            $xml        = file_get_contents($url);
            $weather    = new \SimpleXMLElement($xml);
            $namespaces = $weather->getNamespaces(true);
            $item       = $weather->channel->item[1];
            $result     = array();
            foreach ($item->children($namespaces['w']) as $forecast) {
                $attributes = (array)$forecast->attributes();
                $attributes = $attributes['@attributes'];
                $result[]   = $attributes;
            }
            $this->getCache()->setItem($cacheId, $result);
        }
        return $result;
    }

    public function getDetailedForecast($location)
    {
        $url      = \Zend\Uri\UriFactory::factory(self::WEBSITE_URL . '/' . $location . '/detailed');
        $cacheId  = md5($url);
        $forecast = $this->getCache()->getItem($cacheId, $success);
        if (!$success) {
            $html = file_get_contents($url);
            $dom  = new \DOMDocument();
            $dom->loadHTML($html);
            $tables        = $dom->getElementsByTagName('table');
            $weatherTables = array();
            foreach ($tables as $table) {
                $attributes = $table->attributes;
                foreach ($attributes as $attr) {
                    if ($attr->name == 'class' && ($attr->value == 'detailed' || $attr->value == 'detailed last')) {
                        $weatherTables[] = $table;
                        break;
                    }
                }
            }

            $forecast = array();
            foreach ($weatherTables as $table) {
                $item             = array();
                $day              = $table->getElementsByTagName('th')->item(0);
                $item['day']      = $day->nodeValue;
                $item['forecast'] = array();
                $forecastItems    = $table->getElementsByTagName('tbody')->item(0)->getElementsByTagName('tr');
                foreach ($forecastItems as $forecastItem) {
                    $forecastRow     = array();
                    $forecastColumns = $forecastItem->getElementsByTagName('td');
                    foreach ($forecastColumns as $column) {
                        $attributes = $column->attributes;
                        foreach ($attributes as $attr) {
                            if ($attr->name == 'class') {
                                if ($attr->value == 'icon') {
                                    $img           = $column->getElementsByTagName('img')->item(0);
                                    $imgAttributes = $img->attributes;
                                    foreach ($imgAttributes as $imgAttr) {
                                        if ($imgAttr->name == 'src') {
                                            $forecastRow['icon'] = self::WEBSITE_URL . $imgAttr->value;
                                            break;
                                        }
                                    }
                                }
                                else {
                                    $forecastRow[$attr->value] = $column->nodeValue;
                                }
                                break;
                            }
                        }
                    }
                    $item['forecast'][] = $forecastRow;
                }
                $forecast[] = $item;
            }
            $this->getCache()->setItem($cacheId, $forecast);
        }
        return $forecast;
    }

    public function getAreaName($location)
    {
        $select = $this->getSql()->select();
        $select->columns(array('baodestination_name'));
        $select->from('bao_destinations');
        $select->where(array('baodestination_weather_url' => $location));
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result    = $statement->execute()->current();
        return $result['baodestination_name'];
    }

    public function getAvailableAreas()
    {
        $adapter = $this->getDbAdapter();
        $select  = $this->getSql()->select();
        $select->from('bao_destinations');
        $select->columns(array('baodestination_name', 'baodestination_weather_url'));
        $where = new Where();
        $where->isNotNull('baodestination_weather_url');
        $select->where($where);
        $select->order('baodestination_name asc');
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        return $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
    }

}