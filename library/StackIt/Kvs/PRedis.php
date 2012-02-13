<?php
/**
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */

namespace StackIt\Kvs;

/**
 * PRedis kvs mapper
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */
class PRedis extends AKvs Implements IKvs
{
    /**
     * _initCli
     *
     * @access protected
     * @return void
     */
    protected function _initCli()
    {
        $this->_cli = new \Predis\Client(array(
            'host' => $this->_cfg['redis_host'],
            'port' => $this->_cfg['redis_port'],
            'connection_persistent' => true,
            'connection_async' => true,
        ));
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
