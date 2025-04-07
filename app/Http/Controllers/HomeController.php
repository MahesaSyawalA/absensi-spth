<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PenilaianKhusus;
use App\Models\PenilaianMasyarakat;
use App\Models\RekapanNilaiAkhir;
use App\Models\RekapanPenilaianBulanan;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    public function index()
    {
        $tahun = date('Y');
        $bulan = date('m');

        // Ambil data dari RekapanNilaiAkhir tanpa groupBy
        $rekapanNilaiAkhir = RekapanNilaiAkhir::with('user:id,nama,status_pegawai,foto')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        // Ambil top ASN
        $topAsn = $rekapanNilaiAkhir
            ->filter(fn($item) => $item->user && $item->user->status_pegawai === 'ASN')
            ->sortByDesc('nilai_akhir')
            ->take(1);

        // Ambil top Non ASN
        $topNonAsn = $rekapanNilaiAkhir
            ->filter(fn($item) => $item->user && $item->user->status_pegawai === 'Non ASN')
            ->sortByDesc('nilai_akhir')
            ->take(1);

        // dd($topNonAsn);

        $staffs = User::select('slug', 'nip', 'nama', 'jabatan', 'foto')->where('role', 'pegawai')->get();
        $data = [
            'staffs' => $staffs,
            'topAsn' => $topAsn->values(),
            'topNonAsn' => $topNonAsn->values(),
        ];
        return view('home', $data);
    }

    public function indexPenilaian($slug)
    {
        $selectedUser = User::select('nama', 'nip', 'jabatan', 'jenis_kelamin', 'status_pegawai', 'foto')->where('slug', $slug)->firstOrFail();
        $kriteriaWithSub = Kriteria::with('subKriteria')->get();
        $data = [
            'kriteriaWithSub' => $kriteriaWithSub,
            'selectedUser' => $selectedUser,
            'slug' => $slug,
        ];
        return view('penilaian', $data);
    }

    public function storePenilaian(Request $request)
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tujuan' => 'required|string|max:255',
            'pelayanan' => 'required|string|max:255',
            'subKriteria' => 'required|array',
            'subKriteria.*' => 'required|integer|min:10|max:50',
        ]);

        $selectedUser = User::select('id')->where('slug', $request->slug)->firstOrFail();

        $bulan = date('m');
        $tahun = date('Y');

        DB::beginTransaction();
        try {
            if ($role === 'penilai') {
                // Perhatikan perubahan di query ini: tambah where penilai_id
                $penilaian = PenilaianKhusus::where('user_id', $selectedUser->id)
                    ->where('penilai_id', $user->id)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                $data = [
                    'penilai_id' => $user->id,
                    'user_id' => $selectedUser->id,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'tujuan' => $request->tujuan,
                    'pelayanan' => $request->pelayanan,
                    'perilaku_petugas' => $request->subKriteria[5] ?? null,
                    'penampilan' => $request->subKriteria[6] ?? null,
                    'kecepatan_pelayanan' => $request->subKriteria[7] ?? null,
                    'ketepatan_transparansi' => $request->subKriteria[8] ?? null,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ];

                if ($penilaian) {
                    $penilaian->update($data);
                } else {
                    PenilaianKhusus::create($data);
                }
            } else {
                PenilaianMasyarakat::create([
                    'user_id' => $selectedUser->id,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'tujuan' => $request->tujuan,
                    'pelayanan' => $request->pelayanan,
                    'perilaku_petugas' => $request->subKriteria[5] ?? null,
                    'penampilan' => $request->subKriteria[6] ?? null,
                    'kecepatan_pelayanan' => $request->subKriteria[7] ?? null,
                    'ketepatan_transparansi' => $request->subKriteria[8] ?? null,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Penilaian berhasil disimpan'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function print(Request $request)
    {
        $bulanAwal = $request->input('bulan_awal');
        $bulanAkhir = $request->input('bulan_akhir');
        $tahun = date('Y');

        // Ambil data per bulan
        $penilaianPerBulan = RekapanNilaiAkhir::with('user')
            ->where('tahun', $tahun)
            ->whereBetween('bulan', [$bulanAwal, $bulanAkhir])
            ->get()
            ->groupBy('user_id'); // Kelompokkan berdasarkan user

        // Akumulasi nilai per user
        $penilaianTerkumpul = $penilaianPerBulan->map(function ($bulanUser) {
            $firstData = $bulanUser->first();

            return [
                'user' => $firstData->user,
                'total_nilai_absensi' => $bulanUser->sum('nilai_absensi'),
                'total_nilai_masyarakat' => $bulanUser->sum('nilai_masyarakat'),
                'total_nilai_penilai' => $bulanUser->sum('nilai_penilai'),
                'rata_nilai_akhir' => $bulanUser->avg('nilai_akhir'),
                'jumlah_bulan' => $bulanUser->count(),
                'detail_per_bulan' => $bulanUser // Jika perlu detail per bulan
            ];
        });

        // Ambil top ASN (dari nilai rata-rata)
        $topAsn = $penilaianTerkumpul
            ->filter(function ($item) {
                return $item['user'] && $item['user']->status_pegawai === 'ASN';
            })
            ->sortByDesc('rata_nilai_akhir')
            ->take(1);

        // Ambil top Non ASN (dari nilai rata-rata)
        $topNonAsn = $penilaianTerkumpul
            ->filter(function ($item) {
                return $item['user'] && $item['user']->status_pegawai === 'Non ASN';
            })
            ->sortByDesc('rata_nilai_akhir')
            ->take(1);

        $data = [
            'rekapPenilaianAkhir' => $penilaianTerkumpul->values(),
            'topAsn' => $topAsn->values(),
            'topNonAsn' => $topNonAsn->values(),
            'periode' => [
                'bulan_awal' => $bulanAwal,
                'bulan_akhir' => $bulanAkhir,
                'tahun' => $tahun
            ]
        ];

        $pdf = Pdf::loadView('print', $data);
        return $pdf->download('laporan-penilaian-' . $bulanAwal . '-' . $bulanAkhir . '-' . $tahun . '.pdf');
    }
}
