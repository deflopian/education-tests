<?php
namespace Deflopian\EducationTests\Controllers\Question;

use Deflopian\EducationTests\Models\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class AdminQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return Question::all();
    }

    public function show($id)
    {
        $question = Question::find($id);
        return $question ?: response()->json('Not found', 404);
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['uuid'] = Uuid::generate()->string;
        $question = Question::create($attributes);

        return response()->json($question, 201);
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        $question->update($request->all());

        return response()->json($question, 200);
    }

    public function delete($id)
    {
        Question::find($id)->delete();

        return response()->json(null, 204);
    }
}