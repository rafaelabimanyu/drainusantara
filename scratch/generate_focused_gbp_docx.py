import os
import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.oxml import parse_xml
from docx.oxml.ns import nsdecls

def set_cell_shading(cell, color_hex):
    """Sets cell background color."""
    shading_elm = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{color_hex}"/>')
    cell._tc.get_or_add_tcPr().append(shading_elm)

def set_cell_margins(cell, top=140, bottom=140, left=180, right=180):
    """Sets internal padding for a table cell (20 twips = 1 pt)."""
    tcMar = parse_xml(f'''
        <w:tcMar {nsdecls("w")}>
            <w:top w:w="{top}" w:type="dxa"/>
            <w:bottom w:w="{bottom}" w:type="dxa"/>
            <w:left w:w="{left}" w:type="dxa"/>
            <w:right w:w="{right}" w:type="dxa"/>
        </w:tcMar>
    ''')
    cell._tc.get_or_add_tcPr().append(tcMar)

def set_callout_borders(cell, border_color="0284C7", border_size="32"):
    """Creates a callout box: thick left border, no other borders."""
    borders = parse_xml(f'''
        <w:tcBorders {nsdecls("w")}>
            <w:top w:val="none"/>
            <w:left w:val="single" w:sz="{border_size}" w:space="0" w:color="{border_color}"/>
            <w:bottom w:val="none"/>
            <w:right w:val="none"/>
        </w:tcBorders>
    ''')
    cell._tc.get_or_add_tcPr().append(borders)

def set_table_borders(table, border_color="CBD5E1"):
    """Sets clean subtle borders for standard data tables."""
    borders = parse_xml(f'''
        <w:tblBorders {nsdecls("w")}>
            <w:top w:val="single" w:sz="6" w:space="0" w:color="0F2942"/>
            <w:bottom w:val="single" w:sz="8" w:space="0" w:color="0F2942"/>
            <w:insideH w:val="single" w:sz="4" w:space="0" w:color="{border_color}"/>
            <w:insideV w:val="none"/>
            <w:left w:val="none"/>
            <w:right w:val="none"/>
        </w:tblBorders>
    ''')
    table._tbl.tblPr.append(borders)

def add_header_footer(doc):
    """Configures professional header and footer."""
    section = doc.sections[0]
    section.top_margin = Inches(0.8)
    section.bottom_margin = Inches(0.8)
    section.left_margin = Inches(0.8)
    section.right_margin = Inches(0.8)
    
    # Header
    header = section.header
    hp = header.paragraphs[0]
    hp.alignment = WD_ALIGN_PARAGRAPH.RIGHT
    hrun = hp.add_run("DRAINUSANTARA  |  Master Guide Optimasi Google Business Profile (GBP)")
    hrun.font.name = "Calibri"
    hrun.font.size = Pt(8.5)
    hrun.font.color.rgb = RGBColor(0x94, 0xA3, 0xB8)
    
    # Footer
    footer = section.footer
    fp = footer.paragraphs[0]
    fp.alignment = WD_ALIGN_PARAGRAPH.CENTER
    frun = fp.add_run("SOP & Panduan Lapangan Resmi  •  PT Jawa Jaya Rooter  •  drainusantara.id")
    frun.font.name = "Calibri"
    frun.font.size = Pt(8.5)
    frun.font.color.rgb = RGBColor(0x94, 0xA3, 0xB8)

def add_title(doc, text):
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    p.paragraph_format.space_before = Pt(14)
    p.paragraph_format.space_after = Pt(4)
    run = p.add_run(text)
    run.font.name = "Calibri"
    run.font.size = Pt(22)
    run.font.bold = True
    run.font.color.rgb = RGBColor(0x0F, 0x29, 0x42)
    return p

def add_subtitle(doc, text):
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(14)
    run = p.add_run(text)
    run.font.name = "Calibri"
    run.font.size = Pt(11)
    run.font.color.rgb = RGBColor(0x02, 0x84, 0xC7)
    return p

