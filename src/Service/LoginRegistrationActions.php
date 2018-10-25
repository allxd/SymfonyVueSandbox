<?php

	namespace App\Service;

	use App\Entity\User;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Validator\ValidatorInterface;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Config\Definition\Exception\Exception;
	use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
	use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
	use App\DTO\UserDTO;
	use App\Security\LoginFormAuthenticator;

	class LoginRegistrationActions {
		
		private $objectManager;
		private $validator;
		private $passwordEncoder;
		private $guardHandler;
		private $authenticator;
		private $authenticationUtils;

		public function __construct(ObjectManager $objectManager, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, AuthenticationUtils $authenticationUtils) {
        	$this->objectManager = $objectManager;
        	$this->validator = $validator;
        	$this->passwordEncoder = $passwordEncoder;
        	$this->guardHandler = $guardHandler;
        	$this->authenticator = $authenticator;
        	$this->authenticationUtils = $authenticationUtils;
        }

		public function createNewUser(Request $request) {
			$userDTO = new UserDTO;
			$newUserDTO = $userDTO->create($request);
			$errors = $this->validator->validate($newUserDTO);
			if(count($errors) === 0) {
				$user = new User();
				$user->setEmail($newUserDTO->{'email'});
				$password = $this->passwordEncoder->encodePassword($user, $newUserDTO->{'password'});
				$user->setPassword($password);
				$this->objectManager->persist($user);
        		$this->objectManager->flush();
        		 return $this->guardHandler->authenticateUserAndHandleSuccess(
            		$user,
            		$request,
            		$this->authenticator,
            		'main'
            	);
        	}
        	else {
        		throw new \Exception((string)$errors);
        	}
		}

		public function signIn(Request $request) {
			
		}
	}