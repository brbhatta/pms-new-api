<?php

namespace Modules\Organisation\Application\Contracts;

use Illuminate\Support\Collection;
use Modules\Organisation\Http\Data\PostingData;
use Modules\User\Http\Data\UserData;

interface ManagerHierarchyServiceInterface
{
    /**
     * @param  UserData  $userData
     * @return PostingData
     */
    function getActivePosting(UserData $userData): ?PostingData;

    /**
     * @param  UserData  $userData
     * @return Collection<UserData>
     */
    function immediateManagers(UserData $userData): Collection;

    /**
     * @param  UserData  $userData
     * @return Collection<UserData>
     */
    function allManagers(UserData $userData): Collection;
}
