<?php

/**
 * Class Invoice
 * use to create a invoice
 * and calcule the price
 *
**/
class Invoice  
{
    /**
     * @var name of the article of the voice
     *
    **/
    protected $articleName;

    /**
     * @var price of the article without taxes
     *
    **/
    protected $priceWithoutTax;

    /**
     * @var value of the tax
     *
    **/
    protected $tax;

    /**
     * @return article name
     *
    **/
    public function getArticleName()
    {
        return $this->articleName;
    }

    /**
     * @param $string set the name of an article
     *
    **/
    public function setArticleName($string)
    {
        $this->articleName = $string;
    }

    /**
     * @return price return price
     *
    **/
    public function getPriceWithoutTax()
    {
        return $this->priceWithoutTax;
    }

    /**
     * @param $price set the value of the price, only an int is accepted
     *
    **/
    public function setPriceWithoutPrice($price)
    {
        if (is_int($price)){
            $this->priceWithoutTax = $price;
        }else{
            echo $price.'n\'est pas un entier';
        }
    }

    /**
     * @return return the value of the tax
     *
    **/
    public function getTax()
    {
        return $this->tax;   
    }

    /**
     * @param $tax set int value for int
     *
    **/
    public function setTax($tax)
    {
        if(is_int($tax)){
            $this->tax = $tax;
        }else{
            echo $tax.'n\'est pas un entier';
        }
    }

    /**
     * @return price return prive with tax (price without taxe = the value of tax)
     *
    **/
    public function getPrice()
    {
        return $this->getPriceWithoutTax()+ $this->getTax();
    }
}
