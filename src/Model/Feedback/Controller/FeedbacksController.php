<?php

declare(strict_types=1);

namespace App\Model\Feedback\Controller;

use App\Infrastructure\Controller\AbstractController;
use App\Infrastructure\Controller\Request\Pageable;
use App\Infrastructure\Controller\Request\Paginator;
use App\Model\Feedback\Controller\Transformer\FeedbackTransformer;
use App\Model\Feedback\Service\Fetcher\FeedbacksFetcher;
use Symfony\Component\HttpFoundation\Response;

/**
 * Получение списка отзывов
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
final class FeedbacksController extends AbstractController
{
    public function __construct(
        private readonly FeedbacksFetcher $fetcher,
        private readonly FeedbackTransformer $transformer
    ) {
    }

    public function __invoke(Pageable $pageable): Response
    {
        $result = $this->fetcher->fetch(
            $pageable->getPage(),
            $pageable->getPerPage()
        );

        return $this->createEntityCollectionResponse(
            $result->list,
            $this->transformer,
            new Paginator($pageable, $result->total)
        );
    }
}
