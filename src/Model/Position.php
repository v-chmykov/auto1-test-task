<?php

namespace App\Model;

class Position
{
    /** @var int */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $seniorityLevel;
    /** @var string */
    private $country;
    /** @var string */
    private $city;
    /** @var int */
    private $salary;
    /** @var string */
    private $currency;
    /** @var array */
    private $skills;
    /** @var Company|null */
    private $company;

    /**
     * Position constructor.
     * @param int $id
     * @param string $title
     * @param string $seniorityLevel
     * @param string $country
     * @param string $city
     * @param int $salary
     * @param string $currency
     * @param array $skills
     * @param Company|null $company
     */
    public function __construct(
        int $id,
        string $title,
        string $seniorityLevel,
        string $country,
        string $city,
        int $salary,
        string $currency,
        array $skills,
        ?Company $company
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->seniorityLevel = $seniorityLevel;
        $this->country = $country;
        $this->city = $city;
        $this->salary = $salary;
        $this->currency = $currency;
        $this->skills = $skills;
        $this->company = $company;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'seniority_level' => $this->seniorityLevel,
            'country' => $this->country,
            'city' => $this->city,
            'salary' => $this->salary,
            'currency' => $this->currency,
            'skills' => $this->skills,
            'company' => $this->company->toArray(),
        ];
    }
}