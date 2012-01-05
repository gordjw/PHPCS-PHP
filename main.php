<?php

class PHPCS
{
    static function get_raw( $filename = "." )
    {
        exec( 'phpcs ' . $filename, $raw );

        return $raw;
    }

    static function generate_report( $raw )
    {
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



$raw = PHPCS::get_raw();
$report = PHPCS::generate_report( $raw );
$report->show_all_files();
