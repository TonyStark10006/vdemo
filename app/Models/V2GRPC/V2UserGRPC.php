<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Models\V2GRPC;

use App\Lib\V2RayGRPCAbstract;
use App\Lib\V2UserGRPCInterface;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use V2ray\Core\App\Proxyman\Command\AddUserOperation;
use V2ray\Core\App\Proxyman\Command\AlterInboundRequest;
use V2ray\Core\App\Proxyman\Command\HandlerServiceClient;
use V2ray\Core\App\Proxyman\Command\RemoveUserOperation;
use V2ray\Core\Common\Protocol\SecurityConfig;
use V2ray\Core\Common\Protocol\SecurityType;
use V2ray\Core\Common\Protocol\User;
use V2ray\Core\Common\Serial\TypedMessage;
use V2ray\Core\Proxy\Vmess\Account;

// use Swoft\View\Bean\Annotation\View;
// use Swoft\Http\Message\Server\Response;

/**
 * Class V2UserGRPC
 * @Controller(prefix="/V2UserGRPC")
 * @package App\Controllers
 */
class V2UserGRPC extends V2RayGRPCAbstract implements V2UserGRPCInterface
{
    /**
     * this is a example action. access uri path: /V2UserGRPC
     * @RequestMapping(route="/V2UserGRPC", method=RequestMethod::GET)
     * @return array
     */
//    public function index(): array
//    {
//        return ['item0', 'item1'];
//    }

    protected static $connection;

    protected static $instance;

    public static function init() : self
    {
        if (!self::$connection) {
            self::$connection = new HandlerServiceClient(env("V2RAY_SN"), []);
            return self::$instance = new self();
        } else {
            return self::$instance;
        }
    }

    /**
     * @param string $tag
     * @param $operation
     * @param int $type
     * @return AlterInboundRequest
     */
    public static function setAlterInboundRequest(string $tag, TypedMessage $operation): AlterInboundRequest
    {
        $request = new AlterInboundRequest();
        $request->setTag($tag);
        $request->setOperation($operation);
        return $request;
    }

    /**
     * @param int $level
     * @param string $email
     * @param string $id
     * @param string $alterID
     * @param int $securitySettings
     * @return TypedMessage
     */
    public static function setAddUserOperation(int $level, string $email, string $id, string $alterID, int $securitySettings = SecurityType::AUTO): TypedMessage
    {
        $security = new SecurityConfig();
//        $security->setType(SecurityType::AUTO);
        $security->setType($securitySettings);

        $account = new Account();
        $account->setId($id);
        $account->setAlterId($alterID);
        $account->setSecuritySettings($security);

        // type对应proto.message的name
        // 参考GO的proto.MessageName(message) MessageName returns the fully-qualified proto name for the given message type.
//        $message = new TypedMessage();
//        $message->setType("v2ray.core.proxy.vmess.Account");
//        $message->setValue($account->serializeToString());
        $message = static::setTypedMessage("v2ray.core.proxy.vmess.Account", $account->serializeToString());

        $user = new User();
        $user->setLevel($level);
        $user->setEmail($email);
        $user->setAccount($message);

        $addUserOperation = new AddUserOperation();
        $addUserOperation->setUser($user);

//        $message1 = new TypedMessage();
//        $message1->setType("v2ray.core.app.proxyman.command.AddUserOperation");
//        $message1->setValue($addUserOperation->serializeToString());
        return static::setTypedMessage("v2ray.core.app.proxyman.command.AddUserOperation", $addUserOperation->serializeToString());

    }

    public static function setTypedMessage(string $type, string $value) : TypedMessage
    {
        $message = new TypedMessage();
        $message->setType($type);
        $message->setValue($value);
        return $message;
    }



    /**
     * @param string $id
     * @param string $alterID
     * @param string $securitySettings
     * @return User
     */
//    public function setAddUserAccount(string $id, string $alterID, string $securitySettings): Account
//    {
//        $security = new SecurityConfig();
//        $security->setType(SecurityType::AUTO);
//
//        $user = new Account();
//        $user->setId($id);
//        $user->setAlterId($alterID);
//        $user->setSecuritySettings($security);
//
//        return $user;
//    }

    /**
     * @param string $email
     * @return TypedMessage
     */
    public static function setRemoveUserOperation(string $email): TypedMessage
    {
        $operation = new RemoveUserOperation();
        $operation->setEmail($email);

//        $message = new TypedMessage();
//        $message->setType("v2ray.core.app.proxyman.command.RemoveUserOperation");
//        $message->setValue($operation->serializeToString());

        return static::setTypedMessage("v2ray.core.app.proxyman.command.RemoveUserOperation", $operation->serializeToString());
//        return new TypedMessage(["v2ray.core.app.proxyman.command.RemoveUserOperation", (new RemoveUserOperation([$email]))->serializeToString()]);
    }

    /**
     * @param AlterInboundRequest $alterInboundRequest
     * @return array
     */
    public static function getAlterInboundResponse(AlterInboundRequest $alterInboundRequest): array
    {
        self::start();
        $reply = self::$connection->AlterInbound($alterInboundRequest)[2];
        return [
            'status' => $reply->statusCode,
            "gRPCStatus" => $reply->headers["grpc-status"],
            'gRPCMessage' => $reply->headers["grpc-message"]//round(($reply->getStat()->getValue()) / 1048576 ,3)// . "MiB"
        ];
    }


}
