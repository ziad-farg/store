<?php

namespace App\Enums;

enum ProductStatus: int
{
    case ACTIVE = 1;
    case DRAFT = 2;
    case ARCHIVED = 3;
}
