<?php

namespace App\Http\Controllers;

use App\model\User;
use App\Utils\ErrorCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['login']]);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = $request->get('name');
        $user->password = bcrypt($request->get('password'));
        try{
            if ($user->save()){
                return response()->json(['errCode' => 0,'message' => '注册成功']);
            }
        }catch (\Exception $e){
            if ($e->getCode() == '23000'){
                return response()->json(['errCode' => ErrorCode::$invalidRequest,'message' => '该账号已被注册']);
            }
        }

        return response()->json(['errCode' => ErrorCode::$invalidRequest,'注册失败']);
    }

    public function login(Request $request)
    {
        $credentials = request(['name', 'password']);

        $request->validate([
            'name' => 'required',
            'password' =>'required'
        ]);

        //验证邮箱及密码 如果不存在则直接返回错误信息
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['errCode' => ErrorCode::$sessionExpired,'message' => '账号密码错误']);
        }
        //验证成功则直接返回Token 这里的respondWithToken是自定义函数 用于生成Token
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['status' => 200, 'message' => 'Exit successfully']);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
        //如果要获取用户ID可以这样
        // return response()->json(auth('api')->id());
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
