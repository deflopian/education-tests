<?php
namespace Deflopian\EducationTests\Controllers\Question;

use Deflopian\EducationTests\Models\Question;

use Deflopian\EducationTests\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class TestQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['index']]);
    }

    public function index($test_uuid)
    {
        $test = Test::select(['id'])->whereUuid($test_uuid)->first();
        if (!$test) {
            response()->json('Test not found', 404);
        }

        return Question::exclude(['id', 'test_id', 'created_at', 'updated_at'])->whereTestId($test->id)->orderBy('order_id')->get();
    }
}