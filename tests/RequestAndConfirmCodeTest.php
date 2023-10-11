<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Config;
use App\Entity\TransportType;
use App\Entity\User;
use App\Logger\Logger;
use App\Repository\UserCodesRepository;
use App\Repository\UserConfigRepository;
use App\Services\CodeGeneratorService\CodeGenerator;
use App\Services\ConfirmationService\ConfirmationByCode;
use App\Services\UserSettingService\ChangeService;
use App\UseCase\UserSetting\ChangeUserConfigByCode;
use App\UseCase\UserSetting\ConfirmDto;
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
        $this->getConfirmationByTransportType(TransportType::Telegram);
        $lastLogs = Logger::getLastMessages(2);
        $this->assertEquals(
            'Notification by Telegram. Message to ' . self::TELEGRAM_NICK . '. Context: Ваш код подтверждения : ' . self::CODE,
            trim($lastLogs[1])
        );
        $this->assertEquals(
            'Confirm Successfully Telegram',
            trim($lastLogs[0])
        );
    }

    public function test_should_make_request_by_email_and_check_confirm()
    {
        $this->getConfirmationByTransportType(TransportType::Email);
        $lastLogs = Logger::getLastMessages(2);

        $this->assertEquals(
            'Notification by Email. Message to ' . self::EMAIL_NICK . '. Context: Ваш код подтверждения : ' . self::CODE,
            trim($lastLogs[1])
        );
        $this->assertEquals(
            'Confirm Successfully Email',
            trim($lastLogs[0])
        );
    }

    private function getConfirmationByTransportType(TransportType $transportType): void
    {
        $userCodesRepository = $this->createMock(UserCodesRepository::class);
        $userConfigRepository = $this->createMock(UserConfigRepository::class);

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

        $codeGenerator = $this->createMock(CodeGenerator::class);

        $codeGenerator
            ->expects(self::any())
            ->method('generate')
            ->willReturn(self::CODE);


        $transport = (new TransportFactory())->run($transportType);
        $changeService = new ChangeService($userConfigRepository);

        $confirmation = new ConfirmationByCode($transport, $changeService, $userCodesRepository, $codeGenerator);

        $service = new ChangeUserConfigByCode($confirmation);

        $user = $this->createMock(User::class);
        $config = $this->createMock(Config::class);
        $this->mockEntities($user, $config);

        $service->request($user, $config);
        $service->confirm($user, $config, (new ConfirmDto())->setCode(self::CODE));
    }

    private function mockEntities(MockObject $user, MockObject $config): void
    {
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
    }
}