<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fureev\Trees\NestedSetTrait;
use Fureev\Trees\Config\Base;
use Fureev\Trees\Contracts\TreeConfigurable;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Section extends Model implements TreeConfigurable
{
    use HasFactory;
    use NestedSetTrait;

    protected $guarded = ['id','lft','rgt','lvl','tree_id','parent_id'];
    protected $casts = [
        'content' => PurifyHtmlOnGet::class,
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    protected static function buildTreeConfig(): Base
    {
        $config = new Base(true);
        return $config;
    }
}
