<?php

namespace Spa\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SubMenu
 */
class SubMenu
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $menuId;

    
    protected $menu;

    /**
     * @var string
     */
    private $slug;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SubMenu
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set menuId
     *
     * @param integer $menuId
     * @return SubMenu
     */
    public function setMenuId($menuId)
    {
        $this->menuId = $menuId;
    
        return $this;
    }

    /**
     * Get menuId
     *
     * @return integer 
     */
    public function getMenuId()
    {
        return $this->menuId;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return SubMenu
     */
    public function setSlug($slug)
    {
        $this->slug = $this->toAscii($this->name);
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set menu
     *
     * @param \Spa\BackendBundle\Entity\Menu $menu
     * @return SubMenu
     */
    public function setMenu(\Spa\BackendBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;
    
        return $this;
    }

    /**
     * Get menu
     *
     * @return \Spa\BackendBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }

    public function toAscii($text)
    {

            $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ??';
                $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';

                $string = utf8_decode($text);
                $string = strtr($string, utf8_decode($a), $b);
               // $string = str_replace('', $type,$string);
                $text = strtolower($string);

                
          // replace non letter or digits by -
          $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

          // trim
          $text = trim($text, '-');

          // transliterate
          $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
          // lowercase
          $text = strtolower($text);

          // remove unwanted characters
          $text = preg_replace('~[^-\w]+~', '', $text);

          if (empty($text))
          {
            return 'n-a';
          }
          return $text;
    }
}