<?php
declare(strict_types=1);

namespace App;

use App\Domain\DomainEvent;
use App\Domain\DomainEventListener;
use App\Domain\MonitoringPubSub;
use App\RedisConnector;
use Clue\React\Redis\Factory as RedisFactory;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class RedisMonitoring implements MonitoringPubSub
{
   private static $namespace = 'monitoring_data';

   public function __construct(
      private RedisConnector $redisConnector,
      private DomainEventListener $domainEventListener,
      private string $redisHost, 
      private string $redisPort, 
      private string $redisPass,
   ) {

   }

   protected function listenEvents(LoopInterface $loop){
      
      $redisFactory = new RedisFactory($loop);
      $uri = 'redis://' . $this->redisHost . ':' . $this->redisPort;
      if ($this->redisPass) {
         $uri .= '?password=' . $this->redisPass;
      }
      $redis = $redisFactory->createLazyClient($uri);

		$redis->get(self::$namespace . ':last_message')->then(function ($value) {
         echo "Ostatnia wiadomość w Redis: $value\n";
      });

      $redis->subscribe('new_event')->then(function () use ($redis) {
         echo "Nasłuchiwanie na nowe wiadomości w kanale 'new_event'...\n";
      });
      $listener = $this->domainEventListener;
      $redis->on('message', function ($channel, $message) use ($listener) {
         echo "Otrzymano nową wiadomość na kanale '$channel': $message\n";
         dump($message);
         $listener->handle($message);
      });

   }

   public function runMonitoring()
   {
      $loop = Loop::get();
      $timer = $loop->addPeriodicTimer(10, function () {
         echo 'Tick' . PHP_EOL;
     });

      $this->listenEvents($loop);

      $loop->run();

   }

   public function emitEvent(DomainEvent $val)
   {
      $this->redisConnector->setKey(self::$namespace,'last_message', $val);
      $this->redisConnector->publishMsg('new_event', $val);
   }


}
