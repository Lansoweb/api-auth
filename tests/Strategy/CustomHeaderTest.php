<?php

declare(strict_types=1);

namespace Los\ApiAuth\Test\Strategy;

use Laminas\Diactoros\ServerRequest;
use Los\ApiAuth\AuthData;
use Los\ApiAuth\Strategy\CustomHeader;
use PHPUnit\Framework\TestCase;

use function assert;

/** @covers \Los\ApiAuth\Strategy\CustomHeader */
class CustomHeaderTest extends TestCase
{
    public function testMissingHeader(): void
    {
        $strategy = new CustomHeader('X-Custom-Key');
        $request  = new ServerRequest();
        $this->expectExceptionCode(401);
        ($strategy)($request);
    }

    public function testMissingHeaderHotRequired(): void
    {
        $strategy = new CustomHeader('X-Custom-Key', false);
        $request  = new ServerRequest();
        $this->assertNull(($strategy)($request));
    }

    public function testEmptyHeader(): void
    {
        $strategy = new CustomHeader('X-Custom-Key');
        $request  = (new ServerRequest())->withHeader('X-Custom-Key', '');
        $this->expectExceptionMessage('Empty X-Custom-Key header');
        ($strategy)($request);
    }

    public function testValidHeader(): void
    {
        $strategy = new CustomHeader('X-Custom-Key');
        $request  = (new ServerRequest())->withHeader('X-Custom-Key', '123');
        $authData = ($strategy)($request);
        assert($authData instanceof AuthData);
        $this->assertEquals('123', $authData->identity());
    }
}
