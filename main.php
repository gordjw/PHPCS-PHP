<?php

class PHPCS
{
    public function __construct() {
        spl_autoload_register( array( $this, 'autoload' ) );
    }

    private function autoload( $classname ) {
	$classname = strtolower( $classname );
        if( file_exists( dirname(__FILE__) . '/lib/' . $classname . '.php' ) )
            require_once( dirname(__FILE__) . '/lib/' . $classname . '.php' );

    }

    private static function _get_raw( $filename )
    {
        exec( 'phpcs ' . $filename, $raw );

        return $raw;
    }

    public function generate_report( $filename = "." )
    {
	$raw = self::_get_raw( $filename );

        $report = new Report();

        foreach( $raw as $line )
        {
            if( preg_match( "/^FILE: (.*)$/", $line, $matches ) )
            {
                $file = new AFile( $matches[1] );
                $report->files[$matches[1]] = $file;
            }

            if( preg_match( "/^\s+(\d)\s+\|\s+(ERROR|WARNING)\s+\|\s+(.*)$/", $line, $matches ) )
            {
                $file->issues[] = new $matches[2]($matches[1], $matches[3]);
            }
        }

        return $report;
    }

}


$phpcs = new PHPCS();
$report = $phpcs->generate_report();
//$report->show_all_files();
print_r( $report );
