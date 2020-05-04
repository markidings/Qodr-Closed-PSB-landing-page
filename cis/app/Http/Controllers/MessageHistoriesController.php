<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Broadcast;

class MessageHistoriesController extends Controller
{
    public function index()
    {
        $messages = Broadcast::orderBy('id', 'DESC')->get();
        return view('message-history.index', compact('messages'));
    }
}
