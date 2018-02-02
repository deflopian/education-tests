<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EducationTestsSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up() {
        // Create table for storing roles
        Schema::create('{{ $tests_table }}', function (Blueprint $table) {
            $table->increments('id'); // inner id
            $table->string('uuid'); // specific public id
            $table->string('title');
            $table->integer('allowable_mistakes_count')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('{{ $questions_table }}', function (Blueprint $table) {
            $table->increments('id'); // inner id
            $table->string('uuid'); // specific public id
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('single');
            $table->integer('test_id')->unsigned();
            $table->integer('order_id')->default(0);
            $table->timestamps();

            $table->foreign('test_id')->references('id')->on('{{ $tests_table }}')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('{{ $variants_table }}', function (Blueprint $table) {
            $table->increments('id'); // inner id
            $table->string('uuid');  // specific public id
            $table->text('text');
            $table->boolean('is_correct')->default(false);
            $table->integer('question_id')->unsigned();
            $table->integer('order_id')->default(0);
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('{{ $questions_table }}')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('{{ $user_test_attempts_table }}', function (Blueprint $table) {
            $table->increments('id');
            $table->text('answers');
            $table->boolean('passed')->default(false);
            $table->integer('result')->default(0);
            $table->integer('attempt_num')->default(0);
            $table->string('uuid');
            $table->integer('test_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('test_id')->references('id')->on('{{ $tests_table }}')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('{{ $user_key_name }}')->on('{{ $users_table }}')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down() {
        Schema::drop('{{ $tests_table }}');
        Schema::drop('{{ $questions_table }}');
        Schema::drop('{{ $variants_table }}');
        Schema::drop('{{ $user_test_attempts_table }}');
    }
}