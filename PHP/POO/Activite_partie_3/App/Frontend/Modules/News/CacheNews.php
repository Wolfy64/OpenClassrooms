<?php
namespace App\Frontend\Modules\News;

use \OCFram\Cache;

class CacheNews extends Cache
{
    public function __construct($time=60)
    {
        parent::__construct($time);
        $this->setPath();
    }

    public function setName($name)
    {
        $this->name = 'News'.$name.'_'.date('d-M-Y');
    }

    public function setPath($path='tmp/cache/datas/')
    {
        if(\is_string($path)){
            $this->path = $path;
        }else {
            throw new Exception($path." n'est pas une chaine de charactere");
        }
    }

}
