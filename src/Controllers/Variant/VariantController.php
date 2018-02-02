<?php
namespace Deflopian\EducationTests\Controllers\Variant;

use Deflopian\EducationTests\Models\Variant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class VariantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['show']]);
    }

    public function show($uuid)
    {
        $question = Variant::exclude(['id', 'question_id', 'is_correct', 'created_at', 'updated_at'])->whereUuid($uuid)->first();
        return $question ?: response()->json('Not found', 404);
    }
}