<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Console;

use App\Auth\Infrastructure\Generator\KeyPairGenerator;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateKeyPairCommand extends Command
{
    protected static $defaultName = 'auth:generate-keypair';

    public function __construct(
        private readonly FilesystemWriter $writer,
        private readonly string $passphrase = '',
    ) {
        parent::__construct();
    }

    /**
     * @throws FilesystemException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = KeyPairGenerator::generate($this->passphrase);

        $this->writer->write('private.pem', $result->getPrivateKey());
        $this->writer->write('public.pem', $result->getPublicKey());

        return self::SUCCESS;
    }
}
