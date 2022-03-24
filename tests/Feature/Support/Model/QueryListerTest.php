<?php

namespace Tests\Feature\Support\Model;

use App\Models\Admin;
use Database\Seeders\AdminSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueryListerTest extends TestCase
{
    use RefreshDatabase;

    public function test_lister_with_page()
    {
        $this->seed(AdminSeeder::class);

        request()->merge(['page' => 1]);

        $lister = Admin::new()->lister();

        self::assertIsArray($lister);

        self::assertArrayHasKey('page', $lister);
        self::assertArrayHasKey('size', $lister);
        self::assertArrayHasKey('data', $lister);
        self::assertArrayHasKey('total', $lister);
        self::assertArrayHasKey('data', $lister);
        self::assertArrayHasKey('more', $lister);

        self::assertEquals(1, $lister['page']);
    }

    public function test_lister_without_page()
    {
        $this->seed(AdminSeeder::class);
        $lister = Admin::new()->lister();

        self::assertArrayHasKey('page', $lister);
        self::assertArrayHasKey('data', $lister);
        self::assertArrayHasKey('total', $lister);

        self::assertEquals(0, $lister['page']);
    }

    public function test_lister_with_closure()
    {
        $this->seed(AdminSeeder::class);

        $lister = Admin::new()->lister(function (Builder $builder){
            $builder->where('super', true);
        });

        foreach ($lister['data'] as $admin) {
            self::assertTrue($admin['super']);
        }
    }
}
