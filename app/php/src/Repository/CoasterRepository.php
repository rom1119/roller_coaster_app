<?php

namespace App\Repository;

use App\RedisConnector;

class CoasterRepository 
{
    public function __construct(private RedisConnector $redis) {
    
    }


}
