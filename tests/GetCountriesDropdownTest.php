<?php

namespace Apsonex\Countries\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class GetCountriesDropdownTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_provide_array_for_dropdown_list()
    {
        Artisan::call('seed:countries canada');

        $list = countries()->dropdownList(true)->first();

        $this->assertSame('Canada', $list->name);

        $this->assertCount(13, $list->provinces);
    }
}