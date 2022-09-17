<?php

declare(strict_types=1);

namespace App\Model\Feedback\Fixture;

use App\Model\Feedback\Fixture\Factory\FeedbackFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
final class FeedbackFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; $i++) {
            $feedback = FeedbackFactory::createDefault();
            $manager->persist($feedback);
        }

        $manager->flush();
    }
}
