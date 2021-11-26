<?php

namespace foolgry;

interface cache
{
    /**
     * 获取缓存
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * 设置缓存
     * @param $key
     * @param $value
     */
    public function set($key, $value);

    /**
     * 删除缓存
     * @param $key
     */
    public function del($key);

    /**
     * 获取组缓存
     * @param $group
     * @param $key
     * @return mixed
     */
    public function groupGet($group, $key, $default = null);

    /**
     * 设置组缓存
     * @param $group
     * @param $key
     * @param $value
     */
    public function groupSet($group, $key, $value);

    /**
     * 删除组缓存
     * @param $group
     * @param $key
     */
    public function groupDel($group, $key);

    /**
     * 根据key获取增长数据
     * @param $key
     * @param int $step
     * @return numeric
     */
    public function incr($key, $step = 1.0);

    /**
     * 是否存在
     * @param $key
     * @return bool
     */
    public function exist($key);

    /**
     * 不存在就设置 put if absent
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setnx($key, $value);

    /**
     * 对比设置
     * @param $key
     * @param $old
     * @param $value
     * @return bool
     */
    public function cas($key, $old, $value);

    /**
     * 左边出一个
     * @param $key
     * @return mixed
     */
    public function lpop($key);

    /**
     * 右边出一个
     * @param $key
     * @return mixed
     */
    public function rpop($key);

    /**
     * 左边进一个
     * @param $key
     * @param $value
     */
    public function lpush($key, $value);

    /**
     * 右边进一个
     * @param $key
     * @param $value
     */
    public function rpush($key, $value);

}