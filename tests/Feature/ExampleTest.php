<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_root_redirects_to_home(): void
    {
        $this->get('/')->assertRedirect('/home');
        $this->get('/home')->assertOk();
    }
}
