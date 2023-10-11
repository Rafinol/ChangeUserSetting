<?php

declare(strict_types=1);

namespace App\Services\ConfirmationService;

use App\Entity\Config;
use App\Entity\User;
use App\Exception\InvalidConfirmationException;
use App\Exception\NotFoundTransportException;
use App\Repository\UserCodesRepository;
use App\Services\CodeGeneratorService\CodeGenerator;
use App\Services\CodeGeneratorService\CodeGeneratorService;
use App\Services\TransportService\GetRecipientAddressByTransportType;
use App\Services\TransportService\Transport;
use App\Services\UserSettingService\Change;

readonly class ConfirmationByCode implements Confirmation
{
    public function __construct(
        private Transport $transport,
        private Change $changeService,
        private UserCodesRepository $userCodesRepository,
        private CodeGenerator $codeGenerator
    ) {
    }

    /**
     * @throws NotFoundTransportException
     */
    public function request(User $user, Config $config): void
    {
        $code = $this->codeGenerator->generate();
        $message = $this->getMessage($code);
        $address = (new GetRecipientAddressByTransportType())->getAddress($this->transport, $user);
        $this->transport->send($address, $message);
        $this->userCodesRepository->setCodeForUserIdAndConfigId($user->getId(), $config->getId());
    }

    /**
     * @throws InvalidConfirmationException
     */
    public function confirm(User $user, Config $config, array $extraData): void
    {
        $currentCode = $this->userCodesRepository->getCodeByUserIdByConfigId($user->getId(), $config->getId());
        if (isset($extraData['code']) && $extraData['code'] === $currentCode) {
            $this->changeService->apply($config->getId(), $config->getValue());
            return;
        }

        throw new InvalidConfirmationException('Не найден код');
    }

    private function getMessage(string $code): string
    {
        return 'Ваш код подтверждения : ' . $code;
    }
}
