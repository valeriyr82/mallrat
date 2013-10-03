<?php

/**
 * This is the GD Implementation of the PHP Thumb library
 *
 * @package PhpThumb
 */
class App_Image_Adapter_Gd extends App_Image_Adapter_Abstract
{

    /**
     * The prior image (before manipulation)
     *
     * @var resource
     */
    protected $_oldImage;

    /**
     * The working image (used during manipulation)
     *
     * @var resource
     */
    protected $_workingImage;

    /**
     * The current dimensions of the image
     *
     * @var array
     */
    protected $_currentDimensions;

    /**
     * The new, calculated dimensions of the image
     *
     * @var array
     */
    protected $_newDimensions;

    /**
     * The options for this class
     *
     * This array contains various options that determine the behavior in
     * various functions throughout the class.  Functions note which specific
     * option key / values are used in their documentation
     *
     * @var array
     */
    protected $_options;

    /**
     * The maximum width an image can be after resizing (in pixels)
     *
     * @var int
     */
    protected $_maxWidth;

    /**
     * The maximum height an image can be after resizing (in pixels)
     *
     * @var int
     */
    protected $_maxHeight;

    /**
     * The percentage to resize the image by
     *
     * @var int
     */
    protected $_percent;

    /**
     * Class Constructor
     *
     * @return GdThumb
     * @param string $fileName
     */
    public function __construct ($fileName, $options = array())
    {
        parent::__construct($fileName);

        if ($this->determineFormat() === false) {
            return false;
        }
        $this->verifyFormatCompatiblity();

        switch ($this->format) {
            case 'GIF':
                $this->_oldImage = imagecreatefromgif($this->_fileName);
                break;
            case 'JPG':
                $this->_oldImage = imagecreatefromjpeg($this->_fileName);
                break;
            case 'PNG':
                $this->_oldImage = imagecreatefrompng($this->_fileName);
                break;
        }

        $size = getimagesize($this->_fileName);
        $this->_currentDimensions = array(

        'width' => $size[0] , 'height' => $size[1]
        );

        $this->setOptions($options);

    // TODO: Port gatherImageMeta to a separate function that can be called to extract exif data
    }

    /**
     * Class Destructor
     *
     */
    public function __destruct ()
    {
        if (is_resource($this->_oldImage)) {
            imagedestroy($this->_oldImage);
        }

        if (is_resource($this->_workingImage)) {
            imagedestroy($this->_workingImage);
        }
    }

    ##############################
    # ----- API FUNCTIONS ------ #
    ##############################


    /**
     * Resizes an image to be no larger than $_maxWidth or $_maxHeight
     *
     * If either param is set to zero, then that dimension will not be considered as a part of the resize.
     * Additionally, if $this->_options['resizeUp'] is set to true (false by default), then this function will
     * also scale the image up to the maximum dimensions provided.
     *
     * @param int $_maxWidth The maximum width of the image in pixels
     * @param int $_maxHeight The maximum height of the image in pixels
     * @return GdThumb
     */
    public function resize ($maxWidth = 0, $maxHeight = 0)
    {
        // make sure our arguments are valid
        if (! is_numeric($maxWidth)) {
            throw new InvalidArgumentException(
                '$maxWidth must be numeric');
        }

        if (! is_numeric($maxHeight)) {
            throw new InvalidArgumentException(
                '$maxHeight must be numeric');
        }

        // make sure we're not exceeding our image size if we're not supposed to
        if ($this->_options['resizeUp'] === false) {
            $this->_maxHeight = (intval($maxHeight) >
                $this->_currentDimensions['height']) ? $this->_currentDimensions['height'] : $maxHeight;
            $this->_maxWidth = (intval($maxWidth) >
                $this->_currentDimensions['width']) ? $this->_currentDimensions['width'] : $maxWidth;
        } else {
            $this->_maxHeight = intval($maxHeight);
            $this->_maxWidth = intval($maxWidth);
        }

        // get the new dimensions...
        $this->calcImageSize(
            $this->_currentDimensions['width'],
            $this->_currentDimensions['height']
        );

        // create the working image
        if (function_exists('imagecreatetruecolor')) {
            $this->_workingImage = imagecreatetruecolor(
                $this->_newDimensions['newWidth'],
                $this->_newDimensions['newHeight']
            );
        } else {
            $this->_workingImage = imagecreate(
                $this->_newDimensions['newWidth'],
                $this->_newDimensions['newHeight']
            );
        }

        $this->preserveAlpha();

        // and create the newly sized image
        imagecopyresampled(
            $this->_workingImage,
            $this->_oldImage, 0, 0, 0, 0,
            $this->_newDimensions['newWidth'],
            $this->_newDimensions['newHeight'],
            $this->_currentDimensions['width'],
            $this->_currentDimensions['height']
        );

        // update all the variables and resources to be correct
        $this->_oldImage = $this->_workingImage;
        $this->_currentDimensions['width'] = $this->_newDimensions['newWidth'];
        $this->_currentDimensions['height'] = $this->_newDimensions['newHeight'];

        return $this;
    }

