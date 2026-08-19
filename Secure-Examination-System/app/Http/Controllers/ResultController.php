<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::with(['student', 'examination'])->get();
        return view('admin.results', compact('results'));
    }

    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        $result->delete();
        return redirect('/admin/results')->with('success', 'Result deleted successfully');
    }
}
