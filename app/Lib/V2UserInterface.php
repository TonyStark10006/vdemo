<?php
namespace App\Lib;

/**
 * Interface V2UserInterface
 * @package App\Lib
 */
interface V2UserInterface
{

    /**
     * @param void
     * @return array
     */
    public function getUsers() : array;

    /**
     * @param string $id
     * @return array
     */
    public function getUser(string $id) : array;

    /**
     * @param array $user
     * @return array
     */
    public function setUser(array $user) : array;

    /**
     * @param array $users
     * @return array
     */
    public function setUsers(array $users) : array;
}
