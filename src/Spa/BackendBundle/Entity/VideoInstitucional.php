<?php

namespace Spa\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * VideoInstitucional
 */
class VideoInstitucional
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $mp4;

    /**
     * @var string
     */
    private $webm;

    /**
     * @var string
     */
    private $ogv;

    /**
     * @var string
     */
    private $pic;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


    /* begin upload file */
    /**
     * @Assert\File(maxSize="700000000")
     */
    private $file_mp4;

    /**
     * @Assert\File(maxSize="700000000")
     */
    private $file_webm;

    /**
     * @Assert\File(maxSize="700000000")
     */
    private $file_ogv;

    /**
     * @Assert\File(maxSize="700000000")
     */
    private $file_pic;

    private $temp;

    public function setFileMp4(UploadedFile $file_mp4 = null)
    {
        $this->file_mp4 = $file_mp4;

        // check if we have an old image path
        if (isset($this->mp4)) {
            // store the old name to delete after the update
            $this->temp = $this->mp4;
            $this->mp4 = null;
        } else {
            $this->mp4 = 'initial';
        }
    }

    public function setFileWebm(UploadedFile $file_webm = null)
    {
        $this->file_webm = $file_webm;

        // check if we have an old image path
        if (isset($this->webm)) {
            // store the old name to delete after the update
            $this->temp = $this->webm;
            $this->webm = null;
        } else {
            $this->webm = 'initial';
        }

    }

    public function setFileOgv(UploadedFile $file_ogv = null)
    {
        $this->file_ogv = $file_ogv;

        // check if we have an old image path
        if (isset($this->ogv)) {
            // store the old name to delete after the update
            $this->temp = $this->ogv;
            $this->ogv = null;
        } else {
            $this->ogv = 'initial';
        }
    }

    public function setFilePic(UploadedFile $file_pic = null)
    {
        $this->file_pic = $file_pic;

        // check if we have an old image path
        if (isset($this->pic)) {
            // store the old name to delete after the update
            $this->temp = $this->pic;
            $this->pic = null;
        } else {
            $this->pic = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFileMp4()) {
            // do whatever you want to generate a unique name
            $filename = "video_" . uniqid();
            $this->mp4 = $this->getUploadDir() . '/' . $filename.'.'.$this->getFileMp4()->guessExtension();
        }
        
        if (null !== $this->getFileWebm()) {
            // do whatever you want to generate a unique name
            $filename = "video_" . uniqid();
            $this->webm = $this->getUploadDir() . '/' . $filename.'.'.$this->getFileWebm()->guessExtension();
        }

        if (null !== $this->getFileOgv()) {
            // do whatever you want to generate a unique name
            $filename = "video_" . uniqid();
            $this->ogv = $this->getUploadDir() . '/' . $filename.'.'.$this->getFileOgv()->guessExtension();
        }

        if (null !== $this->getFilePic()) {
            // do whatever you want to generate a unique name
            $filename = "video_" . uniqid();
            $this->pic = $this->getUploadDir() . '/' . $filename.'.'.$this->getFilePic()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {

        
        if (null === $this->getFileMp4() && null === $this->getFileWebm() && null === $this->getFileOgv() && null === $this->getFilePic()) {
            return;
        }

        if (null !== $this->getFileMp4())
        { 
            $this->getFileMp4()->move($this->getUploadRootDir(), $this->mp4);

            $this->file_mp4 = null;
        }

        if (null !== $this->getFileWebm())
        { 
            
            $this->getFileWebm()->move($this->getUploadRootDir(), $this->webm);

            $this->file_webm = null;
        }

        if (null !== $this->getFileOgv())
        { 
            $this->getFileOgv()->move($this->getUploadRootDir(), $this->ogv);

            $this->file_ogv = null;
        }

        if (null !== $this->getFilePic())
        { 
            $this->getFilePic()->move($this->getUploadRootDir(), $this->pic);

            $this->file_pic = null;
        }
    }

    public function getFileMp4()
    {
        return $this->file_mp4;
    }

    public function getFileWebm()
    {
        return $this->file_webm;
    }

    public function getFileOgv()
    {
        return $this->file_ogv;
    }

    public function getFilePic()
    {
        return $this->file_pic;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesnt screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/videos';
    } 

    /* end upload file */

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
     * Set title
     *
     * @param string $title
     * @return VideoInstitucional
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set mp4
     *
     * @param string $mp4
     * @return VideoInstitucional
     */
    public function setMp4($mp4)
    {
        $this->mp4 = $mp4;
    
        return $this;
    }

    /**
     * Get mp4
     *
     * @return string 
     */
    public function getMp4()
    {
        return $this->mp4;
    }

    /**
     * Set webm
     *
     * @param string $webm
     * @return VideoInstitucional
     */
    public function setWebm($webm)
    {
        $this->webm = $webm;
    
        return $this;
    }

    /**
     * Get webm
     *
     * @return string 
     */
    public function getWebm()
    {
        return $this->webm;
    }

    /**
     * Set ogv
     *
     * @param string $ogv
     * @return VideoInstitucional
     */
    public function setOgv($ogv)
    {
        $this->ogv = $ogv;
    
        return $this;
    }

    /**
     * Get ogv
     *
     * @return string 
     */
    public function getOgv()
    {
        return $this->ogv;
    }

    /**
     * Set pic
     *
     * @param string $pic
     * @return VideoInstitucional
     */
    public function setPic($pic)
    {
        $this->pic = $pic;
    
        return $this;
    }

    /**
     * Get pic
     *
     * @return string 
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return VideoInstitucional
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return VideoInstitucional
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
     * @return VideoInstitucional
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

    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));
        //var_dump($this->file_mp4);exit;
        if ($this->file_mp4 || $this->file_webm || $this->file_ogv || $this->file_pic)
        {
            $this->preUpload();
            $this->temp = null;
            $this->upload();
        }

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }
}
