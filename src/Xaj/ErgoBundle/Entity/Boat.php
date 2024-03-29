<?php

namespace Xaj\ErgoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Xaj\ErgoBundle\Entity\Rower;
use Xaj\ErgoBundle\Entity\Leader;

/**
 * Boat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Xaj\ErgoBundle\Entity\BoatRepository")
 */
class Boat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="record", type="integer")
     */
    private $record;

    /**
     * @var boolean
     *
     * @ORM\Column(name="payment", type="boolean")
     */
    private $payment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted;

    /**
     * @var  boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;

    /**
     * @ORM\OneToMany(targetEntity="Xaj\ErgoBundle\Entity\Rower", mappedBy="boat", orphanRemoval=true)
     */
    private $rowers;

    /**
     * @ORM\OneToOne(targetEntity="Xaj\ErgoBundle\Entity\Leader", mappedBy="boat", orphanRemoval=true)
     */
    private $leader;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->record = 0;
        $this->payment = false;
        $this->deleted = false;
        $this->valid = false;
        $this->rowers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Boat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Boat
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set record
     *
     * @param \DateTime $record
     * @return Boat
     */
    public function setRecord($record)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get record
     *
     * @return \DateTime 
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * Set payment
     *
     * @param boolean $payment
     * @return Boat
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return boolean 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Add rowers
     *
     * @param \Xaj\ErgoBundle\Entity\Rower $rowers
     * @return Boat
     */
    public function addRower(\Xaj\ErgoBundle\Entity\Rower $rowers)
    {
        $this->rowers[] = $rowers;

        return $this;
    }

    /**
     * Remove rowers
     *
     * @param \Xaj\ErgoBundle\Entity\Rower $rowers
     */
    public function removeRower(\Xaj\ErgoBundle\Entity\Rower $rowers)
    {
        $this->rowers->removeElement($rowers);
    }

    /**
     * Get rowers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRowers()
    {
        return $this->rowers;
    }

    /**
     * Set leader
     *
     * @param \Xaj\ErgoBundle\Entity\Leader $leader
     * @return Boat
     */
    public function setLeader(\Xaj\ErgoBundle\Entity\Leader $leader = null)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * Get leader
     *
     * @return \Xaj\ErgoBundle\Entity\Leader 
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     * @return Boat
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean 
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Boat
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
