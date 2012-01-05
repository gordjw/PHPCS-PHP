<?php

class Report
{
    public $files;

    public function show_all_files()
    {
        foreach( $this->files as $file )
        {
            echo $file->filename . "\n";
            foreach( $file->issues as $issue )
            {
                $issue->_print();
            }
        }
    }
}
