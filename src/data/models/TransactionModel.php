<?php

namespace src\data\models;

final class TransactionModel
{
    protected string $date;
    protected int $id;
    protected string $userType;
    protected string $operationType;
    protected string $amount;
    protected string $currency;

    public function __construct(string $date, int $id, string $userType, string $operationType, string $amount, string $currency)
    {
        $this->date = $date;
        $this->id = $id;
        $this->userType = $userType;
        $this->operationType = $operationType;
        $this->amount = $amount;
        $this->currency = $currency;
    }

	/**
	 * @return string
	 */
	public function getDate(): string {
		return $this->date;
	}
	
	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getUserType(): string {
		return $this->userType;
	}
	
	/**
	 * @return string
	 */
	public function getOperationType(): string {
		return $this->operationType;
	}
	
	/**
	 * @return string
	 */
	public function getAmount(): string {
		return $this->amount;
	}
	
	/**
	 * @return string
	 */
	public function getCurrency(): string {
		return $this->currency;
	}
}