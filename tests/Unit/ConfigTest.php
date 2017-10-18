<?php

namespace Tests\Feature;

use App\Services\Config;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_有預設屬性()
    {
        $inputStub = [
            'ext'              => '',
            'location'         => '',
            'subDirectory'     => '',
            'unit'             => '',
            'remove'           => '',
            'handler'          => '',
            'destination'      => '',
            'dir'              => '',
            'connectionString' => '',
        ];

        $config = new Config($inputStub);

        $this->assertObjectHasAttribute('connectionString', $config);
        $this->assertObjectHasAttribute('destination', $config);
        $this->assertObjectHasAttribute('dir', $config);
        $this->assertObjectHasAttribute('ext', $config);
        $this->assertObjectHasAttribute('handler', $config);
        $this->assertObjectHasAttribute('location', $config);
        $this->assertObjectHasAttribute('remove', $config);
        $this->assertObjectHasAttribute('subDirectory', $config);
        $this->assertObjectHasAttribute('unit', $config);
    }
}
