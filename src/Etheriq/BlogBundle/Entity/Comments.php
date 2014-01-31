<?php
/**
 * Created by PhpStorm.
 * File: Comments.php
 * User: Yuriy Tarnavskiy
 * Date: 27.01.14
 * Time: 14:21
 */

namespace Etheriq\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Blog
 * @package Etheriq\BlogBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="comments")
 * @Gedmo\SoftDeleteable(fieldName="deletedComment", timeAware=false)
 */
class Comments
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Author of the comment
     *
     * @ORM\ManyToOne(targetEntity="Etheriq\AdminBlogBundle\Entity\User")
     * @var User
     */
    protected $author;

    /**
     * @var integer blog
     *
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     */
    protected $blog;

    /**
     *
     * @ORM\Column(name="deletedComment", type="datetime", nullable=true)
     */
    protected $deletedComment;

    /**
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     *
     * @Assert\NotBlank(message = "comment.not_blank")
     * @Assert\Length(min = "5", minMessage = "comment_text.minLength_error")
     * @ORM\Column(type="text")
     */
    protected $textComment;
    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rating;

    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
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
     * Set deletedComment
     *
     * @param  \DateTime $deletedComment
     * @return Comments
     */
    public function setDeletedComment($deletedComment)
    {
        $this->deletedComment = $deletedComment;

        return $this;
    }

    /**
     * Get deletedComment
     *
     * @return \DateTime
     */
    public function getDeletedComment()
    {
        return $this->deletedComment;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return Comments
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
     * Set textComment
     *
     * @param  string   $textComment
     * @return Comments
     */
    public function setTextComment($textComment)
    {
        $this->textComment = $textComment;

        return $this;
    }

    /**
     * Get textComment
     *
     * @return string
     */
    public function getTextComment()
    {
        return $this->textComment;
    }

    /**
     * Set blog
     *
     * @param  \Etheriq\BlogBundle\Entity\Blog $blog
     * @return Comments
     */
    public function setBlog(\Etheriq\BlogBundle\Entity\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return \Etheriq\BlogBundle\Entity\Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set author
     *
     * @param  \Etheriq\AdminBlogBundle\Entity\User $author
     * @return Comments
     */
    public function setAuthor(\Etheriq\AdminBlogBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Etheriq\AdminBlogBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set rating
     *
     * @param  integer  $rating
     * @return Comments
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }
}
