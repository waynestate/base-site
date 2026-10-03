<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Signature('base:module {name} {--s|site=false : Scaffold into the site namespace (defaults to config/base.php site_namespace)}')]
#[Description('Scaffold out files for a new modular component, use singular form of module name, e.g. "spotlight-row"')]
class BaseModule extends Command
{
    public const SITE_MENU_ID_START = 999900;

    protected string $stub; // Stub file contents
    protected string $lowercase; // dummy-component
    protected string $singleword; // dummycomponent
    protected string $camelcase; // DummyComponent
    protected string $titlecase; // Dummy Component

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

    public function getSiteNamespace(): ?string
    {
        /** @var mixed $site */
        $site = $this->option('site');

        if ($site === 'false' || $site === false) {
            return null;
        }

        if (is_string($site) && $site !== '') {
            return $site;
        }

        return config('base.site_namespace', 'Site');
    }

    protected function setModule($module): bool
    {
        $this->lowercase = strtolower($module);
        $this->camelcase = str_replace('-', '', ucwords($module, '-'));
        $this->singleword = strtolower($this->camelcase);
        $this->titlecase = str_replace('-', ' ', ucwords($module, '-'));

        $siteNamespace = $this->getSiteNamespace();
        $viewPath = $siteNamespace !== null
            ? 'resources/views/'.Str::snake($siteNamespace).'/components/'.$this->lowercase.'.blade.php'
            : 'resources/views/components/'.$this->lowercase.'.blade.php';

        if (Storage::disk('base')->exists($viewPath)) {
            $this->error('Module "'.$this->lowercase.'" already exists, please use another name.');
            return false;
        }

        return true;
    }

    protected function initializeStub($type): void
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
    }

    protected function localizeStub(): void
    {
        $this->stub = str_replace('dummy-component', $this->lowercase, $this->stub);
        $this->stub = str_replace('dummycomponent', $this->singleword, $this->stub);
        $this->stub = str_replace('DummyComponent', $this->camelcase, $this->stub);
        $this->stub = str_replace('Dummy Component', $this->titlecase, $this->stub);
    }

    protected function getMenu(): array
    {
        return json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
    }

    protected function component(): void
    {
        $this->initializeStub('component');
        $this->localizeStub();

        $siteNamespace = $this->getSiteNamespace();
        $viewPath = $siteNamespace !== null
            ? 'resources/views/'.Str::snake($siteNamespace).'/components/'.$this->lowercase.'.blade.php'
            : 'resources/views/components/'.$this->lowercase.'.blade.php';

        Storage::disk('base')->put($viewPath, $this->stub);
        $this->line($viewPath.' written successfully.');
    }

    protected function styleguideController(): void
    {
        $this->initializeStub('component-controller');
        $this->localizeStub();

        $siteNamespace = $this->getSiteNamespace();
        if ($siteNamespace !== null) {
            $this->stub = str_replace(
                'namespace Styleguide\Http\Controllers;',
                "namespace App\\{$siteNamespace}\\Styleguide\\Controllers;",
                $this->stub
            );
            $path = 'app/'.$siteNamespace.'/Styleguide/Controllers/Component'.$this->camelcase.'Controller.php';
        } else {
            $path = 'styleguide/Http/Controllers/Component'.$this->camelcase.'Controller.php';
        }

        Storage::disk('base')->put($path, $this->stub);
        $this->line($path.' written successfully.');
    }

    protected function styleguideMenu(): void
    {
        $siteNamespace = $this->getSiteNamespace();

        if ($siteNamespace !== null) {
            $menuPath = 'app/'.$siteNamespace.'/Styleguide/menu.json';
            $siteMenu = Storage::disk('base')->exists($menuPath)
                ? json_decode(Storage::disk('base')->get($menuPath), true)
                : [];

            if (! is_array($siteMenu)) {
                $siteMenu = [];
            }

            $existingSubmenu = $siteMenu[102]['submenu'][9999]['submenu'] ?? [];
            if (! empty($existingSubmenu)) {
                $lastId = max(array_keys($existingSubmenu));
                $nextId = (int) $lastId + 1;
            } else {
                $nextId = self::SITE_MENU_ID_START + 1;
            }

            $item = [
                'menu_item_id' => $nextId,
                'is_active' => 1,
                'page_id' => $nextId,
                'target' => '',
                'display_name' => $this->titlecase,
                'class_name' => '',
                'relative_url' => '/styleguide/component/'.$this->singleword,
                'submenu' => [],
            ];

            $siteMenu[102]['submenu'][9999]['submenu'][$nextId] = $item;

            Storage::disk('base')->put($menuPath, json_encode($siteMenu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->line($menuPath.' written successfully.');
        } else {
            $menuPath = 'styleguide/menu.json';
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

            Storage::disk('base')->put($menuPath, json_encode($menu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->line($menuPath.' written successfully.');
        }
    }

    protected function styleguidePage(): void
    {
        $siteNamespace = $this->getSiteNamespace();

        if ($siteNamespace !== null) {
            $menuPath = 'app/'.$siteNamespace.'/Styleguide/menu.json';
            $siteMenu = Storage::disk('base')->exists($menuPath)
                ? json_decode(Storage::disk('base')->get($menuPath), true)
                : [];
            $existingSubmenu = $siteMenu[102]['submenu'][9999]['submenu'] ?? [];
            $pageId = ! empty($existingSubmenu)
                ? end($existingSubmenu)['menu_item_id']
                : self::SITE_MENU_ID_START + 1;
        } else {
            $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
            $pageId = end($menu[102]['submenu'][9999]['submenu'])['menu_item_id'];
        }

        $this->initializeStub('component-page');
        $this->localizeStub();

        $this->stub = str_replace('DummyId', (string) $pageId, $this->stub);

        if ($siteNamespace !== null) {
            $this->stub = str_replace(
                "namespace Styleguide\Pages;\n",
                "namespace App\\{$siteNamespace}\\Styleguide\\Pages;\n\nuse Styleguide\Pages\Page;",
                $this->stub
            );
            $path = 'app/'.$siteNamespace.'/Styleguide/Pages/Component'.$this->camelcase.'.php';
        } else {
            $path = 'styleguide/Pages/Component'.$this->camelcase.'.php';
        }

        Storage::disk('base')->put($path, $this->stub);
        $this->line($path.' written successfully.');
    }
}
