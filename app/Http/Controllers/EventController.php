<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;

class EventController extends Controller
{
    // UPDATED: Pakai Route Model Binding (Event $event) bukan $id manual
    public function show(Event $event)
    {
        $categories = Category::all();
        return view('event-detail', compact('event', 'categories'));
    }

    public function checkout()
    {
        $categories = Category::all();
        return view('checkout', compact('categories'));
    }

    public function ticket()
    {
        $categories = Category::all();
        return view('ticket', compact('categories'));
    }
}