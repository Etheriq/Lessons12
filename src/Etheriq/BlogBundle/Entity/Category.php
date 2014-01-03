<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 03.01.14
 * Time: 20:36
 */

namespace Etheriq\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 * @package Etheriq\BlogBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
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
     * @ORM\Column(type="string", length=150)
     */
    protected $categoryName;

    /**
     *
     *@ORM\OneToMany(targetEntity="Blog", mappedBy="category")
     */
    protected $blogs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blogs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set categoryName
     *
     * @param string $categoryName
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string 
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Add blogs
     *
     * @param \Etheriq\BlogBundle\Entity\Blog $blogs
     * @return Category
     */
    public function addBlog(\Etheriq\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;

        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \Etheriq\BlogBundle\Entity\Blog $blogs
     */
    public function removeBlog(\Etheriq\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }
}
