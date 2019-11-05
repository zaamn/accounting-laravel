<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer');
            $table->string('currency');
            $table->string('date_time');
            $table->string('item_code');
            $table->string('product_id');
            $table->string('quantity');
            $table->decimal('unit_price');
            $table->decimal('discount');
            $table->decimal('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_carts');
    }
}
