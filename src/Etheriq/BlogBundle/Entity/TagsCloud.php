<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 12.01.14
 * Time: 19:12
 */

namespace Etheriq\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="tagsCloud")
 */
class TagsCloud
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
    protected $tagCloudName;

    /**
     *
     * @ORM\Column(type="integer")
     */
    protected $tagCloudCount;

    /**
     *
     *@ORM\Column(type="string", length=150)
     */
    protected $tagSlug;

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
     * Set tagCloudName
     *
     * @param  string    $tagCloudName
     * @return TagsCloud
     */
    public function setTagCloudName($tagCloudName)
    {
        $this->tagCloudName = $tagCloudName;

        return $this;
    }

    /**
     * Get tagCloudName
     *
     * @return string
     */
    public function getTagCloudName()
    {
        return $this->tagCloudName;
    }

    /**
     * Set tagCloudCount
     *
     * @param  integer   $tagCloudCount
     * @return TagsCloud
     */
    public function setTagCloudCount($tagCloudCount)
    {
        $this->tagCloudCount = $tagCloudCount;

        return $this;
    }

    /**
     * Get tagCloudCount
     *
     * @return integer
     */
    public function getTagCloudCount()
    {
        return $this->tagCloudCount;
    }

    /**
     * Set tagSlug
     *
     * @param  string    $tagSlug
     * @return TagsCloud
     */
    public function setTagSlug($tagSlug)
    {
        $this->tagSlug = $tagSlug;

        return $this;
    }

    /**
     * Get tagSlug
     *
     * @return string
     */
    public function getTagSlug()
    {
        return $this->tagSlug;
    }
}
