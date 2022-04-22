<?php

namespace Tests\Feature\Support\Model;

use App\Models\Admin;
use Database\Seeders\AdminSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QueryListerTest extends TestCase
{
    use RefreshDatabase;

    public function testListerWithPage()
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

    public function testListerWithoutPage()
    {
        $this->seed(AdminSeeder::class);

        $count = Admin::new()->count();

        $lister = Admin::new()->lister();

        self::assertIsArray($lister);
        self::assertCount($count, $lister);
    }

    public function testListerWithClosure()
    {
        $this->seed(AdminSeeder::class);

        $lister = Admin::new()->lister(function (Builder $builder){
            $builder->where('super', true);
        });

        foreach ($lister as $admin) {
            self::assertTrue($admin['super']);
        }
    }

    public function testListerWithWhereStatus()
    {
        $this->seed(AdminSeeder::class);

        $admin = Admin::new()->inRandomOrder()->first();

        $admin->update(['status' => false]);

        $count = Admin::new()->where('status', true)->count();

        request()->merge(['status' => true]);

        $lister = Admin::new()->lister();

        self::assertCount($count, $lister);
    }
}
