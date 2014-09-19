<?php
namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use DMS\Filter\Rules as Filter;
use DMS\Bundle\FilterBundle\Rule as SfFilter;
use DateTime;
use Blogger\BlogBundle\Annotation\StandardObject;
use Blogger\BlogBundle\Validator\Constraints as BloggerAssert;
use Blogger\BlogBundle\DMSFilter\Rules as BloggerFilter;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\BlogRepository")
 * @ORM\Table(name="blog", indexes={@ORM\Index(name="search_idx", columns={"title", "created"})})
 **/
class Blog
{
  /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
   **/
  protected $id;

  /**
   * @BloggerAssert\ContainsWord
   * @BloggerFilter\StripWords()
   * @ORM\Column(type="string")
   **/
  protected $title;

  /**
   * @ORM\Column(type="string", length=100)
   * SfFilter\Service(service="mycustomedms.strip_sensitive_word", method="filter")
   **/
  protected $author;


  /**
   * @ORM\Column(type="text")
   **/
  protected $blog;

  /**
   * @ORM\Column(type="string", length=20)
   **/
  protected $image;

  /**
   * @ORM\Column(type="text")
   **/
  protected $tags;

  /**
   * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
   **/
  protected $comments;

  /**
   * @ORM\Column(type="datetime")
   **/
  protected $created;

  /**
   * @ORM\Column(type="datetime")
   **/
  protected $updated;

  public function __construct()
  {
    $this->comments = new ArrayCollection();
    $this->setCreated(new \DateTime());
    $this->setUpdated(new \DateTime());
  }

  public function __tostring()
  {
    return $this->getTitle();
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
     *
     * @StandardObject("title", dataType="string")
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Blog
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     * @StandardObject("author", dataType="string")
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set blog
     *
     * @param string $blog
     * @return Blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return string 
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Blog
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Blog
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
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
     * Add comments
     *
     * @param \Blogger\BlogBundle\Entity\Comment $comments
     * @return Blog
     */
    public function addComment(\Blogger\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Blogger\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Blogger\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
