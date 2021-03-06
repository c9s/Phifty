<?php

namespace Phifty\ServiceProvider;

use Phifty\Kernel;
use Phifty\Testing\TestCase;

class CurrentUserProviderServiceTest extends TestCase
{
    public function testCurrentUserService()
    {
        $kernel = Kernel::minimal($this->configLoader);

        $config = [
            'Class' => \Phifty\Security\CurrentUser::class,
            'Model' => \UserBundle\Model\User::class,
        ];

        $config = CurrentUserServiceProvider::canonicalizeConfig($kernel, $config);

        $service = new CurrentUserServiceProvider;
        $service->register($kernel, $config);

        $this->assertNotNull($service);
        $this->assertNotNull($kernel->currentUser);
    }
}
