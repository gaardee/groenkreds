<?php

namespace Tests\Feature;

use App\Filament\Resources\Aktiviteter\Pages\CreateAktivitet;
use App\Filament\Resources\Kredse\Pages\CreateKreds;
use App\Filament\Resources\Kredse\Pages\EditKreds;
use App\Filament\Resources\Sider\Pages\CreatePage;
use App\Models\Aktivitet;
use App\Models\Kreds;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk();
    }

    public function test_public_registration_is_gone(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_resource_pages_render(): void
    {
        $this->actingAs(User::factory()->create());

        $kreds = Kreds::create(['key' => 'abc', 'navn' => 'FDF Testby']);
        Aktivitet::create(['type' => 2, 'title' => 'Genbrug', 'slug' => 'genbrug', 'ikon' => 'fas fa-recycle']);
        Page::create(['navn' => 'Om', 'slug' => 'om']);

        foreach (['/admin', '/admin/kredse', '/admin/aktiviteter', '/admin/sider', '/admin/brugere',
            '/admin/kredse/create', '/admin/aktiviteter/create', '/admin/sider/create', '/admin/brugere/create',
            "/admin/kredse/{$kreds->id}/edit"] as $url) {
            $this->get($url)->assertOk();
        }

        $this->get('/admin/kredse')->assertSee('FDF Testby');
        $this->get('/admin/aktiviteter')->assertSee('Genbrug');
    }

    public function test_new_kreds_gets_a_secret_key(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateKreds::class)
            ->fillForm(['navn' => 'Ny kreds', 'active' => true, 'latitude' => 55.5, 'longitude' => 9.5])
            ->call('create')
            ->assertHasNoFormErrors();

        $kreds = Kreds::where('navn', 'Ny kreds')->firstOrFail();
        $this->assertTrue($kreds->active);
        $this->assertNotEmpty($kreds->key);
    }

    public function test_kreds_can_be_updated(): void
    {
        $this->actingAs(User::factory()->create());
        $kreds = Kreds::create(['key' => 'abc', 'navn' => 'Gammel']);

        Livewire::test(EditKreds::class, ['record' => $kreds->getRouteKey()])
            ->fillForm(['navn' => 'Ny', 'kontakt_email' => 'x@example.com'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Ny', $kreds->refresh()->navn);
    }

    public function test_aktivitet_slug_is_generated_from_title(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateAktivitet::class)
            ->fillForm(['type' => 3, 'title' => 'Leg i skoven'])
            ->assertSchemaStateSet(['slug' => 'leg-i-skoven'])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('aktiviteter', ['slug' => 'leg-i-skoven', 'type' => 3]);
    }

    public function test_page_slug_cannot_shadow_app_routes(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreatePage::class)
            ->fillForm(['navn' => 'Admin', 'slug' => 'admin'])
            ->call('create')
            ->assertHasFormErrors(['slug']);
    }
}