    /**
     * Adaptively Resizes the Image
     *
     * This function attempts to get the image to as close to the provided dimensions as possible, and then crops the
     * remaining overflow (from the center) to get the image to be the size specified
     *
     * @param int $_maxWidth
     * @param int $_maxHeight
     * @return GdThumb
     */
    public function adaptiveResize ($width, $height)
    {
        // make sure our arguments are valid
        if (! is_numeric($width) || $width == 0) {
            throw new InvalidArgumentException(
                '$width must be numeric and greater than zero');
        }

        if (! is_numeric($height) || $height == 0) {
            throw new InvalidArgumentException(
                '$height must be numeric and greater than zero');
        }

        // make sure we're not exceeding our image size if we're not supposed to
        if ($this->_options['resizeUp'] === false) {
            $this->_maxHeight = (intval($height) >
                $this->_currentDimensions['height']) ? $this->_currentDimensions['height'] : $height;
            $this->_maxWidth = (intval($width) >
                $this->_currentDimensions['width']) ? $this->_currentDimensions['width'] : $width;
        } else {
            $this->_maxHeight = intval($height);
            $this->_maxWidth = intval($width);
        }

        $this->calcImageSizeStrict(
            $this->_currentDimensions['width'],
            $this->_currentDimensions['height']
        );

        // resize the image to be close to our desired dimensions
        $this->resize(
            $this->_newDimensions['newWidth'],
            $this->_newDimensions['newHeight']
        );

        // reset the max dimensions...
        if ($this->_options['resizeUp'] === false) {
            $this->_maxHeight = (intval($height) >
                $this->_currentDimensions['height']) ? $this->_currentDimensions['height'] : $height;
            $this->_maxWidth = (intval($width) >
                $this->_currentDimensions['width']) ? $this->_currentDimensions['width'] : $width;
        } else {
            $this->_maxHeight = intval($height);
            $this->_maxWidth = intval($width);
        }

        // create the working image
        if (function_exists('imagecreatetruecolor')) {
            $this->_workingImage = imagecreatetruecolor($this->_maxWidth, $this->_maxHeight);
        } else {
            $this->_workingImage = imagecreate($this->_maxWidth, $this->_maxHeight);
        }

        $this->preserveAlpha();

        $cropWidth = $this->_maxWidth;
        $cropHeight = $this->_maxHeight;
        $cropX = 0;
        $cropY = 0;

        // now, figure out how to crop the rest of the image...
        if ($this->_currentDimensions['width'] > $this->_maxWidth) {
            $cropX = intval(($this->_currentDimensions['width'] - $this->_maxWidth) / 2);
        } elseif ($this->_currentDimensions['height'] > $this->_maxHeight) {
            $cropY = intval(($this->_currentDimensions['height'] - $this->_maxHeight) / 2);
        }

        imagecopyresampled(
            $this->_workingImage, $this->_oldImage, 0, 0, $cropX, $cropY,
            $cropWidth, $cropHeight, $cropWidth, $cropHeight
        );

        // update all the variables and resources to be correct
        $this->_oldImage = $this->_workingImage;
        $this->_currentDimensions['width'] = $this->_maxWidth;
        $this->_currentDimensions['height'] = $this->_maxHeight;

        return $this;
    }

