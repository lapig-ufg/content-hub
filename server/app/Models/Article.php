<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Article extends Model
{
    use HasFactory, Translatable;

    protected $translatable = ['title', 'description'];
    protected $table = "articles";

    protected $fillable = [
        'title',
        'description',
        'authors',
        'image',
        'file_pt',
        'file_en',
    ];

    public static function getTranslate(string $lang)
    {
        $articles = Article::withTranslation($lang)->get();

        foreach($articles as $article)
        {
            foreach($article->translations as $translation)
            {
                $article[$translation->column_name] = $translation->value;
            }

            if($lang == "en")
            {
                $article["file"] = $article->file_en;
            }
            else
            {
                $article["file"] = $article->file_pt;
            }

            unset($article->translations, $article->file_pt, $article->file_en);
        }

        return $articles;
    }
}
