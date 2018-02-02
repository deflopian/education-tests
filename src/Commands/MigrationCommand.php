<?php
namespace Deflopian\EducationTests;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'education-tests:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Education Tests specifications.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('education-tests', substr(__DIR__, 0, -8).'views');

        $tests_table              = Config::get('education-tests.tests_table');
        $questions_table          = Config::get('education-tests.questions_table');
        $variants_table           = Config::get('education-tests.variants_table');
        $user_test_attempts_table = Config::get('education-tests.user_test_attempts_table');

        $this->line('');
        $this->info( "Tables: $tests_table, $questions_table, $variants_table, $user_test_attempts_table" );

        $message = "A migration that creates '$tests_table', '$questions_table', '$variants_table', '$user_test_attempts_table'".
        " tables will be created in database/migrations directory";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration($tests_table, $questions_table, $variants_table, $user_test_attempts_table)) {

                $this->info("Migration successfully created!");
            } else {
                $this->error(
                    "Couldn't create migration.\n Check the write permissions".
                    " within the database/migrations directory."
                );
            }

            $this->line('');

        }
    }

    /**
     * Create the migration.
     *
     * @param string $tests_table
     * @param string $questions_table
     * @param string $variants_table
     * @param string $user_test_attempts_table
     *
     * @return bool
     */
    protected function createMigration($tests_table, $questions_table, $variants_table, $user_test_attempts_table)
    {
        $migration_file = base_path("/database/migrations")."/".date('Y_m_d_His')."_education_tests_setup_tables.php";

        $user_model = Config::get('auth.providers.users.model');
        $user_model = new $user_model;
        $user_key_name = $user_model->getKeyName();
        $users_table  = $user_model->getTable();

        $data = compact('tests_table', 'questions_table', 'variants_table', 'user_test_attempts_table', 'users_table', 'user_key_name');

        $output = $this->laravel->view->make('education-tests::generators.migration')->with($data)->render();

        if (!file_exists($migration_file) && $fs = fopen($migration_file, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
