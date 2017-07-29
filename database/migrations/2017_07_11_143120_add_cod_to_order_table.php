<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
           $table->string('cod')->after('transcation_id');
           $table->string('your_customer_key')->nullable()->after('transcation_id');
           $table->string('delayed_this_order')->nullable()->after('transcation_id');
           $table->string('name_of_card')->nullable()->after('transcation_id');
           $table->string('billing_address')->nullable()->after('transcation_id');
           $table->string('billing_post_code')->nullable()->after('transcation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('cod');
            $table->dropColumn('delayed_this_order');
            $table->dropColumn('your_customer_key');
            $table->dropColumn('name_of_card');
            $table->dropColumn('billing_address');
            $table->dropColumn('billing_post_code');
        });
    }
}
