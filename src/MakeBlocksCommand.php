<?php

namespace AwStudio\Blocks;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeBlocksCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:blocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the macrame feature Blocks.';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new controller creator command instance.
     *
     * @param  Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Handle the execution of the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->makeAppFiles();
        $this->makeResourceFiles();

        return 0;
    }

    protected function makeAppFiles()
    {
        // Controllers
        $this->files->copyDirectory(
            $this->publishPath('app/controllers'),
            base_path('admin/Http/Controllers')
        );

        // Indexes
        $this->files->copyDirectory(
            $this->publishPath('app/index'),
            base_path('admin/Http/Indexes')
        );

        // Migrations
        $this->files->copyDirectory(
            $this->publishPath('app/migrations'),
            database_path('migrations')
        );

        // Indexes
        $this->files->copyDirectory(
            $this->publishPath('app/models'),
            app_path('Models')
        );

        // Parsers
        $this->files->copyDirectory(
            $this->publishPath('app/parsers'),
            app_path('Casts/Parsers')
        );

        // Indexes
        $this->files->copyDirectory(
            $this->publishPath('app/index'),
            base_path('admin/Http/Indexes')
        );

        // Resources
        $this->files->copyDirectory(
            $this->publishPath('app/resources'),
            base_path('admin/Http/Resources')
        );

        $this->addParserToContentCast();
        $this->addRoutes();
    }

    protected function addParserToContentCast()
    {
        $path = app_path('Casts/ContentCast.php');
        $content = $this->files->get($path);

        // Add parser
        $search = 'protected $parsers = [';
        $replace = "protected \$parsers = [
            'block'      => Parsers\BlockParser::class,";
        $content = Str::replaceFirst($search, $replace, $content);

        $this->files->put($path, $content);
    }

    protected function addRoutes()
    {
        $path = base_path('routes/admin.php');
        $content = $this->files->get($path);

        // Add parser
        $search = '});';
        $replace = "
    // blocks
    Route::get('/blocks', [BlockController::class, 'index'])->name('blocks.index');
    Route::post('/blocks', [BlockController::class, 'store'])->name('blocks.store');
    Route::get('/blocks/items', [BlockController::class, 'items'])->name('blocks.items');
    Route::get('/blocks/{block}', [BlockController::class, 'show'])->name('blocks.show');
    Route::put('/blocks/{block}', [BlockController::class, 'update'])->name('blocks.update');
});";
        $content = Str::replaceFirst($search, $replace, $content);

        $this->files->put($path, $content);

        $insert = "use Admin\Http\Controllers\BlockController;";
        $before = "use Illuminate\Support\Facades\Route;";

        $this->insertBefore($path, $insert, $before);
    }

    protected function makeResourceFiles()
    {
        // Modules
        $this->files->copyDirectory(
            $this->publishPath('resources/modules'),
            resource_path('admin/js/modules')
        );

        // Pages
        $this->files->copyDirectory(
            $this->publishPath('resources/pages'),
            resource_path('admin/js/Pages/Block')
        );

        $this->addBlocksToSections();
        $this->addBlocksToPages();
        $this->addSidebarLink();
        $this->addFormTypes();
        $this->addResourceTypes();
    }

    protected function addBlocksToSections()
    {
        $path = resource_path('admin/js/modules/content/sections/index.ts');
        $content = $this->files->get($path);

        // Add to sections
        $search = 'const sections = {';
        $replace = 'const sections = {
    block: SectionBlocks,';
        $content = Str::replaceFirst($search, $replace, $content);

        // Add import
        $search = 'import';
        $replace = "import { SectionBlocks } from '@admin/modules/blocks';
import";
        $content = Str::replaceFirst($search, $replace, $content);

        $this->files->put($path, $content);
    }

    protected function addBlocksToPages()
    {
        $path = resource_path('admin/js/Pages/Page/components/PanelContentSidebar.vue');
        $content = $this->files->get($path);

        // Add template
        $search = '</ContentSidebar>';
        $replace = '    <DrawerSection title="Blöcke">
            <Cabinet>
                <DrawerBlocks :draws="SectionBlocks" />
            </Cabinet>
        </DrawerSection>
    </ContentSidebar>';
        $content = Str::replaceFirst($search, $replace, $content);

        // Add imports
        $search = 'import';
        $replace = "import { SectionBlocks, DrawerBlocks } from '@admin/modules/blocks';
import";
        $content = Str::replaceFirst($search, $replace, $content);

        $this->files->put($path, $content);
    }

    protected function addSidebarLink()
    {
        $path = resource_path('admin/js/modules/sidebar-navigation/index.ts');
        $content = $this->files->get($path);

        // Add link
        $search = '});';
        $replace = '});

// Navigation links
sidebarLinks.push({
    title: "Blöcke",
    href: "/admin/blocks",
    icon: IconBlocks,
});';
        $content = Str::replaceLast($search, $replace, $content);

        // Add link
        $search = 'import';
        $replace = "import { IconBlocks } from '@macramejs/admin-vue3';
import";
        $content = Str::replaceLast($search, $replace, $content);

        $this->files->put($path, $content);
    }

    protected function addFormTypes()
    {
        $path = resource_path('admin/js/types/forms.ts');
        $content = $this->files->get($path);

        $content .= '

// Block

export type BlockContent = {
    name: string,
    content: {[k:string]: any}[],
}
export type BlockContentForm = Form<BlockContent>;';

        $this->files->put($path, $content);
    }

    protected function addResourceTypes()
    {
        $path = resource_path('admin/js/types/resources.ts');
        $content = $this->files->get($path);

        $content .= '

// Block
export type Block = {
    id?: number;
    content: { [key: string]: any };
    name: string;
};

export type BlockResource = Resource<Block>;
export type BlockCollectionResource = CollectionResource<Block>;';

        $this->files->put($path, $content);
    }

    protected function publishPath($path)
    {
        return __DIR__.'/../publishes/'.$path;
    }

    public function insertBefore(string $path, string $insert, string $before)
    {
        $content = $this->files->get($path);

        if (str_contains($content, $insert)) {
            return;
        }

        $content = Str::replaceFirst($before, $insert.PHP_EOL.$before, $content);

        $this->files->put($path, $content);

        $this->info("{$path} changed, please check it for correction and formatting.");
    }
}
