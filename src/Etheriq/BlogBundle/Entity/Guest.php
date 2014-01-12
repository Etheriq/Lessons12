<?php
/**
 * Created by PhpStorm.
 * File: Guest.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 15:08
 */

namespace Etheriq\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Guest
 *
 * @ORM\Entity(repositoryClass="Etheriq\BlogBundle\Repository\GuestRepository")
 * @ORM\Table(name="guest")
 * @Gedmo\SoftDeleteable(fieldName="deletedGuest", timeAware=false)
 */
class Guest
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
    protected $deletedGuest;

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
     * @Gedmo\Slug(fields={"nameGuest"})
     * @ORM\Column(type="string", length=250, unique=true)
     */
    protected $slug;

    /**
     *
     * @ORM\Column(name="name_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"nameGuest"})
     */
    protected $nameChanged;

    /**
     *
     * @Assert\Regex(pattern="/^[a-zA-Z]+$/", message="name.regex.error")
     * @Assert\NotBlank(message = "name.not_blank")
     * @Assert\Length(min = "5", minMessage = "name.short")
     * @ORM\Column(type="string", length=120, unique=true)
     */
    protected $nameGuest;

    /**
     *
     * @Assert\NotBlank(message = "email.not_blank")
     * @Assert\Email(message = "email.not_correct")
     * @ORM\Column(type="string", length=150)
     */
    protected $emailGuest;

    /**
     *
     * @Assert\NotBlank(message = "message.not_blank")
     * @Assert\Length(min = "100", minMessage = "message.minLenght_error")
     * @ORM\Column(type="text")
     */
    protected $bodyGuest;

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
     * Set nameGuest
     *
     * @param  string $nameGuest
     * @return Guest
     */
    public function setNameGuest($nameGuest)
    {
        $this->nameGuest = $nameGuest;

        return $this;
    }

    /**
     * Get nameGuest
     *
     * @return string
     */
    public function getNameGuest()
    {
        return $this->nameGuest;
    }

    /**
     * Set emailGuest
     *
     * @param  string $emailGuest
     * @return Guest
     */
    public function setEmailGuest($emailGuest)
    {
        $this->emailGuest = $emailGuest;

        return $this;
    }

    /**
     * Get emailGuest
     *
     * @return string
     */
    public function getEmailGuest()
    {
        return $this->emailGuest;
    }

    /**
     * Set bodyGuest
     *
     * @param  string $bodyGuest
     * @return Guest
     */
    public function setBodyGuest($bodyGuest)
    {
        $this->bodyGuest = $bodyGuest;

        return $this;
    }

    /**
     * Get bodyGuest
     *
     * @return string
     */
    public function getBodyGuest()
    {
        return $this->bodyGuest;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return Guest
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
     * @return Guest
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
     * Set nameChanged
     *
     * @param  \DateTime $nameChanged
     * @return Guest
     */
    public function setNameChanged($nameChanged)
    {
        $this->nameChanged = $nameChanged;

        return $this;
    }

    /**
     * Get nameChanged
     *
     * @return \DateTime
     */
    public function getNameChanged()
    {
        return $this->nameChanged;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Guest
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
     * Set deletedGuest
     *
     * @param  \DateTime $deletedGuest
     * @return Guest
     */
    public function setDeletedGuest($deletedGuest)
    {
        $this->deletedGuest = $deletedGuest;

        return $this;
    }

    /**
     * Get deletedGuest
     *
     * @return \DateTime
     */
    public function getDeletedGuest()
    {
        return $this->deletedGuest;
    }
}
