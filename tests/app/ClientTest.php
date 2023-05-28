<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use src\app\Client;
use src\data\api\ExchangeRateApi;
use src\domain\transactions\DepositTransaction;
use src\domain\transactions\WithdrawTransaction;
use src\domain\transactions\TransactionBase;

final class ClientTest extends TestCase
{
    public function testCSVFileExists(): void
    {
        $filePath = __DIR__.'/../../public/input.csv';

        if (!file_exists($filePath)) {
            $this->fail('CSV file not found: ' . $filePath . "\nMake sure to refer path correctly");
        }

        $this->assertFileExists($filePath);
    }

    public function testYouGetExchangeRate(): void
    {
        $exchangeRate = new ExchangeRateApi();
        
        $this->assertNotEmpty($exchangeRate->all());
    }

    public function testDepositAndWithdrawInheritsFromTransactionBase(): void
    {
        $obj1 = new DepositTransaction();
        $obj2 = new WithdrawTransaction();

        $this->assertInstanceOf(TransactionBase::class, $obj1);
        $this->assertInstanceOf(TransactionBase::class, $obj2);
    }
}

