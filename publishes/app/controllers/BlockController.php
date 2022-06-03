<?php

namespace Admin\Http\Controllers;

use Admin\Http\Controllers\Traits\PageLinks;
use Admin\Http\Indexes\BlockIndex;
use Admin\Http\Resources\BlockResource;
use Admin\Http\Resources\LinkOptionResource;
use Admin\Ui\Page as AdminPage;
use App\Models\Block;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlockController
{
    use PageLinks;

    /**
     * Page index page.
     *
     * @param  Page $block
     * @return Page
     */
    public function items(Request $request, BlockIndex $index)
    {
        return $index->items(
            $request,
            Block::query()
        );
    }

    /**
     * Show the index page for the admin application.
     *
     * @return AdminPage
     */
    public function index(Request $request, AdminPage $adminPage): AdminPage
    {
        $blocks = Block::all();
        // dd(BlockResource::collection($blocks));

        return $adminPage
            ->page('Block/Index')
            ->with('blocks', BlockResource::collection($blocks));
    }

    /**
     * Show the page.
     *
     * @param {{ Model }} $block
     * @param  AdminPage $adminPage
     * @return AdminPage
     */
    public function show(Block $block, AdminPage $adminPage)
    {
        $linkOptions = $this->linkOptions();
        $blocks = Block::all();

        return $adminPage
            ->page('Block/Show')
            ->with('block', new BlockResource($block))
            ->with('blocks', BlockResource::collection($blocks))
            ->with('link-options', LinkOptionResource::collection($linkOptions));
    }

    /**
     * Update the page.
     *
     * @param  Request $request
     * @param  Page    $block
     * @return void
     */
    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'name'    => 'sometimes|string',
            'content' => 'array',
        ]);

        $block->update($validated);

        return redirect()->back();
    }

    /**
     * Store a new page.
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $block = Block::make([
            'name' => $request->name,
        ]);

        $block->creator_id = $request->user()->id;

        $block->save();

        return redirect()->route('admin.blocks.show', [
            'block' => $block,
        ]);
    }

    /**
     * Destroy the given page.
     *
     * @param  Request          $request
     * @param  Page             $block
     * @return RedirectResponse
     */
    public function destroy(Request $request, Block $block)
    {
        $block->delete();

        return redirect(route('admin.blocks.index'));
    }
}
