<?php

class AFile
{
    var $filename;
    public $issues;

    function __construct( $filename )
    {
        $this->filename = $filename;
    }
}
