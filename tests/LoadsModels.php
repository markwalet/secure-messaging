<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

trait LoadsModels
{
    /**
     * Get a list of all eloquent models.
     *
     * @return array|string[][]
     */
    public function models(): array
    {
        $files = new Filesystem();
        $paths = collect($files->allFiles(__DIR__ . '/../app/Models'));

        return $paths->filter(function (SplFileInfo $file) {
            return $file->getExtension() === 'php';
        })->map(function (SplFileInfo $file) {
            return 'App\\Models\\' . Str::substr($file->getRelativePathname(), 0, -4);
        })->filter(function (string $class) {
            return is_subclass_of($class, Model::class);
        })->map(function (string $class) {
            return [$class];
        })->toArray();
    }
}
