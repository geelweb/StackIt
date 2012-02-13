<?php
/**
 * Key Value Store objects abstract class
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */

namespace StackIt\Kvs;

/**
 * Kvs abstract class
 *
 * @abstract
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */
abstract class AKvs
{
    /**
     * _cfg
     *
     * @var mixed
     * @access protected
     */
    protected $_cfg = null;

    /**
     * _cli
     *
     * @var mixed
     * @access protected
     */
    protected $_cli = false;

    /**
     *
     */
    private static $_instance = array();

    /**
     * __construct
     *
     * @param mixed $cfg
     * @access private
     * @return void
     */
    private function __construct($cfg)
    {
        $this->_cfg = $cfg;
        $this->_cli = $this->_initCli();
    }

    /**
     * singleton
     *
     * @param mixed $cfg
     * @static
     * @access public
     * @return void
     */
    public static function singleton($cfg=null)
    {
        $hash = md5(serialize($cfg));
        if (!isset(self::$_instance[$hash])) {
            self::$_instance[$hash] = new static($cfg);
        }

        return self::$_instance[$hash];
    }

    /**
     * _initCli
     *
     * @abstract
     * @access protected
     * @return void
     */
    abstract protected function _initCli();
}
