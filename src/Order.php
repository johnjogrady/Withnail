<?php
/**
 * Created by PhpStorm.
 * User: john.ogrady
 * Date: 22/12/2016
 * Time: 23:10
 */

namespace Itb;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class Order
{
private $orderid;

    /**
     * @return mixed
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * @param mixed $orderid
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->CustomerId;
    }

    /**
     * @param mixed $CustomerId
     */
    public function setCustomerId($CustomerId)
    {
        $this->CustomerId = $CustomerId;
    }

    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->OrderDate;
    }

    /**
     * @param mixed $OrderDate
     */
    public function setOrderDate($OrderDate)
    {
        $this->OrderDate = $OrderDate;
    }

    /**
     * @return mixed
     */
    public function getCompleted()
    {
        return $this->Completed;
    }

    /**
     * @param mixed $Completed
     */
    public function setCompleted($Completed)
    {
        $this->Completed = $Completed;
    }

private	$CustomerId;

private $OrderDate;

private $Completed;

}