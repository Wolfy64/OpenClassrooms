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
     *
     */
    protected $contents;
    /**
     * @var string name of file cache
     *
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

    public function __construct($time)
    {
        $this->setTime($time);
    }

    // SETTERS \\

    /**
     * @param object $contents set and serialize the attribute contents
     *
     */
    public function setContents($contents)
    {
        $this->contents = serialize($contents);
    }

    /**
     * @param string $name set the attribute $name
     *
     */
    abstract public function setName($name);

    /**
     * @param string $path set the attribute $path
     *
     */
    abstract public function setPath($path);

    /**
     * @param integer $time set the attribute $path
     *
     */
    public function setTime($time)
    {
        if (is_int($time)){
            $this->time = $time;
        }else{
            throw new Exception($time." n'est pas un entier");
        }
    }

    // GETTERS \\

    /**
     * @return object attribute $content 
     *
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return string attribute $name
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string attribute path
     *
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return integer attribute $time
     *
     */
    public function getTime()
    {
        return $this->time;
    }

    // METHOD \\

    /**
     * @return bool check if an cached file exists
     * 
     */
    public function cacheExists()
    {
        if (file_exists($this->path.$this->name.'.xml') && $this->isExpired() !== true){
            $this->read();
            return true;
        }else {
            $this->write();
            return false;
        }
    }

    /**
     * @return bool True if the expiry time of the cache files is expired and false if still validate
     *
     */
    public function isExpired()
    {
        return \time() > file_get_contents( $this->path.$this->name.'.xml', false, null, 0, 11 );
    }

    /**
     * @return void create and fill up a cache binary file (can't be read by an IDE !)
     * 
     */
    public function write()
    {
        file_put_contents($this->path.$this->name.'.xml',time() + $this->time.PHP_EOL);
        file_put_contents($this->path.$this->name.'.xml',$this->contents,FILE_APPEND);
    }

    /**
     * @return void read and unserialize cache file
     *
     */
    public function read()
    {
        echo 'le cache existe';
        return unserialize( \file_get_contents($this->path.$this->name.'.xml', false, null, 11) );
    }

    /**
     * @return void unserialize the attribute $content
     *
     */
    public function unserializeContents()
    {
        return unserialize($this->contents);
    }

    public function test()
    {
        $file = 'jhkdbfjbvhcjkhdsvhbdskchbs';
        $filePack = pack($file);
        
    }

}
