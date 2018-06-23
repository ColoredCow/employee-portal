<?php

namespace Tests\Unit\HR;

use App\Models\HR\Employee;
use Tests\Unit\UnitTest;

class EmployeeTest extends UnitTest
{
    protected $employee;

    public function setUp()
    {
        parent::setUp();
        $this->employee = create(Employee::class);
    }

    /** @test */
    public function it_is_created()
    {
        $this->assertTrue(isset($this->employee->id));
    }
}
