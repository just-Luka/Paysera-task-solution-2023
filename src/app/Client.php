<?php

namespace src\app;
use src\app\dependencies\TransactionDependency;
use src\data\api\ExchangeRateApi;
use src\data\models\TransactionModel;
use src\domain\transactions\DepositTransaction;
use src\domain\transactions\TransactionBase;
use src\domain\transactions\WithdrawTransaction;

final class Client {
    private TransactionBase $transactionBase;

    public function __invoke(array|bool $csv, mixed $args = null)
    {
        $exchangeRate = (new ExchangeRateApi)->all();

        foreach ($csv as $row) {
            $model = new TransactionModel(...str_getcsv($row));

            if($model->getOperationType() === 'deposit') {
                $this->transactionBase = new DepositTransaction();
            }else if($model->getOperationType() === 'withdraw') {
                $this->transactionBase = new WithdrawTransaction();
            }
            
            $this->transactionBase->setExchangeRate($exchangeRate);
            $this->transactionBase->setModel($model);
            $result = $this->transactionBase->execute();
            $fee = number_format($result['fee'], 2);
            
            print_r($fee);
            echo "\n";
        }
    }
}