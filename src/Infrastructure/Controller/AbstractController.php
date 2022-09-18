<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\Controller\Response\BadRequestResponse;
use App\Infrastructure\Controller\Response\CommandViolationsRequestResponse;
use App\Infrastructure\Controller\Response\CreatedResponse;
use App\Infrastructure\Controller\Response\EntityCollectionResponse;
use App\Infrastructure\Controller\Response\EntityResponse;
use App\Infrastructure\Controller\Response\NoContentResponse;
use App\Infrastructure\Controller\Response\NotFoundResponse;
use App\Infrastructure\Controller\Response\OkResponse;
use App\Infrastructure\Controller\Transformer\TransformerInterface;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

/**
 * Базовый контроллер.
 */
abstract class AbstractController implements ServiceSubscriberInterface
{
    protected ?ContainerInterface $container = null;

    public static function getSubscribedServices(): array
    {
        return [
            'app.fractal' => FractalManager::class,
        ];
    }

    /**
     * @required
     */
    public function setContainer(ContainerInterface $container): ?ContainerInterface
    {
        $previous = $this->container;
        $this->container = $container;

        return $previous;
    }

    protected function createCreatedResponse(): Response
    {
        return new CreatedResponse();
    }

    protected function createNoContentResponse(): Response
    {
        return new NoContentResponse();
    }

    protected function createOkResponse(): Response
    {
        return new OkResponse();
    }

    protected function createBadRequestResponse(string $code, string $message): Response
    {
        return new BadRequestResponse($code, $message);
    }

    protected function createCommandViolationsResponse(ConstraintViolationListInterface $violations): Response
    {
        return new CommandViolationsRequestResponse($violations);
    }

    protected function createNotFoundResponse(string $code, string $message): Response
    {
        return new NotFoundResponse($code, $message);
    }

    /**
     * @param TransformerAbstract&TransformerInterface $transformer
     */
    protected function createEntityResponse(
        object $entity,
        TransformerInterface $transformer,
        int $statusCode = Response::HTTP_OK
    ): Response {
        $item = new Item($entity, $transformer, $transformer->getType());

        /** @var array $data */
        $data = $this->getFractalManager()->createData($item)->toArray();

        return new EntityResponse($data, $statusCode);
    }

    /**
     * @param TransformerAbstract&TransformerInterface $transformer
     */
    protected function createEntityCollectionResponse(
        iterable $list,
        TransformerAbstract $transformer,
        ?PaginatorInterface $paginator = null,
        int $statusCode = Response::HTTP_OK,
        array $meta = []
    ): Response {
        $collection = new Collection($list, $transformer, $transformer->getType());
        $collection->setMeta($meta);

        if ($paginator !== null) {
            $collection->setPaginator($paginator);
        }

        /** @var array $data */
        $data = $this->getFractalManager()->createData($collection)->toArray();

        return new EntityCollectionResponse($data, $statusCode);
    }

    protected function getFractalManager(): FractalManager
    {
        if ($this->container === null) {
            throw new RuntimeException();
        }

        /** @var FractalManager $fractalManager */
        $fractalManager = $this->container->get('app.fractal');

        return $fractalManager;
    }
}
