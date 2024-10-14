<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BaseModule extends Command
{
    /**
     * @var string
     */
    protected $signature = 'base:module {name}';

    /**
     * @var string
     */
    protected $description = 'Scaffold out files for a new modular component, use singular form of module name, e.g. "spotlight-row"';

    protected $stub; // Stub file contents
    protected $lowercase; // dummy-component
    protected $singleword; // dummycomponent
    protected $camelcase; // DummyComponent
    protected $titlecase; // Dummy Component

    /**
     * Scaffold files.
     */
    public function handle(): void
    {
        $this->setModule($this->argument('name'));

        $this->component();
        $this->styleguideController();
        $this->styleguideMenu();
        $this->styleguidePage();

        $this->newLine();
        $this->info('"modular-' . $this->lowercase . '" is now ready to use. 🚀');
    }

    protected function setModule($module)
    {
        $this->lowercase = strtolower($module);
        $this->camelcase = str_replace('-', '', ucwords($module, '-'));
        $this->singleword = strtolower($this->camelcase);
        $this->titlecase = str_replace('-', ' ', ucwords($module, '-'));

        if (Storage::disk('base')->exists('resources/views/components/'.$this->lowercase.'.blade.php')) {
            die($this->error('Module "'.$this->lowercase.'" already exists, please use another name.'));
        }
    }

    protected function initializeStub($type)
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
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

        Storage::disk('base')->put('resources/views/components/'.$this->lowercase.'.blade.php', $this->stub);
        $this->line('resources/views/components/'.$this->lowercase.'.blade.php written successfully.');
    }

    protected function styleguideController()
    {
        $this->initializeStub('component-controller');
        $this->localizeStub();

        Storage::disk('base')->put('styleguide/Http/Controllers/Component'.$this->camelcase.'Controller.php', $this->stub);
        $this->line('styleguide/Http/Controllers/Component'.$this->camelcase.'Controller.php written successfully.');
    }

    protected function styleguideMenu()
    {
        $menu = $this->getMenu();

        $item = end($menu[102]['submenu'][9999]['submenu']);
        if (empty($item)) {
            $item = end($menu[102]['submenu']);
        }

        $item['menu_item_id']++;
        $item['page_id'] = $item['menu_item_id'];
        $item['display_name'] = $this->titlecase;
        $item['relative_url'] = '/styleguide/component/'.$this->singleword;

        $menu[102]['submenu'][9999]['submenu'][$item['menu_item_id']] = $item;

        Storage::disk('base')->put('styleguide/menu.json', json_encode($menu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->line('styleguide/menu.json written successfully.');
    }

    protected function styleguidePage()
    {
        $menu = $this->getMenu();

        $this->initializeStub('component-page');
        $this->localizeStub();

        $this->stub = str_replace('DummyId', end($menu[102]['submenu'][9999]['submenu'])['menu_item_id'], $this->stub);

        Storage::disk('base')->put('styleguide/Pages/Component'.$this->camelcase.'.php', $this->stub);
        $this->line('styleguide/Pages/Component'.$this->camelcase.'.php written successfully.');
    }
}
