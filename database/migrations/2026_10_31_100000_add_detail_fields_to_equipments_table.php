<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations without resetting existing data.
     */
    public function up(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            if (!Schema::hasColumn('equipments', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('equipments', 'description')) {
                $table->longText('description')->nullable()->after('short_description');
            }
            if (!Schema::hasColumn('equipments', 'features')) {
                $table->text('features')->nullable()->after('specs');
            }
            if (!Schema::hasColumn('equipments', 'applications')) {
                $table->text('applications')->nullable()->after('features');
            }
            if (!Schema::hasColumn('equipments', 'safety_k3')) {
                $table->text('safety_k3')->nullable()->after('applications');
            }
        });

        // Safe backfill for existing equipment records
        $equipments = DB::table('equipments')->get();
        $usedSlugs = [];

        foreach ($equipments as $item) {
            $baseSlug = Str::slug($item->name);
            $slug = $baseSlug ?: 'alat-' . $item->id;
            if (in_array($slug, $usedSlugs, true)) {
                $slug = $slug . '-' . $item->id;
            }
            $usedSlugs[] = $slug;

            $updateData = [];
            if (empty($item->slug)) {
                $updateData['slug'] = $slug;
            }

            // Rich technical data backfill for default equipment units
            if (empty($item->description)) {
                if (str_contains(strtolower($item->name), 'k-50') || str_contains(strtolower($item->name), 'rooter')) {
                    $updateData['description'] = "Mesin drain cleaner Ridgid K-50 & K-60 merupakan tulang punggung armada Drainusantara untuk penanganan saluran pipa mampet residensial dan komersial. Beroperasi secara mekanis murni tanpa bahan kimia soda api, mesin ini memutar kabel spiral baja karbon berkecepatan 400 RPM dengan torsi adaptif.\n\nKabel spiral lentur mampu meluncur mulus melewati sambungan belokan leher angsa (sifon P-trap) dan elbow 90 derajat tanpa mengikis atau melubangi dinding pipa PVC. Putaran spiral efektif mengikis kerak lemak beku, merajut dan menarik keluar gumpalan rambut, serta menghancurkan endapan sisa makanan hingga diameter pipa kembali ke kapasitas aliran optimal 100%.";
                    $updateData['features'] = json_encode([
                        'Motor penggerak elektrik 220V bertenaga tinggi dengan putaran stabil 400 RPM',
                        'Kabel spiral baja karbon tempa modular ukuran 16mm dan 22mm anti-kinking',
                        'Sistem kopling aksi instan: kabel berhenti berputar begitu tuas dilepas untuk keamanan pipa',
                        'Jangkauan modular fleksibel hingga 30 meter menembus pipa bawah lantai dan dak beton',
                        'Dapat dipasangi berbagai mata pisau pemotong (Bulb Auger, Grease Cutter, Spade Cutter)',
                    ]);
                    $updateData['applications'] = json_encode([
                        'Saluran pembuangan wastafel & bak cuci piring dapur (sink) mampet minyak',
                        'Kloset duduk & jongkok tersumbat tisu basah, pembalut, atau benda lunak',
                        'Floor drain kamar mandi menggenang akibat jeratan rambut rontok dan buih sabun',
                        'Saluran pipa talang hujan vertikal dan pipa pembuangan dak rooftop',
                        'Pipa instalasi saluran air kotor ruko, restoran, kafe, dan perkantoran',
                    ]);
                    $updateData['safety_k3'] = "Teknisi Drainusantara wajib mengenakan sarung tangan kulit khusus anti-lilit spiral, kacamata pelindung (goggles), dan cover sepatu higienis. Mesin dilengkapi kabel grounding pengaman kelistrikan untuk mencegah kebocoran arus di area basah.";
                } elseif (str_contains(strtolower($item->name), 'cctv') || str_contains(strtolower($item->name), 'kamera')) {
                    $updateData['description'] = "Kamera Endoskopi CCTV Pipa IP68 30M adalah instrumen diagnostik visual presisi tinggi milik Drainusantara untuk menginvestigasi saluran pipa air kotor yang sering mampet berulang tanpa harus menebak titik kerusakan.\n\nKepala kamera berukuran ringkas dilengkapi sensor HD 1080P, lensa safir anti-gores, dan 12 titik LED sorot tahan air. Terhubung ke kabel dorong fiberglass 30 meter yang kaku namun lentur, kamera ini mampu masuk ke dalam pipa diameter 2 hingga 8 inci dan menampilkan rekaman realtime pada monitor kontrol LCD.";
                    $updateData['features'] = json_encode([
                        'Kepala kamera kedap air standar IP68 Submersible tahan tekanan lumpur dan genangan',
                        'Lensa safir optik kristal anti-gores dengan 12 lampu LED sorot adjustable brightness',
                        'Kabel dorong push-rod fiberglass tahan tekuk sepanjang 30 meter berpenghitung meter digital',
                        'Layar monitor display digital HD dengan fitur perekaman video inspeksi MP4 dan foto',
                        'Memverifikasi titik pipa pecah, sambungan lepas, kemiringan kurang (back-slope), atau akar pohon',
                    ]);
                    $updateData['applications'] = json_encode([
                        'Investigasi saluran pipa tertanam di bawah lantai rumah yang sering mampet berulang',
                        'Pemeriksaan titik kebocoran pipa buangan yang merembes ke dinding atau plafon tetangga',
                        'Deteksi intrusi akar pohon yang menembus sambungan pipa drainase luar ruangan',
                        'Dokumentasi pra-kerja dan pasca-kerja untuk verifikasi kebersihan saluran pipa klien B2B',
                    ]);
                    $updateData['safety_k3'] = "Unit kamera selalu disterilkan dan didesinfeksi sebelum dan sesudah masuk ke pipa pembuangan. Seluruh koneksi kabel sinyal memiliki pelindung ganda kedap air berstandar IP68.";
                } elseif (str_contains(strtolower($item->name), 'hydro') || str_contains(strtolower($item->name), 'jetting')) {
                    $updateData['description'] = "Unit High-Pressure Hydro Jetting Drainusantara dirancang khusus untuk pencucian saluran pipa berskala berat pada restoran, food court, ruko, dan pabrik pengolahan makanan. Menggunakan prinsip semburan air mikro bertekanan variabel 100 hingga 200 bar.\n\nNozel jetting khusus memiliki semburan maju untuk menembus sumbatan dan semburan mundur berkecepatan tinggi yang mendorong selang maju sekaligus membilas bersih kerak lemak padat, lumpur semen, dan residu kimiawi hingga ke dinding pipa PVC.";
                    $updateData['features'] = json_encode([
                        'Tekanan air bertenaga tinggi 100 sampai 200 Bar dengan pompa triplex plunger heavy-duty',
                        'Nozel putar rotary jetter dan nozel retro-jet dengan daya dorong mandiri',
                        'Membersihkan minyak jenuh dan kerak minyak goreng beku hingga 100% tuntas',
                        'Metode 100% ramah lingkungan (eco-friendly) murni tekanan air tanpa zat kimia korosif',
                        'Panjang selang termoplastik tahan gesek hingga 50 meter',
                    ]);
                    $updateData['applications'] = json_encode([
                        'Pipa pembuangan dapur utama restoran cepat saji, hotel, kafe, dan katering',
                        'Saluran grease trap menuju bak kontrol akhir yang mengalami pengendapan lemak beku',
                        'Pipa got tertutup komplek hunian yang dipenuhi sedimen pasir dak dan lumpur padat',
                        'Pembersihan preventif berkala (kontrak perawatan) industri F&B dan komersial',
                    ]);
                    $updateData['safety_k3'] = "Wajib dioperasikan oleh 2 teknisi bersertifikat dengan APD lengkap: face shield, sarung tangan anti-slip tebal, dan sepatu boots tahan tekanan tinggi.";
                } elseif (str_contains(strtolower($item->name), 'cutter') || str_contains(strtolower($item->name), 'mata')) {
                    $updateData['description'] = "Set Mata Pemotong Spiral Baja Modular Drainusantara terdiri dari 4 varian kepala cutter baja karbon tempa berdesain khusus. Setiap kepala pisau memiliki geometri unik untuk menghadapi jenis sumbatan spesifik tanpa risiko merusak dinding bagian dalam pipa paralon.\n\nDipasang pada ujung kabel spiral Ridgid dengan sistem pengunci quick-connect berpegas ganda, mata pisau berputar dengan kecepatan tinggi untuk melilit rambut, mengikis lemak membandel, meratakan semen lunak, hingga memotong akar pohon yang menerobos ke dalam pipa.";
                    $updateData['features'] = json_encode([
                        'Bulb Auger: Kepala spiral bulat fleksibel meliuk di leher angsa kloset & sifon',
                        'Grease Cutter: Bilah ganda bergerigi khusus memecah dan mengikis kerak lemak beku',
                        'Spade Cutter: Pisau pipih lebar untuk mengikis kerak endapan lumpur padat dan pasir',
                        'Sawtooth Root Cutter: Gigi gergaji melingkar baja keras untuk memotong serat akar pohon',
                        'Sistem pengunci pasak pegas anti-lepas di dalam pipa saat rotasi bolak-balik',
                    ]);
                    $updateData['applications'] = json_encode([
                        'Mengangkat gumpalan rambut kusut dan sisa sabun mandi di floor drain',
                        'Menghancurkan kerak lemak membatu pada bak cuci piring dan leher angsa wastafel',
                        'Memotong akar pohon yang masuk melalui celah sambungan pipa bawah tanah pekarangan',
                        'Membersihkan sisa mortar semen atau kotoran pasca renovasi bangunan',
                    ]);
                    $updateData['safety_k3'] = "Pengecekan integritas pasak pengunci sebelum masuk ke lubang saluran untuk memastikan mata pisau tidak tertinggal di dalam instalasi pipa.";
                }
            }

            if (!empty($updateData)) {
                DB::table('equipments')->where('id', $item->id)->update($updateData);
            }
        }

        // Add unique index on slug
        Schema::table('equipments', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations without data destruction.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            if (Schema::hasColumn('equipments', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('equipments', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('equipments', 'features')) {
                $table->dropColumn('features');
            }
            if (Schema::hasColumn('equipments', 'applications')) {
                $table->dropColumn('applications');
            }
            if (Schema::hasColumn('equipments', 'safety_k3')) {
                $table->dropColumn('safety_k3');
            }
        });
    }
};

