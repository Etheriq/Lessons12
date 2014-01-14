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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @ORM\Column(name="deletedArticle", type="datetime", nullable=true)
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
     * @Assert\NotBlank(message = "blog_title.not_blank")
     * @Assert\Length(min = "5", minMessage = "blog_title_length.short")
     * @ORM\Column(type="string", length=200)
     */
    protected $title;

    /**
     *
     * @Assert\NotBlank(message = "blog_text.not_blank")
     * @Assert\Length(min = "50", minMessage = "blog_text.minLenght_error")
     * @ORM\Column(type="text")
     */
    protected $textBlog;

    /**
     *
     * @Assert\File(
     *     maxSize = "3M",
     *     mimeTypes = {"image/*"},
     *     mimeTypesMessage = "uploadMimeType.error",
     *     maxSizeMessage = "maxSize.error"
     * )
     */
    protected $blogImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * Assert\NotBlank
     */
    public $nameImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $pathImage;

    /**
     *
     * @Assert\NotEqualTo(value = 0, message="blog_rating_error")
     * @Assert\NotBlank(message = "blog_tatin.not_blank")
     * @ORM\Column(type="integer")
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
     * @ORM\ManyToMany(targetEntity="Tags", inversedBy="blogTags")
     */
    protected $tags;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $newCategory;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $newTags;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setBlogImage(UploadedFile $file = null)
    {
        $this->blogImage = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getBlogImage()
    {
        return $this->blogImage;
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
     * Set deletedBlog
     *
     * @param  \DateTime $deletedBlog
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
     * @param  \DateTime $created
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
     * @param  \DateTime $updated
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
     * @param  string $slug
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
     * @param  string $title
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
     * @param  string $textBlog
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
     * Set rating
     *
     * @param  string $rating
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
     * @param  integer $numberOfVoters
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
     * @param  \Etheriq\BlogBundle\Entity\Category $category
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
        $this->tags = new ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param  \Etheriq\BlogBundle\Entity\Tags $tags
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

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set newCategory
     *
     * @param  integer $newCategory
     * @return Blog
     */
    public function setNewCategory($newCategory)
    {
        $this->newCategory = $newCategory;

        return $this;
    }

    /**
     * Get newCategory
     *
     * @return integer
     */
    public function getNewCategory()
    {
        return $this->newCategory;
    }

    /**
     * Set newTags
     *
     * @param  integer $newTags
     * @return Blog
     */
    public function setNewTags($newTags)
    {
        $this->newTags = $newTags;

        return $this;
    }

    /**
     * Get newTags
     *
     * @return integer
     */
    public function getNewTags()
    {
        return $this->newTags;
    }

    public function uploadImage($role)
    {
        if($role == 'new') {
        // the file property can be empty if the field is not required
        if (null === $this->getBlogImage()) {
            $this->pathImage = $this->getUploadDir().'/default.jpg';
            $this->nameImage = 'default.jpg';
            return;
        }
        }

        if($role == 'edit') {
            if (null === $this->getBlogImage()) {

                return;
            }

        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to

        $randSuffix = mt_rand(1, 9999);

        $this->getBlogImage()->move(
            $this->getUploadRootDir(),
            $randSuffix.'-'.$this->getBlogImage()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->pathImage = $this->getUploadDir().'/'.$randSuffix.'-'.$this->getBlogImage()->getClientOriginalName();
        $this->nameImage = $randSuffix.'-'.$this->getBlogImage()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->blogImage = null;
    }

    public function getAbsolutePath()
    {
        return null === $this->pathImage
            ? null
            : $this->getUploadRootDir().'/'.$this->pathImage;
    }

    public function getWebPath()
    {
        return null === $this->pathImage
            ? null
            : $this->getUploadDir().'/'.$this->pathImage;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'img/blog';
    }

    /**
     * Set nameImage
     *
     * @param string $nameImage
     * @return Blog
     */
    public function setNameImage($nameImage)
    {
        $this->nameImage = $nameImage;

        return $this;
    }

    /**
     * Get nameImage
     *
     * @return string 
     */
    public function getNameImage()
    {
        return $this->nameImage;
    }

    /**
     * Set pathImage
     *
     * @param string $pathImage
     * @return Blog
     */
    public function setPathImage($pathImage)
    {
        $this->pathImage = $pathImage;

        return $this;
    }

    /**
     * Get pathImage
     *
     * @return string 
     */
    public function getPathImage()
    {
        return $this->pathImage;
    }
}
