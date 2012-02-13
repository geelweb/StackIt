<?php
/**
 * StackIt autoloader
 *
 * @author  Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt
 */

namespace StackIt;

/**
 * StackIt Autoloader helper
 *
 * <code>
 * require_once 'library/StackIt/Autoloader.php';
 * StackIt\Autoloader::register();
 * </code>
 *
 * @author Guillaume Luchet <guillaume@geelweb.org>
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 * @package StackIt
 */
class Autoloader
{
    /**
     * The StackIt library base directory
     *
     * @var string
     * @access private
     */
    private $baseDir;

    /**
     * The StackIt library prefix
     *
     * @var mixed
     * @access private
     */
    private $prefix;

    /**
     * Initialize the base directory and prefix
     *
     * @param string $baseDirectory The StackIt library base directory
     * @access public
     * @return void
     */
    public function __construct($baseDirectory = null)
    {
        $this->baseDir = $baseDirectory ?: dirname(__FILE__);
        $this->prefix = __NAMESPACE__ . '\\';
    }

    /**
     * Register the autoload method
     *
     * @static
     * @access public
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * Autoload method, try to include the file from the class name
     *
     * @param string $className The class to load
     * @access public
     * @return void
     */
    public function autoload($className)
    {
        if (0 !== strpos($className, $this->prefix)) {
            return;
        }

        $relativeClassName = substr($className, strlen($this->prefix));
        $classNameParts = explode('\\', $relativeClassName);

        $file = $this->baseDir
            . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, $classNameParts)
            . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
}
