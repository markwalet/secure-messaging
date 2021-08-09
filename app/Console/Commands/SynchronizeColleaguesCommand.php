<?php

namespace App\Console\Commands;

use App\Models\Colleague;
use App\Support\PasteBinClient;
use Illuminate\Console\Command;

class SynchronizeColleaguesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'colleagues:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize a list of colleagues from an external source.';

    /**
     * Execute the console command.
     *
     * @param PasteBinClient $client
     *
     * @return int
     */
    public function handle(PasteBinClient $client): int
    {
        $data = $client->json('uDzdKzGG');
        $emailAddresses = [];

        foreach ($data as $row) {
            if (in_array($row['email'], $emailAddresses)) {
                $this->warn("Skipping a colleague with emailadress {$row['email']} because the email adress is already in use.");
            }
            $emailAddresses[] = $row['email'];
            $this->storeOrUpdateColleague(
                name: $row['name'],
                email: $row['email']
            );
        }

        $count = count($data);
        $this->info("Synchronized $count colleagues.");

        return 0;
    }

    /**
     * Store or update a colleague.
     *
     * @param string $name
     * @param string $email
     */
    private function storeOrUpdateColleague(string $name, string $email): void
    {
        /** @var Colleague $colleague */
        $colleague = Colleague::query()->where('email', $email)->firstOrNew();

        $colleague->email = $email;
        $colleague->name = $name;

        $colleague->save();
    }
}
