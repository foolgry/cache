<?php

namespace foolgry;

class gcache implements cache
{
    private static $_cache = [];
    private static $instance;

    private function __construct()
    {
    }

    public function instance()
    {
        if (isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 获取缓存
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return self::$_cache[$key] ?? $default;
    }

    public function __get($name)
    {
        return self::$_cache[$name];
    }

    /**
     * 设置缓存
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        self::$_cache[$key] = $value;
    }

    public function __set($name, $value)
    {
        self::$_cache[$name] = $value;
    }

    /**
     * 删除缓存
     * @param $key
     */
    public function del($key)
    {
        unset(self::$_cache[$key]);
    }

    public function __unset($name) {
        unset(self::$_cache[$name]);
    }

    /**
     * 获取组缓存
     * @param $group
     * @param $key
     * @return mixed
     */
    public function groupGet($group, $key, $default = null)
    {
        return (isset(self::$_cache[$group]) && is_array(self::$_cache[$group])) ? (self::$_cache[$group][$key] ?? $default) : $default;
    }

    /**
     * 设置组缓存
     * @param $group
     * @param $key
     * @param $value
     */
    public function groupSet($group, $key, $value)
    {
        if (!isset(self::$_cache[$group])) {
            self::$_cache[$group] = [];
        }
        self::$_cache[$group][$key] = $value;
    }

    /**
     * 删除组缓存
     * @param $group
     * @param $key
     */
    public function groupDel($group, $key)
    {
        if (isset(self::$_cache[$group])) {
            unset(self::$_cache[$group][$key]);
        }
    }

    /**
     * 根据key获取增长数据
     * @param $key
     * @param int $step
     * @return numeric
     */
    public function incr($key, $step = 1.0)
    {
        if (!is_numeric(self::$_cache[$key])) {
            self::$_cache[$key] = 0;
        }
        self::$_cache[$key] += $step;
        return self::$_cache[$key];
    }

    /**
     * 是否存在
     * @param $key
     * @return bool
     */
    public function exist($key)
    {
        return isset(self::$_cache[$key]);
    }

    public function __isset($name) {
        return null !== self::$_cache[$name];
    }

    /**
     * 不存在就设置 put if absent
     * @param $key
     * @param $value
     * @return bool
     */
    public function setnx($key, $value)
    {
        if (isset(self::$_cache[$key])) {
            return false;
        } else {
            self::$_cache[$key] = $value;
            return true;
        }
    }

    /**
     * 对比设置
     * @param $key
     * @param $old
     * @param $value
     * @return bool
     */
    public function cas($key, $old, $value)
    {
        if (md5(serialize($old)) == md5(serialize(self::$_cache[$key]))) {
            self::$_cache[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * 左边出一个
     * @param $key
     * @return mixed
     */
    public function lpop($key)
    {
        $value = self::$_cache[$key];
        if (isset($value) && is_array($value) && count($value) > 0) {
            return array_shift(self::$_cache[$key]);
        }
        return null;
    }

    /**
     * 右边出一个
     * @param $key
     * @return mixed
     */
    public function rpop($key)
    {
        $value = self::$_cache[$key];
        if (isset($value) && is_array($value)) {
            return array_pop(self::$_cache[$key]);
        }
        return null;
    }

    /**
     * 左边进一个
     * @param $key
     */
    public function lpush($key, $value)
    {
        if (!isset(self::$_cache[$key])) {
            self::$_cache[$key] = [];
        }
        array_unshift(self::$_cache[$key], $value);
    }

    /**
     * 右边进一个
     * @param $key
     * @param $value
     */
    public function rpush($key, $value)
    {
        if (!isset(self::$_cache[$key])) {
            self::$_cache[$key] = [];
        }
        array_push(self::$_cache[$key], $value);
    }
}