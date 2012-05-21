<?php
/**
 * Primary PHPCS-PHP interface.
 *
 * Create a new PHPCS object, which allows you to generate reports, change files and coding standards
 *
 * @author Gordon Williamson <gordjw@gmail.com>
 * @since 1.0
 * @packags phpcs-php
 */
class PHPCS
{
    /**
     * @access private
     * @var string
     */
    var $filename;
    /**
     * @access private
     * @var string
     */
    var $standard;

    /**
     * @access public
     * @param string $filename Path (file or directory) to run phpcs over (defaults to '.')
     * @param string $standard Coding standard to apply to your code
     * @return object Instance of the PHPCS class, on which you call generate_report
     */
    public function __construct( $filename = '.', $standard = 'ZEND' ) {
        spl_autoload_register( array( $this, 'autoload' ) );

        $this->filename = $filename;
        $this->standard = $standard;
    }

    /**
     * @access public
     * @param string $filename Change the filename to generate a report on
     **/
    public function set_filename( $filename ) { $this->filename = $filename; }
    
    /**
     * @access public
     * @return string Return the filename currently in use
     **/
    public function get_filename() { return $this->filename; }

    /**
     * @access public
     * @param string $standard Change the coding stanrad to be used
     **/
    public function set_standard( $standard ) { $this->standard = $standard; }

    /**
     * @access public
     * @return string Return the coding standard currently in use
     **/
    public function get_standard() { return $this->standard; }

    /**
     * @access private
     * @param string $classname Attempt to autoload $classname
     */
    private function autoload( $classname ) {
	$classname = strtolower( $classname );
        if( file_exists( dirname(__FILE__) . '/' . $classname . '.php' ) )
            require_once( dirname(__FILE__) . '/' . $classname . '.php' );

    }

    /**
     * @access private
     * @return string Return the raw output of the phpcs command
     */
    private function _get_raw()
    {
        exec( 'phpcs ' . $this->filename, $raw );

        return $raw;
    }

    /**
     * @access public
     * @return array Return the converted raw output as an array for further use
     */
    public function generate_report()
    {
	$raw = $this->_get_raw();

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
