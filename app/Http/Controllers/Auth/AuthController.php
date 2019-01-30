<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use APP\Models\LoginModel;
use App\Http\Controllers\Auth\RegisterController;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * 要求附带account和password（数据来源login表）
     * 
     * @return void
     */
    public function __construct(RegisterController $registerController)
    {
        // 这里额外注意了：官方文档样例中只除外了『login』
        // 这样的结果是，token 只能在有效期以内进行刷新，过期无法刷新
        // 如果把 refresh 也放进去，token 即使过期但仍在刷新期以内也可刷新
        // 不过刷新一次作废
        // 另外关于上面的中间件，官方文档写的是『auth:api』
        // 但是我推荐用 『jwt.auth』，效果是一样的，但是有更加丰富的报错信息返回
        $this->middleware('jwt.auth', ['except' => ['login']]);
        $this->registerController = $registerController;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = ['account' => 'required', 'type' => 'required'];
        $this->validate($request, $rules);
        $credentials = $request->only('account', 'type');
        
        // // // 检查是否存在此用户
        // $user = LoginModel::first();

        dd($this->registerController->checkUserExists( $credentials['account'],  $credentials['type']));

        dd(\JWTAuth::check($credentials['account']));
        // 帐号和密码认证
        if (! $token = \JWTAuth::attempt(['account' => $credentials['account'], 'password' => $credentials['account']])) {

            return $this->fail(4001);
        }

        $userInfo = $this->userInfo();
        
        // 用户状态的确认
        if ($userInfo->status !== LoginModel::STATUS_NORMAL) {

            return $this->fail(4002);
        }

        $response = $this->success($this->userInfo());
        // 把token添加到响应头中
        $response->headers->set('Authorization', 'Bearer ' . $token);
        $response->headers->set('Access-Control-Expose-Headers', 'Authorization');

        return $response;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->success($this->userInfo());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return $this->success();
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->succcess(auth('api')->refresh());
    }


    private function userInfo()
    {
        return \Auth::user();
    }

    private function register(array $data)
    {
        return LoginModel::create([
            'user_id' => 1,
            'type' => $data['type'],
            'account' => $data['account'],
            'password' => bcrypt($data['account']),
        ]);
    }
}