<?php

declare(strict_types=1);

namespace App\Model\Feedback\Tests\Integration\Controller;

use App\Model\Feedback\Tests\Integration\Controller\Fixture\FeedbackFixture;
use App\Tests\Integration\EndpointTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @testdox Тесты контроллера получения списка авторов
 * @group author
 *
 * @internal
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbacksControllerTest extends EndpointTestCase
{
    private const URI = '/feedbacks';

    /**
     * @testdox Корректный запрос
     */
    public function testRequest(): void
    {
        $client = $this->getApiClient();

        $client->jsonRequest(
            Request::METHOD_GET,
            self::URI
        );

        $response = $client->getResponse();

        $this->assertHttpOk($response);
        $this->assertJsonResponse($response);
    }

    protected function getFixtures(): array
    {
        return [
            FeedbackFixture::class,
        ];
    }
}
