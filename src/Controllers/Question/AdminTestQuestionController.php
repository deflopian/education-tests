<?php
namespace Deflopian\EducationTests\Controllers\Question;

use Deflopian\EducationTests\Models\Question;

use Deflopian\EducationTests\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class AdminTestQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($test_id)
    {
        return Question::whereTestId($test_id)->orderBy('order_id')->get();
    }

    public function store($test_id, Request $request)
    {
        $attributes = $request->all();
        $attributes['uuid'] = Uuid::generate()->string;
        $attributes['test_id'] = $test_id;
        $question = Question::create($attributes);

        return response()->json($question, 201);
    }
}