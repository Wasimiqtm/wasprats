<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tag;
use Session;
use DataTables;
use Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tags = Tag::query();
            $user = Auth::user();
            
            return Datatables::of($tags)
                ->addColumn('action', function ($tag) use ($user) {

                    $action = '<td><div class="overlay-edit">';

                    if ($user->can('Tags Delete')) {    
                        $action .= '<a href="'.route('tags.destroy', $tag->id).'" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }
                    $action .= '</div></td>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if ($tag) {
            $tag->delete();
            return response()->json([
                'message' => __('Tag deleted!')
            ], $this->successStatus);
        }

        return response()->json([
            'message' => __('Tag not exist against this id')
        ], $this->errorStatus);
    }
}