def add_h1(doc, text):
    p = doc.add_paragraph()
    p.paragraph_format.space_before = Pt(18)
    p.paragraph_format.space_after = Pt(6)
    p.paragraph_format.keep_with_next = True
    run = p.add_run(text)
    run.font.name = "Calibri"
    run.font.size = Pt(14.5)
    run.font.bold = True
    run.font.color.rgb = RGBColor(0x0F, 0x29, 0x42)
    return p

def add_h2(doc, text):
    p = doc.add_paragraph()
    p.paragraph_format.space_before = Pt(12)
    p.paragraph_format.space_after = Pt(4)
    p.paragraph_format.keep_with_next = True
    run = p.add_run(text)
    run.font.name = "Calibri"
    run.font.size = Pt(11.5)
    run.font.bold = True
    run.font.color.rgb = RGBColor(0x02, 0x84, 0xC7)
    return p

def add_p(doc, text, bold_prefix="", italic=False):
    p = doc.add_paragraph()
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(4)
    p.paragraph_format.line_spacing = 1.15
    if bold_prefix:
        r_bold = p.add_run(bold_prefix)
        r_bold.font.name = "Calibri"
        r_bold.font.size = Pt(10)
        r_bold.font.bold = True
        r_bold.font.color.rgb = RGBColor(0x0F, 0x29, 0x42)
    run = p.add_run(text)
    run.font.name = "Calibri"
    run.font.size = Pt(10)
    run.font.italic = italic
    run.font.color.rgb = RGBColor(0x33, 0x41, 0x55)
    return p

def add_bullet(doc, text, bold_prefix=""):
    p = doc.add_paragraph(style='List Bullet')
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(3)
    p.paragraph_format.line_spacing = 1.15
    if bold_prefix:
        r_bold = p.add_run(bold_prefix)
        r_bold.font.name = "Calibri"
        r_bold.font.size = Pt(10)
        r_bold.font.bold = True
        r_bold.font.color.rgb = RGBColor(0x0F, 0x29, 0x42)
    run = p.add_run(text)
    run.font.name = "Calibri"
    run.font.size = Pt(10)
    run.font.color.rgb = RGBColor(0x33, 0x41, 0x55)
    return p

def add_callout(doc, title, paragraphs, bg_color="F0F9FF", border_color="0284C7"):
    tbl = doc.add_table(rows=1, cols=1)
    tbl.alignment = WD_TABLE_ALIGNMENT.CENTER
    tbl.autofit = False
    
    cell = tbl.rows[0].cells[0]
    cell.width = Inches(6.9)
    set_cell_shading(cell, bg_color)
    set_callout_borders(cell, border_color=border_color, border_size="28")
    set_cell_margins(cell, top=140, bottom=140, left=200, right=200)
    
    p = cell.paragraphs[0]
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(3)
    run_title = p.add_run(f"📌 {title}\n")
    run_title.font.name = "Calibri"
    run_title.font.size = Pt(10.5)
    run_title.font.bold = True
    run_title.font.color.rgb = RGBColor(0x0F, 0x29, 0x42)
    
    for idx, text in enumerate(paragraphs):
        if idx == 0:
            p_curr = p
        else:
            p_curr = cell.add_paragraph()
            p_curr.paragraph_format.space_before = Pt(2)
            p_curr.paragraph_format.space_after = Pt(3)
        run_text = p_curr.add_run(text)
        run_text.font.name = "Calibri"
        run_text.font.size = Pt(9.5)
        run_text.font.color.rgb = RGBColor(0x33, 0x41, 0x55)
    
    p_after = doc.add_paragraph()
    p_after.paragraph_format.space_before = Pt(0)
    p_after.paragraph_format.space_after = Pt(4)

