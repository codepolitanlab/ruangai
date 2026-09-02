<?php

namespace App\Pages\page;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Detail Halaman',
        'module'     => 'page',
        'active_page' => 'page',
        'body_class' => 'rd-dashboard-page',
    ];

    /**
     * GET page/supply/{slug} — halaman statis menu Akun atau post dinamis.
     */
    public function getSupply($slug = null)
    {
        // Halaman statis dari menu Akun (tabel mein_posts tidak tersedia di DB ini)
        $static = $this->staticPages();

        if (isset($static[$slug])) {
            return $this->respond(['page' => $static[$slug]]);
        }

        // Fallback: post dinamis (jika tabel mein_posts ada di lingkungan lain)
        $db = \Config\Database::connect();
        $data['page'] = null;

        if ($db->tableExists('mein_posts')) {
            $data['page'] = $db->table('mein_posts')
                ->where('type', 'page')
                ->where('slug', $slug)
                ->where('status', 'publish')
                ->get()
                ->getRowArray();
        }

        return $this->respond($data);
    }

    /**
     * Konten statis untuk menu Akun. TODO: isi data kontak asli di app/Config/Site.php.
     */
    private function staticPages(): array
    {
        $site = config('Site');

        $email   = $site->email ?: 'support@ruangai.id';
        $phone   = $site->phone ?: '+62 812-3456-7890';
        $address = $site->address ?: '';

        return [
            'about-app' => [
                'title'   => 'Tentang Aplikasi',
                'content' => '<h2>RuangAI</h2>
<p>RuangAI adalah platform pembelajaran AI online yang membantu Anda menguasai keterampilan digital melalui berbagai program unggulan: kelas online, beasiswa, bootcamp, kelas live, hingga tantangan (challenge).</p>
<p>Kami percaya setiap orang berhak mengakses pendidikan berkualitas. Melalui RuangAI Anda dapat belajar dengan kurikulum terstruktur, didampingi mentor berpengalaman, dan memperoleh pengakuan resmi berupa sertifikat.</p>
<h3>Program Unggulan</h3>
<ul>
<li><b>Kelas Online</b> — materi modul yang bisa dipelajari kapan saja dan di mana saja.</li>
<li><b>Live Session</b> — pertemuan langsung bersama instruktur untuk praktik dan tanya jawab.</li>
<li><b>Bootcamp</b> — program intensif berbasis proyek nyata.</li>
<li><b>Beasiswa</b> — kesempatan belajar bagi yang memenuhi syarat.</li>
<li><b>Sertifikat</b> — tanda kelulusan yang dapat diklaim setelah menyelesaikan kelas.</li>
</ul>',
            ],
            'contact-us' => [
                'title'   => 'Kontak Kami',
                'content' => '<h2>Kontak Kami</h2>
<p>Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda.</p>
<div class="contact-row"><i class="bi bi-envelope"></i><div><b>Email</b><span>' . esc($email) . '</span></div></div>
<div class="contact-row"><i class="bi bi-whatsapp"></i><div><b>WhatsApp</b><span>' . esc($phone) . '</span></div></div>
' . ($address ? '<div class="contact-row"><i class="bi bi-geo-alt"></i><div><b>Alamat</b><span>' . esc($address) . '</span></div></div>' : '') . '
<p style="margin-top:14px">Jam operasional: Senin – Jumat, pukul 09.00 – 17.00 WIB.</p>',
            ],
            'tnc' => [
                'title'   => 'Syarat dan Ketentuan',
                'content' => '<h2>Syarat dan Ketentuan</h2>
<p>Dengan menggunakan aplikasi RuangAI, Anda dianggap telah membaca, memahami, dan menyetujui seluruh ketentuan berikut.</p>
<h3>1. Akun Pengguna</h3>
<ul>
<li>Anda bertanggung jawab menjaga kerahasiaan akun dan kata sandi.</li>
<li>Informasi yang diberikan saat pendaftaran harus benar dan dapat dipertanggungjawabkan.</li>
</ul>
<h3>2. Penggunaan Layanan</h3>
<ul>
<li>Konten materi bersifat pribadi dan tidak boleh dibagikan atau diperjualbelikan tanpa izin.</li>
<li>Dilarang menggunakan layanan untuk tujuan yang melanggar hukum.</li>
</ul>
<h3>3. Pembayaran</h3>
<ul>
<li>Seluruh transaksi pembayaran mengikuti mekanisme yang berlaku di aplikasi.</li>
<li>Pengembalian dana (refund) mengikuti kebijakan yang diatur terpisah.</li>
</ul>
<h3>4. Sertifikat</h3>
<ul>
<li>Sertifikat diterbitkan setelah Anda memenuhi syarat kelulusan kelas.</li>
</ul>',
            ],
            'privacy' => [
                'title'   => 'Kebijakan Privasi',
                'content' => '<h2>Kebijakan Privasi</h2>
<p>RuangAI menghargai privasi Anda. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda.</p>
<h3>Data yang Kami Kumpulkan</h3>
<ul>
<li>Data pendaftaran: nama, email, dan nomor telepon.</li>
<li>Data penggunaan: progres belajar, hasil tugas, dan aktivitas pada aplikasi.</li>
</ul>
<h3>Penggunaan Data</h3>
<ul>
<li>Memproses pendaftaran dan keanggotaan.</li>
<li>Menampilkan progres dan menerbitkan sertifikat.</li>
<li>Mengirim informasi terkait layanan.</li>
</ul>
<h3>Perlindungan Data</h3>
<ul>
<li>Data Anda disimpan dengan standar keamanan yang memadai.</li>
<li>Kami tidak menjual data pribadi Anda kepada pihak ketiga.</li>
</ul>',
            ],
        ];
    }
}
