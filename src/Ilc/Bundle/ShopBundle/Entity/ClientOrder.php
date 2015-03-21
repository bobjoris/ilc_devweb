<?php

namespace Ilc\Bundle\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientOrder
 *
 * @ORM\Table(name="client_orders")
 * @ORM\Entity
 */
class ClientOrder
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
     * @ORM\Column(name="orderReference", type="string", length=50)
     */
    private $orderReference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDate", type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="orders")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @ORM\OneToMany(targetEntity="ClientOrderLine", mappedBy="order", cascade={"persist"})
     */
    protected $orderLines;


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
     * Set orderReference
     *
     * @param string $orderReference
     * @return ClientOrder
     */
    public function setOrderReference($orderReference)
    {
        $this->orderReference = $orderReference;

        return $this;
    }

    /**
     * Get orderReference
     *
     * @return string 
     */
    public function getOrderReference()
    {
        return $this->orderReference;
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     * @return ClientOrder
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime 
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderLines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set client
     *
     * @param \Ilc\Bundle\ShopBundle\Entity\Client $client
     * @return ClientOrder
     */
    public function setClient(\Ilc\Bundle\ShopBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Ilc\Bundle\ShopBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add orderLines
     *
     * @param \Ilc\Bundle\ShopBundle\Entity\ClientOrderLine $orderLines
     * @return ClientOrder
     */
    public function addOrderLine(\Ilc\Bundle\ShopBundle\Entity\ClientOrderLine $orderLines)
    {
        $this->orderLines[] = $orderLines;

        return $this;
    }

    /**
     * Remove orderLines
     *
     * @param \Ilc\Bundle\ShopBundle\Entity\ClientOrderLine $orderLines
     */
    public function removeOrderLine(\Ilc\Bundle\ShopBundle\Entity\ClientOrderLine $orderLines)
    {
        $this->orderLines->removeElement($orderLines);
    }

    /**
     * Get orderLines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }
}
