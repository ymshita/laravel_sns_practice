<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * タグ関連記事一覧画面
     */
    public function show(string $name)
    {
        $tag = Tag::where('name', $name)->first();
        return view('tags.show', ['tag' => $tag]);
    }
}
