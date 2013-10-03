<?php

/**
 * PhpThumb : PHP Thumb Library <http://phpthumb.gxdlabs.com>
 *
 * @copyright Copyright (c) 2009 Gen X Design
 * @link http://phpthumb.gxdlabs.com
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 3.0
 * @package PhpThumb
 */
class App_Image
{
    /**
     * Factory
     *
     * @param  string $filename The path and file to load [optional]
     * @return App_Image_Adapter_Abstract
     */
    public static function create($filename = null, $options = array())
    {
        $adapter = new App_Image_Adapter_Gd($filename, $options);
        if ($adapter->getHasError() == 1) {
            return false;
        }
        return $adapter;
    }
}
