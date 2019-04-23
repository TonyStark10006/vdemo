<?php
namespace App\Lib;

/**
 * Interface V2RayStatInterface
 * @package App\Lib
 */
interface V2StatInterface
{
    /**
     * @param string $name
     * @return array
     */
    public function getUserDownlinkStat(string $name) : array ;

    /**
     * @param string $name
     * @return array
     */
    public function getUserUplinkStat(string $name) : array ;

    /**
     * @param string $name
     * @return array
     */
    public function getUserLinkStat(string $name) : array ;

    /**
     * @param $proxy
     * @return array
     */
    public function getUsersDownlinkStat(string $proxy) : array ;

    /**
     * @param $proxy
     * @return array
     */
    public function getUsersUplinkStat(string $proxy) : array ;

    /**
     * @param $proxy
     * @return array
     */
    public function getUsersLinkStat(string $proxy) : array ;
}
