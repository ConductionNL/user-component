<?php


namespace App\Service;


use App\Entity\User;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use ZxcvbnPhp\Zxcvbn;

class UserService
{
    private CommonGroundService $commonGroundService;
    private EntityManagerInterface $entityManager;
    private ParameterBagInterface $parameterBag;
    private UserPasswordHasherInterface $hasher;
    private Zxcvbn $zxcvbn;

    /**
     * UserService constructor.
     * @param UserPasswordHasherInterface $hasher
     * @param LayerService $layerService
     */
    public function __construct(UserPasswordHasherInterface $hasher, LayerService $layerService)
    {
        $this->entityManager = $layerService->getEntityManager();
        $this->parameterBag = $layerService->getParameterBag();
        $this->commonGroundService = $layerService->getCommonGroundService();
        $this->hasher = $hasher;
        $this->zxcvbn = new Zxcvbn();
    }

    /**
     * Creates an array of data that Zxcvbn uses to validate against
     *
     * @param User $user
     * @return array
     */
    public function getUserData(User $user): array
    {
        $userData = [
            $user->getUsername(),
        ];
        if($user->getPerson()){
            try{
                $person = $this->commonGroundService->getResource($user->getPerson());
                $userData[] = $person['name'];
                foreach($person['emails'] as $email){
                    $userData[] = $email['email'];
                }
            } catch (ClientException $exception){

            }
        }
        return $userData;
    }

    /**
     * Sets a new password for user
     *
     * @param User $user
     * @param string $password
     * @return User
     */
    public function setPassword(User $user, string $password): User
    {
        $score = $this->zxcvbn->passwordStrength($password, $this->getUserData($user))['score'];
        $minimumStrength = $this->parameterBag->get('password_strength');
        if($score < $minimumStrength){
            throw new BadRequestException("Password scores $score while $minimumStrength is needed.");
        }
        $user->setPassword($this->hasher->hashPassword($user, $password));
        return $user;
    }
}