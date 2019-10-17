<?php

namespace App\Tests\Model;

use App\Model\SkillsFilter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SkillsFilterTest extends TestCase
{
    private const POSITIONS = [
        ['skills' => ['PHP', 'SQL']],
        ['skills' => ['PHP', 'MySQL']],
        ['skills' => ['GoLang', 'Microservices']],
    ];

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param $skills
     * @param $expectedPositions
     * @param $expectedException
     */
    public function apply($skills, $expectedPositions, $expectedException): void
    {
        $filter = new SkillsFilter($skills);
        $this->assertEquals($skills, $filter->getSkills());

        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $this->assertEquals($expectedPositions, $filter->apply(self::POSITIONS));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'Filter by php' => [
                ['php'],
                [
                    ['skills' => ['PHP', 'SQL']],
                    ['skills' => ['PHP', 'MySQL']],
                ],
                null
            ],
            'Filter by php and mysql' => [
                ['php', 'mysql'],
                [
                    ['skills' => ['PHP', 'MySQL']],
                ],
                null
            ],
            'Nothing found' => [
                ['brainfuck'],
                null,
                NotFoundHttpException::class
            ],
        ];
    }
}