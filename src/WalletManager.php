<?php
namespace Poirot\Wallet;

use Poirot\Wallet\Entity\EntityWallet;
use Poirot\Wallet\Interfaces\iRepoWallet;
use Poirot\Wallet\Interfaces\iWalletManager;
use Poirot\Wallet\Repo\Mongo\WalletEntity;


class WalletManager
    implements iWalletManager
{
    /** iRepoWallet */
    protected $repoWallet;


    /**
     * iWalletManager constructor.
     *
     * @param iRepoWallet $repository
     */
    function __construct(iRepoWallet $repository)
    {
        $this->repoWallet = $repository;
    }


    /**
     * InCome For Wallet Owner
     *
     * @param mixed $ownerID Affected wallet owner
     * @param int|float $amount
     * @param string $typeOfWallet Type of wallet
     * @param string $target Who or What is the reason of this charge
     *
     * @param string    $meta         if you buy charge  get factor
     * @return $this
     * @throws \Exception
     */
    function income($ownerID, $amount, $typeOfWallet = "default", $target = 'direct', $meta = null)
    {
        if ($amount < 0)
            // Negative Values No Allowed!
            throw new \Exception(
                'Negative Value Not Allowed For Income Method, Use ::outgo instead.'
            );


        $wallet = new EntityWallet;
        $wallet
            ->setOwnerId($ownerID)
            ->setWalletType($typeOfWallet)
            ->setTarget($target)
            ->setAmount($amount)
            ->setMeta($meta)
        ;

        $this->repoWallet->insert($wallet);
        return $this;
    }

    /**
     * OutGo For Wallet Owner
     *
     * @param mixed $ownerID Affected wallet owner
     * @param int|float $amount
     * @param string $typeOfWallet Type of wallet
     * @param string $target Who or What is the reason of this charge
     *
     * @param string    $meta        what of meta data of amount of transactions
     * @return $this
     */
    function outgo($ownerID, $amount, $typeOfWallet = "default", $target = 'direct', $meta = null)
    {
        if ($amount > 0)
            $amount *= -1;


        $wallet = new EntityWallet;
        $wallet
            ->setOwnerId($ownerID)
            ->setWalletType($typeOfWallet)
            ->setTarget($target)
            ->setAmount($amount)
            ->setMeta($meta)
        ;

        $this->repoWallet->insert($wallet);
        return $this;
    }

    /**
     * Get Total Cost Of Wallet Owner
     *
     * @param mixed  $ownerID
     * @param string $typeOfWallet Type of wallet
     *
     * @return float|int Can be negative number
     */
    function getTotal($ownerID, $typeOfWallet = "default")
    {
        return $this->repoWallet->getSumTotalAmount($ownerID, $typeOfWallet);
    }

    /**
     * Get Last Transaction Entry
     *
     * @param $ownerID
     * @param string $typeOfWallet
     *
     * @return WalletEntity
     */
    function getLastEntry($ownerID, $typeOfWallet = "default")
    {
        $r = $this->repoWallet->findLastEntry($ownerID, $typeOfWallet);
        return $r;
    }
}
