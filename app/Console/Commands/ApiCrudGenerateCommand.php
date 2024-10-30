<?php

namespace App\Console\Commands;

use App\Helper\Generator\Configurator;
use ErrorException;
use Illuminate\Console\Command;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ApiCrudGenerateCommand extends Command
{
    private const CRUD_FILES_PATH = 'generators.crud.';
    private const RESOURCE_FILE_PATH = 'generators.resource';
    private const REQUEST_FILE_PATH = 'generators.request';
    private const ROUTES_FILE_PATH = 'generators.routes';
    private const MIGRATION_FILE_PATH = 'generators.migration';
    private const MODEL_FILE_PATH = 'generators.model';
    private const RESOURCE_PATH = 'app/Http/Resources/';
    private const REQUESTS_PATH = 'app/Http/Requests/';
    private const MODEL_PATH = 'app/Models/';

    private array $properties = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crud:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $entityName = $this->ask('Entity name: ');
        $this->defineProperties();
        $apiPath = $this->ask('API Route: ', sprintf('/api/v1/%ss', strtolower($entityName)));

        $controllerLocation = $this->ask('Controller file location?', sprintf('app/Http/Controllers/Api/V1/%s', $entityName));
        $controllerNamespace = $this->ask('Controller namespace?', str_replace('/', '\\', str_replace('app', 'App', (string) $controllerLocation)));
        $isAuth = strtolower($this->ask('Should use Sanctum Auth?', 'y')) === 'y';

        $entityData = [
            'entityName' => ucfirst($entityName),
            'entityNamespace' => 'App\Models',
            'controllerNamespace' => $controllerNamespace,
            'controllerLocation' => $controllerLocation,
            'apiPath' => $apiPath,
            'isAuth' => $isAuth,
            'properties' => $this->properties,
        ];

        $templates = $this->getTemplates();

        foreach ($templates as $key => $template) {
            $generate = strtolower($this->ask(sprintf('Do you need %s? (y/n)', $template['name']), 'y')) === 'y';
            if (! $generate) {
                unset($templates[$key]);
            }
        }

        $this->generate($templates, $entityData);

        $this->output->note('Done');

        return Command::SUCCESS;
    }

    private function generate(array $templates, array $entityData): void
    {
        $this->createModel($entityData);
        $this->createMigration($entityData);

        $this->createResource($entityData);
        $this->createRequest($entityData);

        $this->createControllers($templates, $entityData);
        $this->createRoutes($templates, $entityData);
    }

    private function defineProperties(): void
    {
        $this->output->note('Leave empty to exit');
        $property = $this->ask('Property: ');

        if (! $property) {
            return;
        }

        $propertyType = $this->definePropertyType();

        $isNullable = strtolower($this->ask('Is nullable', 'n')) === 'y';

        $isUnique = false;
        if (! $isNullable) {
            $isUnique = strtolower($this->ask('Is unique', 'n')) === 'y';
        }

        $propertyTypes = Configurator::getPropertyTypesOptions();

        $this->properties[$property] = [
            'type' => $propertyType,
            'nullable' => $isNullable,
            'unique' => $isUnique,
            'swagger' => [
                'value' => $propertyTypes[$propertyType]['value'],
                'format' => $propertyTypes[$propertyType]['format'],
                'isString' => $propertyTypes[$propertyType]['isString'],
            ],
        ];

        $this->defineProperties();
    }

    private function definePropertyType(): string
    {
        $questionHelper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            'Select property type :',
            array_keys(Configurator::getPropertyTypesOptions())
        );

        return $questionHelper->ask($this->input, $this->output, $question);
    }

    private function createModel(array $entityData): void
    {
        $filePath = self::MODEL_PATH . $entityData['entityName'] . '.php';
        $content = view(self::MODEL_FILE_PATH, $entityData)->render();

        $this->createFile($filePath, $content);
    }

    private function createMigration(array $entityData): void
    {
        $fileName = (new \DateTime('now'))->format('Y_m_d_His') . '_create_' . strtolower($entityData['entityName']) . 's_table.php';
        $filePath = database_path('migrations') . '/' . $fileName;
        $content = view(self::MIGRATION_FILE_PATH, $entityData)->render();

        $this->createFile($filePath, $content);
    }

    private function createResource(array $entityData): void
    {
        if (! is_dir(self::RESOURCE_PATH) && ! mkdir(self::RESOURCE_PATH)) {
            throw new ErrorException('Could not create ' . self::RESOURCE_PATH);
        }

        $filePath = self::RESOURCE_PATH . $entityData['entityName'] . 'Resource.php';
        $content = view(self::RESOURCE_FILE_PATH, $entityData)->render();

        $this->createFile($filePath, $content);
    }

    private function createRequest(array $entityData): void
    {
        if (! is_dir(self::REQUESTS_PATH) && ! mkdir(self::REQUESTS_PATH)) {
            throw new ErrorException('Could not create ' . self::REQUESTS_PATH);
        }

        $filePath = self::REQUESTS_PATH . $entityData['entityName'] . 'Request.php';
        $content = view(self::REQUEST_FILE_PATH, $entityData)->render();

        $this->createFile($filePath, $content);
    }

    private function createRoutes(array $templates, array $entityData): void
    {
        $apiRoutes = base_path() . '/routes/api.php';
        $content = PHP_EOL . view(self::ROUTES_FILE_PATH, [
            'entityData' => $entityData,
            'templates' => $templates,
            ])->render();

        $this->createFile($apiRoutes, $content);
    }

    private function createControllers(array $templates, array $entityData): void
    {
        $folderPath = $entityData['controllerLocation'];

        if (! is_dir($folderPath) && ! mkdir($folderPath)) {
            throw new ErrorException('Could not create ' . $folderPath);
        }

        foreach ($templates as $template) {
            $fileName = str_replace(self::CRUD_FILES_PATH, '', $template['file']);
            $filePath = $entityData['controllerLocation'] . '/' . $fileName . $entityData['entityName'] . '.php';
            $content = view($template['file'], $entityData)->render();

            $this->createFile($filePath, $content);
        }
    }

    private function createFile(string $filePath, string $content): void
    {
        file_put_contents($filePath, $content, FILE_APPEND)
            ? $this->output->success('File ' . $filePath . ' created/updated')
            : $this->output->error('Could not create/update file ' . $filePath);
    }

    private function getTemplates(): array
    {
        return [
            'C' => [
                'file' => self::CRUD_FILES_PATH . 'Create',
                'name' => '(C)reate',
            ],
            'R' => [
                'file' => self::CRUD_FILES_PATH . 'Retrieve',
                'name' => '(R)etrieve',
            ],
            'U' => [
                'file' => self::CRUD_FILES_PATH . 'Update',
                'name' => '(U)pdate',
            ],
            'D' => [
                'file' => self::CRUD_FILES_PATH . 'Delete',
                'name' => '(D)elete',
            ],
            'L' => [
                'file' => self::CRUD_FILES_PATH . 'RetrieveCollection',
                'name' => '(L)isting with sorting',
            ],
        ];
    }
}
