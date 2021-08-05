<?php

namespace Tests\Unit\Services;

use App\Libraries\Ssh;
use App\Services\Contracts\SwitchDataService;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class SwitchDataServiceTest extends TestCase
{
    private $switchDataService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->switchDataService = App::make(SwitchDataService::class);
    }

    public function test_example()
    {
        //
    }
}
