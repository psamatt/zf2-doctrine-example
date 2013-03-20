<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Post
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Post implements InputFilterAwareInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

     /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $createdDate;

    protected $inputFilter;

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
    * @return Post
    */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
    * Get title
    *
    * @param string
    */
    public function getTitle()
    {
        return $this->title;
    }

    /**
    * Set content
    *
    * @param string $content
    * @return Post
    */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
    * Get Cotntent
    *
    * @return String
    */
    public function getContent()
    {
        return $this->content;
    }

    /**
    * Set category
    *
    * @param Category $category
    * @return Post
    */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
    * Get category
    *
    * @return Category
    */
    public function getCategory()
    {
        return $this->category;
    }

    /**
    * @ORM\PrePersist
    */
    public function setCreatedDate()
    {
        $this->createdDate = new \DateTime();
    }

    /**
    * Get Created Date
    *
    * @return \DateTime
    */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
    * Exchange array - used in ZF2 form
    *
    * @param array $data An array of data
    */
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id']))? $data['id'] : null;
        $this->title = (isset($data['title']))? $data['title'] : null;
        $this->content = (isset($data['content']))? $data['content'] : null;
        $this->category = (isset($data['category']))? $data['category'] : null;
        $this->createdOn = (isset($data['createdOn']))? $data['createdOn'] : null;
    }

    /**
    * Get an array copy of object
    *
    * @return array
    */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
    * Set input method
    *
    * @param InputFilterInterface $inputFilter
    */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
    * Get input filter
    *
    * @return InputFilterInterface
    */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'content',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
