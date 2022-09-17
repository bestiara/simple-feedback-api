<?php

declare(strict_types=1);

namespace App\Model\Feedback\Entity;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Идентификатор отзыва
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackId
{
    private function __construct(
        private string $value
    ) {
        if (!uuid_is_valid($this->value)) {
            throw new InvalidArgumentException();
        }
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $value): self
    {
        Assert::uuid($value);

        return new self($value);
    }

    public static function next(): self
    {
        /** @var string $value */
        $value = uuid_create(UUID_TYPE_DCE);

        return new self($value);
    }

    public function equals(self $dest): bool
    {
        return $this->value === $dest->value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
