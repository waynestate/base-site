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
    }

    public function controller()
    {
        $this->initializeStub('controller');
        $this->replaceContract();
        $this->stub = str_replace('Dummy Template', $this->feature.' Template', $this->stub);
        $this->stub = str_replace('DummyController', $this->feature.'Controller', $this->stub);
        $this->stub = str_replace(
            ['$dummy', '$this->dummy', '$dummys', '$this->getDummys'],
            ['$'.strtolower($this->feature), '$this->'.strtolower($this->feature), '$'.strtolower($this->feature).'s', '$this->get'.ucfirst(strtolower($this->feature)).'s'],
            $this->stub
        );
        $this->stub = str_replace('DummyView', strtolower($this->feature), $this->stub);

        Storage::disk('base')->put('app\Http\Controllers\/'.$this->feature.'Controller.php', $this->stub);
    }

    public function contract()
    {
        $this->initializeStub('contract');
        $this->replaceContract();
        $this->stub = str_replace('getDummys', 'get'.ucfirst(strtolower($this->feature)).'s', $this->stub);
        $this->stub = str_replace('dummys', strtolower($this->feature).'s', $this->stub);

        Storage::disk('base')->put('contracts\Repositories\/'.$this->feature.'RepositoryContract.php', $this->stub);
    }

    public function repository()
    {
        $this->initializeStub('repository');
        $this->replaceContract();
        $this->stub = str_replace('DummyRepository', ucfirst($this->feature).'Repository', $this->stub);
        $this->stub = str_replace('getDummy()', 'get'.ucfirst(strtolower($this->feature)).'s()', $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature).'s', $this->stub);

        Storage::disk('base')->put('app\Repositories\/'.ucfirst($this->feature).'Repository.php', $this->stub);
    }

    public function repositoryStyleguide()
    {
        $this->initializeStub('repository-styleguide');
        $this->stub = str_replace('DummyRepository', ucfirst($this->feature).'Repository', $this->stub);
        $this->stub = str_replace('getDummy()', 'get'.ucfirst(strtolower($this->feature)).'s()', $this->stub);
        $this->stub = str_replace('dummy', strtolower($this->feature).'s', $this->stub);

        Storage::disk('base')->put('styleguide\Repositories\/'.ucfirst($this->feature).'Repository.php', $this->stub);
    }

    public function setFeature($feature)
    {
        $this->feature = $feature;
    }

    public function initializeStub($type)
    {
        $this->stub = Storage::disk('base')->get('stubs/'.$type.'.stub');
    }

    public function replaceContract()
    {
        $this->stub = str_replace('DummyRepositoryContract', $this->feature.'RepositoryContract', $this->stub);
    }
}
