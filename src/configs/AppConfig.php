<?php

namespace src\configs;

class AppConfig {
    const DEPOSIT_FEE = 0.0003;
    const PRIVATE_WITHDRAWAL_FEE = 0.003;
	const BUSINESS_WITHDRAWAL_FEE = 0.005;
	const FREE_TRANSACTIONS = [
        'withdraw_private' => [
            'type' => 'private',
			'frequency' => 3,
			'amount' => 1000,
            'currency' => 'EUR',
        ],
	];
}