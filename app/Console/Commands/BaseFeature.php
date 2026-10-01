<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\AddsStyleguideMenuItems;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('base:feature {feature} {--base : Scaffold into base\'s own folders instead of the site\'s Custom ones}')]
#[Description('Scaffold out files for a new feature, use singular form of feature name, e.g. "Spotlight"')]
class BaseFeature extends Command
{
    use AddsStyleguideMenuItems;

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

        if ($this->option('base')) {
            $this->stub = str_replace("use App\Http\Controllers\Controller;\n", '', $this->stub);
        }

        Storage::disk('base')->put($this->custom('app/Http/Controllers').$this->feature.'Controller.php', $this->stub);
    }

    public function contract()
    {
        $this->initializeStub('contract');
        $this->replaceContract();
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);

        Storage::disk('base')->put($this->custom('contracts/Repositories').$this->feature.'RepositoryContract.php', $this->stub);
    }

    public function repository()
    {
        $this->initializeStub('repository');
        $this->replaceContract();
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);

        Storage::disk('base')->put($this->custom('app/Repositories').$this->feature.'Repository.php', $this->stub);
    }

    public function repositoryStyleguide()
    {
        $this->initializeStub('repository-styleguide');
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy', 'get'.$this->feature, $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature), $this->stub);
        $this->stub = str_replace('DummyFactory', $this->feature, $this->stub);

        Storage::disk('base')->put($this->custom('styleguide/Repositories').$this->feature.'Repository.php', $this->stub);
    }

    public function menu()
    {
        $url = '/styleguide/'.($this->option('base') ? '' : 'sitespecific/').strtolower($this->feature);

        // Base features go under Templates, ahead of its "Site specific" entry
        [$menu, $this->menuItemId] = $this->option('base')
            ? $this->addMenuItem($this->getMenu(), '101.submenu', 101, $this->feature, $url, before: 999)
            : $this->addMenuItem($this->getMenu(), '101.submenu.999.submenu', 999, $this->feature, $url);

        Storage::disk('base')->put('styleguide/menu.json', json_encode($menu, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function page()
    {
        $this->initializeStub('page');
        $this->replaceController();
        $this->stub = str_replace('DummyPage', $this->getPage(), $this->stub);
        $this->stub = str_replace('DummyTitle', $this->feature, $this->stub);
        $this->stub = str_replace('DummyId', (string) $this->menuItemId, $this->stub);

        Storage::disk('base')->put('styleguide/Pages/'.$this->getPage().'.php', $this->stub);
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

        Storage::disk('base')->put($this->custom('factories').$this->feature.'.php', $this->stub);
    }

    public function setFeature($feature): bool
    {
        $this->feature = ucfirst($feature);

        // A Custom controller sharing a base controller's name would silently replace it
        if (collect([
            'app/Http/Controllers/'.$this->feature.'Controller.php',
            'app/Http/Controllers/Custom/'.$this->feature.'Controller.php',
        ])->contains(fn ($path) => Storage::disk('base')->exists($path))) {
            $this->error('Feature already exists, please use another name.');

            return false;
        }

        return true;
    }

    public function initializeStub($type)
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
        $this->stub = str_replace(
            ['{{ custom }}', '{{ views }}'],
            $this->option('base') ? ['', ''] : ['\Custom', 'site-specific.'],
            $this->stub
        );
    }

    /**
     * Folder to write to, with a trailing slash: the Custom subfolder unless --base.
     */
    public function custom(string $folder): string
    {
        return $folder.($this->option('base') ? '/' : '/Custom/');
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

    public function getPage(): string
    {
        return ($this->option('base') ? '' : 'Sitespecific').$this->feature;
    }

    public function getMenu()
    {
        return json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
    }
}
