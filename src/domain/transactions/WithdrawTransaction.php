<?php

namespace src\domain\transactions;
use DateTime;
use src\configs\AppConfig;
use src\data\models\TransactionModel;

class WithdrawTransaction extends TransactionBase {        
    /**
     * Execute private withdrawal
     *
     * @return void
     */
    protected function private(): void
    {
        $this->data['fee'] = $this->calculatePrivateFee($this->model);
    }
    
    /**
     * Execute business withdrawal
     *
     * @return void
     */
    protected function business(): void
    {
        $this->data['fee'] = $this->model->getAmount() * AppConfig::BUSINESS_WITHDRAWAL_FEE;
    }
    
    /**
     * calculatePrivateFee does some math
     *
     * @return numeric|float
     */
    private function calculatePrivateFee(TransactionModel $model): float
    {
        $amount = $model->getAmount();

        if($model->getCurrency() !== AppConfig::FREE_TRANSACTIONS['withdraw_private']['currency']) {
            $amount = $amount / $this->exchangeRate->rates->{$model->getCurrency()};
        }

        if(!isset(self::$memorySim[$model->getId()])) {
           $this->setMemSim($model, $amount);
        }else {
            $prevWithdraw = self::$memorySim[$model->getId()];

            if($prevWithdraw['charge_free_reset_at'] <= $model->getDate()) {
                $this->setMemSim($model, $amount);
            }else {
                self::$memorySim[$model->getId()] = [
                    'charge_free_amount' => ($prevWithdraw['charge_free_amount'] >= 0 ? $prevWithdraw['charge_free_amount'] : 0)  - $amount,
                    'charge_free_reset_at' => (new DateTime($model->getDate()))->modify('next monday')->format('Y-m-d'),
                    'frequency' => $prevWithdraw['frequency'] + 1,
                ];
            }
        }

        if(self::$memorySim[$model->getId()]['charge_free_amount'] < 0 
        || self::$memorySim[$model->getId()]['frequency'] > AppConfig::FREE_TRANSACTIONS['withdraw_private']['frequency']) {
            return abs(self::$memorySim[$model->getId()]['charge_free_amount']) * AppConfig::PRIVATE_WITHDRAWAL_FEE;
        }

        return 0;
    }

    private function setMemSim(TransactionModel $model, float $amount): void
    {
        self::$memorySim[$model->getId()] = [
            'charge_free_amount' => AppConfig::FREE_TRANSACTIONS['withdraw_private']['amount'] - $amount,
            'charge_free_reset_at' => (new DateTime($model->getDate()))->modify('next monday')->format('Y-m-d'),
            'frequency' => 1,
        ];
    }
}