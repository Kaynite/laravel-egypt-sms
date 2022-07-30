<?php

namespace Kaynite\Tests\Feature;

use Kaynite\SMS\Facades\SMS;
use Kaynite\SMS\Providers\SMSServiceProvider;
use Orchestra\Testbench\TestCase;

class InitialTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [SMSServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('sms.default', 'log');
        $app['config']->set('sms.smsmisr', [
            'username' => 'Test',
            'passowrd' => 'Test',
            'sender'   => 'Test',
        ]);
    }

    /** @test */
    public function initial_test()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_logs()
    {
        $this->assertFalse(false);
        $res = SMS::to('222')->message('test message')->send();
    }

}
