<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableAddShippingAndPaymentStatus extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Payment status added next to payment_method
            $table->string('payment_status')->nullable()->after('payment_method');
            // Shipping address: you can use 'text' or, if you prefer a more structured approach, 'json'
            $table->text('shipping_address')->nullable()->after('payment_status');
            // Alternatively, if you want to store this as JSON:
            // $table->json('shipping_address')->nullable()->after('payment_status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'shipping_address']);
        });
    }
}
