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

  public function toAscii($text)
{

    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ??';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';

        $string = utf8_decode($text);
        $string = strtr($string, $a, $b);
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