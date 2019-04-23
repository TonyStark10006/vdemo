<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers;

use App\Lib\V2StatInterface;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoole\Exception;

// use Swoft\View\Bean\Annotation\View;
// use Swoft\Http\Message\Server\Response;

/**
 * Class V2StatController
 * @Controller(prefix="/stat")
 * @package App\Controllers
 */
class V2StatController implements V2StatInterface
{
    /**
     * @RequestMapping(route="user/{type}/{direction}/{name}", method=RequestMethod::GET)
     * @return array
     */
    public function user(): array
    {
        return ['item0' => 0, 'item1' => 1, 'item2' => 2, 'item3' => 3];

    }

    /**
     * @RequestMapping(route="users/{name}", method=RequestMethod::GET)
     * @return
     */
    public function users(): array
    {
        return ['item0' => 0, 'item1' => 1, 'item2' => 2, 'item3' => 3];

    }

    /**
     * @RequestMapping(route="/v2user", method=RequestMethod::GET)
     *
     */

    public function v2user()// : array
    {
//        return V2StatGRPCController::getQueryStat(
//            V2StatGRPCController::init()->setQueryStatRequest('123', false));

        //添加用户
//        return V2UserGRPCController::getAlterInboundResponse(V2UserGRPCController::setAlterInboundRequest(
//            "proxy", V2UserGRPCController::init()->setAddUserOperation(1, "hahaha@123.com",
//            "a3482e88-686a-4a58-8126-99c9df64b7bf",
//            64)
//        ));//setAddUserOperation(1, "hahahaha@123.com", "a3482e88-686a-4a58-8126-99c9df64b7bf", 64);

        // 删除用户
        return V2UserGRPCController::getAlterInboundResponse(
            V2UserGRPCController::setAlterInboundRequest(
                "proxy",
                V2UserGRPCController::init()::setRemoveUserOperation("hahaha@123.com")));
    }


    /**
     * 测试接口
     * @RequestMapping(route="/v2ray/serverslist", method=RequestMethod::POST)
     *
     */
    public function test(Request $request)
    {
        return [
            "username" => $request->post("username"),
            "serversList" => [
                [
                    "address" => "v2ray.cool",
                    "port" =>  10086,
                    "id" =>  "a3482e88-686a-4a58-8126-99c9df64b7bf",
                    "alterId" =>  64,
                    "security" =>  "auto",
                    "network" =>  "tcp",
                    "remarks" =>  "asf",
                    "headerType" =>  "none",
                    "requestHost" =>  "",
                    "pathString" =>  "",
                    "streamSecurity" =>  "",
                    "configType" =>  1,
                    "configVersion" =>  1,
                    "testResult" =>  "",
                    "subid" =>  ""
                ],
                [
                    "address" => "v2ray.haha",
                    "port" =>  10087,
                    "id" =>  "a3482e88-686a-4a58-8126-99c9df64b7bf",
                    "alterId" =>  64,
                    "security" =>  "auto",
                    "network" =>  "tcp",
                    "remarks" =>  "节点",
                    "headerType" =>  "none",
                    "requestHost" =>  "",
                    "pathString" =>  "",
                    "streamSecurity" =>  "",
                    "configType" =>  1,
                    "configVersion" =>  1,
                    "testResult" =>  "",
                    "subid" =>  ""
                ],
                [
                    "address" => "v2ray.warm",
                    "port" =>  10088,
                    "id" =>  "ages2e88-a348-4a58-8126-99c9df23f4sc",
                    "alterId" =>  64,
                    "security" =>  "auto",
                    "network" =>  "tcp",
                    "remarks" =>  "random",
                    "headerType" =>  "none",
                    "requestHost" =>  "",
                    "pathString" =>  "",
                    "streamSecurity" =>  "",
                    "configType" =>  1,
                    "configVersion" =>  1,
                    "testResult" =>  "",
                    "subid" =>  ""
                ]
            ]
        ];
//        return self::getUsersLinkStat('proxy');
//        return V2StatGRPCController::getQueryStat(
//            V2StatGRPCController::init()->setQueryStatRequest('123', false));
    }

    /**
     * 测试接口
     * @RequestMapping(route="/v2ray/auth", method=RequestMethod::POST)
     *
     */
    public function test1(Request $request)
    {
        return [
            "username" => $request->post("username"),
            "expire" => round(microtime(true) * 1000 + 604800000),//strtotime("+1 week"),
            "token" => $request->post("password"),//hash("sha256", $request->post("password")),
            "code" => 200
        ];
//        return self::getUsersLinkStat('proxy');
//        return V2StatGRPCController::getQueryStat(
//            V2StatGRPCController::init()->setQueryStatRequest('123', false));
    }

    public function getUserDownlinkStat(string $name): array
    {
        return V2StatGRPCController::getStat(
            V2StatGRPCController::init()->setStatRequest([3, $name, 2], false));
    }

    public function getUserUplinkStat(string $name): array
    {
        return V2StatGRPCController::getStat(
            V2StatGRPCController::init()->setStatRequest([3, $name, 1], false));
    }

    public function getUserLinkStat(string $name): array
    {
//        $stat = (float)substr(self::getUserDownlinkStat($name)[1], strlen(self::getUserDownlinkStat($name)[1]) - 3)
//            + (float)substr(self::getUserUplinkStat($name)[1], strlen(self::getUserUplinkStat($name)[1]) - 3);
        $stats = V2StatGRPCController::getQueryStat(
            V2StatGRPCController::init()->setQueryStatRequest($name, false)
        );
        $stat = 0;
        foreach ($stats as $item) {
            $stat += $item;
        }
        return [
            "name" => substr($key = array_keys($stats)[0], 0, strlen($key) - 9),
            "value" => $stat// . "MiB"
        ];
    }

    public function getUsersDownlinkStat(string $proxy): array
    {
        return V2StatGRPCController::getStat(
            V2StatGRPCController::init()->setStatRequest([3, $proxy, 2], false));
    }

    public function getUsersUplinkStat(string $proxy): array
    {
        return V2StatGRPCController::getStat(
            V2StatGRPCController::init()->setStatRequest([3, $proxy, 2], false));
    }

    public function getUsersLinkStat(string $proxy): array
    {
        $stats = V2StatGRPCController::getQueryStat(
            V2StatGRPCController::init()->setQueryStatRequest($proxy, false)
        );
        $stat = 0;
        foreach ($stats as $item) {
            $stat += $item;
        }
        return [
            "name" => substr($key = array_keys($stats)[0], 0, strlen($key) - 9),
            "value" => $stat// . "MiB"
        ];
    }


}
