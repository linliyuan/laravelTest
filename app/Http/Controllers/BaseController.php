<?php


namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * @param array $data
     * 发送执行成功信息
     * result: 1=>成功  0=>失败
     */
    public function responseSuccess($data = ['result' => 1]){
        $res = [
            'errCode' => 0,
            'errMsg' => 'ok',
            'data' => $data
        ];
        $this->responseJson($res);
    }

    /**
     * @param null $errCode
     * @param string $errMsg
     * 发送执行失败信息
     */
    public function responseFail($errCode = null , $errMsg = "an error occurred."){
        $res = [
            'errCode' => $errCode,
            'errMsg' => $errMsg,
        ];
        $this->responseJson($res);
    }

    private function responseJson($data){
        $resp = new JsonResponse();
        $resp->header("Content-Type","application/json");
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $resp->setContent($data);
        $resp->send();
        exit();
    }
}