    /**
     * Resizes an image by a given _percent uniformly
     *
     * _percentage should be whole number representation (i.e. 1-100)
     *
     * @param int $_percent
     * @return GdThumb
     */
    public function resizePercent ($percent = 0)
    {
        if (! is_numeric($percent)) {
            throw new InvalidArgumentException(
                '$percent must be numeric');
        }

        $this->_percent = intval($percent);

        $this->calcImageSizePercent(
            $this->_currentDimensions['width'],
            $this->_currentDimensions['height']
        );

        if (function_exists('imagecreatetruecolor')) {
            $this->_workingImage = imagecreatetruecolor(
                $this->_newDimensions['newWidth'],
                $this->_newDimensions['newHeight']
            );
        } else {
            $this->_workingImage = imagecreate(
                $this->_newDimensions['newWidth'],
                $this->_newDimensions['newHeight']
            );
        }

        $this->preserveAlpha();

        ImageCopyResampled(
            $this->_workingImage, $this->_oldImage, 0, 0, 0, 0,
            $this->_newDimensions['newWidth'],
            $this->_newDimensions['newHeight'],
            $this->_currentDimensions['width'],
            $this->_currentDimensions['height']
        );

        $this->_oldImage = $this->_workingImage;
        $this->_currentDimensions['width'] = $this->_newDimensions['newWidth'];
        $this->_currentDimensions['height'] = $this->_newDimensions['newHeight'];

        return $this;
    }

    /**
     * Crops an image from the center with provided dimensions
     *
     * If no height is given, the width will be used as a height, thus creating a square crop
     *
     * @param int $cropWidth
     * @param int $cropHeight
     * @return GdThumb
     */
    public function cropFromCenter ($cropWidth, $cropHeight = null)
    {
        if (! is_numeric($cropWidth)) {
            throw new InvalidArgumentException('$cropWidth must be numeric');
        }

        if ($cropHeight !== null && ! is_numeric($cropHeight)) {
            throw new InvalidArgumentException('$cropHeight must be numeric');
        }

        if ($cropHeight === null) {
            $cropHeight = $cropWidth;
        }

        $cropWidth = ($this->_currentDimensions['width'] <
             $cropWidth) ? $this->_currentDimensions['width'] : $cropWidth;
        $cropHeight = ($this->_currentDimensions['height'] <
             $cropHeight) ? $this->_currentDimensions['height'] : $cropHeight;

        $cropX = intval(($this->_currentDimensions['width'] - $cropWidth) / 2);
        $cropY = intval(($this->_currentDimensions['height'] - $cropHeight) / 2);

        $this->crop($cropX, $cropY, $cropWidth, $cropHeight);

        return $this;
    }

    /**
     * Vanilla Cropping - Crops from x,y with specified width and height
     *
     * @param int $startX
     * @param int $startY
     * @param int $cropWidth
     * @param int $cropHeight
     * @return GdThumb
     */
    public function crop ($startX, $startY, $cropWidth, $cropHeight)
    {
        // validate input
        if (! is_numeric($startX)) {
            throw new InvalidArgumentException('$startX must be numeric');
        }

        if (! is_numeric($startY)) {
            throw new InvalidArgumentException('$startY must be numeric');
        }

        if (! is_numeric($cropWidth)) {
            throw new InvalidArgumentException('$cropWidth must be numeric');
        }

        if (! is_numeric($cropHeight)) {
            throw new InvalidArgumentException('$cropHeight must be numeric');
        }

        // do some calculations
        $cropWidth = ($this->_currentDimensions['width'] <
             $cropWidth) ? $this->_currentDimensions['width'] : $cropWidth;
        $cropHeight = ($this->_currentDimensions['height'] <
             $cropHeight) ? $this->_currentDimensions['height'] : $cropHeight;

        // ensure everything's in bounds
        if (($startX + $cropWidth) > $this->_currentDimensions['width']) {
            $startX = ($this->_currentDimensions['width'] - $cropWidth);
        }

        if (($startY + $cropHeight) > $this->_currentDimensions['height']) {
            $startY = ($this->_currentDimensions['height'] - $cropHeight);
        }

        if ($startX < 0) {
            $startX = 0;
        }

        if ($startY < 0) {
            $startY = 0;
        }

        // create the working image
        if (function_exists('imagecreatetruecolor')) {
            $this->_workingImage = imagecreatetruecolor($cropWidth, $cropHeight);
        } else {
            $this->_workingImage = imagecreate($cropWidth, $cropHeight);
        }

        $this->preserveAlpha();

        imagecopyresampled(
            $this->_workingImage, $this->_oldImage, 0, 0, $startX,
            $startY, $cropWidth, $cropHeight, $cropWidth, $cropHeight
        );

        $this->_oldImage = $this->_workingImage;
        $this->_currentDimensions['width'] = $cropWidth;
        $this->_currentDimensions['height'] = $cropHeight;

        return $this;
    }

