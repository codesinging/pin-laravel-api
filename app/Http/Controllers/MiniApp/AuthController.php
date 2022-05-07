<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers\MiniApp;

use App\Models\WechatUser;
use App\Support\Wechat\MiniApp;
use EasyWeChat\Kernel\Exceptions\BadResponseException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class AuthController extends Controller
{
    /**
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws BadResponseException
     */
    public function login(Request $request): JsonResponse
    {
        $code = $request->input('code');
        $userInfo = $request->input('userInfo');

        $response = MiniApp::client()->get('sns/jscode2session', [
            'appid' => MiniApp::config('app_id'),
            'secret' => MiniApp::config('secret'),
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ]);

        if ($response->isSuccessful()) {
            $openid = $response['openid'];
            $sessionKey = $response['session_key'];

            $user = WechatUser::new()->firstOrCreate(['openid' => $openid], [
                'name' => $userInfo['nickName'],
                'avatar' => $userInfo['avatarUrl'],
            ]);

            $token = $user->createToken('mini')->plainTextToken;

            return $this->success('登录成功', compact('code', 'openid', 'user', 'token', 'sessionKey'));
        }

        return $this->error('登录凭证校验失败', -1, $response->toArray());
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->success('获取登录用户成功', $user);
    }
}
