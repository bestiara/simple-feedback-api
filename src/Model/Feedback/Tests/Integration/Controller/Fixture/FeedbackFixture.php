<?php

declare(strict_types=1);

namespace App\Model\Feedback\Tests\Integration\Controller\Fixture;

use App\Model\Feedback\Fixture\Factory\FeedbackFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist(
            FeedbackFactory::createDefault()
        );

        $manager->flush();
    }
}
