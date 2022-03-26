<?php

namespace Tests\Feature\Support\Reflection;

use App\Support\Reflection\ClassReflection;
use ReflectionException;
use Tests\TestCase;

/**
 * @title 类反射测试
 */
class ClassReflectionTest extends TestCase
{
    protected string $file = self::class;

    protected ClassReflection $reflection;

    /**
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        $this->reflection = new ClassReflection($this->file);
    }

    public function test_class_title()
    {
        self::assertEquals('类反射测试', $this->reflection->classTitle());
    }

    /**
     * @title 测试获取方法标题
     * @return void
     * @throws ReflectionException
     */
    public function test_method_title()
    {
        self::assertNull($this->reflection->methodTitle('test_class_title'));
        self::assertEquals('测试获取方法标题', $this->reflection->methodTitle('test_method_title'));
    }
}
