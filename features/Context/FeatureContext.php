<?php

namespace App\Behat;

use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext
{
    /**
     * @Then /^the response is JSON$/
     */
    public function theResponseIsJson(): void
    {
        $response = $this->getSession()->getPage()->getContent();
        $decoded = json_decode($response, true);

        Assert::assertNotFalse($decoded);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @Then /^the response contains (?P<key>\w+) equals (?P<value>\w+)$/
     */
    public function theResponseContainsKeyWithValue($key, $value): void
    {
        $response = $this->getSession()->getPage()->getContent();
        $decoded = json_decode($response, true);

        Assert::assertArrayHasKey($key, $decoded);
        Assert::assertEquals($decoded[$key], $value);
    }

    /**
     * @param string $total
     *
     * @Then /^the response contains at least (?P<total>\d+) elements$/
     */
    public function theResponseContainsAtLeast($total): void
    {
        $response = $this->getSession()->getPage()->getContent();
        $decoded = json_decode($response, true);

        Assert::assertGreaterThanOrEqual($total, count($decoded));
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @Then /^every position in response has a field (?P<key>\w+) with value (?P<value>\w+)$/
     */
    public function everyPositionInResponseHasFieldWithValue($key, $value): void
    {
        $response = $this->getSession()->getPage()->getContent();
        $decoded = json_decode($response, true);

        foreach ($decoded as $position) {
            Assert::assertArrayHasKey($key, $position);
            Assert::assertEquals($position[$key], $value);
        }
    }

    /**
     * @param string skills
     *
     * @Then /^every position in response has skill (?P<rawSkills>(\w+)(,\w+)*)$/
     */
    public function everyPositionsHasSkills($rawSkills): void
    {
        $response = $this->getSession()->getPage()->getContent();
        $decoded = json_decode($response, true);
        $skills = explode(',', strtolower($rawSkills));
        $searchSkillsCount = count($skills);

        foreach ($decoded as $position) {
            Assert::assertArrayHasKey('skills', $position);

            $positionSkills = explode(',', strtolower(implode(',', $position['skills'])));
            Assert::assertCount($searchSkillsCount, array_intersect($skills, $positionSkills));
        }
    }
}
