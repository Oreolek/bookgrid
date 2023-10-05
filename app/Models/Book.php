<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'user_id'];

    public function sections() {
        return $this->hasMany(Section::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function collaborators() {
        return $this->belongsToMany(User::class, 'books_collaborators', 'book_id', 'user_id');
    }

    /**
     * Find all books accessible to a user (owner or collaborator).
     **/
    public function scopeAccessible(Builder $query, int $user_id) {
        $query
            ->where('user_id', $user_id)
            ->orWhereHas('collaborators', function(Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            });
    }
}
