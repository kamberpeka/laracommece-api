<?php

use App\Enums\ProductConditionEnum;
use App\Enums\ProductVisibilityEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique()->index();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->text('description_short')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_title')->nullable();

            $table->boolean('on_sale')->default(false);
            $table->boolean('online_only')->default(false);

            $table->integer('quantity')->default(0);

            $table->decimal('price', 20, 6)->default(0);
            $table->decimal('additional_shipping_cost', 20, 2)->default(0);

            $table->decimal('width', 20, 6)->default(0);
            $table->decimal('height', 20, 6)->default(0);
            $table->decimal('weight', 20, 6)->default(0);

            $table->boolean('out_of_stock')->default(1);
            $table->boolean('active')->default(false);

            $table->boolean('virtual')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
