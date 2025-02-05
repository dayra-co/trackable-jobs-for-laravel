<?php declare(strict_types=1);

namespace Junges\TrackableJobs\Contracts;

interface TrackableContract
{
    /** The key of the model you want the trackable job to be related to. Usually the id or uuid. */
    public function trackableKey(): ?string;

    /** The type of the model you want the trackable job to be related to. Usually the morph class. */
    public function trackableType(): ?string;

    /** The sender of the job. */
    public function sender(): ?string;

    /** The queue of the job. */
    public function getQueue(): ?string;
}
