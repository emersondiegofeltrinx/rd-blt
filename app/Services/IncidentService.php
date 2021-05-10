<?php

namespace App\Services;

use App\Models\Incident;
use Exception;
use Illuminate\Support\Facades\Log;

class IncidentService
{
    /**
     * Incident model
     *
     * @var Incident
     */
    private Incident $incident;

    /**
     * Constructor method
     *
     * @param Incident $incident
     *
     * @return void
     */
    public function __construct(Incident $incident)
    {
        $this->incident = $incident;
    }

    /**
     * List incidents
     *
     * @return object
     */
    public function list(): object
    {
        return $this->incident
            ->orderBy('id', 'desc')
            ->paginate(5);
    }

    /**
     * Save incident
     *
     * @param string $title
     * @param string $description
     * @param string $criticality
     * @param string $type
     * @param string $status
     *
     * @return bool
     */
    public function save(
        string $title,
        string $description,
        string $criticality,
        string $type,
        string $status
    ): bool {
        try {
            $this->incident->title       = $title;
            $this->incident->description = $description;
            $this->incident->criticality = $criticality;
            $this->incident->type        = $type;
            $this->incident->status      = $status;

            return $this->incident->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Get incident
     *
     * @param int $id
     *
     * @return null|Incident
     */
    public function get(int $id): ?Incident
    {
        try {
            $incidents = $this->incident->where('id', $id);

            if ($incidents->count() === 0) {
                return null;
            }

            return $incidents->first();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    /**
     * Update incident
     *
     * @param int    $id
     * @param string $title
     * @param string $description
     * @param string $criticality
     * @param string $type
     * @param string $status
     *
     * @return bool
     */
    public function update(
        int $id,
        string $title,
        string $description,
        string $criticality,
        string $type,
        string $status
    ): bool {
        try {
            $incidents = $this->incident->where('id', $id);

            if ($incidents->count() === 0) {
                return false;
            }

            $incident = $incidents->first();
            $incident->title       = $title;
            $incident->description = $description;
            $incident->criticality = $criticality;
            $incident->type        = $type;
            $incident->status      = $status;

            return $incident->update();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete incident
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $incidents = $this->incident->where('id', $id);

            if ($incidents->count() === 0) {
                return false;
            }

            return $incidents->first()->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
