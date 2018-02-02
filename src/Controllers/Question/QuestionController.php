<?php
namespace Deflopian\EducationTests\Controllers\Question;

use Deflopian\EducationTests\Models\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['show']]);
    }

    public function show($uuid)
    {
        $question = Question::exclude(['id', 'test_id', 'created_at', 'updated_at'])->whereUuid($uuid)->first();
        return $question ?: response()->json('Not found', 404);
    }
}