    /**
     * Rotates image either 90 degrees clockwise or counter-clockwise
     *
     * @param string $direction
     * @retunrn GdThumb
     */
    public function rotateImage ($direction = 'CW')
    {
        if ($direction == 'CW') {
            $this->rotateImageNDegrees(90);
        } else {
            $this->rotateImageNDegrees(- 90);
        }

        return $this;
    }

    /**
     * Rotates image specified number of degrees
     *
     * @param int $degrees
     * @return GdThumb
     */
    public function rotateImageNDegrees ($degrees)
    {
        if (! is_numeric($degrees)) {
            throw new InvalidArgumentException('$degrees must be numeric');
        }

        if (! function_exists('imagerotate')) {
            throw new RuntimeException('Your version of GD does not support image rotation.');
        }

        $this->_workingImage = imagerotate($this->_oldImage, $degrees, 0);

        $newWidth = $this->_currentDimensions['height'];
        $newHeight = $this->_currentDimensions['width'];
        $this->_oldImage = $this->_workingImage;
        $this->_currentDimensions['width'] = $newWidth;
        $this->_currentDimensions['height'] = $newHeight;

        return $this;
    }

    /**
     * Shows an image
     *
     * This function will show the current image by first sending the appropriate header
     * for the format, and then outputting the image data. If headers have already been sent,
     * a runtime exception will be thrown
     *
     * @return GdThumb
     */
    public function show ()
    {
        if (headers_sent()) {
            throw new RuntimeException('Cannot show image, headers have already been sent');
        }

        switch ($this->format) {
            case 'GIF':
                header('Content-type: image/gif');
                imagegif($this->_oldImage);
                break;
            case 'JPG':
                header('Content-type: image/jpeg');
                imagejpeg($this->_oldImage, null, $this->_options['jpegQuality']);
                break;
            case 'PNG':
                header('Content-type: image/png');
                imagepng($this->_oldImage);
                break;
        }

        return $this;
    }

    /**
     * Saves an image
     *
     * This function will make sure the target directory is writeable, and then save the image.
     *
     * If the target directory is not writeable, the function will try to correct the permissions (if allowed, this
     * is set as an option ($this->_options['correctPermissions']).  If the target cannot be made writeable, then a
     * RuntimeException is thrown.
     *
     * TODO: Create additional paramter for color matte when saving images with alpha to non-alpha formats
     * (i.e. PNG => JPG)
     *
     * @param string $fileName The full path and filename of the image to save
     * @param string $format The format to save the image in (optional, must be one of [GIF,JPG,PNG]
     * @return GdThumb
     */
    public function save ($fileName, $format = null)
    {
        $validFormats = array(
            'GIF' , 'JPG' , 'PNG'
        );
        $format = ($format !== null) ? strtoupper($format) : $this->format;

        if (! in_array($format, $validFormats)) {
            throw new InvalidArgumentException('Invalid format type specified in save function: ' . $format);
        }

        // make sure the directory is writeable
        if (! is_writeable(dirname($fileName))) {
            // try to correct the permissions
            if ($this->_options['correctPermissions'] === true) {
                    @chmod(dirname($fileName), 0777);

                // throw an exception if not writeable
                if (! is_writeable(dirname($fileName))) {
                    throw new RuntimeException(
                        'File is not writeable, and could not correct permissions: ' .
                        $fileName
                    );
                }
            } else {
                throw new RuntimeException('File not writeable: ' . $fileName);
            }
        }

        switch ($format) {
            case 'GIF':
                imagegif($this->_oldImage, $fileName);
                break;
            case 'JPG':
                imagejpeg($this->_oldImage, $fileName, $this->_options['jpegQuality']);
                break;
            case 'PNG':
                imagepng($this->_oldImage, $fileName);
                break;
        }

        return $this;
    }

