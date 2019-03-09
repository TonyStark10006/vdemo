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
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
// use Swoft\View\Bean\Annotation\View;
// use Swoft\Http\Message\Server\Response;

/**
 * Class V2StatController
 * @Controller(prefix="/v2Stat")
 * @package App\Controllers
 */
class V2StatController implements V2StatInterface
{
    /**
     * this is a example action. access uri path: /v2Stat
     * @RequestMapping(route="/v2Stat", method=RequestMethod::GET)
     * @return array
     */
    public function index(): array
    {
        return ['item0' => 0, 'item1' => 1, 'item2' => 2, 'item3' => 3];

    }


    /**
     * 测试接口
     * @RequestMapping(route="/v2ray/test", method=RequestMethod::GET)
     *
     */
    public function test()
    {
        return self::getUserLinkStat('123');
//        return GRPCController::getQueryStat(
//            GRPCController::init()->setQueryStatRequest('123', false));
    }

    public function getUserDownlinkStat(string $name): array
    {
        return GRPCController::getStat(
            GRPCController::init()->setStatRequest([3, $name, 2], false));
    }

    public function getUserUplinkStat(string $name): array
    {
        return GRPCController::getStat(
            GRPCController::init()->setStatRequest([3, $name, 1], false));
    }

    public function getUserLinkStat(string $name): array
    {
//        $stat = (float)substr(self::getUserDownlinkStat($name)[1], strlen(self::getUserDownlinkStat($name)[1]) - 3)
//            + (float)substr(self::getUserUplinkStat($name)[1], strlen(self::getUserUplinkStat($name)[1]) - 3);
        $stats = GRPCController::getQueryStat(
            GRPCController::init()->setQueryStatRequest($name, false)
        );
        $stat = 0;
        foreach ($stats as $item) {
            $stat += $item;
        }
        return [
            "name" => substr($key = array_keys($stats)[0], 0, strlen($key) - 9),
            "value" => $stat . "MiB"
        ];
    }

    public function getUsersDownlinkStat(): array
    {
        // TODO: Implement getUsersDownlinkStat() method.
    }

    public function getUsersUplinkStat(): array
    {
        // TODO: Implement getUsersUplinkStat() method.
    }

    public function getUsersLinkStat(): array
    {
        // TODO: Implement getUsersLinkStat() method.
    }


}
