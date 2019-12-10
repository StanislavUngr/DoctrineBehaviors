<?php

declare(strict_types=1);

namespace BehaviorFixtures\ORM;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BehaviorFixtures\ORM\FilterableRepository")
 */
class FilterableEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * Returns object id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return name.
     */
    public function getName(): name
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param the $name value to set.
     */
    public function setName(the $name): void
    {
        $this->name = $name;
    }

    /**
     * Get code.
     *
     * @return integer code.
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param integer $code the value to set.
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }
}
