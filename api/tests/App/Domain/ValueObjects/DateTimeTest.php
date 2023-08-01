<?php

declare(strict_types=1);

namespace Tests\App\Domain\ValueObjects;

use App\Domain\Exceptions\DateTimeException;
use App\Domain\ValueObjects\DateTime;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class DateTimeTest extends TestCase
{
    /**
     * @throws \App\Domain\Exceptions\DateTimeException
     */
    public function testNow(): void
    {
        $date = DateTime::now();

        self::assertEquals($date->format('d/m/y'), (new DateTimeImmutable())->format('d/m/y'));
    }

    /**
     * @throws \App\Domain\Exceptions\DateTimeException
     */
    public function testIncorrectDate(): void
    {
        $this->expectException(DateTimeException::class);

        DateTime::create('incorrect format');
    }

    /**
     * @throws \App\Domain\Exceptions\DateTimeException
     * @throws Exception
     */
    public function testCreateDate(): void
    {
        $dateTime = '2000-01-01T01:01:01+00:00';

        self::assertEquals(
            (string)DateTime::create($dateTime),
            (new DateTimeImmutable($dateTime))->format(DateTime::FORMAT),
        );
    }
}
