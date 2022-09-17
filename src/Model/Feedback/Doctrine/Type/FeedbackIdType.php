<?php

declare(strict_types=1);

namespace App\Model\Feedback\Doctrine\Type;

use App\Model\Feedback\Entity\FeedbackId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class FeedbackIdType extends Type
{
    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return \is_string($value)
            ? FeedbackId::fromString($value)
            : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof FeedbackId
            ? parent::convertToDatabaseValue($value->toString(), $platform)
            : null;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return 'feedback_id';
    }
}