    #################################
    # ----- GETTERS / SETTERS ----- #
    #################################


    /**
     * Sets $this->_options to $_options
     *
     * @param array $_options
     */
    public function setOptions ($options = array())
    {
        // make sure we've got an array for $this->_options (could be null)
        if (! is_array($this->_options)) {
            $this->_options = array();
        }

        // make sure we've gotten a proper argument
        if (! is_array($options)) {
            throw new InvalidArgumentException(
                'set_options requires an array');
        }

        // we've yet to init the default _options, so create them here
        if (sizeof($this->_options) == 0) {
            $defaultOptions = array(

            'resizeUp' => false , 'jpegQuality' => 100 ,
            'correctPermissions' => false , 'preserveAlpha' => true ,
            'alphaMaskColor' => array(

            255 , 255 , 255
            ) , 'preserveTransparency' => true ,
            'transparencyMaskColor' => array(

            0 , 0 , 0
            )
            );
        } else {
            $defaultOptions = $this->_options;
        }

        $this->_options = array_merge($defaultOptions, $options);
    }

    /**
     * Returns $_currentDimensions.
     *
     * @see GdThumb::$_currentDimensions
     */
    public function getCurrentDimensions ()
    {
        return $this->_currentDimensions;
    }

    /**
     * Sets $_currentDimensions.
     *
     * @param object $_currentDimensions
     * @see GdThumb::$_currentDimensions
     */
    public function setCurrentDimensions ($currentDimensions)
    {
        $this->_currentDimensions = $currentDimensions;
    }

    /**
     * Returns $_maxHeight.
     *
     * @see GdThumb::$_maxHeight
     */
    public function getMaxHeight ()
    {
        return $this->_maxHeight;
    }

    /**
     * Sets $_maxHeight.
     *
     * @param object $_maxHeight
     * @see GdThumb::$_maxHeight
     */
    public function setMaxHeight ($maxHeight)
    {
        $this->_maxHeight = $maxHeight;
    }

    /**
     * Returns $_maxWidth.
     *
     * @see GdThumb::$_maxWidth
     */
    public function getMaxWidth ()
    {
        return $this->_maxWidth;
    }

    /**
     * Sets $_maxWidth.
     *
     * @param object $_maxWidth
     * @see GdThumb::$_maxWidth
     */
    public function setMaxWidth ($maxWidth)
    {
        $this->_maxWidth = $maxWidth;
    }

    /**
     * Returns $_newDimensions.
     *
     * @see GdThumb::$_newDimensions
     */
    public function getNewDimensions ()
    {
        return $this->_newDimensions;
    }

    /**
     * Sets $_newDimensions.
     *
     * @param object $_newDimensions
     * @see GdThumb::$_newDimensions
     */
    public function setNewDimensions ($newDimensions)
    {
        $this->_newDimensions = $newDimensions;
    }

    /**
     * Returns $_options.
     *
     * @see GdThumb::$_options
     */
    public function getOptions ()
    {
        return $this->_options;
    }

    /**
     * Returns $_percent.
     *
     * @see GdThumb::$percent
     */
    public function getPercent ()
    {
        return $this->_percent;
    }

    /**
     * Sets $_percent.
     *
     * @param object $percent
     * @see GdThumb::$percent
     */
    public function setPercent ($percent)
    {
        $this->_percent = $percent;
    }

