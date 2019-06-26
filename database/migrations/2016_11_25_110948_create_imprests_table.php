<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImprestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imprests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id')->unsigned();
            $table->string('imprest_number');
            $table->string('requester_id');
            $table->tinyInteger('process')->unsigned();
            $table->tinyInteger('imprest_type')->default(1);
            $table->text('reference')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('number_of_days')->nullable();
            $table->date('date_of_issue')->nullable();
            $table->string('account_id')->nullable();;
            $table->text('nature_of_duty')->nullable();
            $table->text('proposed_itinerary')->nullable();
            $table->integer('officer_id')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('CB_number')->nullable();
            $table->date('CB_date')->nullable();
            $table->string('voucher_number')->nullable();
            $table->string('station_name')->nullable();
            $table->double('advance_amount');
            $table->string('remark')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('surrender_cheque_number')->nullable();
            $table->date('surrender_cheque_date')->nullable();
            $table->double('surrender_cheque_amount')->nullable();
            $table->text('surrender_cheque_remark')->nullable();
            $table->integer('currency_link_id')->nullable();
            $table->timestamps();

           $table->foreign('applicant_id')->references('AccountLink')->on('Accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imprests');
    }
}
