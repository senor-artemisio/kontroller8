<?php

namespace App\Api\DTO;

/**
 * Data transfer object for profile.
 */
class ProfileDTO extends BaseDTO
{
    /** @var string */
    protected $userId;

    /** @var int */
    protected $age;

    /** @var int */
    protected $weight;

    /** @var int */
    protected $height;

    /** @var float */
    protected $activity;

    /** @var float */
    protected $modifier;

    /** @var bool */
    protected $gender;

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getActivity(): float
    {
        return $this->activity;
    }

    /**
     * @param float $activity
     */
    public function setActivity(float $activity): void
    {
        $this->activity = $activity;
    }

    /**
     * @return float
     */
    public function getModifier(): float
    {
        return $this->modifier;
    }

    /**
     * @param float $modifier
     */
    public function setModifier(float $modifier): void
    {
        $this->modifier = $modifier;
    }

    /**
     * @return bool
     */
    public function getGender(): bool
    {
        return $this->gender;
    }

    /**
     * @param bool $gender
     */
    public function setGender(bool $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return array list of changeable attributes
     */
    protected function getChangeableAttributes(): array
    {
        return ['age', 'weight', 'height', 'activity', 'modifier', 'gender'];
    }
}