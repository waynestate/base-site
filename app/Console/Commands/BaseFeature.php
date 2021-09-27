<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BaseFeature extends Command
{
    /**
     * @var string
     */
    protected $signature = 'base:feature {feature}';

    /**
     * @var string
     */
    protected $description = 'Scaffold out files for a new feature';

    /**
     * Scaffold files.
     */
    public function handle()
    {
        $this->setFeature($this->argument('feature'));

        $this->controller();
        $this->contract();
        $this->repository();
        $this->repositoryStyleguide();
        $this->menu();
        $this->page();
        $this->view();
        $this->factory();
    }

    public function controller()
    {
        $this->initializeStub('controller');
        $this->replaceContract();
        $this->replaceController();
        $this->replaceVariables();
        $this->stub = str_replace('Dummy Template', $this->feature.' Template', $this->stub);
        $this->stub = str_replace('DummyView', $this->getView(), $this->stub);

        Storage::disk('base')->put('app\Http\Controllers\/'.$this->feature.'Controller.php', $this->stub);
    }

    public function contract()
    {
        $this->initializeStub('contract');
        $this->replaceContract();
        $this->stub = str_replace('getDummys', 'get'.$this->feature.'s', $this->stub);
        $this->stub = str_replace('dummys', strtolower($this->feature).'s', $this->stub);

        Storage::disk('base')->put('contracts\Repositories\/'.$this->feature.'RepositoryContract.php', $this->stub);
    }

    public function repository()
    {
        $this->initializeStub('repository');
        $this->replaceContract();
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy()', 'get'.$this->feature.'s()', $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature).'s', $this->stub);

        Storage::disk('base')->put('app\Repositories\/'.$this->feature.'Repository.php', $this->stub);
    }

    public function repositoryStyleguide()
    {
        $this->initializeStub('repository-styleguide');
        $this->stub = str_replace('DummyRepository', $this->feature.'Repository', $this->stub);
        $this->stub = str_replace('getDummy()', 'get'.$this->feature.'s()', $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature).'s', $this->stub);
        $this->stub = str_replace('DummyFactory', $this->feature, $this->stub);

        Storage::disk('base')->put('styleguide\Repositories\/'.$this->feature.'Repository.php', $this->stub);
    }

    public function menu()
    {
        $menu = $this->getMenu();

        $item = end($menu[101]['submenu'][999]['submenu']);

        $item['menu_item_id']++;
        $item['page_id'] = $item['menu_item_id'];
        $item['display_name'] = $this->feature.'s';
        $item['relative_url'] = '/styleguide/'.strtolower($this->feature).'s';

        $menu[101]['submenu'][999]['submenu'][$item['menu_item_id']] = $item;

        Storage::disk('base')->put('styleguide/menu.json', json_encode($menu, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    }

    public function page()
    {
        $menu = $this->getMenu();

        $this->initializeStub('page');
        $this->replaceController();
        $this->stub = str_replace('DummyPage', $this->feature.'s', $this->stub);
        $this->stub = str_replace('DummyTitle', $this->feature.'s', $this->stub);
        $this->stub = str_replace('DummyId', end($menu[101]['submenu'])['menu_item_id'], $this->stub);

        Storage::disk('base')->put('styleguide\Pages\/'.$this->feature.'s.php', $this->stub);
    }

    public function view()
    {
        $this->initializeStub('view');
        $this->replaceVariables();

        Storage::disk('base')->put('resources\views\/'.$this->getView().'.blade.php', $this->stub);
    }

    public function factory()
    {
        $this->initializeStub('factory');
        $this->stub = str_replace('DummyFactory', $this->feature, $this->stub);

        Storage::disk('base')->put('factories\/'.$this->feature.'.php', $this->stub);
    }

    public function setFeature($feature)
    {
        $this->feature = ucfirst(rtrim($feature, 's'));

        if (Storage::disk('base')->exists('app\Http\Controllers\/'.$this->feature.'Controller.php')) {
            die($this->error('Feature already exists, please use another name.'));
        }
    }

    public function initializeStub($type)
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
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
            ['$dummy', '$this->dummy', '$dummys', '->getDummys'],
            ['$'.strtolower($this->feature), '$this->'.strtolower($this->feature), '$'.strtolower($this->feature).'s', '->get'.$this->feature.'s'],
            $this->stub
        );
    }

    public function getView()
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $this->feature)).'s';
    }

    public function getMenu()
    {
        return json_decode(Storage::disk('base')->get('styleguide/menu.json'), true);
    }
}
