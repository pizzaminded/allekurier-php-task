<?php

declare(strict_types=1);

namespace App\Core\User\Application\Exception;

use DomainException;

/**
 * Parent class for every exception in user application layer.
 */
abstract class UserApplicationException extends DomainException
{

}