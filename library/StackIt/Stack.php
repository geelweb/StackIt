<?php
/**
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt
 */

namespace StackIt;

/**
 * StackIt is a library to push data in stack then to pop them latter for mass
 * procesing
 *
 * <code>
 * StackIt\Stack::setConfig('config.ini');
 * StackIt\Stack::push('my-stack', array('foo'));
 * </code>
 *
 * @example examples/config.ini A basic ini config file
 * @example examples/stack_push.php Push to the stack
 * @example examples/daemon.php Process the stack
 *
 * @authorGuillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt
 */
class Stack
{
    /**
     *
     */
    private static $_config = array();

    /**
     *
     */
    private static $_instance = array();

    /**
     * Load the KVS objectaccording to the given stack ID
     *
     * @param string $id The stack ID
     * @static
     * @access public
     * @return void
     */
    public static function factory($id)
    {
        if (!isset(self::$_instance[$id])) {
            if (!isset(self::$_config[$id])) {
                throw new Exception('Stack configuration not found');
            }

            if (!isset(self::$_config[$id]['kvs'])) {
                throw new Exception('kvs entry not found in stack config');
            }

            $class = self::$_config[$id]['kvs'];
            if (!class_exists($class)) {
                $class = "StackIt\Kvs\\$class";
                if (!class_exists($class)) {
                    throw new Exception('KVS ' . $class . ' not found');
                }
            }

            self::$_instance[$id] = $class::singleton(self::$_config[$id]);
        }

        return self::$_instance[$id];
    }

    /**
     * setConfig
     *
     * @param mixed $config
     * @static
     * @access public
     * @return void
     */
    public static function setConfig($config)
    {
        if (is_array($config)) {
            self::$_config = $config;
        } elseif(is_string($config) && file_exists($config)) {
            self::$_config = parse_ini_file($config, true);
        }
    }

    /**
     * getConfig
     *
     * @param mixed $id
     * @static
     * @access public
     * @return void
     */
    public static function getConfig($id=null)
    {
        return $id !== null && isset(self::$_config[$id]) ? self::$_config[$id] : self::$_config;
    }

    /**
     * getStacksIds
     *
     * @static
     * @access public
     * @return void
     */
    public static function getStacksIds()
    {
        return array_keys(self::$_config);
    }

    /**
     * push
     *
     * @param mixed $id
     * @param mixed $value
     * @static
     * @access public
     * @return void
     */
    public static function push($id, $value)
    {
        self::factory($id)->push($id, $value);
    }

    /**
     * process
     *
     * @param mixed $id
     * @static
     * @access public
     * @return void
     */
    public static function process($id)
    {
        $items = self::factory($id)->pop($id);

        if (!isset(self::$_config[$id]['processor'])) {
            throw new Exception('processor entry not found in stack config');
        }

        $class = self::$_config[$id]['processor'];
        if (!class_exists($class)) {
            $class = "StackIt\Processor\\$class";
            if (!class_exists($class)) {
                throw new Exception('Processor ' . $class . ' not found');
            }
        }
        $proc = $class::singleton(self::$_config[$id]);
        return $proc->process($items);
    }
}

