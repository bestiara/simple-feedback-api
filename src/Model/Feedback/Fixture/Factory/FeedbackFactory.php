<?php

declare(strict_types=1);

namespace App\Model\Feedback\Fixture\Factory;

use App\Model\Feedback\Entity\Feedback;
use App\Model\Feedback\Entity\FeedbackId;
use Faker\Factory;
use Faker\Generator;

/**
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackFactory
{
    private static ?Generator $faker = null;

    public static function createDefault(): Feedback
    {
        return self::createEntity();
    }

    private static function createEntity(): Feedback
    {
        $faker = self::getOrCreateFaker();

        return new Feedback(
            FeedbackId::next(),
            $faker->name(),
            $faker->phoneNumber(),
            $faker->ipv4()
        );
    }

    private static function getOrCreateFaker(): Generator
    {
        if (!isset(self::$faker)) {
            self::$faker = Factory::create('ru_RU');
        }

        return self::$faker;
    }
}
