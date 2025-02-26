<?php

namespace Junges\TrackableJobs\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface TrackableJobContract
{
    /** Return the model related to the tracked job. */
    public function trackable(): MorphTo;

    /** Mark the job as queued. */
    public function markAsQueued(string|int|null $jobId = null): bool;

    /** Mark the job as started. */
    public function markAsStarted($payload): bool;

    /** Mark the job as finished successfully. */
    public function markAsFinished(string $message = null): bool;

    /** Mark the job as retrying. */
    public function markAsRetrying(int $attempts, bool $is_end): bool;

    /** Mark the job as finished with error. */
    public function markAsFailed(string $exception = null): bool;

    /** Saves the output of the job. */
    public function setOutput(string $output): bool;
}
