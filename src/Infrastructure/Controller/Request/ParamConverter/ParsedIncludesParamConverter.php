<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Request\ParamConverter;

use App\Infrastructure\Controller\Request\ParsedIncludes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

final class ParsedIncludesParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        /** @var string|mixed $value */
        $value = $request->query->get('include', '');

        if (!\is_string($value)) {
            throw new BadRequestException('Incorrect includes, must be string');
        }

        $includes = explode(',', $value);
        $includes = array_map('trim', $includes);
        $includes = array_values(array_filter($includes));

        $request->attributes->set(
            $configuration->getName(),
            new ParsedIncludes($includes)
        );

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === ParsedIncludes::class;
    }
}
