<?php

use Deflopian\EducationTests\Controllers\Question\AdminQuestionController;
use Deflopian\EducationTests\Controllers\Question\AdminTestQuestionController;
use Deflopian\EducationTests\Controllers\Question\TestQuestionController;
use Deflopian\EducationTests\Controllers\Question\QuestionController;
use Deflopian\EducationTests\Controllers\Variant\AdminQuestionVariantController;
use Deflopian\EducationTests\Controllers\Variant\AdminVariantController;
use Deflopian\EducationTests\Controllers\Variant\QuestionVariantController;
use Deflopian\EducationTests\Controllers\Variant\VariantController;
use Deflopian\EducationTests\Controllers\Attempt\UserTestAttemptController;
use Deflopian\EducationTests\Controllers\Test\TestController;
use Deflopian\EducationTests\Controllers\Test\AdminTestController;

Route::apiResource('api/tests', TestController::class);
Route::apiResource('api/variants', VariantController::class);
Route::apiResource('api/questions', QuestionController::class);
Route::apiResource('api/tests/{test_id}/questions', TestQuestionController::class);
Route::apiResource('api/questions/{question_id}/variants', QuestionVariantController::class);
Route::apiResource('api/user-test-attempts', UserTestAttemptController::class);

Route::apiResource('api/admin/tests', AdminTestController::class);
Route::apiResource('api/admin/variants', AdminVariantController::class);
Route::apiResource('api/admin/questions', AdminQuestionController::class);
Route::apiResource('api/admin/tests/{test_id}/questions', AdminTestQuestionController::class);
Route::apiResource('api/admin/questions/{question_id}/variants', AdminQuestionVariantController::class);