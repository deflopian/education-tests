<?php
namespace Deflopian\EducationTests\Controllers\Variant;

use Deflopian\EducationTests\Models\Question;

use Deflopian\EducationTests\Models\Test;
use Deflopian\EducationTests\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class AdminQuestionVariantController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($question_id)
    {
        return Variant::whereQuestionId($question_id)->orderBy('order_id')->get();
    }

    public function store($question_id, Request $request)
    {
        $attributes = $request->all();
        $attributes['uuid'] = Uuid::generate()->string;
        $attributes['question_id'] = $question_id;
        $variant = Variant::create($attributes);

        return response()->json($variant, 201);
    }
}