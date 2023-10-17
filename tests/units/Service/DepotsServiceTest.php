<?php

namespace App\Tests\units\Service;

use App\Api\v1\DTO\Request\ReponsesValidationRequestDTO;
use App\Api\v1\DTO\Request\ReponseValidationRequestDTO;
use App\Api\v1\DTO\Response\ReponseValidationResponseDTO;
use App\Api\v1\Exceptions\ReponseNotFountException;
use App\Api\v1\Services\DepotsService;
use App\Entity\DemandeClinique\Reponse;
use App\Repository\DemandeClinique\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class DepotsServiceTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private DepotsService $depotsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->depotsService = new DepotsService(
            $this->entityManager
        );
    }

    /**
     * @throws ReponseNotFountException
     */
    public function testItCanValidateAReponse()
    {
        $reponsesValidationRequestDTO = new ReponsesValidationRequestDTO();
        $reponsesValidationRequestDTO->validationReason = 'reason';
        $reponsesValidationRequestDTO->reponsesIds =  [10];

        $repository = $this->createMock(ReponseRepository::class);

        $this->entityManager
            ->expects(self::once())
            ->method('getRepository')
            ->with(Reponse::class)
            ->willReturn($repository)
        ;

        $repository
            ->expects(self::once())
            ->method('findBy')
            ->with(['id' => $reponsesValidationRequestDTO->reponsesIds])
            ->willReturn([new Reponse()])
        ;

        $this->entityManager->expects(self::once())->method('flush');

        $expectedResult = current($this->depotsService->validateReponses($reponsesValidationRequestDTO));

        $this->assertInstanceOf(ReponseValidationResponseDTO::class, $expectedResult);
        $this->assertNotNull($expectedResult->validatedAt);
        $this->assertEquals('reason', $expectedResult->validationReason);
    }

    /**
     * @throws ReponseNotFountException
     */
    public function testItCanNotValidateANotFoundReponse()
    {
        $reponsesValidationRequestDTO = new ReponsesValidationRequestDTO();
        $reponsesValidationRequestDTO->validationReason = 'test reason';
        $reponsesValidationRequestDTO->reponsesIds =  [999];

        $repository = $this->createMock(ReponseRepository::class);

        $this->entityManager
            ->expects(self::once())
            ->method('getRepository')
            ->with(Reponse::class)
            ->willReturn($repository)
        ;
        $repository
            ->expects(self::once())
            ->method('findBy')
            ->with(['id' => $reponsesValidationRequestDTO->reponsesIds])
            ->willReturn([])
        ;
        $this->entityManager->expects(self::never())->method('flush');

        $this->expectException(ReponseNotFountException::class);

        $this->depotsService->validateReponses($reponsesValidationRequestDTO);
    }

}