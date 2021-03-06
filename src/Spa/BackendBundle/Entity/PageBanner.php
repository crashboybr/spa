<?php

namespace Spa\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageBanner
 */
class PageBanner
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $page;

    /**
     * @var integer
     */
    private $bannerId;

    /**
     * @var boolean
     */
    private $hided;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;



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
     * Set page
     *
     * @param string $page
     * @return PageBanner
     */
    public function setPage($page)
    {
        $this->page = $page;
    
        return $this;
    }

    /**
     * Get page
     *
     * @return string 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set bannerId
     *
     * @param integer $bannerId
     * @return PageBanner
     */
    public function setBannerId($bannerId)
    {
        $this->bannerId = $bannerId;
    
        return $this;
    }

    /**
     * Get bannerId
     *
     * @return integer 
     */
    public function getBannerId()
    {
        return $this->bannerId;
    }

    /**
     * Set hided
     *
     * @param boolean $hided
     * @return PageBanner
     */
    public function setHided($hided)
    {
        $this->hided = $hided;
    
        return $this;
    }

    /**
     * Get hided
     *
     * @return boolean 
     */
    public function getHided()
    {
        return $this->hided;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return PageBanner
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PageBanner
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return PageBanner
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * @var \Spa\BackendBundle\Entity\Banner
     */
    private $banner;


    /**
     * Set banner
     *
     * @param \Spa\BackendBundle\Entity\Banner $banner
     * @return PageBanner
     */
    public function setBanner(\Spa\BackendBundle\Entity\Banner $banner = null)
    {
        $this->banner = $banner;
    
        return $this;
    }

    /**
     * Get banner
     *
     * @return \Spa\BackendBundle\Entity\Banner 
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

}