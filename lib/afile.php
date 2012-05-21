<?php
/**
 * File object
 *
 * Holds information about each file, such as:
 ** Filename
 ** Issues
 *
 * @package Phpcs-php
 * @author  Gordon Williamson <gordjw@gmail.com>
 * @since   1.0
 * @category 
 * @license 
 * @link 
 */

class AFile
{
    var $filename;
    public $issues;

    function __construct( $filename )
    {
        $this->filename = $filename;
    }
}
