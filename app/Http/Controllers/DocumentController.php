<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function upload(Request $request, $permit_id)
    {
        $request->validate([
            'document' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ]);

        $file = $request->file('document');
        $path = $file->store("documents/{$permit_id}", 'public');

        Document::create([
            'permit_id' => $permit_id,
            'document_type_id' => $request->document_type_id ?? null,
            'uploaded_by' => Auth::id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'uploaded_at' => now(),
        ]);

        return back()->with('success', 'Document ajouté avec succès.');
    }
}
