<?php

namespace App\Models;

use App\Casts\PageContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Macrame\Admin\Media\Traits\HasFiles;

class Block extends Model
{
    use HasFactory, HasFiles;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
    ];

    /**
     * Attributes casts.
     *
     * @var array
     */
    protected $casts = [
        'content' => PageContent::class,
    ];

    /**
     * Default model attributes.
     *
     * @var array
     */
    protected $attributes = [
        'content' => '[]',
    ];

    /**
     * The creator of the page.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
