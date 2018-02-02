<?php
namespace Deflopian\EducationTests\Controllers\Variant;

use Deflopian\EducationTests\Models\Question;

use Deflopian\EducationTests\Models\Test;
use Deflopian\EducationTests\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class QuestionVariantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['index']]);
    }

    public function index($question_uuid)
    {
        $question = Question::select(['id'])->whereUuid($question_uuid)->first();
        if (!$question) {
            response()->json('Question not found', 404);
        }
        return Variant::exclude(['id', 'question_id', 'created_at', 'updated_at', 'is_correct'])->whereQuestionId($question->id)->orderBy('order_id')->get();
    }
}