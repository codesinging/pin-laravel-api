<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Reflection;

use ReflectionClass;
use ReflectionException;

class ClassReflection
{
    protected ReflectionClass $class;

    /**
     * @param string $file
     *
     * @throws ReflectionException
     */
    public function __construct(protected string $file)
    {
        $this->class = new ReflectionClass($this->file);
    }

    /**
     * 从注释中获取标题
     *
     * @param string $comment
     *
     * @return string|null
     */
    private function parseTitle(string $comment): ?string
    {
        if (preg_match('#\*\s*@title\s+(.+)\s*\n#', $comment, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * 获取类标题
     *
     * @return string|null
     */
    public function classTitle(): ?string
    {
        $comment = $this->class->getDocComment();
        return $this->parseTitle($comment);
    }

    /**
     * 获取方法标题
     *
     * @param string $name
     *
     * @return string|null
     * @throws ReflectionException
     */
    public function methodTitle(string $name): ?string
    {
        if ($this->class->hasMethod($name)) {
            $method = $this->class->getMethod($name);
            $comment = $method->getDocComment();
            return $this->parseTitle($comment);
        }
        return null;
    }
}
