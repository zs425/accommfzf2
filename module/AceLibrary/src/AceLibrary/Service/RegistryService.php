<?php
namespace AceLibrary\Service;

class RegistryService
{

    protected $registry = array();

    public function set($key, $var)
    {
        $key = (string)$key;
        if (!strlen($key)) {
            throw new \Exception('Invalid registry key');
        }
        $this->registry[$key] = $var;
    }

    public function get($key)
    {
        if (!$this->exists($key)) {
            throw new \Exception('Specified key does not exist in the registry');
        }
        return $this->registry[$key];
    }

    public function exists($key)
    {
        return array_key_exists($key, $this->registry);
    }
}