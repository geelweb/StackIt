<?php
/**
 * Processor to insert stack elements in a table
 *
 * @author  Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_PostgreSQL
 */

namespace StackIt\Processor\PostgreSQL;

/**
 * Insert data in a PostgreSQL table
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_PostgreSQL
 */
class Insert extends \StackIt\Processor\AProcessor implements \StackIt\Processor\IProcessor
{
    public function process($items)
    {
        $conn = pg_connect($this->_cfg['pg_conn_str']);
        foreach($items as $row) {
            pg_insert($conn, $this->_cfg['pg_insert_table'], $row);
        }
    }
}

