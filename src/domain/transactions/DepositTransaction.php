<?php

namespace src\domain\transactions;
use src\configs\AppConfig;

class DepositTransaction extends TransactionBase {
    /**
     * Execute private deposit
     *
     * @return void
     */
    protected function private(): void
    {
        $this->data['fee'] = $this->model->getAmount() * AppConfig::DEPOSIT_FEE;
    }

    /**
     * Execute business deposit
     *
     * @return void
     */
    protected function business(): void
    {
        $this->data['fee'] = $this->model->getAmount() * AppConfig::DEPOSIT_FEE;
    }
}