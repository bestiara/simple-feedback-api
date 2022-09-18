<?php

declare(strict_types=1);

namespace App\Model\Feedback\Controller\Request;

use App\Infrastructure\Controller\Request\RequestDataInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
final class FeedbackCreateRequestData implements RequestDataInterface
{
    /**
     * @var string
     */
    #[Assert\Sequentially([
        new Assert\Type('string'),
        new Assert\NotBlank(),
        new Assert\Length(max: 255),
    ])]
    public $name;

    /**
     * @var string
     */
    #[Assert\Sequentially([
        new Assert\Type('string'),
        new Assert\NotBlank(),
    ])]
    public $phone;
}
