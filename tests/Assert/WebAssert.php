<?php

declare(strict_types=1);

namespace App\Tests\Assert;

use App\Tests\Assert\Response\IsHttpBadRequest;
use App\Tests\Assert\Response\IsHttpCreated;
use App\Tests\Assert\Response\IsHttpForbidden;
use App\Tests\Assert\Response\IsHttpNoContent;
use App\Tests\Assert\Response\IsHttpNotFound;
use App\Tests\Assert\Response\IsHttpOk;
use App\Tests\Assert\Response\IsHttpUnauthorized;
use App\Tests\Assert\Response\IsHttpUnprocessableEntity;
use App\Tests\Assert\Response\IsJsonResponse;
use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\HttpFoundation\Response;

/**
 * Трейт с кастомными ассертами
 *
 * @method static assertThat($value, Constraint $constraint, string $message = ''): void
 */
trait WebAssert
{
    public function assertHttpOk(Response $response, string $message = ''): void
    {
        self::assertThat($response, self::isHttpOk(), $message);
    }

    public function assertHttpCreated(Response $response, string $message = ''): void
    {
        self::assertThat($response, self::isHttpCreated(), $message);
    }

    public function assertHttpNoContent(Response $response, string $message = ''): void
    {
        self::assertThat($response, self::isHttpNoContent(), $message);
    }

    public function assertHttpBadRequest(Response $response, string $message = ''): void
    {
        self::assertThat($response, self::isHttpBadRequest(), $message);
    }

    public function assertHttpUnauthorized(Response $response, string $message = ''): void
    {
        self::assertThat($response, self::isHttpUnauthorized(), $message);
    }

    public function assertHttpForbidden(Response $condition, string $message = ''): void
    {
        self::assertThat($condition, self::isHttpForbidden(), $message);
    }

    public function assertHttpNotFound(Response $condition, string $message = ''): void
    {
        self::assertThat($condition, self::isHttpNotFound(), $message);
    }

    public function assertHttpUnprocessableEntity(Response $condition, string $message = ''): void
    {
        self::assertThat($condition, self::isHttpUnprocessableEntity(), $message);
    }

    public function assertJsonResponse(Response $condition, string $message = ''): void
    {
        self::assertThat($condition, self::isJsonResponse(), $message);
    }

    public static function isHttpOk(): IsHttpOk
    {
        return new IsHttpOk();
    }

    public static function isHttpCreated(): IsHttpCreated
    {
        return new IsHttpCreated();
    }

    public static function isHttpNoContent(): IsHttpNoContent
    {
        return new IsHttpNoContent();
    }

    public static function isHttpBadRequest(): IsHttpBadRequest
    {
        return new IsHttpBadRequest();
    }

    public static function isHttpUnauthorized(): IsHttpUnauthorized
    {
        return new IsHttpUnauthorized();
    }

    public static function isHttpForbidden(): IsHttpForbidden
    {
        return new IsHttpForbidden();
    }

    public static function isHttpNotFound(): IsHttpNotFound
    {
        return new IsHttpNotFound();
    }

    public static function isHttpUnprocessableEntity(): IsHttpUnprocessableEntity
    {
        return new IsHttpUnprocessableEntity();
    }

    public static function isJsonResponse(): IsJsonResponse
    {
        return new IsJsonResponse();
    }
}
