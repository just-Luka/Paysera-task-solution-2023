<?php

namespace src\domain\transactions;
use src\data\models\TransactionModel;

abstract class TransactionBase {
    protected TransactionModel $model;
    protected mixed $exchangeRate;
    protected static array $memorySim;
    protected array $data = [
        'fee' => 0,
        // 'status' => '',
        // and some other data ...
    ];
    
    abstract protected function private();
    abstract protected function business();
    
    /**
     * Execute the payment
     *
     * @return array
     */
    public function execute(): array
    {
        $this->{$this->model->getUserType()}();
        // some other logic ...

        return $this->data;
    }
    
    /**
     * Setter for $model
     *
     * @param  mixed $model
     * @return void
     */
    public function setModel(TransactionModel $model): void
    {
        $this->model = $model;
    }
        
    /**
     * Setter for $exchangeRate
     *
     * @param  mixed $data
     * @return void
     */
    public function setExchangeRate(mixed $data): void
    {
        $this->exchangeRate = $data;
    }
}