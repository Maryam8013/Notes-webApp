<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return Note::where('user_id', auth()->id())->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $note = Note::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return $note;
    }

      // GET /api/notes/{id}
    public function show($id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($note);
    }
    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);

        $note->update($request->only('title', 'content'));

        return $note;
    }

    public function destroy($id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);
        $note->delete();

        return response()->json(['success' => true]);
    }
}
