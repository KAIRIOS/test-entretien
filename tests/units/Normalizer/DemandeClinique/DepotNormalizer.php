<?php

namespace App\Normalizer\DemandeClinique\tests\units;

use atoum\atoum;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use mock\App\Entity\DemandeClinique\Depot;
use mock\App\Entity\DemandeClinique\Reponse;
use mock\App\Normalizer\DemandeClinique\ReponseNormalizer;

class DepotNormalizer extends atoum\test
{
    private ReponseNormalizer $reponseNormalizer;

    public function beforeTestMethod(): void
    {
        $this->reponseNormalizer = new ReponseNormalizer();
        $this->calling($this->reponseNormalizer)->normalize = [
            'reponse' => 1,
        ];
    }

    public function testNormalize(): void
    {
        $this
            ->assert('Test de normalisation OK')
            ->given(
                $reponse = $this->getReponse(),
                $depot = $this->getDepot([$reponse])
            )
            ->if(
                $depotNormalizer = $this->getTestedInstance()
            )
            ->then
                ->array($depotNormalizer->normalize($depot))
                    ->isEqualTo([
                        'id' => 1,
                        'date_creation' => '2019-01-01 00:00:00',
                        'titre' => 'titre',
                        'description' => 'description',
                        'reponses' => [
                            [
                                'reponse' => 1,
                            ],
                        ],
                    ])
                ->mock($this->reponseNormalizer)
                    ->call('normalize')
                        ->withArguments($reponse)
                        ->once()
        ;
    }

    public function testSupportsNormalization(): void
    {
        $this->assert('Mauvais objet de normalisation')
            ->given($objet = $this->getReponse())
            ->if(
                $depotNormalizer = $this->getTestedInstance()
            )
            ->then
            ->boolean($depotNormalizer->supportsNormalization($objet))
            ->isFalse();
    }

    private function getDepot($reponses = []): Depot
    {
        $depot = new Depot();
        $this->calling($depot)->getReponses = new ArrayCollection($reponses);
        $this->calling($depot)->getId = 1;
        $this->calling($depot)->getDateCreation = new DateTime('2019-01-01 00:00:00');
        $this->calling($depot)->getTitre = 'titre';
        $this->calling($depot)->getDescription = 'description';


        return $depot;
    }

    private function getReponse(): Reponse
    {
        return new Reponse();
    }

    private function getTestedInstance()
    {
        return $this->newTestedInstance($this->reponseNormalizer);
    }
}
