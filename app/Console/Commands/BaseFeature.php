<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Signature('base:feature {feature} {--s|site=false : Scaffold into the site namespace (defaults to config/base.php site_namespace)}')]
#[Description('Scaffold out files for a new feature, use singular form of feature name, e.g. "Spotlight"')]
class BaseFeature extends Command
{
    public const SITE_MENU_ID_START = 999100;

    protected string $feature;

    protected string $stub;

    /**
     * Scaffold files.
     */
    public function handle(): int
    {
        if (! $this->setFeature($this->argument('feature'))) {
            return self::FAILURE;
        }

        $this->controller();
        $this->contract();
        $this->repository();
        $this->repositoryStyleguide();
        $this->menu();
        $this->page();
        $this->view();
        $this->factory();

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

    public function controller(): void
    {
        $this->initializeStub('controller');
        $this->replaceContract();
        $this->replaceController();
        $this->replaceVariables();
        $this->stub = str_replace('Dummy Template', $this->feature.' Template', $this->stub);
        $this->stub = str_replace('DummyView', $this->getView(), $this->stub);

        $siteNamespace = $this->getSiteNamespace();
        if ($siteNamespace !== null) {
            $this->stub = str_replace(
                'namespace App\Http\Controllers;',
                "namespace App\\{$siteNamespace}\\Controllers;\n\nuse App\Http\Controllers\Controller;",
                $this->stub
            );
            $path = 'app/'.$siteNamespace.'/Controllers/'.$this->feature.'Controller.php';
        } else {
            $path = 'app/Http/Controllers/'.$this->feature.'Controller.php';
        }

        Storage::disk('base')->put($path, $this->stub);
    }

    public function contract(): void
    {
        $this->initializeStub('contract');
        $this->replaceContract();
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);

        Storage::disk('base')->put('contracts/Repositories/'.$this->feature.'RepositoryContract.php', $this->stub);
    }

    public function repository(): void
    {
        $this->initializeStub('repository');
        $this->replaceContract();
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);

        $siteNamespace = $this->getSiteNamespace();
        if ($siteNamespace !== null) {
            $this->stub = str_replace('namespace App\Repositories;', 'namespace App\\'.$siteNamespace.'\Repositories;', $this->stub);
            $path = 'app/'.$siteNamespace.'/Repositories/'.$this->feature.'Repository.php';
        } else {
            $path = 'app/Repositories/'.$this->feature.'Repository.php';
        }

