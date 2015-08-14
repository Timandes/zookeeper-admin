<?php
/**
 * ZookeeperClient
 *
 * @package zookeeper-admin
 */

namespace timandes;

/**
 * Wrapper of ZookeeperClient
 *
 * @author Timandes White <timands@gmail.com>
 */
class ZookeeperClient extends \ZookeeperClient
{
    public function get($path)
    {
        $value = parent::get($path);
        if (!is_string($value))
            return $value;
        
        $retval = @unserialize($value);
        if ($retval === false)
            return $value;
        else
            return $retval;
    }
}
