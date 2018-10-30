<?php
	namespace App\Service;
	use App\Entity\User;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Validator\ValidatorInterface;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use App\ExceptionHandler\CustomAppException;
	use Symfony\Component\Security\Core\Security;
	use App\DTO\UserDTO;

	class RegistrationManager {
		
		private $objectManager;
		private $validator;
		private $passwordEncoder;
		private $security;

		/**
		 * @param ObjectManager $objectManager
		 * @param ValidatorInterface $validator
		 * @param UserPasswordEncoderInterface $passwordEncoder
		 * @param Security $security
		 */
		public function __construct(ObjectManager $objectManager, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, Security $security) {
        	$this->objectManager = $objectManager;
        	$this->validator = $validator;
        	$this->passwordEncoder = $passwordEncoder;
        	$this->security = $security;
        }

		/**
		 * @param string $email
		 * @return bool
		 */
        public function checkEmail(string $email) {
        	$userRepository = $this->objectManager->getRepository(User::class);
			$user = $userRepository->findOneBy([
    			'email' => $email]);
			return ($user instanceof User);
        }

		/**
		 * @param Request $request
		 * @throws CustomAppException
		 */
		public function createNewUser(Request $request) {
			$newUserDTO = UserDTO::create($request);
			if($this->checkEmail($newUserDTO->email)) {
				throw new CustomAppException('email already exists');
			}

			$errors = $this->validator->validate($newUserDTO);
			if(count($errors) === 0) {
				$user = new User();
				$user->setEmail($newUserDTO->{'email'});
				$password = $this->passwordEncoder->encodePassword($user, $newUserDTO->password);
				$user->setPassword($password);
				$this->objectManager->persist($user);
        		$this->objectManager->flush();
        		return;
        	}
        	else {
        		throw new CustomAppException((string)$errors);
        	}
		}

		/**
		 * @return UserDTO
		 * @throws CustomAppException
		 */
		public function getCurrentUser() {
			$user = $this->security->getUser();
			if($user) {
				return new UserDTO($user);
			}
			else {
				throw new CustomAppException('no current user');
			}
		}
	}