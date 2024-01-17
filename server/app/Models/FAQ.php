<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class FAQ extends Model
{
    use HasFactory, Translatable;

    protected $translatable = ['question', 'answer'];
    protected $table = "faq";

    protected $fillable = [
        'sequence',
        'question',
        'answer',
    ];

    public static function getTranslate(string $lang)
    {
        $faq = FAQ::withTranslation($lang)->get();

        foreach($faq as $element)
        {
            foreach($element->translations as $translation)
            {
                $element[$translation->column_name] = $translation->value;
            }

            unset($element->translations);
        }

        return $faq;
    }
}