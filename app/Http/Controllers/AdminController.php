<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ForumReport;
use App\Models\Tutor;

class AdminController extends Controller
{
    public function applications()
    {
        $pendingApps = DB::table('tutor_applications')
            ->join('users', 'users.id', '=', 'tutor_applications.user_id')
            ->select(
                'tutor_applications.*',
                'users.name',
                'users.email',
                'users.role'
            )
            ->where('tutor_applications.status', 'pending')
            ->latest()
            ->get();

        $approvedApps = DB::table('tutor_applications')
            ->join('users', 'users.id', '=', 'tutor_applications.user_id')
            ->select(
                'tutor_applications.*',
                'users.name',
                'users.email',
                'users.role'
            )
            ->where('tutor_applications.status', 'approved')
            ->latest()
            ->get();

        return view('admin.tutor_applications', compact(
            'pendingApps',
            'approvedApps'
        ));
    }

    public function approve($id){
        $app = DB::table('tutor_applications')->where('id', $id)->first();

        DB::table('users')
            ->where('id', $app->user_id)
            ->update(['role' => 'tutor']);

        DB::table('tutor_applications')
            ->where('id', $id)
            ->update(['status' => 'approved']);

        Tutor::create([
            'user_id' => $app->user_id,

            'tps' => $app->tps,
            'literasi' => $app->literasi,
            'numerasi' => $app->numerasi,

            'bio' => '',
            'rating' => 0,
            'total_reviews' => 5,
        ]);

        return back();
    }

    public function reject($id)
    {
        DB::table('tutor_applications')
            ->where('id', $id)
            ->update([
                'status' => 'rejected'
            ]);

        return back()->with(
            'success_message',
            'Pengajuan tutor berhasil ditolak.'
        );
    /**
     * Daftar report diskusi (thread) & balasan (reply) yang masuk dari user.
     * Dikelompokkan per konten yang dilaporkan, biar kalau satu thread
     * dilaporkan 3 user, admin cuma lihat 1 kartu dengan 3 alasan.
     */
    public function reports()
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $reports = ForumReport::with(['user', 'reportable.user'])
            ->latest()
            ->get()
            // Konten yang reportable-nya udah gak ada (misal udah dihapus manual) di-skip
            ->filter(fn (ForumReport $report) => $report->reportable !== null)
            ->groupBy(fn (ForumReport $report) => $report->reportable_type.':'.$report->reportable_id);

        return view('admin.reports', compact('reports'));
    }

    /**
     * Hapus konten (thread/reply) yang dilaporkan. Report yang nempel
     * ikut terhapus otomatis lewat trait Reportable pas model-nya di-delete.
     */
    public function destroyReportedContent(ForumReport $report)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $content = $report->reportable;

        if ($content) {
            $content->delete();
        }

        return back()->with('success', 'Konten yang dilaporkan berhasil dihapus.');
    }

    /**
     * Abaikan report (report palsu/gak valid). Konten TIDAK dihapus,
     * cuma semua report yang nempel ke konten itu yang dibersihkan
     * biar gak numpuk terus di halaman report.
     */
    public function dismissReports(ForumReport $report)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $content = $report->reportable;

        if ($content) {
            $content->reports()->delete();
        } else {
            // Reportable-nya udah gak ada (kasus jarang), tinggal hapus report yatim ini aja
            $report->delete();
        }

        return back()->with('success', 'Report berhasil diabaikan.');
    }
}
