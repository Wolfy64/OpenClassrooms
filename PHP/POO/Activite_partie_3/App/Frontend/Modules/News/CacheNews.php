<?php
namespace App\Frontend\Modules\News;

use \OCFram\Cache;

class CacheNews extends Cache
{
    /**
     * Set the attribute $name
     *  => News{$name}_{date}
     * @param string $name
     * @return Void
     */
    public function setName($name)
    {
        $this->name = 'News'.$name.'_'.date('d-M-Y');
    }

    /**
     * Set path => '../tmp/cache/datas/'
     * @return Void
     */
    public function setPath($path ='../tmp/cache/datas/')
    {
        if(\is_string( $path )){
            $this->path = $path;
        }else {
            throw new Exception($path." n'est pas une chaine de charactere");
        }
    }
}
