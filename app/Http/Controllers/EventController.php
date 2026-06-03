<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    function show($id){
        $event = Event::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('event-detail', compact('event', 'categories'));
    }
    function checkout(){
        $categories = Category::all();
        return view('checkout', compact('categories'));
    }
    function ticket(){
        $categories = Category::all();
        return view('ticket', compact('categories'));
    }
}