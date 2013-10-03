<?php

/**
 * This is the base class that all implementations must extend.  It contains the
 * core variables and functionality common to all implementations, as well as the functions that
 * allow plugins to augment those classes.
 *
 * @package PhpThumb
 */
abstract class App_Image_Adapter_Abstract
{
    /**
     * All imported objects
     *
     * An array of imported plugin objects
     *
     * @var array
     */
    protected $_imported;
    /**
     * All imported object functions
     *
     * An array of all methods added to this class by imported plugin objects
     *
     * @var array
     */
    protected $_importedFunctions;
    /**
     * The last error message raised
     *
     * @var string
     */
    protected $_errorMessage;
    /**
     * Whether or not the current instance has any errors
     *
     * @var bool
     */
    protected $_hasError;
    /**
     * The name of the file we're manipulating
     *
     * This must include the path to the file (absolute paths recommended)
     *
     * @var string
     */
    protected $_fileName;
    /**
     * What the file format is (mime-type)
     *
     * @var string
     */
    protected $_format;

    /**
     * Class constructor
     *
     * @return ThumbBase
     */
    public function __construct ($fileName)
    {
        $this->_imported                = array();
        $this->_importedFunctions    = array();
        $this->_errorMessage            = null;
        $this->_hasError                = false;
        $this->_fileName                = $fileName;

        $this->fileExistsAndReadable();
    }

    /**
     * Imports plugins in $registry to the class
     *
     * @param array $registry
     */
    public function importPlugins ($registry)
    {
        foreach ($registry as $plugin => $meta) {
            $this->imports($plugin);
        }
    }

    /**
     * Imports a plugin
     *
     * This is where all the plugins magic happens!  This function "loads" 
     * the plugin functions, making them available as
     * methods on the class.
     *
     * @param string $object The name of the object to import / "load"
     */
    protected function imports ($object)
    {
        // the new object to import
        $newImport             = new $object();
        // the name of the new object (class name)
        $importName            = get_class($newImport);
        // the new functions to import
        $importFunctions     = get_class_methods($newImport);

        // add the object to the registry
        array_push($this->imported, array($importName, $newImport));

        // add the methods to the registry
        foreach ($importFunctions as $key => $functionName) {
            $this->_importedFunctions[$functionName] = &$newImport;
        }
    }

    /**
     * Checks to see if $this->_fileName exists and is readable
     *
     */
    protected function fileExistsAndReadable ()
    {
        if (!file_exists($this->_fileName)) {
            $this->triggerError('Image file not found: ' . $this->_fileName);
        } elseif (!is_readable($this->_fileName)) {
            $this->triggerError('Image file not readable: ' . $this->_fileName);
        }
    }

    /**
     * Sets $this->_errorMessage to $errorMessage and throws an exception
     *
     * Also sets $this->_hasError to true, so even if the exceptions are caught, we don't
     * attempt to proceed with any other functions
     *
     * @param string $errorMessage
     */
    protected function triggerError ($errorMessage)
    {
        $this->_hasError     = true;
        $this->_errorMessage    = $errorMessage;

        //throw new Exception ($errorMessage);
    }

    /**
     * Calls plugin / imported functions
     *
     * This is also where a fair amount of plugins magaic happens.  
     * This magic method is called whenever an "undefined" class
     * method is called in code, and we use that to call an imported function.
     *
     * You should NEVER EVER EVER invoke this function manually.  The universe will implode if you do... seriously ;)
     *
     * @param string $method
     * @param array $args
     */
    public function __call ($method, $args)
    {
        if (array_key_exists($method, $this->_importedFunctions)) {
            $args[] = $this;
            return call_user_func_array(array($this->importedFunctions[$method], $method), $args);
        }

        throw new BadMethodCallException ('Call to undefined method/class function: ' . $method);
    }

    /**
     * Returns $imported.
     * @see ThumbBase::$imported
     * @return array
     */
    public function getImported ()
    {
        return $this->_imported;
    }

    /**
     * Returns $importedFunctions.
     * @see ThumbBase::$importedFunctions
     * @return array
     */
    public function getImportedFunctions ()
    {
        return $this->_importedFunctions;
    }

    /**
     * Returns $errorMessage.
     *
     * @see ThumbBase::$errorMessage
     */
    public function getErrorMessage ()
    {
        return $this->_errorMessage;
    }

    /**
     * Sets $errorMessage.
     *
     * @param object $errorMessage
     * @see ThumbBase::$errorMessage
     */
    public function setErrorMessage ($errorMessage)
    {
        $this->_errorMessage = $errorMessage;
    }

    /**
     * Returns $fileName.
     *
     * @see ThumbBase::$fileName
     */
    public function getFileName ()
    {
        return $this->_fileName;
    }

    /**
     * Sets $fileName.
     *
     * @param object $fileName
     * @see ThumbBase::$fileName
     */
    public function setFileName ($fileName)
    {
        $this->_fileName = $fileName;
    }

    /**
     * Returns $format.
     *
     * @see ThumbBase::$format
     */
    public function getFormat ()
    {
        return $this->_format;
    }

    /**
     * Sets $format.
     *
     * @param object $format
     * @see ThumbBase::$format
     */
    public function setFormat ($format)
    {
        $this->_format = $format;
    }

    /**
     * Returns $hasError.
     *
     * @see ThumbBase::$hasError
     */
    public function getHasError ()
    {
        return $this->_hasError;
    }

    /**
     * Sets $hasError.
     *
     * @param object $hasError
     * @see ThumbBase::$hasError
     */
    public function setHasError ($hasError)
    {
        $this->_hasError = $hasError;
    }
}
