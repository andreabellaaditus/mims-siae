<?php

namespace App\Trait;

trait OperationsForPolicy
{
    const VIEWANY = 0;
    const VIEW = 1;
    const CREATE = 2;
    const UPDATE = 3;
    const DELETEANY = 4;
    const DELETE = 5;
    const RESTORE = 6;
    const FORCEDELETE = 7;
}
