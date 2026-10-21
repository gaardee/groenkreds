<?php

namespace Tests\Feature;

use App\Models\Aktivitet;
use App\Models\Kreds;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    private function kreds(array $attributes = []): Kreds
    {
        return Kreds::create(array_merge([
            'key' => (string) Str::uuid(),
            'navn' => 'FDF Testby',
            'latitude' => 56.1,
            'longitude' => 10.2,
        ], $attributes));
    }

    private function aktivitet(array $attributes = []): Aktivitet
    {
        return Aktivitet::create(array_merge([
            'type' => 1,
            'title' => 'Plant et træ',
            'slug' => 'plant-et-trae',
            'ikon' => 'fas fa-tree',
            'indhold' => '<p>Indhold</p>',
        ], $attributes));
    }

    public function test_map_shows_only_active_kredse(): void
    {
        $this->kreds(['navn' => 'Aktiv kreds', 'active' => true]);
        $this->kreds(['navn' => 'Inaktiv kreds', 'active' => false]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Aktiv kreds')
            ->assertDontSee('Inaktiv kreds');

        $this->get('/kortet')->assertOk();
    }

    public function test_map_can_focus_a_kreds(): void
    {
        $kreds = $this->kreds(['active' => true]);

        $this->get(route('kortet.kreds', $kreds))->assertOk()->assertSee('kredsprop', false);
    }

    public function test_aktiviteter_list_and_detail(): void
    {
        $this->aktivitet();

        $this->get('/aktiviteter')->assertOk()->assertSee('Plant et træ');
        $this->get('/aktiviteter/plant-et-trae')->assertOk()->assertSee("modal('show')", false);
        $this->get('/aktiviteter/findes-ikke')->assertNotFound();
    }

    public function test_pages_are_listed_in_menu_and_rendered_by_slug(): void
    {
        Page::create(['navn' => 'Om os', 'slug' => 'om-os', 'content' => '<p>Velkommen</p>']);

        $this->get('/om-os')->assertOk()->assertSee('Velkommen', false);
        $this->get('/kortet')->assertSee(route('page', 'om-os'));
        $this->get('/findes-ikke')->assertNotFound();
    }

    public function test_menu_survives_a_serializing_cache_store(): void
    {
        config(['cache.default' => 'file']);
        Cache::flush();
        Page::create(['navn' => 'Om os', 'slug' => 'om-os']);

        $this->get('/kortet')->assertOk()->assertSee('Om os');
        $this->get('/kortet')->assertOk()->assertSee('Om os');

        Cache::flush();
    }

    public function test_page_cache_is_cleared_when_a_page_changes(): void
    {
        $this->get('/kortet')->assertDontSee('Ny side');

        Page::create(['navn' => 'Ny side', 'slug' => 'ny-side']);

        $this->get('/kortet')->assertSee('Ny side');
    }

    public function test_kreds_can_be_edited_with_its_secret_key(): void
    {
        Storage::fake('public');
        $kreds = $this->kreds();
        $aktivitet = $this->aktivitet();

        $this->get("/kreds/{$kreds->key}")->assertOk()->assertSee('FDF Testby');
        $this->get('/kreds/'.Str::uuid())->assertNotFound();

        $png = 'data:image/png;base64,'.base64_encode(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='));

        $this->put("/kreds/{$kreds->key}", [
            'motivation' => 'Vi vil passe på jorden',
            'kontakt_navn' => 'Anna',
            'kontakt_email' => 'anna@example.com',
            'aktiviteter' => [$aktivitet->id],
            'photos' => [$png],
        ])->assertRedirect(route('kreds.edit', $kreds->key));

        $kreds->refresh();
        $this->assertTrue($kreds->active);
        $this->assertSame('Vi vil passe på jorden', $kreds->motivation);
        $this->assertSame([$aktivitet->id], $kreds->aktiviteter->pluck('id')->all());
        $this->assertCount(1, $kreds->billeder);
        Storage::disk('public')->assertExists('photos/'.$kreds->billeder[0]);
    }

    public function test_old_nova_urls_redirect_to_admin(): void
    {
        $this->get('/nova')->assertRedirect('/admin');
        $this->get('/nova/resources/kredse')->assertRedirect('/admin');
    }
}
