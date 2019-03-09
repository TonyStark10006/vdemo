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
     * @return array
     */
    public function getUsersDownlinkStat() : array ;

    /**
     * @return array
     */
    public function getUsersUplinkStat() : array ;

    /**
     * @return array
     */
    public function getUsersLinkStat() : array ;
}
