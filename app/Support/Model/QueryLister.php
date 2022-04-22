<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait QueryLister
{
    /**
     * 获取模型列表数据
     *
     * @param Closure|Builder|null $builder
     *
     * @return array
     */
    public function lister(Closure|Builder $builder = null): array
    {
        if ($builder instanceof Closure) {
            $query = $this->newQuery();
            $builder = call_user_func($builder, $query) ?? $query;
        }

        $builder = $builder ?? $this->newQuery();

        if ($page = intval(request('page', 0))) {
            $size = intval(request('size'));

            $pagination = $builder->paginate($size, ['*'], 'page', $page);

            if ($pagination->lastPage() < $pagination->currentPage()) {
                $pagination = $builder->paginate($size, ['*'], 'page', $pagination->lastPage());
            }

            $result = [
                'page' => $pagination->currentPage(),
                'size' => $pagination->perPage(),
                'total' => $pagination->total(),
                'data' => $pagination->items(),
                'more' => $pagination->hasMorePages(),
            ];
        } else {
            $result = $builder->get()->toArray();
        }

        return $result;
    }
}
