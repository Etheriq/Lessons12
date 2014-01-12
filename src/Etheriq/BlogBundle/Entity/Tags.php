<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 03.01.14
 * Time: 20:59
 */

namespace Etheriq\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Tags
 * @package Etheriq\BlogBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tags
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="string", length=150, unique=true)
     */
    protected $tagName;

    /**
     *
     * @Gedmo\Slug(fields={"tagName"})
     * @ORM\Column(type="string", length=200, unique=true)
     */
    protected $slug;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Blog", mappedBy="tags")
     */
    protected $blogTags;

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
     * Set tagName
     *
     * @param  string $tagName
     * @return Tags
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;

        return $this;
    }

    /**
     * Get tagName
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blogTags = new ArrayCollection();
    }

    /**
     * Add blogTags
     *
     * @param  \Etheriq\BlogBundle\Entity\Blog $blogTags
     * @return Tags
     */
    public function addBlogTag(\Etheriq\BlogBundle\Entity\Blog $blogTags)
    {
        $this->blogTags[] = $blogTags;

        return $this;
    }

    /**
     * Remove blogTags
     *
     * @param \Etheriq\BlogBundle\Entity\Blog $blogTags
     */
    public function removeBlogTag(\Etheriq\BlogBundle\Entity\Blog $blogTags)
    {
        $this->blogTags->removeElement($blogTags);
    }

    /**
     * Get blogTags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlogTags()
    {
        return $this->blogTags;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Tags
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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

    public function __toString()
    {
        return $this->getTagName();
    }

}
