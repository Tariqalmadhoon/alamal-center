<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class MediaRouteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_it_serves_media_files_from_public_disk(): void
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/q6sAAAAASUVORK5CYII=');
        $path = 'tests-media/test.png';
        Storage::disk('public')->put($path, $png);

        $response = $this->get('/media/'.$path);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/png');

        Storage::disk('public')->delete($path);
    }

    public function test_it_returns_404_for_missing_media_file(): void
    {
        $this->get('/media/tests-media/missing.png')->assertNotFound();
    }
}
