<?php

namespace App\Http\Controllers;

use App\Models\Archive;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Archive::with('permit.citizen', 'permit.permitType', 'archivedBy')
                          ->latest()
                          ->paginate(15);

        return view('archives.index', compact('archives'));
    }
}
