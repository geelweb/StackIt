<?php
/**
 * StackIt Daemon object
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt
 */

namespace StackIt;

/**
 * Daemon object used to process the stacks
 *
 * <code>
 * StackIt\Daemon::setConfig('config.ini');
 * StackIt\Daemon::singleton()->daemonize();
 * </code>
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt
 */
class Daemon
{
    /**
     *
     * @access private
     */
    private static $_instance = null;

    /**
     *
     * @access private
     */
    private static $_proc = array();

    /**
     * __construct
     *
     * @access private
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * singleton
     *
     * @access public
     * @return void
     */
    public function singleton()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * setConfig
     *
     * @param mixed $cfg
     * @static
     * @access public
     * @return void
     */
    public static function setConfig($cfg)
    {
        Stack::setConfig($cfg);
    }

    /**
     * run
     *
     * @param array $IDs
     * @param mixed $daemon
     * @access public
     * @return void
     */
    public function run($IDs=array(), $daemon=false)
    {
        if (empty($IDs)) {
            $IDs = Stack::getStacksIds();
        }

        $nb_proc=0;
        foreach ($IDs as $id) {
            if ($daemon && !$this->_checkInterval($id)) {
                continue;
            }
            if ($daemon && !$this->_checkMaxExecution($id)) {
                exit(1);
            }

            $this->_initProc($id);
            Stack::process($id);
            $nb_proc++;
        }

        return $nb_proc;
    }

    /**
     * daemonize
     *
     * @param array $IDs
     * @param int $sleeping_delay
     * @access public
     * @return void
     */
    public function daemonize($IDs=array(), $sleeping_delay=3600)
    {
        $sleeping = 0;
        while(true) {
            $nb_proc = $this->run($IDs, true);
            if ($nb_proc == 0) {
                $sleeping++;
                if ($sleeping >= $sleeping_delay) {
                    // daemon do nothing since more than 1 hour (or sleeping
                    // delay)
                    exit(1);
                }
            }
            sleep(1);
        }
    }

    /**
     * _initProc
     *
     * @param mixed $id
     * @access private
     * @return void
     */
    private function _initProc($id)
    {
        if (!isset(self::$_proc[$id])) {
            self::$_proc[$id] = array(
                'last_execution_time' => 0,
                'nb_execution' => 0,
            );
        }

        self::$_proc[$id]['last_execution_time'] = time();
        self::$_proc[$id]['nb_execution']++;
    }

    /**
     * _checkInterval
     *
     * @param mixed $id
     * @access private
     * @return void
     */
    private function _checkInterval($id)
    {
        if (!isset(self::$_proc[$id])) {
            // never executed
            return true;
        }

        $cfg = Stack::getConfig($id);
        if (!isset($cfg['interval']) || $cfg['interval'] == 0) {
            // no interval defined between 2 execution
            return true;
        }
        if (self::$_proc[$id]['last_execution_time'] < time() - $cfg['interval']) {
            // executed before "interval" ago
            return true;
        }

        return false;
    }

    /**
     * _checkMaxExecution
     *
     * @param mixed $id
     * @access private
     * @return void
     */
    private function _checkMaxExecution($id)
    {
        if (!isset(self::$_proc[$id])) {
            // never executed
            return true;
        }

        $cfg = Stack::getConfig($id);
        if (!isset($cfg['max_execution']) || $cfg['max_execution'] == 0) {
            // no limit
            return true;
        }

        if ($cfg['max_execution'] > self::$_proc[$id]['nb_execution']) {
            // max number of executions not reached
            return true;
        }

        return false;
    }
}