        Storage::disk('base')->put($path, $this->stub);
    }

    public function repositoryStyleguide(): void
    {
        $this->initializeStub('repository-styleguide');
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);
        $this->stub = str_replace('DummyFactory', $this->feature, $this->stub);

        $siteNamespace = $this->getSiteNamespace();
        if ($siteNamespace !== null) {
            $this->stub = str_replace('namespace Styleguide\Repositories;', 'namespace App\\'.$siteNamespace.'\Styleguide\Repositories;', $this->stub);
            $this->stub = str_replace(
                'use App\Repositories\\'.$this->feature.'Repository as Repository;',
                'use App\\'.$siteNamespace.'\Repositories\\'.$this->feature.'Repository as Repository;',
                $this->stub
            );
            $path = 'app/'.$siteNamespace.'/Styleguide/Repositories/'.$this->feature.'Repository.php';
        } else {
            $path = 'styleguide/Repositories/'.$this->feature.'Repository.php';
        }

        Storage::disk('base')->put($path, $this->stub);
    }

    public function menu(): void
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

            $existingSubmenu = $siteMenu[101]['submenu'][999]['submenu'] ?? [];
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
                'display_name' => $this->feature,
                'class_name' => '',
                'relative_url' => '/styleguide/'.strtolower($this->feature),
                'submenu' => [],
            ];

            $siteMenu[101]['submenu'][999]['submenu'][$nextId] = $item;

            Storage::disk('base')->put($menuPath, json_encode($siteMenu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } else {
            $menuPath = 'styleguide/menu.json';
            $menu = $this->getMenu();

            $item = end($menu[101]['submenu'][999]['submenu']);

            $item['menu_item_id']++;
            $item['page_id'] = $item['menu_item_id'];
            $item['display_name'] = $this->feature;
            $item['relative_url'] = '/styleguide/'.strtolower($this->feature);

            $menu[101]['submenu'][999]['submenu'][$item['menu_item_id']] = $item;

            Storage::disk('base')->put($menuPath, json_encode($menu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    public function page(): void
    {
        $siteNamespace = $this->getSiteNamespace();

        if ($siteNamespace !== null) {
            $menuPath = 'app/'.$siteNamespace.'/Styleguide/menu.json';
            $siteMenu = Storage::disk('base')->exists($menuPath)
                ? json_decode(Storage::disk('base')->get($menuPath), true)
                : [];
            $existingSubmenu = $siteMenu[101]['submenu'][999]['submenu'] ?? [];
            $pageId = ! empty($existingSubmenu)
                ? end($existingSubmenu)['menu_item_id']
                : self::SITE_MENU_ID_START + 1;
        } else {
            $menu = json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
            $pageId = end($menu[101]['submenu'][999]['submenu'])['menu_item_id'];
        }

        $this->initializeStub('page');
        $this->replaceController();
        $this->stub = str_replace('DummyPage', $this->feature, $this->stub);
        $this->stub = str_replace('DummyTitle', $this->feature, $this->stub);
        $this->stub = str_replace('DummyId', (string) $pageId, $this->stub);

        if ($siteNamespace !== null) {
            $this->stub = str_replace(
                "namespace Styleguide\Pages;\n",
                "namespace App\\{$siteNamespace}\\Styleguide\\Pages;\n\nuse Styleguide\Pages\Page;",
                $this->stub
            );
            $path = 'app/'.$siteNamespace.'/Styleguide/Pages/'.$this->feature.'.php';
        } else {
            $path = 'styleguide/Pages/'.$this->feature.'.php';
        }

        Storage::disk('base')->put($path, $this->stub);
    }

    public function view(): void
    {
        $this->initializeStub('view');
        $this->replaceVariables();

        $siteNamespace = $this->getSiteNamespace();
        $viewPath = $siteNamespace !== null
            ? 'resources/views/'.Str::snake($siteNamespace).'/'.$this->getView().'.blade.php'
            : 'resources/views/'.$this->getView().'.blade.php';

        Storage::disk('base')->put($viewPath, $this->stub);
    }

    public function factory(): void
    {
        $path = 'factories/'.$this->feature.'.php';

        if (Storage::disk('base')->exists($path)) {
            return;
        }

        $this->initializeStub('factory');
        $this->stub = str_replace('DummyFactory', $this->feature, $this->stub);

        Storage::disk('base')->put($path, $this->stub);
    }

    public function setFeature($feature): bool
    {
        $this->feature = ucfirst($feature);
        $siteNamespace = $this->getSiteNamespace();

        $path = $siteNamespace !== null
            ? 'app/'.$siteNamespace.'/Controllers/'.$this->feature.'Controller.php'
            : 'app/Http/Controllers/'.$this->feature.'Controller.php';

        if (Storage::disk('base')->exists($path)) {
            $this->error('Feature already exists, please use another name.');
            return false;
        }

        return true;
    }

    public function initializeStub($type): void
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
    }

    public function replaceContract(): void
    {
        $this->stub = str_replace('DummyRepositoryContract', $this->feature.'RepositoryContract', $this->stub);
    }

    public function replaceController(): void
    {
        $this->stub = str_replace('DummyController', $this->feature.'Controller', $this->stub);
    }

    public function replaceVariables(): void
    {
        $this->stub = str_replace(
            ['$dummy', '$this->dummy', '->getDummy'],
            ['$'.strtolower($this->feature), '$this->'.strtolower($this->feature), '->get'.$this->feature],
            $this->stub
        );
    }

    public function getView(): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $this->feature));
    }

    public function getMenu(): array
    {
        return json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
    }
}
