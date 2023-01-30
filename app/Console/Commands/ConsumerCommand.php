<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message-broker:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $connection = new AMQPStreamConnection('192.168.128.194', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }
}
