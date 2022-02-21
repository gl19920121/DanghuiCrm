<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Article;
use App\Models\ArticleType;
use App\Models\User;
use App\Http\Requests\StoreArticlePost;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = 10;
        $articles = Article::query()->active()->orderBy('created_at', 'desc')->paginate($pageSize);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function create(Request $request)
    {
        $types = ArticleType::get()->groupBy(['level', 'pno']);
        $users = User::children()->get();

        return view('articles.create', compact('types', 'users'));
    }

    public function edit(Article $article)
    {
        $types = ArticleType::get()->groupBy(['level', 'pno']);
        $users = User::children()->get();

        return view('articles.edit', compact('article', 'types', 'users'));
    }



    public function store(StoreArticlePost $request)
    {
        // dd($request->all());
        $coverPath = NULL;
        $cover = $request->file('cover');
        if($request->hasFile('cover')) {
            if (!$cover->isValid()) {
                session()->flash('danger', '图片上传失败');
                return redirect()->back()->withInput();
            }
            $coverPath = Storage::disk('article_cover')->putFile(date('Y-m-d').'/'.$request->user()->id, $cover);
        }
        unset($cover);

        $typeNo = NULL;
        for ($i=0; $i < count($request->type_no); $i++) {
            if (empty($request->type_no[$i])) {
                $typeNo = $request->type_no[$i - 1];
                break;
            }
            if ($i === array_key_last($request->type_no)) {
                $typeNo = $request->type_no[$i];
                break;
            }
        }
        // $typeNo = $request->type_no[array_key_last($request->type_no)];

        $article = new Article();
        $article->title = $request->title;
        $article->cover = $coverPath;
        $article->brief = $request->brief;
        $article->article_types_id = ArticleType::where('no', $typeNo)->first()->id;
        $article->publisher_id = $request->publisher_id;
        $article->publisher_name = User::find($article->publisher_id)->nickname;
        $article->content = $request->content;
        $article->user_id = Auth::user()->id;
        $article->save();

        return redirect()->back();
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back();
    }

    public function update(Article $article, Request $request)
    {
        // dd($request->all());
        $coverPath = NULL;
        if ($request->has('cover')) {
            $cover = $request->file('cover');
            if($request->hasFile('cover')) {
                if (!$cover->isValid()) {
                    session()->flash('danger', '图片上传失败');
                    return redirect()->back()->withInput();
                }
                $coverPath = Storage::disk('article_cover')->putFile(date('Y-m-d').'/'.$request->user()->id, $cover);
            }
            unset($cover);
        } else {
            $coverPath = $article->cover;
        }

        $typeNo = NULL;
        for ($i=0; $i < count($request->type_no); $i++) {
            if (empty($request->type_no[$i])) {
                $typeNo = $request->type_no[$i - 1];
                break;
            }
            if ($i === array_key_last($request->type_no)) {
                $typeNo = $request->type_no[$i];
                break;
            }
        }

        $article->title = $request->title;
        $article->cover = $coverPath;
        $article->brief = $request->brief;
        $article->article_types_id = ArticleType::where('no', $typeNo)->first()->id;
        $article->publisher_id = $request->publisher_id;
        $article->publisher_name = User::find($article->publisher_id)->nickname;
        $article->content = $request->content;
        $article->user_id = Auth::user()->id;
        $article->save();

        return redirect()->route('articles.index');
    }
}
