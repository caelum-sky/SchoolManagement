<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;

class SubjectController extends Controller
{

    

    public function index()
    {
        $subjects = Subject::all();
        return view('admin.index', compact('subjects'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'code' => 'required|string|unique:subjects,code',
            'unit' => '|numeric|min:0|max:10'
        ]);
    
        Subject::create($request->all());
    
        return redirect()->back()->with('success', 'Subject added successfully!');
    }
    
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id) {
        $subject = Subject::findOrFail($id);
        $subject->update($request->all());
        return redirect()->back()->with('success', 'Subject updated successfully.');
    }
    

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('storage.index')->with('success', 'Subject deleted successfully.');
    }
}

