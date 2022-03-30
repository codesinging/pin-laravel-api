<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Routing;

use App\Exceptions\ErrorCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ApiResponses
{
    /**
     * 返回正确的 json 响应
     *
     * @param array|string|Collection|Model|null $message
     * @param Model|array|Collection|null $data
     *
     * @return JsonResponse
     */
    public function success(Model|array|string|Collection $message = null, Model|array|Collection $data = null): JsonResponse
    {
        $code = ErrorCode::OK;
        is_string($message) or list($data, $message) = [$message, $data];
        return response()->json(compact('code', 'message', 'data'));
    }

    /**
     * 返回错误的 json 响应
     *
     * @param string|null $message
     * @param int $code
     * @param mixed|null $data
     *
     * @return JsonResponse
     */
    public function error(string $message = null, int $code = ErrorCode::ERROR, mixed $data = null): JsonResponse
    {
        return response()->json(compact('message', 'code', 'data'));
    }
}
