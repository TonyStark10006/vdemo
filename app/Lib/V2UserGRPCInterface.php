<?php
namespace App\Lib;


use V2ray\Core\App\Proxyman\Command\AddUserOperation;
use V2ray\Core\App\Proxyman\Command\AlterInboundRequest;
use V2ray\Core\App\Proxyman\Command\RemoveUserOperation;
use V2ray\Core\Common\Protocol\SecurityConfig;
use V2ray\Core\Common\Protocol\User;
use V2ray\Core\Common\Serial\TypedMessage;
use V2ray\Core\Proxy\Vmess\Account;

interface V2UserGRPCInterface extends GRPCInterface
{
//    public function reconnect();
//
//    public function disconnect(): void;
//
//    public static function init(): HandlerServiceClient ;

    public static function setAlterInboundRequest(string $tag, TypedMessage $operation) : AlterInboundRequest ;

    public static function setAddUserOperation(int $level, string $email, string $id, string $alterID, int $securitySettings) : TypedMessage ;

//    public function setAddUserAccount(string $id, string $alterID, string $securitySettings) : User ;//Account;

    public static function setRemoveUserOperation(string $email) : TypedMessage ;

    public static function getAlterInboundResponse(AlterInboundRequest $alterInboundRequest) : array ;

}
