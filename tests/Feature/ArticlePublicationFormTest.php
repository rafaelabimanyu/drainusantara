<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlePublicationFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_unchecked_create_stays_unchecked_after_failed_validation(): void
    {
        $this->actingAs(User::factory()->create());
        $url = route('admin.articles.create');
        $this->assertChecked($this->get($url)->assertOk()->getContent(), true);
        $this->from($url)->post(route('admin.articles.store'), ['title' => 'Draft', 'content' => ''])
            ->assertRedirect($url)->assertSessionHasErrors('content');
        $this->assertChecked($this->get($url)->assertOk()->getContent(), false);
    }

    public function test_unchecked_edit_stays_unchecked_after_failed_validation(): void
    {
        $this->actingAs(User::factory()->create());
        $article = Article::create([
            'title' => 'Published', 'slug' => 'published', 'content' => 'Isi',
            'is_published' => true, 'published_at' => now(),
        ]);
        $url = route('admin.articles.edit', $article);
        $this->assertChecked($this->get($url)->assertOk()->getContent(), true);
        $this->from($url)->put(route('admin.articles.update', $article), ['title' => 'Draft', 'content' => ''])
            ->assertRedirect($url)->assertSessionHasErrors('content');
        $this->assertChecked($this->get($url)->assertOk()->getContent(), false);
        $this->assertTrue($article->fresh()->is_published);
    }

    public function test_checked_create_stays_checked_after_failed_validation(): void
    {
        $this->actingAs(User::factory()->create());
        $url = route('admin.articles.create');
        $this->from($url)->post(route('admin.articles.store'), ['title' => 'Publish', 'content' => '', 'is_published' => '1'])
            ->assertRedirect($url)->assertSessionHasErrors('content');
        $this->assertChecked($this->get($url)->assertOk()->getContent(), true);
    }

    private function assertChecked(string $html, bool $expected): void
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $input = (new \DOMXPath($dom))->query('//input[@type="checkbox" and @name="is_published"]');
        $this->assertCount(1, $input);
        $this->assertSame($expected, $input->item(0)->hasAttribute('checked'));
    }
}
