<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\AddsStyleguideMenuItems;
use App\Console\Commands\Concerns\ChecksExistingFiles;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('base:module {name} {--base : Scaffold into base\'s own folders instead of the site-specific ones}')]
#[Description('Scaffold out files for a new modular component, use singular form of module name, e.g. "spotlight-row"')]
class BaseModule extends Command
{
    use AddsStyleguideMenuItems;
    use ChecksExistingFiles;

    protected string $stub; // Stub file contents
    protected string $lowercase; // dummy-component
    protected string $singleword; // dummycomponent
    protected string $camelcase; // DummyComponent
    protected string $titlecase; // Dummy Component
    protected int $menuItemId;

    /**
     * Scaffold files.
     */
    public function handle(): int
    {
        if (! $this->setModule($this->argument('name'))) {
            return self::FAILURE;
        }

        $this->component();
        $this->styleguideController();
        $this->styleguideMenu();
        $this->styleguidePage();

        $this->newLine();
        $this->info('"modular-'.$this->lowercase.'" is now ready to use. 🚀');

        return self::SUCCESS;
    }

    protected function setModule($module): bool
    {
        $this->lowercase = strtolower($module);
        $this->camelcase = str_replace('-', '', ucwords($module, '-'));
        $this->singleword = strtolower($this->camelcase);
        $this->titlecase = str_replace('-', ' ', ucwords($module, '-'));

        // A site component or page sharing a base one's name would silently replace it
        if ($this->anyExists([
            'resources/views/components/'.$this->lowercase.'.blade.php',
            'resources/views/site-specific/components/'.$this->lowercase.'.blade.php',
            'styleguide/Pages/Component'.$this->camelcase.'.php',
            'styleguide/Pages/Custom/Component'.$this->camelcase.'.php',
        ])) {
            $this->error('Module "'.$this->lowercase.'" already exists, please use another name.');

            return false;
        }

        return true;
    }

    protected function initializeStub($type)
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
        $this->stub = str_replace('{{ custom }}', $this->option('base') ? '' : '\Custom', $this->stub);
    }

    protected function localizeStub()
    {
        $this->stub = str_replace('dummy-component', $this->lowercase, $this->stub);
        $this->stub = str_replace('dummycomponent', $this->singleword, $this->stub);
        $this->stub = str_replace('DummyComponent', $this->camelcase, $this->stub);
        $this->stub = str_replace('Dummy Component', $this->titlecase, $this->stub);
    }

    protected function getMenu()
    {
        return json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
    }

    protected function component()
    {
        $this->initializeStub('component');
        $this->localizeStub();

        $this->write('resources/views/'.($this->option('base') ? '' : 'site-specific/').'components/'.$this->lowercase.'.blade.php');
    }

    protected function styleguideController()
    {
        $this->initializeStub('component-controller');
        $this->localizeStub();

        $this->write('styleguide/Http/Controllers/'.($this->option('base') ? '' : 'Custom/').'Component'.$this->camelcase.'Controller.php');
    }

    protected function styleguideMenu()
    {
        $url = '/styleguide/component/'.$this->singleword;

        // Base modules go under Components, ahead of its "Site specific" entry
        [$menu, $this->menuItemId] = $this->option('base')
            ? $this->addMenuItem($this->getMenu(), '102.submenu', 102, $this->titlecase, $url, before: 9999)
            : $this->addMenuItem($this->getMenu(), '102.submenu.9999.submenu', 9999, $this->titlecase, $url);

        Storage::disk('base')->put('styleguide/menu.json', json_encode($menu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->line('styleguide/menu.json written successfully.');
    }

    protected function styleguidePage()
    {
        $this->initializeStub('component-page');
        $this->localizeStub();

        $this->stub = str_replace('DummyId', (string) $this->menuItemId, $this->stub);

        if ($this->option('base')) {
            $this->stub = str_replace("use Styleguide\Pages\Page;\n", '', $this->stub);
        }

        $this->write('styleguide/Pages/'.($this->option('base') ? '' : 'Custom/').'Component'.$this->camelcase.'.php');
    }

    protected function write(string $path): void
    {
        Storage::disk('base')->put($path, $this->stub);
        $this->line($path.' written successfully.');
    }
}
