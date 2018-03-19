<?php
declare (strict_types=1);

namespace Tardigrades\SectionField\Service;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tardigrades\SectionField\ValueObject\FullyQualifiedClassName;
use Tardigrades\SectionField\ValueObject\Id;

/**
 * @coversDefaultClass Tardigrades\SectionField\Service\DoctrineSectionCreator
 * @covers ::<private>
 */
final class DoctrineSectionCreatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var EntityManagerInterface|Mockery\Mock */
    private $entityManager;

    public function setUp()
    {
        $this->entityManager = Mockery::mock(EntityManagerInterface::class);
    }

    /**
     * @test
     * @covers ::__construct
     */
    public function it_creates()
    {
        $section = new DoctrineSectionCreator($this->entityManager);
        $this->assertInstanceOf(DoctrineSectionCreator::class, $section);
    }

    /**
     * @test
     * @covers ::save
     */
    public function it_saves()
    {
        $className = FullyQualifiedClassName::fromString('I am qualified! In a Class!');
        $id = Id::fromInt(2222);
        $data = Mockery::mock('alias:Tardigrades\SectionField\Generator\CommonSectionInterface')->makePartial();

        $section = new DoctrineSectionCreator($this->entityManager);

        $this->entityManager->shouldReceive('persist')
            ->once()
            ->with($data);

        $this->entityManager->shouldReceive('flush')
            ->once();

        $section->save($data);
    }

    /**
     * @test
     * @covers ::persist
     */
    public function it_persists()
    {
        $className = FullyQualifiedClassName::fromString('I am qualified! In a Class!');
        $id = Id::fromInt(2222);
        $data = Mockery::mock('alias:Tardigrades\SectionField\Generator\CommonSectionInterface')->makePartial();

        $section = new DoctrineSectionCreator($this->entityManager);

        $this->entityManager->shouldReceive('persist')
            ->once()
            ->with($data);

        $this->entityManager->shouldReceive('flush')
            ->never();

        $section->persist($data);
    }

    /**
     * @test
     * @covers ::flush
     */
    public function it_flushes()
    {
        $section = new DoctrineSectionCreator($this->entityManager);

        $this->entityManager->shouldReceive('flush')
            ->once();

        $section->flush();
    }
}