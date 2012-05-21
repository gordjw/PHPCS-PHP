<?php

class Issue
{
    public $line;
    public $message;

    function __construct( $line, $message )
    {
        $this->line = $line;
        $this->message = $message;
    }

    function _print()
    {
        echo get_class( $this ) . " | " . $this->line . " : " . $this->message . "\n";
    }
}
