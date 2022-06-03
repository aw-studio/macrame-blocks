<?php

namespace Tests\Integration\Foundation;

use Tests\Integration\IntegrationTestCase;

class MakeCmsCommandTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testItPublishesRoutes()
    {
        $this->artisan();
    }
}
