<?php

namespace App\Casts\Parsers;

use App\Http\Resources\Wrapper\Image;
use App\Models\Block;
use Macrame\Content\Contracts\Parser;

class BlockParser implements Parser
{
    /**
     * Image.
     *
     * @var Image
     */
    public Block $block;

    /**
     * Create new Parser instance.
     *
     * @param  array $value
     * @return void
     */
    public function __construct(
        protected array $value
    ) {
        //
    }

    public function parse()
    {
        $this->block = Block::query()
            ->where('id', $this->value['block'] ?? null)
            ->first();
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        $content = $this->block->content;

        return $this->block->content->parse()->toArray(request());
    }
}
