<?php
/**
 * Key Value Store objects interface
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */

namespace StackIt\Kvs;

/**
 * Kvs interface
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Kvs
 */
interface IKvs
{
    /**
     * push
     *
     * @param mixed $id
     * @param mixed $value
     * @access public
     * @return void
     */
    public function push($id, $value);

    /**
     * pop
     *
     * @param mixed $id
     * @access public
     * @return void
     */
    public function pop($id);
}
