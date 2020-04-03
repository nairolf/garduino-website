<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Carbon\Carbon;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={"get", "put"},
 *     normalizationContext={"groups"={"temperature_listing:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"temperature_listing:write"}, "swagger_definition_name"="Write"},
 *     attributes={
 *          "pagination_items_per_page"=2,
 *          "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TemperatureRepository")
 * @ApiFilter(SearchFilter::class, properties={"channel": "partial", "sensor": "partial"})
 * @ApiFilter(RangeFilter::class, properties={"value"})
 */
class Temperature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"temperature_listing:read", "temperature_listing:write"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="3",
     *     max="256",
     *     maxMessage="Name your sensor in max 256 chars."
     * )
     */
    private $sensor;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"temperature_listing:read", "temperature_listing:write"})
     * @Assert\NotBlank()
     */
    private $channel;

    /**
     * @ORM\Column(type="float")
     * @Groups({"temperature_listing:read", "temperature_listing:write"})
     * @Assert\NotBlank()
     */
    private $value;

    /**
     * When was the temperature captured.
     * @ORM\Column(type="datetime")
     * @Groups({"temperature_listing:read"})
     */
    private $createdAt;

    /**
     * Set creation time to now()
     */
    public function __construct(float $value = null)
    {
        $this->value = $value;
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return mixed
     * @author Florian Hanno <florian.hanno@twt.de>
     */
    public function getId()
    {
        return $this->id;
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

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }
}
