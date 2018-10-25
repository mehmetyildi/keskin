<?php

namespace App\Http\Controllers;

use App\Models\Articles\Article;

class ArticlesController extends Controller
{
    /**
     * Show the articles listing page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::where('publish_until', '>=', todayWithFormat('Y-m-d'))
            ->where('publish', true)->orWhere('publish_until', null)
            ->where('publish_at', '<=', todayWithFormat('Y-m-d'))
            ->where('publish', true)
            ->orderBy('position', 'ASC')
            ->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the article detail page.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($url)
    {
        $theArticle = Article::where('url_'. app()->getLocale(), $url)->firstOrFail();
        $articles = Article::where('id', '!=', $theArticle->id)->where('publish_until', '>=', todayWithFormat('Y-m-d'))
            ->where('publish', true)->orWhere('publish_until', null)
            ->where('id', '!=', $theArticle->id)
            ->where('publish_at', '<=', todayWithFormat('Y-m-d'))
            ->where('publish', true)
            ->orderBy('position', 'ASC')
            ->take(3)
            ->get();
        return view('articles.detail', compact('theArticle', 'articles'));
    }

}