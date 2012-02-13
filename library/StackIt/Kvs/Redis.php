<?php
/**
 * Redis key value store mapper
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */

namespace StackIt\Kvs;

/**
 * Redis
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */
class Redis extends AKvs Implements IKvs
{
    /**
     * _initCli
     *
     * @access protected
     * @return void
     */
    protected function _initCli()
    {
        $this->_cli = new \Redis;
        $this->_cli->pconnect(
            $this->_cfg['redis_host'],
            $this->_cfg['redis_port']
        );
        return $this->_cli;
    }

    /**
     * push
     *
     * @param mixed $id
     * @param mixed $value
     * @access public
     * @return void
     */
    public function push($id, $value)
    {
        $this->_cli->rpush($id, serialize($value));
    }

    /**
     * pop
     *
     * @param mixed $id
     * @access public
     * @return void
     */
    public function pop($id)
    {
        $len = $this->_cli->llen($id);
        $items = $this->_cli->lrange($id, 0, $len);
        $this->_cli->ltrim($id, $len, -1);

        $items = array_map('unserialize', $items);

        return $items;
    }
}
