<?php
namespace Poirot\Wallet\Interfaces;

use Poirot\Wallet\Repo\Mongo\WalletEntity;


interface iWalletManager
{
    /**
     * InCome For Wallet Owner
     *
     * @param mixed     $ownerID      Affected wallet owner
     * @param int|float $amount
     * @param string    $typeOfWallet Type of wallet
     * @param string    $target       Who or What is the reason of this charge
     * @param string    $meta         if you buy charge  get factor
     *
     * @return $this
     */
    function income($ownerID, $amount, $typeOfWallet, $target, $meta = null);

    /**
     * OutGo For Wallet Owner
     * @param mixed     $ownerID      Affected wallet owner
     * @param int|float $amount
     * @param string    $typeOfWallet Type of wallet
     * @param string    $target       Who or What is the reason of this charge
     * @param string    $meta        what of meta data of amount of transactions
     *
     * @return $this
     */
    function outgo($ownerID, $amount, $typeOfWallet, $target, $meta = null);

    /**
     * Get Total Cost Of Wallet Owner
     *
     * @param mixed $ownerID
     * @param string $typeOfWallet Type of wallet
     *
     * @return float|int Can be negative number
     */
    function getTotal($ownerID, $typeOfWallet);

    /**
     * Get Last Transaction Entry
     *
     * @param $ownerID
     * @param string $typeOfWallet
     *
     * @return WalletEntity
     */
    function getLastEntry($ownerID, $typeOfWallet = "default");
}
