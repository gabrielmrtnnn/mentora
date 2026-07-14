<?php

namespace Tests\Feature;

use App\Models\ForumReply;
use App\Models\ForumReport;
use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumModerationSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_delete_own_thread(): void
    {
        $owner = User::factory()->create();
        $thread = ForumThread::create(['user_id' => $owner->id, 'category' => 'diskusi umum', 'title' => 'T', 'body' => 'B']);

        $this->actingAs($owner)
            ->delete(route('forum.thread.destroy', $thread->id))
            ->assertRedirect(route('forum'));

        $this->assertDatabaseMissing('forum_threads', ['id' => $thread->id]);
    }

    public function test_non_owner_cannot_delete_thread(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $thread = ForumThread::create(['user_id' => $owner->id, 'category' => 'diskusi umum', 'title' => 'T', 'body' => 'B']);

        $this->actingAs($other)
            ->delete(route('forum.thread.destroy', $thread->id))
            ->assertForbidden();

        $this->assertDatabaseHas('forum_threads', ['id' => $thread->id]);
    }

    public function test_admin_can_delete_others_reply(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $thread = ForumThread::create(['user_id' => $owner->id, 'category' => 'diskusi umum', 'title' => 'T', 'body' => 'B']);
        $reply = ForumReply::create(['forum_thread_id' => $thread->id, 'user_id' => $owner->id, 'body' => 'R']);

        $this->actingAs($admin)
            ->delete(route('forum.reply.destroy', $reply->id))
            ->assertRedirect(route('forum.show', $thread->id));

        $this->assertDatabaseMissing('forum_replies', ['id' => $reply->id]);
    }

    public function test_user_can_report_thread_but_not_twice(): void
    {
        $owner = User::factory()->create();
        $reporter = User::factory()->create();
        $thread = ForumThread::create(['user_id' => $owner->id, 'category' => 'diskusi umum', 'title' => 'T', 'body' => 'B']);

        $this->actingAs($reporter)
            ->post(route('forum.report'), ['type' => 'thread', 'id' => $thread->id, 'reason' => 'spam'])
            ->assertRedirect();

        $this->assertDatabaseCount('forum_reports', 1);

        // report kedua ke konten yang sama harus ditolak dengan sopan (bukan crash 500)
        $this->actingAs($reporter)
            ->post(route('forum.report'), ['type' => 'thread', 'id' => $thread->id, 'reason' => 'spam'])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseCount('forum_reports', 1);
    }

    public function test_user_cannot_report_own_thread(): void
    {
        $owner = User::factory()->create();
        $thread = ForumThread::create(['user_id' => $owner->id, 'category' => 'diskusi umum', 'title' => 'T', 'body' => 'B']);

        $this->actingAs($owner)
            ->post(route('forum.report'), ['type' => 'thread', 'id' => $thread->id, 'reason' => 'spam'])
            ->assertStatus(422);
    }

    public function test_admin_reports_page_renders_and_delete_works(): void
    {
        $owner = User::factory()->create();
        $reporter = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $thread = ForumThread::create(['user_id' => $owner->id, 'category' => 'diskusi umum', 'title' => 'Judul Dilaporkan', 'body' => 'Isi']);
        $report = $thread->reports()->create(['user_id' => $reporter->id, 'reason' => 'spam', 'description' => 'contoh']);

        $this->actingAs($admin)
            ->get(route('admin.reports'))
            ->assertOk()
            ->assertSee('Judul Dilaporkan')
            ->assertSee('1 laporan');

        $this->actingAs($admin)
            ->delete(route('admin.reports.destroy', $report->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('forum_threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('forum_reports', ['id' => $report->id]);
    }

    public function test_non_admin_cannot_access_admin_reports_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.reports'))
            ->assertForbidden();
    }

    public function test_admin_can_dismiss_report_without_deleting_content(): void
    {
        $owner = User::factory()->create();
        $reporter = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $thread = ForumThread::create(['user_id' => $owner->id, 'category' => 'diskusi umum', 'title' => 'T', 'body' => 'B']);
        $report = $thread->reports()->create(['user_id' => $reporter->id, 'reason' => 'spam']);

        $this->actingAs($admin)
            ->post(route('admin.reports.dismiss', $report->id))
            ->assertRedirect();

        // Konten tetap ada
        $this->assertDatabaseHas('forum_threads', ['id' => $thread->id]);

        // Report-nya udah gak ada lagi, jadi gak numpuk di halaman report
        $this->assertDatabaseMissing('forum_reports', ['id' => $report->id]);
    }
}
