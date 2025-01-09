<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\Coaster;

class ConstraintChecker
{
    /**
     * @param iterable CoasterWorkingConstraint[] $constraintList
     */
    public function __construct(private iterable $constraintList)
    {
    }
 
   public function check(Coaster $coaster): array {

      $messages = [];
      /** @var CoasterWorkingConstraint $contraint */
      foreach ($this->constraintList as $contraint) {
         if ($contraint->isSatisfied($coaster)) {
            $messages[] = $contraint->generateMsg($coaster);
         }
     }

      return $messages;

   }

}
