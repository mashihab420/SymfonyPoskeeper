<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $invoiceno;



    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $productid;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceno(): ?string
    {
        return $this->invoiceno;
    }

    public function setInvoiceno(string $invoiceno): self
    {
        $this->invoiceno = $invoiceno;

        return $this;
    }



    public function getProductid(): ?string
    {
        return $this->productid;
    }

    public function setProductid(?string $productid): self
    {
        $this->productid = $productid;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }





}
