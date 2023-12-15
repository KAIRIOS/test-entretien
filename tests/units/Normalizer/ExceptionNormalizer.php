<?php

namespace App\Normalizer\tests\units;

use atoum\atoum;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExceptionNormalizer extends atoum\test
{
    public function testNormalize()
    {
        $this
            ->assert('Test de normalisation OK')
            ->given(
                $previous = $this->getException(),
                $exception = $this->getException($previous)
            )
            ->if(
                $exceptionNormalizer = $this->getTestedInstance()
            )
            ->then
                ->array($exceptionNormalizer->normalize($exception))
                    ->isEqualTo([
                        'code' => 400,
                        'message' => 'message',
                        'previous' => [
                            'code' => 400,
                            'message' => 'message',
                            'previous' => null,
                        ],
                    ])
        ;
    }

    public function testSupportsNormalization()
    {
        $this->assert('Mauvais objet de normalisation')
            ->given($objet = 'object')
            ->if(
                $depotNormalizer = $this->getTestedInstance()
            )
            ->then
            ->boolean($depotNormalizer->supportsNormalization($objet))
            ->isFalse();
    }


    private function getException($previous = null)
    {
        return new BadRequestHttpException('message', $previous, 400);
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance();
    }
}
