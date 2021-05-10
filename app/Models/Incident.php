<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    /**
     * Criticality high
     */
    public const CRITICALITY_HIGH = 'H';

    /**
     * Criticality medium
     */
    public const CRITICALITY_MEDIUM = 'M';

    /**
     * Criticality low
     */
    public const CRITICALITY_LOW = 'L';

    /**
     * Type alarm
     */
    public const TYPE_ALARM = 'A';

    /**
     * Type incident
     */
    public const TYPE_INCIDENT = 'I';

    /**
     * Type other
     */
    public const TYPE_OTHER = 'O';

    /**
     * Status active
     */
    public const STATUS_ACTIVE = 'A';

    /**
     * Status inactive
     */
    public const STATUS_INACTIVE = 'I';
}
