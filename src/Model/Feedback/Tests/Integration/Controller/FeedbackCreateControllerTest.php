<?php

declare(strict_types=1);

namespace App\Model\Feedback\Tests\Integration\Controller;

use App\Tests\Integration\EndpointTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @testdox Тесты контроллера создания отзыва
 * @group feedback
 *
 * @coversNothing
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class FeedbackCreateControllerTest extends EndpointTestCase
{
    private const URI = '/feedbacks';

    /**
     * @testdox Корректный запрос
     */
    public function testRequest(): void
    {
        $client = $this->getApiClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            self::URI,
            [
                'name' => 'Петр Петров',
                'phone' => '88004467125',
            ]
        );

        $response = $client->getResponse();

        $this->assertHttpCreated($response);
        $this->assertJsonResponse($response);
    }
}
