<?php

declare(strict_types=1);

namespace App\Policy\Request;

use Authorization\IdentityInterface;
use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorAwareTrait;
use Authorization\Exception\ForbiddenException;
class UserPermissionPolicy implements RequestPolicyInterface
{
    use LocatorAwareTrait;

    /**
     * Method to check if the request can be accessed
     *
     * @param \Authorization\IdentityInterface|null $identity Identity
     * @param \Cake\Http\ServerRequest $request Server Request
     * @return bool|null
     */
    public function canAccess(?IdentityInterface $identity, ServerRequest $request): ?bool
    {
       
		

        return true;
    }
}
