<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logins', function (Blueprint $table) {
            $morphPrefix = config('audit-login.user.morph-prefix', 'login_auditable');

            $table->id();
            $table->unsignedBigInteger($morphPrefix.'_id')->nullable();
            $table->string($morphPrefix.'_type')->nullable();
            $table->string('event');
            $table->text('metadata')->nullable();
            $table->text('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 1023)->nullable();
            $table->timestamps();

            $table->index([$morphPrefix.'_id', $morphPrefix.'_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_logins');
    }
};
