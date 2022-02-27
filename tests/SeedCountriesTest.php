<?php

namespace Apsonex\Countries\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class SeedCountriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_seed_country()
    {
        $this->assertDatabaseCount('countries', 0);
        $this->assertDatabaseCount('provinces', 0);

        Artisan::call('seed:countries canada');

        $this->assertDatabaseCount('countries', 1);
        $this->assertDatabaseCount('provinces', 13);
    }

}