def add_styled_table(doc, headers, rows, col_widths=None):
    tbl = doc.add_table(rows=len(rows) + 1, cols=len(headers))
    tbl.alignment = WD_TABLE_ALIGNMENT.CENTER
    tbl.autofit = False
    set_table_borders(tbl)
    
    # Header Row
    hdr_row = tbl.rows[0]
    for idx, header_text in enumerate(headers):
        cell = hdr_row.cells[idx]
        if col_widths and idx < len(col_widths):
            cell.width = Inches(col_widths[idx])
        set_cell_shading(cell, "0F2942")
        set_cell_margins(cell, top=140, bottom=140, left=140, right=140)
        p = cell.paragraphs[0]
        p.paragraph_format.space_before = Pt(0)
        p.paragraph_format.space_after = Pt(0)
        run = p.add_run(header_text)
        run.font.name = "Calibri"
        run.font.size = Pt(9.5)
        run.font.bold = True
        run.font.color.rgb = RGBColor(0xFF, 0xFF, 0xFF)
        
    # Data Rows
    for r_idx, row_data in enumerate(rows):
        row = tbl.rows[r_idx + 1]
        bg_color = "F8FAFC" if r_idx % 2 == 1 else "FFFFFF"
        for c_idx, cell_value in enumerate(row_data):
            cell = row.cells[c_idx]
            if col_widths and c_idx < len(col_widths):
                cell.width = Inches(col_widths[c_idx])
            set_cell_shading(cell, bg_color)
            set_cell_margins(cell, top=90, bottom=90, left=140, right=140)
            p = cell.paragraphs[0]
            p.paragraph_format.space_before = Pt(0)
            p.paragraph_format.space_after = Pt(0)
            run = p.add_run(cell_value)
            run.font.name = "Calibri"
            run.font.size = Pt(9)
            run.font.color.rgb = RGBColor(0x1E, 0x29, 0x3B)
            
    p_after = doc.add_paragraph()
    p_after.paragraph_format.space_before = Pt(0)
    p_after.paragraph_format.space_after = Pt(4)

