<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 03.01.14
 * Time: 19:37
 */

namespace Etheriq\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Blog
 * @package Etheriq\BlogBundle\Entity
 *
 *
 * @ORM\Entity(repositoryClass="Etheriq\BlogBundle\Repository\BlogRepository")
 * @ORM\Table(name="blog")
 * @Gedmo\SoftDeleteable(fieldName="deletedBlog", timeAware=false)
 */
class Blog
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
     * @ORM\Column(name="deletedGuest", type="datetime", nullable=true)
     */
    protected $deletedBlog;

    /**
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=250, unique=true)
     */
    protected $slug;

    /**
     *
     * @Assert\NotBlank(message = "name.not_blank")
     * @Assert\Length(min = "5", minMessage = "name.short")
     * @ORM\Column(type="string", length=200)
     */
    protected $title;

    /**
     *
     * @Assert\NotBlank(message = "message.not_blank")
     * @Assert\Length(min = "50", minMessage = "message.minLenght_error")
     * @ORM\Column(type="text")
     */
    protected $textBlog;

    /**
     *
     * @ORM\Column(type="string", length=240)
     */
    protected $picture;

    /**
     *
     * @ORM\Column(type="decimal", scale=1)
     */
    protected $rating;

    /**
     *
     * @ORM\Column(type="integer")
     */
    protected $numberOfVoters;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="blogs")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Tags", mappedBy="blogTags")
     */
    protected $tags;

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
     * Set deletedBlog
     *
     * @param \DateTime $deletedBlog
     * @return Blog
     */
    public function setDeletedBlog($deletedBlog)
    {
        $this->deletedBlog = $deletedBlog;

        return $this;
    }

    /**
     * Get deletedBlog
     *
     * @return \DateTime 
     */
    public function getDeletedBlog()
    {
        return $this->deletedBlog;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Blog
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Blog
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Blog
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

    /**
     * Set title
     *
     * @param string $title
     * @return Blog
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
     * Set textBlog
     *
     * @param string $textBlog
     * @return Blog
     */
    public function setTextBlog($textBlog)
    {
        $this->textBlog = $textBlog;

        return $this;
    }

    /**
     * Get textBlog
     *
     * @return string 
     */
    public function getTextBlog()
    {
        return $this->textBlog;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Blog
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set rating
     *
     * @param string $rating
     * @return Blog
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set numberOfVoters
     *
     * @param integer $numberOfVoters
     * @return Blog
     */
    public function setNumberOfVoters($numberOfVoters)
    {
        $this->numberOfVoters = $numberOfVoters;

        return $this;
    }

    /**
     * Get numberOfVoters
     *
     * @return integer 
     */
    public function getNumberOfVoters()
    {
        return $this->numberOfVoters;
    }

    /**
     * Set category
     *
     * @param \Etheriq\BlogBundle\Entity\Category $category
     * @return Blog
     */
    public function setCategory(\Etheriq\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Etheriq\BlogBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param \Etheriq\BlogBundle\Entity\Tags $tags
     * @return Blog
     */
    public function addTag(\Etheriq\BlogBundle\Entity\Tags $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Etheriq\BlogBundle\Entity\Tags $tags
     */
    public function removeTag(\Etheriq\BlogBundle\Entity\Tags $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;


        $tags->forAll(function ($key, $element) {

            $element->addBlogTag($this);

            return true;
        });

        return $this;
    }
}
