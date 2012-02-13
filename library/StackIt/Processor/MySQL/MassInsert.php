<?php
/**
 * MySQL mass insert processor
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_MySQL
 */

namespace StackIt\Processor\MySQL;

/**
 * MassINsert processor. Insert data in a MySQL database with only one insert.
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_MySQL
 */
class MassInsert extends \StackIt\Processor\AProcessor implements \StackIt\Processor\IProcessor
{
    public function process($items)
    {
        $conn = mysql_pconnect(
            $this->_cfg['mysql_server'],
            $this->_cfg['mysql_username'],
            $this->_cfg['mysql_password']);

        if (!$conn) {
            throw new \StackIt\Exception('Error connecting to the database');
        }

        if (!mysql_select_db($this->_cfg['mysql_database'], $conn)) {
            throw new \StackIt\Exception('Error setting the active database');
        }

        $query = 'insert into %s (%s) values %s';

        $columns = explode(',', $this->_cfg['mysql_insert_columns']);

        $values = array();
        foreach ($items as $row) {
            $data = array();
            foreach($columns as $c) {
                $data[] = mysql_real_escape_string($row[$c]);
            }
            $values[] = "'" . implode("', '", $data) . "'";
        }

        $query = sprintf($query,
            $this->_cfg['mysql_insert_table'],
            implode(', ', $columns),
            '(' . implode('), (', $values) . ')');

        if (!mysql_query($query, $conn)) {
            throw new \StackIt\Exception('Error inserting data');
        }
    }
}
