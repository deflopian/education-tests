<?php
namespace Deflopian\EducationTests\Controllers\Test;

use Deflopian\EducationTests\Models\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['show', 'index']]);
    }

    public function index()
    {
        return Test::exclude(['id', 'created_at', 'updated_at'])->get();
    }

    public function show($uuid)
    {
        $test = Test::exclude(['id', 'created_at', 'updated_at'])->whereUuid($uuid)->first();
        return $test ?: response()->json('Not found', 404);
    }
}