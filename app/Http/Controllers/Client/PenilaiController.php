<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PenilaianKhusus;
use App\Models\RekapanNilaiAkhir;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaiController extends Controller
{
    public function index(){
        $penilaianAkhirQuery = RekapanNilaiAkhir::with(['user' => function ($query) {
            $query->select('id', 'nama', 'status_pegawai');
        }]);

        $penilaianAkhir = $penilaianAkhirQuery->orderByDesc('nilai_akhir')->get() ?? collect();

        $users = User::where('role', 'pegawai')
        ->select('id','slug', 'nama', 'nip', 'jabatan')
        ->with(['penilaianMasyarakat' => function ($query) {
            $query->select(
                'user_id',
                DB::raw('ROUND(AVG(avg_perilaku_petugas), 2) as avg_perilaku_petugas'),
                DB::raw('ROUND(AVG(avg_penampilan), 2) as avg_penampilan'),
                DB::raw('ROUND(AVG(avg_kecepatan_pelayanan), 2) as avg_kecepatan_pelayanan'),
                DB::raw('ROUND(AVG(avg_ketepatan_transparansi), 2) as avg_ketepatan_transparansi'),
                DB::raw('ROUND(AVG((avg_perilaku_petugas + avg_penampilan + avg_kecepatan_pelayanan + avg_ketepatan_transparansi) / 4), 2) as avg_total')
            )->groupBy('user_id');
        }])
        ->get();

        $userSession = Auth::user();

        $riwayatPenilaian = PenilaianKhusus::where('penilai_id',$userSession->id)->with(['user:id,nama,jabatan,status_pegawai'])->get();
        // dd($riwayatPenilaian);
        $data = [
            'title' => 'Penilaian',
            'users' => $users,
            'riwayatPenilaian' => $riwayatPenilaian,
            'penilaianAkhir' => $penilaianAkhir,
        ];
        return view('client.penilai.penilaian',$data);
    }
}
