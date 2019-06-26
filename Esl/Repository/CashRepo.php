<?php
/**
 * Created by PhpStorm.
 * User: vinnyvinny
 * Date: 10/26/18
 * Time: 2:09 PM
 */

namespace Esl\Repository;


class CashRepo
{
    public function initCash()
    {
        return new self();
    }

    public function testIt($a,$b){
        dd($a);
    }
}
