<?php

namespace Apsonex\Countries\Tests;

use Apsonex\Countries\Models\Coordinate;
use Apsonex\Countries\Models\Country;
use Apsonex\Countries\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class CoordinatesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('seed:countries canada');
    }

    /** @test */
    public function it_can_fetch_stored_address_from_database()
    {
        //Seed
        $this->seedDummyAddress();

        $this->assertTrue(Coordinate::query()->count() <= 0);

        //Coordinate::findForAddress(static::dummyAddress());
    }

    protected function seedDummyAddress()
    {
        $CA = Country::where('iso_3166_2', strtoupper('ca'))->firstOrFail();

        $province = Province::where([
            'abbreviation' => strtoupper('on'),
            'country_id'   => $CA->id
        ])->firstOrFail();

        Coordinate::create([
            'slug'              => Coordinate::makeSlug($this->dummyAddress()),
            'formatted_address' => 'formatted_address',
            'place_id'          => 'place_id',
            'latitude'          => 12.12345,
            'longitude'         => 12.12345,
            'location'          => null,
            'province_id'       => $province->id,
            'country_id'        => $CA->id,
        ]);
    }

    protected function dummyAddress(): array
    {
        return [
            'street_number'       => '500',
            'street_name'         => 'Ray Lawson',
            'street_abbreviation' => 'Blvd',
            'street_direction'    => null,
            'city'                => 'Brampton',
            'zip'                 => 'L6Y 5B3',
            'province'            => 'Ontario',
            'country'             => 'Canada',
        ];
    }
}