<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Config;
use App\Entity\TransportType;
use App\Entity\User;
use App\Logger\Logger;
use App\Repository\UserCodesRepository;
use App\Repository\UserConfigRepository;
use App\Service\CodeGeneratorService\CodeGenerator;
use App\Service\ConfirmationService\ConfirmationByCode;
use App\Service\UserSettingService\ChangeService;
use App\UseCase\UserSetting\ChangeUserConfigByCode;
use App\UseCase\UserSetting\TransportFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RequestAndConfirmCodeTest extends TestCase
{
    private const CODE          = '1234';
    private const TELEGRAM_NICK = '@hellyboys2028';
    private const EMAIL_NICK    = 'ivanov@petrov.com';

    public function test_should_make_request_by_telegram_and_check_confirm()
    {
        $this->requestAndConfirmByTransport(TransportType::Telegram);

        [$requestLogInfo, $confirmLogInfo] = $this->getRequestAndConfirmInfoMessages();

        $this->assertEquals('Telegram for ' . self::TELEGRAM_NICK . '. Code : ' . self::CODE, $requestLogInfo);
        $this->assertEquals('Confirm Successfully Telegram', $confirmLogInfo);
    }

    public function test_should_make_request_by_email_and_check_confirm()
    {
        $this->requestAndConfirmByTransport(TransportType::Email);

        [$requestLogInfo, $confirmLogInfo] = $this->getRequestAndConfirmInfoMessages();

        $this->assertEquals('Email for ' . self::EMAIL_NICK . '. Code : ' . self::CODE, $requestLogInfo);
        $this->assertEquals('Confirm Successfully Email', $confirmLogInfo);
    }

    private function requestAndConfirmByTransport(TransportType $transportType): void
    {
        $userCodesRepository = $this->createMock(UserCodesRepository::class);
        $userConfigRepository = $this->createMock(UserConfigRepository::class);
        $user = $this->createMock(User::class);
        $config = $this->createMock(Config::class);
        $codeGenerator = $this->createMock(CodeGenerator::class);

        $this->initMockReturns(
            $userCodesRepository,
            $userConfigRepository,
            $user,
            $config,
            $codeGenerator,
            $transportType
        );

        $transport = (new TransportFactory())->run($transportType);
        $changeService = new ChangeService($userConfigRepository);
        $confirmation = new ConfirmationByCode($transport, $changeService, $userCodesRepository, $codeGenerator);
        $service = new ChangeUserConfigByCode($confirmation);

        $service->request($user, $config);
        $service->confirm($user, $config, self::CODE);
    }

    private function initMockReturns(
        MockObject $userCodesRepository,
        MockObject $userConfigRepository,
        MockObject $user,
        MockObject $config,
        MockObject $codeGenerator,
        TransportType $transportType
    ): void {
        $user->expects(self::any())
            ->method('getId')
            ->willReturn(1);

        $user->expects(self::any())
            ->method('getEmail')
            ->willReturn(self::EMAIL_NICK);

        $user->expects(self::any())
            ->method('getPhone')
            ->willReturn('+7955878798');

        $user->expects(self::any())
            ->method('getTelegram')
            ->willReturn(self::TELEGRAM_NICK);

        $config->expects(self::any())
            ->method('getId')
            ->willReturn(10);

        $config->expects(self::any())
            ->method('getValue')
            ->willReturn('Согласие на обработку персональных данных');

        $userCodesRepository
            ->expects(self::any())
            ->method('getCodeByUserIdByConfigId')
            ->willReturn(self::CODE);

        $userConfigRepository
            ->expects(self::any())
            ->method('setConfig')
            ->willReturnCallback(function () use ($transportType) {
                Logger::info("Confirm Successfully " . $transportType->name);
            });

        $codeGenerator
            ->expects(self::any())
            ->method('generate')
            ->willReturn(self::CODE);
    }

    private function getRequestAndConfirmInfoMessages(): array
    {
        $lastLogs = Logger::getLastMessages(2);

        return [trim($lastLogs[1]), trim($lastLogs[0]),];
    }
}