    /**
     * Returns $oldImage.
     *
     * @see GdThumb::$oldImage
     */
    public function getOldImage ()
    {
        return $this->_oldImage;
    }

    /**
     * Sets $oldImage.
     *
     * @param object $_oldImage
     * @see GdThumb::$_oldImage
     */
    public function setOldImage ($oldImage)
    {
        $this->_oldImage = $oldImage;
    }

    /**
     * Returns $_workingImage.
     *
     * @see GdThumb::$_workingImage
     */
    public function getWorkingImage ()
    {
        return $this->_workingImage;
    }

    /**
     * Sets $_workingImage.
     *
     * @param object $_workingImage
     * @see GdThumb::$_workingImage
     */
    public function setWorkingImage ($workingImage)
    {
        $this->_workingImage = $workingImage;
    }

    #################################
    # ----- UTILITY FUNCTIONS ----- #
    #################################


    /**
     * Calculates a new width and height for the image based on $this->_maxWidth and the provided dimensions
     *
     * @return array
     * @param int $width
     * @param int $height
     */
    protected function calcWidth ($width, $height)
    {
        $newWidthPercentage = (100 * $this->_maxWidth) / $width;
        $newHeight = ($height * $newWidthPercentage) / 100;

        return array(
        'newWidth' => intval($this->_maxWidth) , 'newHeight' => intval($newHeight)
        );
    }

    /**
     * Calculates a new width and height for the image based on $this->_maxWidth and the provided dimensions
     *
     * @return array
     * @param int $width
     * @param int $height
     */
    protected function calcHeight ($width, $height)
    {
        $newHeightPercentage = (100 * $this->_maxHeight) / $height;
        $newWidth = ($width * $newHeightPercentage) / 100;

        return array(

        'newWidth' => ceil($newWidth) , 'newHeight' => ceil($this->_maxHeight)
        );
    }

    /**
     * Calculates a new width and height for the image based on $this->_percent and the provided dimensions
     *
     * @return array
     * @param int $width
     * @param int $height
     */
    protected function calcPercent ($width, $height)
    {
        $newWidth = ($width * $this->_percent) / 100;
        $newHeight = ($height * $this->_percent) / 100;

        return array(

        'newWidth' => ceil($newWidth) , 'newHeight' => ceil($newHeight)
        );
    }

    /**
     * Calculates the new image dimensions
     *
     * These calculations are based on both the provided dimensions and $this->_maxWidth and $this->_maxHeight
     *
     * @param int $width
     * @param int $height
     */
    protected function calcImageSize ($width, $height)
    {
        $newSize = array(

        'newWidth' => $width , 'newHeight' => $height
        );

        if ($this->_maxWidth > 0) {
            $newSize = $this->calcWidth($width, $height);

            if ($this->_maxHeight > 0 && $newSize['newHeight'] > $this->_maxHeight) {
                $newSize = $this->calcHeight(
                    $newSize['newWidth'],
                    $newSize['newHeight']
                );
            }
        }

        if ($this->_maxHeight > 0) {
            $newSize = $this->calcHeight($width, $height);

            if ($this->_maxWidth > 0 && $newSize['newWidth'] > $this->_maxWidth) {
                $newSize = $this->calcWidth(
                    $newSize['newWidth'],
                    $newSize['newHeight']
                );
            }
        }

        $this->_newDimensions = $newSize;
    }

