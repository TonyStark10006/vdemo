<?php
namespace App\Lib;

use V2ray\Core\App\Stats\Command\GetStatsRequest;
use V2ray\Core\App\Stats\Command\QueryStatsRequest;

interface GRPCInterface
{
//    public function __construct(string $sn);

    public function reconnect();// : SSC ;

    public function disconnect() : void ;

    public static function setStatRequest(array $name, bool $reset) : GetStatsRequest;

    public static function getStat(GetStatsRequest $request) : array ;

    public static function setQueryStatRequest(string $pattern, bool $reset) : QueryStatsRequest;

    public static function getQueryStat(QueryStatsRequest $request) : array ;
}
