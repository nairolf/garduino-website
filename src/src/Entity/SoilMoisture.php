<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SoilMoistureRepository")
 * @codeCoverageIgnore
 */
class SoilMoisture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sensor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSensor(): ?string
    {
        return $this->sensor;
    }

    public function setSensor(string $sensor): self
    {
        $this->sensor = $sensor;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'timestamp' => $this->getTimestamp(),
            'value' => $this->getValue(),
            'sendor' => $this->getSensor()
        ];
    }
}
