<?php

namespace Junges\TrackableJobs\Models;
use Junges\TrackableJobs\Enums\TrackedJobStatus;


class TrackedJobAttempt extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'telescope';
    protected $table='tracked_job_attempts';
    protected $fillable = [
        'tracked_job_id',
        'status',
        'started_at',
        'finished_at',
        'output',
    ];

    protected $attributes = [
        'output' => '[]',
    ];
    protected function casts(): array
    {
        return [
            'status' => TrackedJobStatus::class,
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'output' => 'array',
        ];
    }

    /** Whether the job has already started. */
    public function hasStarted(): bool
    {
        return ! empty($this->started_at);
    }

    /** Get the duration of the job, in human diff. */
    public function duration(): Attribute
    {
        return Attribute::make(
            get: function () : string {
                if (! $this->hasStarted()) {
                    return '';
                }

                return ($this->finished_at ?? now())
                    ->diffAsCarbonInterval($this->started_at)
                    ->forHumans(['short' => true]);
            }
        );
    }

}