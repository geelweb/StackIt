<?php
/**
 * PostgreSQL CopyFromStdin processor
 *
 * @author  Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_PostgreSQL
 */

namespace StackIt\Processor\PostgreSQL;

/**
 * CopyFromStdin processor insert data in a PostgreSQL database using only one
 * "copy from stdin" query
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_PostgreSQL
 */
class CopyFromStdin extends \StackIt\Processor\AProcessor implements \StackIt\Processor\IProcessor
{
    /**
     * process
     *
     * @param mixed $items
     * @access public
     * @return void
     */
    public function process($items)
    {
        $conn = pg_connect($this->_cfg['pg_conn_str']);
        pg_query($conn, sprintf(
            "copy %s (%s) from stdin",
            $this->_cfg['pg_insert_table'],
            $this->_cfg['pg_insert_columns']));

        $columns = explode(',', $this->_cfg['pg_insert_columns']);

        foreach($items as $row) {
            $data=array();
            foreach ($columns as $c) {
                $data[] = $row[$c];
            }
            pg_put_line($conn, implode("\t", $data) . "\n");
        }
        pg_end_copy($conn);
    }
}
