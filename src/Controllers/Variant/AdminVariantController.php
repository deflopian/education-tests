<?php
namespace Deflopian\EducationTests\Controllers\Variant;

use Deflopian\EducationTests\Models\Variant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class AdminVariantController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return Variant::all();
    }

    public function show($id)
    {
        $variant = Variant::find($id);
        return $variant ?: response()->json('Not found', 404);
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['uuid'] = Uuid::generate()->string;
        $variant = Variant::create($attributes);

        return response()->json($variant, 201);
    }

    public function update(Request $request, $id)
    {
        $variant = Variant::find($id);
        $variant->update($request->all());

        return response()->json($variant, 200);
    }

    public function delete($id)
    {
        Variant::find($id)->delete();

        return response()->json(null, 204);
    }
}