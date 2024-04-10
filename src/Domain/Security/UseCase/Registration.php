<?php

namespace App\Domain\Security\UseCase;

use App\Domain\Security\Event\RegistrationEvent;
use App\Domain\Security\Exception\EmailAlreadyExistException;
use App\Domain\Security\Gateway\UserGatewayInterface;
use App\Domain\Security\Request\RegistrationRequest;
use App\Domain\Security\Response\RegistrationResponse;
use App\Domain\Shared\Event\EventDispatcherInterface;
use Assert\Assertion;
use Assert\AssertionFailedException;

readonly class Registration
{
    public function __construct(private UserGatewayInterface $userGateway, private EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * @throws AssertionFailedException
     * @throws EmailAlreadyExistException
     */
    public function execute(RegistrationRequest $request): RegistrationResponse
    {
        $this->validate($request);

        $user = $this->userGateway->register(['email' => $request->getEmail(), 'password' => $request->getPassword()]);
        $this->eventDispatcher->dispatch(new RegistrationEvent($user), RegistrationEvent::USER_REGISTRATION);

        return new RegistrationResponse($user);
    }

    /**
     * @throws AssertionFailedException
     * @throws EmailAlreadyExistException
     */
    public function validate(RegistrationRequest $request): void
    {
        Assertion::notBlank($request->getEmail());
        Assertion::email($request->getEmail());
        Assertion::notBlank($request->getPassword());
        Assertion::notBlank($request->getConfirmPassword());
        Assertion::minLength($request->getPassword(), 6);
        Assertion::same($request->getPassword(), $request->getConfirmPassword());

        if ($this->userGateway->findByEmail($request->getEmail())) {
            throw new EmailAlreadyExistException('This email is already exist');
        }
    }
}
