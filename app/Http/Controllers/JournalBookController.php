<?php

namespace App\Http\Controllers;

use App\Models\JournalBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JournalBookController extends Controller
{
    public function show($id) {
        $book = JournalBook::find($id);
        return response()->json(['data' => $book]);
    }
}
