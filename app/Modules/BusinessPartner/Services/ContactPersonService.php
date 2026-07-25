<?php

namespace Modules\BusinessPartner\Services;

use Modules\BusinessPartner\Models\ContactPerson;
use Modules\BusinessPartner\Repositories\ContactPersonRepository;

class ContactPersonService
{
    public function __construct(
        protected ContactPersonRepository $contactPersonRepository,
    ) {}
