<?php

namespace App\Service;

use Conduction\CommonGroundBundle\Service\AuthenticationService;
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
    private AuthenticationService $authenticationService;

    public function __construct(ParameterBagInterface $parameterBag, FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->parameterBag = $parameterBag;
        $this->authenticationService = new AuthenticationService($parameterBag);
    }

    public function createJWTToken(array $payload): string
    {
        $algorithmManager = new AlgorithmManager([new RS512()]);
        $pem = $this->fileService->writeFile('privatekey', base64_decode($this->parameterBag->get('private_key')));
        $jwk = JWKFactory::createFromKeyFile($pem);
        $this->fileService->removeFile($pem);

        $jwsBuilder = new JWSBuilder($algorithmManager);
        $jws = $jwsBuilder
            ->create()
            ->withPayload(json_encode($payload))
            ->addSignature($jwk, ['alg' => 'RS512'])
            ->build();

        $serializer = new CompactSerializer();

        return $serializer->serialize($jws, 0);
    }

    public function verifyJWTToken(string $token): array
    {
        return $this->authenticationService->verifyJWTToken($token, $this->parameterBag->get('public_key'));
    }
}
