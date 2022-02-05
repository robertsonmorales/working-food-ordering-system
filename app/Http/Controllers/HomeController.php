<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{MenuCategories, Menu};

class HomeController extends Controller
{
    protected $categories, $menus;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MenuCategories $categories, Menu $menus)
    {
        $this->middleware('auth');

        $this->menu = $menus;
        $this->category = $categories;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = $this->category->limitFields()
            ->active()
            ->latest()
            ->get();

        $menus = $this->menu->limitFields()
            ->active()
            ->latest()
            ->get();

        return view('index', [
            'categories' => $categories,
            'menus' => $menus
        ]);
    }
}
