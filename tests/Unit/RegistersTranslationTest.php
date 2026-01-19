<?php

use App\Utils\Traits\RegistersTranslation;

uses(Tests\TestCase::class);

it('loads translations from resource lang when module lang exists', function () {
    $name = 'DummyModule';
    $nameLower = 'dummymodule';

    // create a fake resource lang dir
    $langPath = resource_path('lang/modules/'.$nameLower);
    if (! is_dir($langPath)) {
        mkdir($langPath, 0755, true);
    }

    // create a dummy file to ensure directory exists
    file_put_contents($langPath.'/en.json', json_encode(['key' => 'value']));

    // Create a small object that uses the trait and records calls
    $obj = new class($name, $nameLower) {
        use RegistersTranslation;

        public array $calls = [];

        public function __construct(public string $name, public string $nameLower) {}

        public function loadTranslationsFrom($path, $namespace): void
        {
            $this->calls[] = ['type' => 'load', 'path' => $path, 'namespace' => $namespace];
        }

        public function loadJsonTranslationsFrom($path): void
        {
            $this->calls[] = ['type' => 'json', 'path' => $path];
        }
    };

    $obj->registerTranslations();

    // assert that both methods were called with the resource path
    $loadCalled = collect($obj->calls)->firstWhere('type', 'load');
    $jsonCalled = collect($obj->calls)->firstWhere('type', 'json');

    expect($loadCalled)->not->toBeNull();
    expect($loadCalled['path'])->toBe($langPath);
    expect($loadCalled['namespace'])->toBe($nameLower);

    expect($jsonCalled)->not->toBeNull();
    expect($jsonCalled['path'])->toBe($langPath);

    // cleanup
    @unlink($langPath.'/en.json');
    @rmdir($langPath);
    @rmdir(dirname($langPath));
});
