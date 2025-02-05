<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $table_name;
    private bool $usingUuid;

    public function __construct()
    {
        $this->table_name = config('trackable-jobs.tables.tracked_jobs', 'tracked_jobs');
        $this->usingUuid = config('trackable-jobs.using_uuid', false);
    }

    /**
     * The database connection that should be used by the migration.
     *
     * @var string
     */
    protected $connection = 'telescope';

    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $this->usingUuid
                ? $table->uuid()->primary()
                : $table->id();
            $table->string('trackable_id')->index()->nullable();
            $table->string('trackable_type')->index()->nullable();
            $table->string('sender');
            $table->string('receiver');
            $table->string('name');
            $table->string('status')->nullable();
            $table->string('job_id')->nullable()->after('name');
            $table->integer('attempts')->default(1)->after('status');
            $table->json('output')->nullable();
            $table->json('payload')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });

        //Add Trackable Job Attempts Table
        Schema::create('tracked_job_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracked_job_id');
            $table->string('status');
            $table->json('output')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table_name);
        Schema::dropIfExists('tracked_job_attempts');
    }
};
