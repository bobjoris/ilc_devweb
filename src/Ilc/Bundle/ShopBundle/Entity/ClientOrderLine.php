<?php

namespace Ilc\Bundle\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientOrderLine
 *
 * @ORM\Table(name="client_order_lines")
 * @ORM\Entity
 */
class ClientOrderLine
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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;


    /**
     * @ORM\ManyToOne(targetEntity="ClientOrder", inversedBy="orderLines", cascade={"remove"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;



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
     * Set quantity
     *
     * @param integer $quantity
     * @return ClientOrderLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set product
     *
     * @param \Ilc\Bundle\ShopBundle\Entity\Product $product
     * @return ClientOrderLine
     */
    public function setProduct(\Ilc\Bundle\ShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Ilc\Bundle\ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set order
     *
     * @param \Ilc\Bundle\ShopBundle\Entity\ClientOrder $order
     * @return ClientOrderLine
     */
    public function setOrder(\Ilc\Bundle\ShopBundle\Entity\ClientOrder $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Ilc\Bundle\ShopBundle\Entity\ClientOrder 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
