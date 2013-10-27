<?php

namespace Spa\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu
 */
class Menu
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
     * @var string
     */
    private $slug;

    
    protected $submenus;

    public function __construct()
    {
        $this->submenus = new ArrayCollection();
    }


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
     * @return Menu
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
     * Set slug
     *
     * @param string $slug
     * @return Menu
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

     public function toAscii($str, $replace=array(), $delimiter='-') {
     if( !empty($replace) ) {
      $str = str_replace((array)$replace, ' ', $str);
     }

     $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
     $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
     $clean = strtolower(trim($clean, '-'));
     $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

     return $clean;
    }


    /**
     * Add submenus
     *
     * @param \Spa\BackendBundle\Entity\SubMenu $submenus
     * @return Menu
     */
    public function addSubmenu(\Spa\BackendBundle\Entity\SubMenu $submenus)
    {
        $this->submenus[] = $submenus;
    
        return $this;
    }

    /**
     * Remove submenus
     *
     * @param \Spa\BackendBundle\Entity\SubMenu $submenus
     */
    public function removeSubmenu(\Spa\BackendBundle\Entity\SubMenu $submenus)
    {
        $this->submenus->removeElement($submenus);
    }

    /**
     * Get submenus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubmenus()
    {
        return $this->submenus;
    }

    public function __toString()
    {
        return $this->name;
    }
}