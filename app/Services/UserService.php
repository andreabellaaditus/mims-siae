<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserService
{
    const ROLE_ADMIN = 'Amministratore';
    const ROLE_INTERNAL_STAFF = 'Internal Staff';
    const ROLE_EXTERNAL_STAFF = 'External Staff';
    const ROLE_CASHIER = 'Cassiere';
    const CLIENT = 'Cliente';
    const SUPPLIER = 'Fornitore';
    const ROLE_SCHOOL = 'Scuola';
    const ROLE_TRAVEL_AGENCY = 'Agenzia Viaggio';
    const ROLE_COMMERCIAL = 'Commerciale';
    const VIRTUAL_MATRIX = 'Matrici Virtuali';
    const COMMERCIAL = 'Commerciale';
    const PROSPECT = 'Lista Contatti';



    public function allRoles(): mixed
    {
        return Role::all()->pluck('name','id');
    }

    public function idRoleAdmin(): int
    {
        return array_search(self::ROLE_ADMIN, $this->allRoles());
    }

    public function nameRoleAdmin(): string
    {
        return self::ROLE_ADMIN;
    }

    public function idRoleInternalStaff(): int
    {
        return array_search(self::ROLE_INTERNAL_STAFF, $this->allRoles());
    }

    public function nameRoleInternalStaff(): string
    {
        return self::ROLE_INTERNAL_STAFF;
    }

    public function idRoleCashier(): int
    {
        return array_search(self::ROLE_CASHIER, $this->allRoles());
    }

    public function nameRoleCashier(): string
    {
        return self::ROLE_CASHIER;
    }
}
