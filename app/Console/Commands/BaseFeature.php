<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\AddsStyleguideMenuItems;
use App\Console\Commands\Concerns\ChecksExistingFiles;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('base:feature {feature} {--base : Scaffold a base feature, with its view outside site-specific/ and its page under Templates}')]
#[Description('Scaffold out files for a new feature, use singular form of feature name, e.g. "Spotlight"')]
class BaseFeature extends Command
{
    use AddsStyleguideMenuItems;
    use ChecksExistingFiles;

    protected string $feature;

    protected string $stub;

    protected int $menuItemId;

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

    public function controller()
    {
        $this->initializeStub('controller');
        $this->replaceContract();
        $this->replaceController();
        $this->replaceVariables();
        $this->stub = str_replace('Dummy Template', $this->feature.' Template', $this->stub);
        $this->stub = str_replace('DummyView', $this->getView(), $this->stub);

        Storage::disk('base')->put('app/Http/Controllers/'.$this->feature.'Controller.php', $this->stub);
    }

    public function contract()
    {
        $this->initializeStub('contract');
        $this->replaceContract();
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);

        Storage::disk('base')->put('contracts/Repositories/'.$this->feature.'RepositoryContract.php', $this->stub);
    }

    public function repository()
    {
        $this->initializeStub('repository');
        $this->replaceContract();
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);

        Storage::disk('base')->put('app/Repositories/'.$this->feature.'Repository.php', $this->stub);
    }

    public function repositoryStyleguide()
    {
        $this->initializeStub('repository-styleguide');
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);
        $this->stub = str_replace('DummyFactory', $this->feature, $this->stub);

        Storage::disk('base')->put('styleguide/Repositories/'.$this->feature.'Repository.php', $this->stub);
    }

    public function menu()
    {
        $url = '/styleguide/'.strtolower($this->feature);

        $menu = $this->getMenu();

        // Base features go under Templates, ahead of its "Site specific" entry; site features are alphabetical after its guide
        [$menu, $this->menuItemId] = $this->option('base')
            ? $this->addMenuItem($menu, '101.submenu', 101, $this->feature, $url, before: 999)
            : $this->addMenuItem($menu, '101.submenu.999.submenu', 999, $this->feature, $url, before: $this->alphabeticalBefore($menu[101]['submenu'][999]['submenu'] ?? [], $this->feature, pinned: 1));

        Storage::disk('base')->put('styleguide/menu.json', json_encode($menu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function page()
    {
        $this->initializeStub('page');
        $this->replaceController();
        $this->stub = str_replace('DummyPage', $this->feature, $this->stub);
        $this->stub = str_replace('DummyTitle', $this->feature, $this->stub);
        $this->stub = str_replace('DummyId', (string) $this->menuItemId, $this->stub);

        Storage::disk('base')->put('styleguide/Pages/'.$this->feature.'.php', $this->stub);
    }

    public function view()
    {
        $this->initializeStub('view');
        $this->replaceVariables();

        Storage::disk('base')->put('resources/views/'.($this->option('base') ? '' : 'site-specific/').$this->getView().'.blade.php', $this->stub);
    }

    public function factory()
    {
        $this->initializeStub('factory');
        $this->stub = str_replace('DummyFactory', $this->feature, $this->stub);

        Storage::disk('base')->put('factories/'.$this->feature.'.php', $this->stub);
    }

    public function setFeature($feature): bool
    {
        $this->feature = ucfirst($feature);

        // Don't overwrite an existing feature, or add one that a Custom overload would shadow
        if ($this->anyExists([
            'app/Http/Controllers/'.$this->feature.'Controller.php',
            'app/Http/Controllers/Custom/'.$this->feature.'Controller.php',
            'styleguide/Pages/'.$this->feature.'.php',
            'styleguide/Pages/Custom/'.$this->feature.'.php',
        ])) {
            $this->error('Feature already exists, please use another name.');

            return false;
        }

        return true;
    }

    public function initializeStub($type)
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
        $this->stub = str_replace('{{ views }}', $this->option('base') ? '' : 'site-specific.', $this->stub);
    }

    public function replaceContract()
    {
        $this->stub = str_replace('DummyRepositoryContract', $this->feature.'RepositoryContract', $this->stub);
    }

    public function replaceController()
    {
        $this->stub = str_replace('DummyController', $this->feature.'Controller', $this->stub);
    }

    public function replaceVariables()
    {
        $this->stub = str_replace(
            ['$dummy', '$this->dummy', '->getDummy'],
            ['$'.strtolower($this->feature), '$this->'.strtolower($this->feature), '->get'.$this->feature],
            $this->stub
        );
    }

    public function getView()
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $this->feature));
    }

    public function getMenu()
    {
        return json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
    }
}
