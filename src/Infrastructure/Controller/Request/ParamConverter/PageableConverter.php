<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Request\ParamConverter;

use App\Infrastructure\Controller\Request\Pageable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class PageableConverter implements ParamConverterInterface
{
    private const PARAM_PER_PAGE = 'per-page';
    private const PARAM_PAGE = 'page';
    private const DEFAULT_PER_PAGE = 20;
    private const MAX_PER_PAGE = 100;
    private const MIN_PAGE = 1;

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $params = $request->query;

        $page = max(
            $params->getInt(self::PARAM_PAGE, self::MIN_PAGE),
            self::MIN_PAGE
        );

        $perPage = min(
            $params->getInt(self::PARAM_PER_PAGE, self::DEFAULT_PER_PAGE),
            self::MAX_PER_PAGE
        );

        $request->attributes->set(
            $configuration->getName(),
            new Pageable($perPage, $page, $request->getUri())
        );

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Pageable::class;
    }
}
