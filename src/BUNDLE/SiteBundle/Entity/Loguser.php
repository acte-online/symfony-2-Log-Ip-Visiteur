<?php
// src/BUNDLE/SiteBundle/Entity/Loguser.php
namespace BUNDLE\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="loguser")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Loguser
{
	/**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="ip",type="string", length=255)
     * @Assert\NotBlank
     */
    private $ip;
    
    /**
     * @ORM\Column(name="dateinsert", type="datetime")
     * @Assert\NotBlank
     */
    private $dateinsert;
    
    /**
     * @ORM\Column(name="page",type="string", length=255, nullable=true)
     */
    private $page;
    
    /**
     * @ORM\Column(name="article",type="string", length=255, nullable=true)
     */
    private $article;
    
    /**
     * @ORM\Column(name="useragent",type="string", length=255, nullable=true)
     */
    private $useragent;
    
    /**
     * @ORM\Column(name="querystring",type="string", length=255, nullable=true)
     */
    private $querystring;
    
    /**
     * @ORM\Column(name="referer",type="string", length=255, nullable=true)
     */
    private $referer;
    
    /**
     * @ORM\Column(name="uri",type="string", length=255, nullable=true)
     */
    private $uri;
    

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
     * Set ip
     *
     * @param string $ip
     * @return Loguser
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set dateinsert
     *
     * @param \DateTime $dateinsert
     * @return Loguser
     */
    public function setDateinsert($dateinsert)
    {
        $this->dateinsert = $dateinsert;

        return $this;
    }

    /**
     * Get dateinsert
     *
     * @return \DateTime 
     */
    public function getDateinsert()
    {
        return $this->dateinsert;
    }

    /**
     * Set page
     *
     * @param string $page
     * @return Loguser
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
     * Set article
     *
     * @param string $article
     * @return Loguser
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set useragent
     *
     * @param string $useragent
     * @return Loguser
     */
    public function setUseragent($useragent)
    {
        $this->useragent = $useragent;

        return $this;
    }

    /**
     * Get useragent
     *
     * @return string 
     */
    public function getUseragent()
    {
        return $this->useragent;
    }

    /**
     * Set querystring
     *
     * @param string $querystring
     * @return Loguser
     */
    public function setQuerystring($querystring)
    {
        $this->querystring = $querystring;

        return $this;
    }

    /**
     * Get querystring
     *
     * @return string 
     */
    public function getQuerystring()
    {
        return $this->querystring;
    }

    /**
     * Set referer
     *
     * @param string $referer
     * @return Loguser
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set uri
     *
     * @param string $uri
     * @return Loguser
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }
}
