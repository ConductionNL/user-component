<?php


namespace App\Service;


use Conduction\CommonGroundBundle\Service\FileService;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\RS512;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JWTService
{
    private ParameterBagInterface $parameterBag;
    private FileService $fileService;

    public function __construct(ParameterBagInterface $parameterBag, FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->parameterBag = $parameterBag;
    }

    public function createJWTToken(array $payload): string
    {
        $algorithmManager = new AlgorithmManager([new RS512()]);
        $pem = $this->writeFile(base64_decode($this->parameterBag->get('private_key')), 'pem');
        $jwk = JWKFactory::createFromKeyFile($pem);
        $this->removeFiles([$pem]);

        $jwsBuilder = new JWSBuilder($algorithmManager);
        $jws = $jwsBuilder
            ->create()
            ->withPayload(json_encode($payload))
            ->addSignature($jwk, ['alg' => 'RS512'])
            ->build();

        $serializer = new CompactSerializer();

        return $serializer->serialize($jws, 0);
    }
}