<?php
/**
 * Exec processor
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_Console
 */

namespace StackIt\Processor\Console;

/**
 * Exec processor used to execute script using the php exec command
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt_Processor_Console
 */
class Exec extends \StackIt\Processor\AProcessor implements \StackIt\Processor\IProcessor
{
    public function process($items)
    {
        foreach ($items as $item) {
            $output = array();
            exec((string) $item, $output);

            $this->_log($output);
        }
    }

    protected function _log($data)
    {
        if (isset ($this->_cfg['exec_log_method'])) {
            switch ($this->_cfg['exec_log_method']) {
            case 'syslog':
                foreach ($data as $row) {
                    syslog(LOG_INFO, $row);
                }
                break;
            case 'file':
                $fh = fopen($this->_cfg['exec_log_file'], 'a');
                if (!$fh) {
                    throw new \StackIt\Exception(sprintf('Unable to open log file <%s> (exec_log_file)', $this->_cfg['exec_log_file']));
                }

                foreach($data as $row) {
                    fwrite($fh, $row);
                }

                fclose($fh);
                break;
            case 'none':
                break;
            default:
                throw new \StackIt\Exception(sprintf('Unknow log method <%s> (exec_log_method)', $this->_cfg['exec_log_method']));
            }
        }
    }
}
