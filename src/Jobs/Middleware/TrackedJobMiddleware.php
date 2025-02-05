<?php

namespace Junges\TrackableJobs\Jobs\Middleware;

/** @property-read \Illuminate\Contracts\Queue\Job $job */
class TrackedJobMiddleware
{
    public function handle(mixed $job, callable $next): void
    {
        if ($job->job->attempts() > 1) {
            $job->trackedJob->markAsRetrying($job->job->attempts(), false);
        } else {
            $job->trackedJob->markAsStarted($job->job->payload());
        }

        $response = $next($job);

        if ($job->job->isReleased()) {
            $job->trackedJob->markAsRetrying($this->job->attempts(), true);
        } else {
            $job->trackedJob->markAsFinished($response);
        }
    }
}
