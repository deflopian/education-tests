<?php
namespace Deflopian\EducationTests\Controllers\Test;

use Deflopian\EducationTests\Models\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class AdminTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return Test::all();
    }

    public function show($id)
    {
        $test = Test::find($id);
        return $test ?: response()->json('Not found', 404);
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['uuid'] = Uuid::generate()->string;
        $test = Test::create($attributes);

        return response()->json($test, 201);
    }

    public function update(Request $request, $test_id)
    {
        $test = Test::find($test_id);
        $test->update($request->all());

        return response()->json($test, 200);
    }

    public function delete(Test $test)
    {
        $test->delete();

        return response()->json(null, 204);
    }
}