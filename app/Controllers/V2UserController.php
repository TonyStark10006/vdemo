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

use App\Lib\V2UserInterface;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
// use Swoft\View\Bean\Annotation\View;
// use Swoft\Http\Message\Server\Response;

/**
 * Class V2UserController
 * @Controller(prefix="/v2ray")
 * @package App\Controllers
 */
class V2UserController implements V2UserInterface
{
    public static $pool;

    /**
     * this is a example action. access uri path: /V2ray
     * @RequestMapping(route="/v2ray", method=RequestMethod::GET)
     * @return array
     */
    public function index(): array
    {
        return ['item0', 'item1'];
    }

    public function getUser(string $id): array
    {
        // TODO: Implement getUser() method.
    }

    public function setUser(array $user): array
    {
        // TODO: Implement setUser() method.
    }

    public function getUsers(): array
    {
        // TODO: Implement getUsers() method.
    }

    public function setUsers(array $users): array
    {
        // TODO: Implement setUsers() method.
    }
}
