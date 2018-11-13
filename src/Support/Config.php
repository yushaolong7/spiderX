<?php
/**
 * Created by spider.
 * @File: Config.php
 * @User: Hui
 * @Author: learner.hui@gmail.com
 * @Date: 2018/11/13
 * @Time: 11:53
 */
namespace Spider\Support;

use ArrayAccess;

class Config implements ArrayAccess
{
    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function get($key, $default = null)
    {
        $config = $this->config;
        if(is_null($key)) {
            return null;
        }

        if(isset($config[$key])) {
            return $config[$key];
        }

        if(false === strpos($key, '.')) {
            return $default;
        }

        foreach (explode('.', $key) as $segment) {
            if(!is_array($config) || !array_key_exists($segment, $config)) {
                return $default;
            }
            $config = $config[$segment];
        }
        return $config;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->config);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        if(isset($this->config[$offset])) {
            $this->config[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if(isset($this->config[$offset])) {
            unset($this->config[$offset]);
        }
    }

}