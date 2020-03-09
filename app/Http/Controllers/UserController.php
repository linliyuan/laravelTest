<?php


namespace App\Http\Controllers;


use App\model\User;
use App\Utils\ErrorCode;
use function foo\func;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index(){
        $use = User::query()->findOrFail(['id' => 900003]);
        $use->fill(['name' => "xixi"]);
        $use->save();
        return $this->responseSuccess();
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'sex' => 'required'
        ]);

        $user = User::query()->where(['name' => $request->get('name')])->get();
        $user = json_decode(json_encode($user),1);
        var_dump($user);
        if(!empty($user[0])){
            return $this->responseFail(ErrorCode::$invalidRequest,"用户名已存在");
        }

        (new User($request->all()))->save();
    }

    public function destory(Request $request){
//        User::destroy($request->get('id'));
        User::deleted(function (){
            return $this->responseSuccess();
        });
        $user = User::query()->where('id',$request->get('id'));
//        $user = json_decode(json_encode($user),1);
        var_dump($user);
    }
}