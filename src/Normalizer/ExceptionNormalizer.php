<?php

namespace App\Normalizer;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class ExceptionNormalizer implements NormalizerInterface
{
    /**
     * @param $data
     * @param string|null $format
     * @param array<mixed> $context
     *
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Throwable;
    }

    /**
     * @param $exception
     * @param string|null $format
     * @param array<mixed> $context
     *
     * @return array<mixed>
     */
    public function normalize($exception, string $format = null, array $context = []): array
    {
        return $this->getData($exception);
    }

    /**
     * @param Throwable $exception
     *
     * @return array<mixed>
     */
    private function getData(Throwable $exception): array
    {
        return [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'previous' => $exception->getPrevious() ? $this->getData($exception->getPrevious()) : null,
        ];
    }
}
