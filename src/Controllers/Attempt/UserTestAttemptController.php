<?php
namespace Deflopian\EducationTests\Controllers\Attempt;

use Deflopian\EducationTests\Models\Test;
use Deflopian\EducationTests\Models\UserTestAttempt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class UserTestAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['store']]);
        $this->middleware('admin', ['except' => ['show']]);
    }

    public function index()
    {
        return UserTestAttempt::all();
    }

    public function show(UserTestAttempt $test)
    {
        return $test;
    }

    public function store(Request $request)
    {
        $answers = $request->post('answers');

        if (!$answers) {
            return response()->json('Response contains no answers', 400);
        }
        $user = $request->user();

        $test_uuid = $request->post('uuid');
        $test = Test::where('uuid', $test_uuid)->first();

        if (!$test) {
            return response()->json("There is no test with id $test_uuid", 404);
        }

        $test_questions = $test->getQuestions();

        $scores = 0;
        foreach ($test_questions as $test_question) {
            $answer = $answers[$test_question->uuid];
            $question_is_passed = false;
            if ($answer) {
                $variants = $test_question->getVariants();
                foreach ($variants as $variant) {
                    if (array_key_exists($variant->uuid, $answer)) {
                        if ($variant->is_correct) {
                            $question_is_passed = true;
                        } else {
                            $question_is_passed = false;
                            break;
                        }
                    }
                }
            }
            if ($question_is_passed) {
                $scores++;
            }
        }

        $uuid = Uuid::generate()->string;

        $passed = $scores >= count($test_questions) - $test->allowable_mistakes_count;

        UserTestAttempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'answers' => $answers,
            'passed' => $passed,
            'result' => $scores,
            'uuid' => $uuid,
            'attempt_num' => UserTestAttempt::whereUserId($user->id)->whereTestId($test->id)->count() + 1
        ]);

        return response()->json($uuid, 201);
    }

    public function update(Request $request, UserTestAttempt $test)
    {
        $test->update($request->all());

        return response()->json($test, 200);
    }

    public function delete(Test $test)
    {
        $test->delete();

        return response()->json(null, 204);
    }
}