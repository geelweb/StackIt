<?php
/**
 * Stack processor interface
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor
 */

namespace StackIt\Processor;

/**
 * Processor interface
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor
 */
interface IProcessor
{
    /**
     * process
     *
     * @param mixed $items
     * @access public
     * @return void
     */
    public function process($items);
}