    /**
     * Calculates new image dimensions, not allowing the width and height to be less than either the max width or height
     *
     * @param int $width
     * @param int $height
     */
    protected function calcImageSizeStrict ($width, $height)
    {
        // first, we need to determine what the longest resize dimension is..
        if ($this->_maxWidth >= $this->_maxHeight) {
            // and determine the longest original dimension
            if ($width >
                 $height) {
                    $_newDimensions = $this->calcHeight($width, $height);

                if ($_newDimensions['newWidth'] < $this->_maxWidth) {
                    $_newDimensions = $this->calcWidth($width, $height);
                }
            } elseif ($height >= $width) {
                $_newDimensions = $this->calcWidth($width, $height);

                if ($_newDimensions['newHeight'] < $this->_maxHeight) {
                    $_newDimensions = $this->calcHeight($width, $height);
                }
            }
        } elseif ($this->_maxHeight > $this->_maxWidth) {
            if ($width >= $height) {
                $_newDimensions = $this->calcWidth($width, $height);

                if ($_newDimensions['newHeight'] < $this->_maxHeight) {
                    $_newDimensions = $this->calcHeight($width, $height);
                }
            } elseif ($height > $width) {
                $_newDimensions = $this->calcHeight($width, $height);

                if ($_newDimensions['newWidth'] < $this->_maxWidth) {
                    $_newDimensions = $this->calcWidth($width, $height);
                }
            }
        }

        $this->_newDimensions = $_newDimensions;
    }

    /**
     * Calculates new dimensions based on $this->_percent and the provided dimensions
     *
     * @param int $width
     * @param int $height
     */
    protected function calcImageSizePercent ($width, $height)
    {
        if ($this->_percent > 0) {
            $this->_newDimensions = $this->calcPercent($width, $height);
        }
    }

    /**
     * Determines the file format by mime-type
     *
     * This function will throw exceptions for invalid images / mime-types
     *
     */
    protected function determineFormat ()
    {
        $formatInfo = getimagesize($this->_fileName);

        // non-image files will return false
        if ($formatInfo === false) {
            $this->triggerError('File is not a valid image: ' . $this->_fileName);
            return false;
        }

        $mimeType = isset($formatInfo['mime']) ? $formatInfo['mime'] : null;

        switch ($mimeType) {
            case 'image/gif':
                $this->format = 'GIF';
                break;
            case 'image/jpeg':
                $this->format = 'JPG';
                break;
            case 'image/png':
                $this->format = 'PNG';
                break;
            default:
                $this->triggerError('Image format not supported: ' . $mimeType);
        }
    }

    /**
     * Makes sure the correct GD implementation exists for the file type
     *
     */
    protected function verifyFormatCompatiblity ()
    {
        $isCompatible = true;
        $gdInfo = gd_info();

        switch ($this->format) {
            case 'GIF':
                $isCompatible = $gdInfo['GIF Create Support'];
                break;
            case 'JPG':
                $isCompatible = $gdInfo['JPEG Support'];
                break;
            case 'PNG':
                $isCompatible = $gdInfo[$this->format . ' Support'];
                break;
            default:
                $isCompatible = false;
        }

        if (! $isCompatible) {
            $this->triggerError('Your GD installation does not support ' . $this->format . ' image types');
        }
    }

    /**
     * Preserves the alpha or transparency for PNG and GIF files
     *
     * Alpha / transparency will not be preserved if the appropriate _options are set to false.
     * Also, the GIF transparency is pretty skunky (the results aren't awesome), but it works like a
     * champ... that's the nature of GIFs tho, so no huge surprise.
     *
     * This functionality was originally suggested by commenter Aimi (no links / site provided) - Thanks! :)
     *
     */
    protected function preserveAlpha ()
    {
        if ($this->format == 'PNG' && $this->_options['preserveAlpha'] === true) {
            imagealphablending($this->_workingImage, false);

            $colorTransparent = imagecolorallocatealpha(
                $this->_workingImage,
                $this->_options['alphaMaskColor'][0],
                $this->_options['alphaMaskColor'][1],
                $this->_options['alphaMaskColor'][2], 0
            );

            imagefill($this->_workingImage, 0, 0, $colorTransparent);
            imagesavealpha($this->_workingImage, true);
        }
        // preserve transparency in GIFs... this is usually pretty rough tho
        if ($this->format == 'GIF' && $this->_options['preserveTransparency'] === true) {
                $colorTransparent = imagecolorallocate(
                    $this->_workingImage,
                    $this->_options['transparencyMaskColor'][0],
                    $this->_options['transparencyMaskColor'][1],
                    $this->_options['transparencyMaskColor'][2]
                );

            imagecolortransparent($this->_workingImage, $colorTransparent);
            imagetruecolortopalette($this->_workingImage, true, 256);
        }
    }
}
