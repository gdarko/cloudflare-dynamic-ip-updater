<?php

namespace gdarko\CDU;

/**
 * Class Config
 *
 * @package gdarko\CDU
 * @copyright Darko Gjorgjijoski <dg@darkog.com>
 * @license GPLv2
 */
class Config extends Base
{
    private $config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->load();
    }

    /**
     * Returns the config
     * @return mixed
     */
    public function all()
    {
        return $this->config;
    }

    /**
     * Return config value
     *
     * @param $key
     * @param  null  $default
     */
    public function get($key, $default = null)
    {
        return isset($this->config[$key]) ? $this->config[$key] : $default;
    }

    /**
     * Set config value
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * Remove config value
     *
     * @param $key
     */
    public function remove($key)
    {
        if (isset($this->config[$key])) {
            unset($this->config[$key]);
        }
    }

    /**
     * Save config value
     */
    public function save()
    {
        $path = $this->data_path();
        $json = json_encode($this->config, JSON_PRETTY_PRINT);
        file_put_contents($path, $json);
    }

    /**
     * Load the config
     */
    private function load()
    {
        $path = $this->data_path();
        if (file_exists($path)) {
            $contents = file_get_contents($path);
            $decoded  = json_decode($contents, true);
            if (is_array($decoded)) {
                $this->config = $decoded;
            } else {
                $this->config = array();
            }
        } else {
            $this->config = array();
        }
    }

    /**
     * Return the data path
     *
     * @return string
     */
    private function data_path() {
        return $this->path('.data');
    }

}