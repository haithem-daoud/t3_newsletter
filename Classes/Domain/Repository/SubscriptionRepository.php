<?php

namespace TYPO3\T3Newsletter\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Subscription Repository
 */
class SubscriptionRepository extends Repository {

	protected $defaultOrderings = [ 'crdate' => QueryInterface::ORDER_ASCENDING ];
        
    /**
     * @param string $token
     * @return object
     */
    public function findSubscriptionByToken(string $token): object
    {
        $query = $this->createQuery();

        $query->getQuerySettings()->setIgnoreEnableFields(true);

        $query->matching($query->equals('token', $token));
        return $query->execute()->getFirst();
    }
    
    /**
     * @param string $email
     * @return object|null
     */
    public function findSubscriptionByEmail(string $email): ?object
    {
        $query = $this->createQuery();

        $query->getQuerySettings()->setIgnoreEnableFields(true);

        $query->matching($query->equals('email', $email));
        return $query->execute()->getFirst();
    }
}
