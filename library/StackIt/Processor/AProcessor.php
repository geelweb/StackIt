<?php
/**
 * StackIt processor abstract class
 *
 * @author  Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor
 */

namespace StackIt\Processor;

/**
 * Processor abstract class
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor
 */
abstract class AProcessor
{
    /**
     * _cfg
     *
     * @var mixed
     * @access protected
     */
    protected $_cfg = null;

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
}
