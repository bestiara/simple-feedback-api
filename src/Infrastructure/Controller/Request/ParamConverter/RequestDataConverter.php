<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Request\ParamConverter;

use App\Infrastructure\Controller\Request\RequestDataInterface;
use App\Infrastructure\Http\Exception\RequestValidationFailedException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

final class RequestDataConverter implements ParamConverterInterface
{
    public function __construct(
        private readonly Serializer $serializer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function supports(ParamConverter $configuration): bool
    {
        /** @psalm-suppress PossiblyNullArgument */
        return is_subclass_of($configuration->getClass(), RequestDataInterface::class);
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $dataClass = $configuration->getClass();

        /** @psalm-suppress PossiblyNullArgument */
        if (!is_subclass_of($dataClass, RequestDataInterface::class)) {
            throw new InvalidArgumentException();
        }

        $rawData = array_merge(
            $request->query->all(),
            $request->request->all()
        );

        /** @var ClassMetadata $metadata */
        $metadata = $this->validator->getMetadataFor(new $dataClass());
        $constraints = [];

        foreach ($metadata->getConstrainedProperties() as $propertyName) {
            $propertyMetadatas = $metadata->getPropertyMetadata($propertyName);

            foreach ($propertyMetadatas as $propertyMetadata) {
                $constraints[$propertyName] = array_merge(
                    $constraints[$propertyName] ?? [],
                    $propertyMetadata->getConstraints()
                );
            }
        }

        if ($constraints !== []) {
            $violations = $this->validator->validate(
                $rawData,
                new Collection([
                    'allowExtraFields' => true,
                    'fields' => $constraints,
                ])
            );

            if ($violations->count() > 0) {
                throw new RequestValidationFailedException($violations);
            }
        }

        try {
            $data = $this->serializer->denormalize($rawData, $dataClass, null, [
                AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
            ]);
        } catch (Throwable $exception) {
            throw new BadRequestHttpException(
                $exception->getMessage(),
                $exception
            );
        }

        $request->attributes->set(
            $configuration->getName(),
            $data
        );

        return true;
    }
}