def build_focused_gbp_guide():
    doc = docx.Document()
    add_header_footer(doc)
    
    # Header / Title
    add_title(doc, "MASTER GUIDE: PANDUAN LENGKAP & SOP OPTIMASI GOOGLE BUSINESS PROFILE (GBP)")
    add_subtitle(doc, "Cetak Biru Taktis Mendominasi Local 3-Pack Google Maps, Menguasai Panggilan Darurat, dan Membangun Otoritas Lokal Drainusantara")
    
    # Metadata Callout
    add_callout(doc, "PROFIL TARGET & RUANG LINGKUP OPERASIONAL", [
        "Nama Brand: Drainusantara (Induk Perusahaan: PT Jawa Jaya Rooter)",
        "Spesialisasi: Jasa Saluran Pipa Mampet, Kloset Tersumbat, Wastafel Lemak, Talang Air Hujan, & Inspeksi CCTV Kamera.",
        "Area Operasional: Seluruh Wilayah Jabodetabek (DKI Jakarta, Tangerang Selatan, Tangerang Kota, Depok, Bekasi, Bogor) & Kota Bandung.",
        "Target Utama: Mengamankan Posisi 1–3 di Google Maps Local 3-Pack untuk kueri darurat (misal: 'jasa pipa mampet terdekat', 'tukang ledeng bintaro', 'saluran mampet depok')."
    ], bg_color="F8FAFC", border_color="0F2942")
    
    # BAB 1
    add_h1(doc, "BAB 1: ANATOMI ALGORITMA GOOGLE MAPS (LOCAL 3-PACK)")
    add_p(doc, "Google Maps menggunakan tiga pilar utama untuk menentukan bisnis mana yang tampil di 3 posisi teratas (Local 3-Pack):")
    add_bullet(doc, "Seberapa dekat lokasi fisik bisnis atau posko armada dengan orang yang sedang melakukan penelusuran di ponselnya.", "1. Proximity (Jarak Fisik): ")
    add_bullet(doc, "Seberapa tepat kategori, menu layanan, deskripsi, dan ulasan profil Anda cocok dengan masalah yang dicari pengguna.", "2. Relevance (Kesesuaian Masalah): ")
    add_bullet(doc, "Seberapa dipercaya bisnis Anda oleh Google, diukur dari konsistensi ulasan bintang 5, kecepatan balasan owner, foto asli lapangan, dan konsistensi data NAP (Name, Address, Phone) di seluruh internet.", "3. Prominence (Reputasi & Otoritas): ")
    add_p(doc, "Bagi bisnis jasa pipa mampet, Anda tidak bisa memindahkan rumah pelanggan agar lebih dekat, namun Anda memiliki kontrol 100% terhadap pilar Relevance dan Prominence. Panduan ini dirancang untuk memaksimalkan kedua pilar tersebut.")

    # BAB 2
    add_h1(doc, "BAB 2: FONDASI PROFIL BISNIS (SETUP & SETTINGS)")
    
    add_h2(doc, "2.1 Penamaan Profil yang Bebas Banned (Anti-Suspension)")
    add_p(doc, "Banyak pemilik jasa pipa mampet terkena penalti pembekuan profil (hard suspension) karena menumpuk kata kunci secara ilegal (misal: 'Jasa Pipa Mampet Jakarta Depok Tangerang Bekasi Murah 24 Jam'). Google menggunakan AI teks untuk mendeteksi pelanggaran ini.")
    add_bullet(doc, "Gunakan nama brand resmi yang rapi: 'Drainusantara - Jasa Saluran Pipa Mampet' atau 'Drainusantara Plumbing & Drain Specialist'.", "Rekomendasi Nama Resmi: ")
    add_bullet(doc, "Jika memiliki titik workshop terdaftar resmi di Ciracas / Duren Sawit, Anda dapat menggunakan 'Drainusantara - Jasa Pipa Mampet Jakarta Timur'.", "Pilihan Multi-Lokasi Resmi: ")

    add_h2(doc, "2.2 Pemilihan Kategori Utama & Sekunder")
    add_p(doc, "Kategori adalah sinyal penentu terbesar dalam relevansi penelusuran. Jangan salah memilih kategori:")
    add_bullet(doc, "Wajib pilih 'Plumber' (Tukang Ledeng). Di Google Indonesia, 'Plumber' adalah kata pemicu utama munculnya peta saat pengguna mencari masalah kloset, wastafel, atau pipa.", "Kategori Utama (Primary Category): ")
    add_bullet(doc, "Tambahkan: (1) Drainage service (Jasa Saluran Pembuangan), (2) Septic system service, (3) Water treatment service, (4) Emergency service.", "Kategori Sekunder (Secondary Categories): ")

    add_h2(doc, "2.3 Alamat Fisik vs Service Area Business (SAB)")
    add_p(doc, "Model operasional Drainusantara adalah mengirimkan teknisi ke lokasi pelanggan (on-site emergency service):")
    add_bullet(doc, "Jika ruko/kantor PT Jawa Jaya Rooter memiliki plang fisik permanen (Jl. Duren Sawit Raya No. 45 / Jl. Raya Ciracas), tampilkan alamat tersebut di Google Maps. Ini memberikan sinyal otoritas fisik (Physical Prominence) yang jauh lebih kuat dibanding profil tanpa alamat.", "Skenario Kantor Fisik: ")
    add_bullet(doc, "Aktifkan opsi 'Saya mengirimkan barang dan jasa ke pelanggan saya' (Service Area).", "Pengaturan Pengiriman Jasa: ")
    add_bullet(doc, "Di kolom 'Wilayah Layanan', masukkan 25 kecamatan utama di Jabodetabek: Bintaro, BSD Serpong, Ciputat, Pamulang, Kebayoran Baru, Cilandak, Tebet, Pasar Minggu, Duren Sawit, Ciracas, Cakung, Kebon Jeruk, Kembangan, Kelapa Gading, Beji, Pancoran Mas, Sawangan, Cinere, Bekasi Barat, Bekasi Selatan, Rawalumbu, Cikarang, Cibinong, Sentul, dan Kota Bandung.", "Daftar Wilayah Layanan Wajib: ")

    add_h2(doc, "2.4 Jam Operasional & Atribut Khusus")
    add_bullet(doc, "Atur ke 'Buka 24 Jam' (Open 24 hours). Bisnis pipa mampet dicari terutama saat malam hari atau subuh ketika terjadi luapan air darurat. Profil 24 jam mendapatkan prioritas tampil saat kompetitor tutup.", "Jam Buka: ")
    add_bullet(doc, "Tetapkan jam operasional tetap buka pada tanggal merah dan hari libur nasional.", "Jam Buka Khusus (Special Hours): ")
    add_bullet(doc, "Centang: 'Perkiraan biaya online diberikan' (Online estimates), 'Layanan di lokasi tersedia' (On-site services).", "Atribut Layanan: ")

    # BAB 3
    add_h1(doc, "BAB 3: DESKRIPSI BISNIS KAYA KATA KUNCI & PENAWARAN (750 KARAKTER)")
    add_p(doc, "Kolom deskripsi di GBP menyediakan kuota maksimal 750 karakter. Susun kalimat dengan piramida terbalik: masalah utama, keunggulan teknis, jaminan garansi, dan ajakan bertindak (CTA).")
    
    add_callout(doc, "TEKS RESMI DESKRIPSI GOOGLE BUSINESS PROFILE (SIAP SALIN)", [
        "Drainusantara (PT Jawa Jaya Rooter) adalah spesialis jasa pelancaran saluran pipa air mampet profesional di Jabodetabek & Bandung dengan layanan siaga 24 jam darurat.",
        "",
        "Kami melayani pelancaran kloset/toilet tersumbat, wastafel cuci piring (lemak/fatberg), pipa kamar mandi, talang air hujan rooftop, bak kontrol, dan pembersihan grease trap resto. Menggunakan teknologi modern Spiral Cable Drain Cleaner Ridgid K-50/K-60 dan High-Pressure Water Jetting tanpa bongkar keramik lantai semen.",
        "",
        "Keunggulan Drainusantara:",
        "• Teknisi tiba dalam 30–45 menit dari posko terdekat.",
        "• Metode modern tanpa pembongkaran pipa & ramah lingkungan.",
        "• Jaminan No Cure No Pay: Tidak lancar, tidak perlu bayar!",
        "• Garansi pengerjaan tuntas 14–30 hari.",
        "",
        "Hubungi hotline WhatsApp kami sekarang untuk penanganan cepat dan konsultasi gratis!"
    ], bg_color="F0FDF4", border_color="16A34A")

    # BAB 4
    add_h1(doc, "BAB 4: SETUP PRODUK & KATALOG LAYANAN (SERVICES & PRODUCTS)")
    add_p(doc, "Google Maps kini memiliki fitur pencocokan otomatis antara kata kunci pengguna dengan item di katalog layanan. Lengkapi 6 menu layanan berikut di dashboard GBP:")
    
    services_data = [
        ["Pelancaran Toilet & Kloset Duduk Mampet", "Mulai Rp 400.000", "Penanganan darurat kloset tersumbat pembalut, tisu, atau benda keras tanpa bongkar lantai semen dengan mesin Ridgid K-50 spiral baja."],
        ["Pelancaran Wastafel Dapur (Lemak Padat)", "Mulai Rp 350.000", "Pembersihan pipa bak cuci piring dari kerak minyak beku (fatberg) dan sisa makanan. Mengembalikan diameter pipa 100% normal."],
        ["Pelancaran Talang Air Hujan & Rooftop", "Mulai Rp 450.000", "Pembersihan saluran talang vertikal dari endapan lumpur, lumut, dan daun kering mencegah rembesan plafon rumah saat hujan lebat."],
        ["Inspeksi Kamera Pipa (CCTV Endoskopi)", "Mulai Rp 600.000", "Deteksi visual pipa bawah tanah dengan kamera micro-lens resolusi tinggi untuk mengetahui titik pipa patah, pecah, atau tersumbat akar pohon."],
        ["Pelancaran Floor Drain Kamar Mandi", "Mulai Rp 350.000", "Pengangkatan sumbatan gumpalan rambut, buih sabun mandi, dan kotoran padat pada leher angsa saluran kamar mandi."],
        ["Cuci Pipa Lemak Restoran & Grease Trap", "Mulai Rp 750.000", "Perawatan berkala dan pelancaran pipa buangan limbah minyak komersial untuk kafe, restoran, rumah makan, dan kantin pabrik."]
    ]
    add_styled_table(doc, ["Nama Layanan", "Harga Referensi", "Deskripsi Lengkap untuk Dashboard GBP"], services_data, [2.2, 1.2, 3.5])

    # BAB 5
    add_h1(doc, "BAB 5: STRATEGI REVIEW BINTANG 5 & ALGORITMA KATA KUNCI ULASAN")
    add_p(doc, "Ulasan bukan sekadar alat pembuktian sosial (social proof). Google menggunakan teks review sebagai faktor perangkingan lokal nomor satu. Jika review memuat kata 'wastafel mampet di Bintaro', listing Anda akan langsung meroket saat orang di Bintaro mencari wastafel mampet.")
    
    add_h2(doc, "5.1 SOP Permohonan Ulasan oleh Teknisi Lapangan")
    add_p(doc, "Momentum terbaik meminta ulasan adalah tepat saat pengerjaan selesai dan pelanggan melihat air mengalir deras kembali. Teknisi wajib menjalankan langkah berikut:")
    add_bullet(doc, "Tunjukkan air yang mengalir deras kepada pelanggan: 'Alhamdulillah sudah lancar ya Bu/Pak, airnya sudah berputar deras tanpa rembesan.'", "Langkah 1: Validasi Kepuasan: ")
    add_bullet(doc, "Minta izin mengirimkan pesan WhatsApp berisi tautan ulasan resmi.", "Langkah 2: Permintaan Izin: ")
    add_bullet(doc, "Kirimkan pesan template berikut dari HP operasional admin/teknisi:", "Langkah 3: Pengiriman Pesan: ")
    
    add_callout(doc, "TEMPLATE WHATSAPP PERMOHONAN ULASAN BINTANG 5", [
        "Halo Bapak/Ibu [Nama Pelanggan],",
        "Terima kasih telah mempercayakan pelancaran saluran air rumah Anda kepada tim Drainusantara hari ini.",
        "",
        "Alhamdulillah pengerjaan di [Nama Perumahan / Area] telah tuntas dan saluran kembali normal.",
        "Untuk membantu tetangga di sekitar [Nama Kota/Kecamatan] yang membutuhkan tukang pipa terpercaya, kami sangat berterima kasih jika Bapak/Ibu berkenan memberikan ulasan bintang 5 singkat di Google Maps kami.",
        "",
        "👉 Klik tautan singkat ini untuk memberi ulasan: [MASUKKAN_LINK_SHORT_REVIEW_GBP]",
        "",
        "Tip singkat ulasan: Cukup sebutkan masalah yang diperbaiki (misal: kloset/wastafel) dan metode tanpa bongkar yang kami gunakan. Terima kasih banyak atas dukungan Bapak/Ibu! 🙏"
    ], bg_color="F0FDF4", border_color="16A34A")

    add_h2(doc, "5.2 SOP Pemilik Membalas Ulasan (Owner Response Keyword Injection)")
    add_p(doc, "Setiap ulasan wajib dibalas dalam waktu maksimal 24 jam. Jangan membalas dengan kalimat generik seperti 'Terima kasih'. Masukkan nama wilayah dan jenis layanan di dalam balasan pemilik:")
    
    add_callout(doc, "CONTOH BALASAN PEMILIK BERBOBOT SEO TINGGI", [
        "Ulasan Pelanggan: 'Pelayanannya cepat, teknisi ramah, pipa wastafel yang mampet langsung lancar.'",
        "",
        "Balasan Pemilik yang Tepat:",
        "'Terima kasih banyak Bapak Dimas atas ulasan bintang 5 dan kepercayaannya kepada tim Drainusantara cabang Tangerang Selatan!",
        "Kami senang dapat membantu melancarkan saluran wastafel dapur rumah Anda di Bintaro Sektor 7 yang tersumbat endapan lemak menggunakan mesin spiral Ridgid tanpa perlu merusak instalasi pipa.",
        "Seluruh pekerjaan dilindungi garansi operasional. Jika membutuhkan pengecekan saluran air kembali, kami selalu siaga 24 jam. Salam sehat selalu!'"
    ], bg_color="F0F9FF", border_color="0284C7")

    add_h2(doc, "5.3 SOP Penanganan Ulasan Bintang Rendah (Review Recovery)")
    add_bullet(doc, "Jangan pernah bersikap defensif atau berdebat di kolom komentar publik.", "Prinsip Utama: ")
    add_bullet(doc, "Gunakan formula: Maaf atas ketidaknyamanan + Tegaskan komitmen garansi No Cure No Pay + Ajak komunikasi privat via nomor hotline manajer.", "Formula Balasan Krisis: ")
    add_bullet(doc, "Setelah masalah di lapangan diselesaikan oleh tim senior, minta pelanggan dengan sopan untuk memperbarui bintang ulasannya.", "Resolusi Offline: ")

    # BAB 6
    add_h1(doc, "BAB 6: SOP VISUAL & FOTO LAPANGAN (GEOTAGGING ASSETS)")
    add_p(doc, "Google memverifikasi keaslian bisnis melalui pemrosesan visual (Google Vision AI) dan metadata lokasi GPS (EXIF Data) yang tertanam di file foto kamera.")
    
    add_h2(doc, "6.1 Standar Operasional Pengambilan Foto Teknisi")
    add_bullet(doc, "Pastikan opsi 'Location Tagging / Simpan Lokasi' pada kamera ponsel Android/iPhone teknisi selalu dalam posisi AKTIF.", "1. GPS EXIF Wajib: ")
    add_bullet(doc, "Teknisi wajib mengenakan seragam kerja resmi berlogo Drainusantara.", "2. Identitas Seragam: ")
    add_bullet(doc, "Wajib menampilkan unit mesin Ridgid K-50/K-60 di lantai kerja bersama gulungan sling spiral baja.", "3. Peralatan Nyata: ")
    add_bullet(doc, "Ambil 1 foto air tergenang (sebelum), dan 1 foto pusaran air mengalir deras ke lubang saluran (sesudah).", "4. Foto Before & After: ")
    add_bullet(doc, "DILARANG mengunggah foto editan kanva penuh teks tebal atau gambar hasil download internet.", "5. Larangan Gambar Buatan: ")

    add_h2(doc, "6.2 Jadwal Unggah Foto")
    add_p(doc, "Unggah minimal 3 foto baru setiap minggu (rekomendasi: hari Selasa dan Jumat). Keaktifan unggahan foto secara konsisten memberi sinyal kepada Google bahwa bisnis ini memiliki aktivitas transaksi yang tinggi dan hidup.")

    # BAB 7
    add_h1(doc, "BAB 7: GOOGLE POSTS (FITUR UPDATE MINGGUAN)")
    add_p(doc, "Google Business Profile memiliki fitur 'Update / Post' yang tampil langsung di bawah listing saat pengguna menelusuri profil Anda. Manfaatkan fitur ini untuk memancing klik langsung ke tombol WhatsApp.")
    
    add_h2(doc, "7.1 Formula Postingan Mingguan Berdaya Konversi Tinggi")
    add_callout(doc, "CONTOH TEMPLATE GOOGLE POST: EDISI SIAGA HUJAN", [
        "🌧️ Musim Hujan Tiba: Waspada Talang Air & Pipa Pembuangan Rooftop Meluap!",
        "",
        "Tumpukan daun kering, lumpur pasir, dan lumut yang mengendap di pipa talang air dapat menyebabkan kebocoran plafon dan banjir di lantai atas rumah Anda.",
        "",
        "Tim Teknisi Drainusantara siaga 24 jam melayani pembersihan & pelancaran saluran pipa talang di area Jakarta, Tangerang Selatan, Depok, dan Bekasi.",
        "",
        "✅ Menggunakan mesin modern tanpa bongkar semen keramik",
        "✅ Teknisi tiba dalam 30–45 menit",
        "✅ Garansi pengerjaan tuntas & No Cure No Pay",
        "",
        "Tombol Aksi (CTA): Klik 'Pesan Sekarang' atau 'Telepon' untuk respon darurat!"
    ], bg_color="FFFBEB", border_color="F59E0B")

    # BAB 8
    add_h1(doc, "BAB 8: PRE-POPULASI GOOGLE Q&A (TANYA JAWAB)")
    add_p(doc, "Fitur 'Questions & Answers' pada Google Maps sering dibiarkan kosong. Padahal, siapapun bisa bertanya dan pemilik bisnis bisa menjawabnya. Google mengindeks kata kunci di dalam Q&A ini untuk mencocokkan kueri.")
    add_p(doc, "Tugaskan tim operasional untuk menanyakan 3 pertanyaan strategis berikut menggunakan akun personal, lalu jawab secara resmi menggunakan Akun Bisnis Drainusantara:")
    
    qa_data = [
        ["Apakah Drainusantara melayani pelancaran pipa mampet di hari libur atau malam hari?", "Ya, betul. Tim Drainusantara siaga 24 jam setiap hari, termasuk akhir pekan dan hari libur nasional untuk area Jabodetabek dan Bandung."],
        ["Apakah pengerjaannya harus membongkar ubin atau pipa paralon?", "Sama sekali tidak perlu pembongkaran. Kami menggunakan teknologi mesin Ridgid spiral baja lentur yang berputar mengikuti liukan leher angsa pipa."],
        ["Bagaimana sistem pembayarannya jika saluran air tetap tidak lancar?", "Kami memberikan jaminan No Cure No Pay. Jika saluran pipa Anda gagal kami lancarkan, Anda tidak dikenakan biaya jasa pengerjaan sepeserpun."]
    ]
    add_styled_table(doc, ["Pertanyaan Publik (Diajukan Tim)", "Jawaban Resmi Pemilik Bisnis (Owner Reply)"], qa_data, [3.2, 3.7])

    # BAB 9
    add_h1(doc, "BAB 9: CHECKLIST OPERASIONAL MINGGUAN ADMIN & TEKNISI")
    add_p(doc, "Agar proses optimasi GBP ini berjalan konsisten dan tidak berhenti di tengah jalan, gunakan tabel jadwal rutin harian dan mingguan berikut:")
    
    checklist_data = [
        ["Harian (Pagi)", "Admin CS", "Cek notifikasi GBP: balas seluruh ulasan baru yang masuk dalam 1x24 jam menggunakan template kata kunci."],
        ["Harian (Sore)", "Teknisi Lapangan", "Kirimkan link ulasan bintang 5 ke WhatsApp setiap pelanggan yang selesai dikerjakan pada hari itu."],
        ["Selasa & Jumat", "Marketing", "Unggah 2–3 foto asli lapangan ber-GPS ke galeri foto Google Business Profile."],
        ["Setiap Rabu", "Marketing", "Terbitkan 1 artikel singkat di Google Post (info edukasi masalah saluran / promo garansi darurat)."],
        ["Akhir Bulan", "Owner / Supervisor", "Buka Dashboard Insight GBP: Analisis jumlah panggilan telepon (Calls), permintaan arah rute (Directions), dan tayangan pencarian."]
    ]
    add_styled_table(doc, ["Waktu Eksekusi", "Penanggung Jawab", "Aktivitas Operasional Wajib"], checklist_data, [1.5, 1.5, 3.9])
    
    # Save document
    output_path = os.path.abspath(r"C:\Users\Ilham Dwi Arsandy\Documents\drainusantara\docs\Panduan-Lengkap-Optimasi-Google-Business-Profile-Drainusantara.docx")
    doc.save(output_path)
    print(f"Focused GBP Guide created at: {output_path}")

if __name__ == "__main__":
    build_focused_gbp_guide()
