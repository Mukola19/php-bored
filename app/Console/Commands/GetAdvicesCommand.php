<?php


namespace App\Console\Commands;

use App\Classes\BoredApi\BoredApi;
use App\Classes\DTO\ActivityDTO;
use App\Classes\Senders\SenderFactory;
use App\Core\Console\Command;

class GetAdvicesCommand extends Command
{

    /**
     * --participants=int (1-8)
     * --type=string ('education', 'recreational', 'social', 'diy', 'charity', 'cooking', 'relaxation', 'music', 'busywork')
     * --sender=string ('file', 'console')
     */

    protected string $signature = 'get:advice {--participants=1} {--type=education} {--sender=console}';

    public function handle()
    {
        $participants = (int)$this->getOption('participants');
        $type = (string)$this->getOption('type');

        $response = BoredApi::getActivity($participants, $type);

        if ($message = $response->json('error')) {
            $this->output->printWarning($message);
            return;
        }

        $sender = SenderFactory::make($this->getOption('sender'));
        $sender->handle(new ActivityDTO($response->json()));

        $this->output->printInfo($sender->getMessage());
    }
}