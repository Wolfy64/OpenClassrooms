<?php
namespace OCFram;

/**
 * To put in cache Data and View
 *
 * @param $time integer by default = 60 seconds
 * @param $path string by default = '/tmp/cache/'
**/
abstract class Cache
{
    /**
     * @var Object of news contents
     */
    protected $contents;
    /**
     * @var string name of file cache
     */
    protected $name;
    /**
     * @var string location of stored file
     *
     */
    protected $path;
    /**
     * @var integer time before expiry
     *
     */
    protected $time;

    public function __construct($news)
    {
        $this->setContents($news);
        $this->setTime();
        $this->setName($news);
        $this->setPath();
        $this->cacheValid();
    }

    // GETTERS \\

    /**
     * @return object $content 
     */
    public function getContents() { return $this->contents; }

    /**
     * @return string $name
     */
    public function getName() { return $this->name; }

    /**
     * @return string $path
     */
    public function getPath() { return $this->path; }

    /**
     * @return integer $time
     */
    public function getTime() { return $this->time; }

    // SETTERS \\

    /**
     * Set the attribute $name
     * @param string $name
     * @return Void
     */
    abstract public function setName($name);

    /**
     * Set the attribute $path
     * @param string $path
     * @return Void
     */
    abstract public function setPath($path);

    /**
     * Set and serialize the attribute contents
     * @param object $contents
     * @return Void
     */
    public function setContents($contents)
    {
        $this->contents = serialize($contents);
    }

    /**
     * Set the attribute $time
     * @param integer $time
     * @return Void
     */
    public function setTime($time=5)
    {
        if (is_int($time)){
            $this->time = $time;
        }else{
            throw new \Exception($time." must be an integer");
        }
    }

    // METHODS \\

    /**
     * To check if a cached file exists and date is valid
     * @return bool
     */
    public function cacheValid()
    {
        // If files exists And is not expired
        if (file_exists($this->path.$this->name.'.xml') && $this->isExpired() !== true){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Return TRUE if the expiry time of the cache files is expired
     * Return FALSE if still validate
     * @return bool
     */
    private function isExpired()
    {
        return \time() > file_get_contents( $this->path.$this->name.'.xml', false, null, 0, 11 );
    }

    /**
     *  Create and fill up a binary cache file 
     *  Sometimes IDE can't be read binary files ! But it's work
     * @return void
     */
    public function write()
    {
        file_put_contents($this->path.$this->name.'.xml',time() + $this->time.PHP_EOL);
        file_put_contents($this->path.$this->name.'.xml',$this->contents,FILE_APPEND);
    }

    /**
     * To read and unserialize cache file
     * @return Object
     */
    public function read()
    {
        return unserialize( \file_get_contents($this->path.$this->name.'.xml', false, null, 11) );
    }

    /**
     * To unserialize the attribute $content
     * @return void
     */
    // public function unserializeContents()
    // {
    //     unserialize($this->contents);
    // }
}
