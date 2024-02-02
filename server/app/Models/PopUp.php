<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class PopUp extends Model
{
    use HasFactory, Translatable;

    protected $translatable = ['title', 'message'];
    protected $table = "popups";

    protected $fillable = [
        'title',
        'message',
        'expiration'
    ];

    public static function getTranslate(string $lang)
    {
        $popups = News::withTranslation($lang)->get();

        foreach($popups as $popup)
        {
            foreach($popup->translations as $translation)
            {
                $popup[$translation->column_name] = $translation->value;
            }

            unset($popup->translations);
        }

        return $popups;
    }
}