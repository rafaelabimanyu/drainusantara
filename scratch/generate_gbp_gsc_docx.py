import os
import docx
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT, WD_ALIGN_VERTICAL
from docx.oxml import OxmlElement, parse_xml
from docx.oxml.ns import nsdecls, qn

def set_cell_shading(cell, color_hex):
    """Sets cell background color."""
    shading_elm = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{color_hex}"/>')
    cell._tc.get_or_add_tcPr().append(shading_elm)

def set_cell_margins(cell, top=140, bottom=140, left=180, right=180):
    """Sets internal padding for a table cell (in twips, 20 twips = 1 pt)."""
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
    """Sets light subtle borders for a regular table."""
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
    hrun = hp.add_run("DRAINUSANTARA  |  Blueprint Optimasi GBP & Akselerasi Posisi GSC")
    hrun.font.name = "Calibri"
    hrun.font.size = Pt(8.5)
    hrun.font.color.rgb = RGBColor(0x94, 0xA3, 0xB8)
    
    # Footer
    footer = section.footer
    fp = footer.paragraphs[0]
    fp.alignment = WD_ALIGN_PARAGRAPH.CENTER
    frun = fp.add_run("Dokumen Rahasia Internal  •  PT Jawa Jaya Rooter  •  drainusantara.id")
    frun.font.name = "Calibri"
    frun.font.size = Pt(8.5)
    frun.font.color.rgb = RGBColor(0x94, 0xA3, 0xB8)

def add_title(doc, text):
    p = doc.add_paragraph()
    p.alignment = WD_ALIGN_PARAGRAPH.LEFT
    p.paragraph_format.space_before = Pt(12)
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
    run.font.size = Pt(15)
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
    run.font.size = Pt(12)
    run.font.bold = True
    run.font.color.rgb = RGBColor(0x02, 0x84, 0xC7)
    return p

def add_h3(doc, text):
    p = doc.add_paragraph()
    p.paragraph_format.space_before = Pt(8)
    p.paragraph_format.space_after = Pt(2)
    p.paragraph_format.keep_with_next = True
    run = p.add_run(text)
    run.font.name = "Calibri"
    run.font.size = Pt(10.5)
    run.font.bold = True
    run.font.color.rgb = RGBColor(0x1E, 0x29, 0x3B)
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

def build_document():
    doc = docx.Document()
    add_header_footer(doc)
    
    # Title Section
    add_title(doc, "BLUEPRINT STRATEGI: OPTIMASI GOOGLE BUSINESS PROFILE (GBP) & AKSELERASI POSISI GOOGLE SEARCH CONSOLE (GSC)")
    add_subtitle(doc, "Panduan Taktis Mendominasi Local 3-Pack Google Maps dan Melesat ke Halaman 1 SERP Organik untuk drainusantara.id")
    
    # Metadata Box
    add_callout(doc, "INFORMASI DOKUMEN & IDENTITAS OPERASIONAL", [
        "Entitas Bisnis: Drainusantara (PT Jawa Jaya Rooter) — Spesialis Saluran Pipa Mampet Jabodetabek & Bandung.",
        "Status Domain: Usia 1 Bulan (Live Oktober 2026) | 342 Halaman Terdeteksi | 279 Terindeks (81.6%) | 71 Kueri GSC.",
        "Posisi Rata-Rata Saat Ini: 17.7 (Halaman 2 Google) | Kueri Potensial: 13.5 (Bintaro), 7.8 (Mesin Ridgid), 5.5 (Plumber Near Me).",
        "Tujuan Dokumen: Memberikan panduan aksi tahap-demi-tahap bagi tim teknis, pemilik bisnis, dan teknisi lapangan untuk mengubah impresi pencarian menjadi konversi panggilan darurat dan pesanan WhatsApp."
    ], bg_color="F8FAFC", border_color="0F2942")
    
    # BAB 1
    add_h1(doc, "BAB 1: RINGKASAN EKSEKUTIF & ANALISIS BASELINE GSC")
    add_p(doc, "Berdasarkan audit data performa resmi Google Search Console (GSC) per awal November 2026, domain drainusantara.id menunjukkan sinyal awal yang sangat menjanjikan. Algoritma Google telah memvalidasi relevansi topikal situs untuk kategori pelancaran saluran pipa air mampet di berbagai wilayah Jabodetabek.")
    add_p(doc, "Namun, posisi rata-rata 17.7 berada di Halaman 2 Google. Pada industri jasa perbaikan darurat (emergency plumbing), perilaku pencari layanan sangat unik: 90%+ konversi langsung diraih oleh listing Google Maps (Local 3-Pack) dan 3 hasil organik teratas di Halaman 1. Halaman 2 hanya menghasilkan CTR di bawah 1%.")
    
    add_h2(doc, "1.1 Analisis Kueri Emas (Striking Distance Queries)")
    add_p(doc, "Kueri 'Striking Distance' adalah kata kunci yang saat ini berada di peringkat 5 s/d 20. Kueri ini tidak membutuhkan perombakan total, melainkan dorongan taktis (optimasi CTR judul, penguatan tautan internal, dan sinyal Google Maps) agar melesat masuk ke Top 3:")
    
    striking_headers = ["Kueri Penelusuran", "Tayangan", "Klik", "Posisi", "Status & Peluang"]
    striking_rows = [
        ["jasa pipa mampet bintaro", "11", "0", "13.55", "Striking Distance Halaman 2. Sangat dekat ke Halaman 1."],
        ["mesin ridgid", "11", "0", "7.82", "Sudah di Halaman 1. Perlu CTR Hook agar diklik."],
        ["ridgid pipa", "5", "0", "9.00", "Halaman 1. Pengakuan atas otoritas peralatan teknis."],
        ["ridgid pipa mampet", "3", "0", "11.00", "Ambang batas Halaman 1. Butuh internal link dari artikel."],
        ["plumber near me", "2", "0", "5.50", "Posisi Top 5. Sangat bergantung pada sinyal GBP & GPS."],
        ["jasa pipa mampet depok", "11", "2", "27.45", "Memiliki klik nyata (CTR 18.2%). Potensi konversi tinggi."],
        ["tukang ledeng bintaro", "4", "0", "27.25", "Variasi kueri lokal Bintaro berniat beli tinggi."],
        ["jasa saluran mampet depok", "23", "0", "44.09", "Tayangan terbesar kedua (23 tayangan), menunggu dorongan."]
    ]
    add_styled_table(doc, striking_headers, striking_rows, [2.1, 0.8, 0.7, 0.8, 2.5])
    
    add_h2(doc, "1.2 Paradigma Sinergi: Menghubungkan GBP, GSC, dan Website")
    add_p(doc, "Sebelum perbaikan ini, terjadi fenomena 'Entity Disconnect' (putusnya sinyal entitas): website tidak menautkan listing Google Maps resmi, dan listing Google Maps belum teroptimasi secara sinkron dengan landing page kecamatan. Dengan menghubungkan kedua entitas ini via Schema Plumber dan konsistensi NAP, Google Knowledge Graph akan mengenali Drainusantara sebagai kontraktor fisik berizin resmi di Jabodetabek.")

    # BAB 2
    add_h1(doc, "BAB 2: BLUEPRINT MASTER OPTIMASI GOOGLE BUSINESS PROFILE (GBP)")
    add_p(doc, "Google Business Profile adalah aset paling bernilai untuk menjaring pelanggan lokal dengan intensitas darurat tinggi. Calon pelanggan yang pipa dapurnya mampet atau klosetnya meluap membutuhkan bantuan instan dalam 30–60 menit.")
    
    add_h2(doc, "2.1 Konfigurasi Kategori & Nama Profil (Anti-Suspension)")
    add_bullet(doc, "Pilih 'Plumber' (Tukang Ledeng). Ini adalah kategori primer terkuat di algoritma penelusuran lokal Google Indonesia untuk kata kunci pipa dan saluran.", "Kategori Utama (Primary Category): ")
    add_bullet(doc, "Tambahkan 'Drainage service' (Jasa Saluran Pembuangan), 'Septic system service', dan 'Water pipe installer'.", "Kategori Sekunder (Secondary Categories): ")
    add_bullet(doc, "Gunakan format resmi 'Drainusantara - Jasa Saluran Pipa Mampet'. Hindari penumpukan kata kunci berlebihan (misal: 'Jasa Pipa Mampet Murah 24 Jam Jakarta Depok Bogor Bekasi Tangerang') karena Google menerapkan deteksi otomatis yang dapat membekukan listing profil Anda.", "Nama Bisnis Resmi: ")
    
    add_h2(doc, "2.2 Standardisasi NAP & Tautan Tracking Khusus")
    add_p(doc, "Konsistensi data Name, Address, Phone (NAP) merupakan pilar nomor 1 dalam algoritma Local SEO Google:")
    add_bullet(doc, "Gunakan alamat kantor resmi PT Jawa Jaya Rooter (Jl. Duren Sawit Raya No. 45 / Jl. Raya Ciracas). Pastikan ejaan jalan, nomor RT/RW, dan kode pos persis sama antara GBP, footer web, dan halaman Kontak.", "Alamat Fisik (Address): ")
    add_bullet(doc, "Gunakan satu nomor hotline utama (format WhatsApp operasional). Hindari mengganti-ganti nomor agar sinyal kredibilitas tidak terpecah.", "Nomor Kontak (Phone): ")
    add_bullet(doc, "Jangan gunakan URL polos! Gunakan URL berparameter UTM berikut agar setiap klik dan telepon dari GBP terlacak akurat di Google Analytics 4 dan Search Console:", "Website Link dengan Tracking UTM: ")
    
    add_callout(doc, "URL RESMI UNTUK PROFIL GOOGLE BUSINESS PROFILE", [
        "https://drainusantara.id/?utm_source=google_business_profile&utm_medium=organic&utm_campaign=gbp_listing",
        "Catatan: Pasang URL ini di kolom 'Situs Web' pada dashboard Google Bisnis Anda."
    ], bg_color="F0FDF4", border_color="16A34A")

    add_h2(doc, "2.3 Pengaturan Wilayah Layanan (Service Area Business - SAB)")
    add_p(doc, "Karena teknisi Drainusantara mobile mendatangi rumah/kantor pelanggan, aktifkan fitur 'Area Layanan'. Jangan hanya memilih 1 provinsi DKI Jakarta, masukkan seluruh sub-area jangkauan operasional armada:")
    add_bullet(doc, "Jakarta Selatan (Kebayoran Baru, Cilandak, Pasar Minggu, Tebet, Jagakarsa, Pancoran), Jakarta Timur (Duren Sawit, Ciracas, Cakung, Kramat Jati), Jakarta Barat (Kebon Jeruk, Cengkareng, Kembangan), Jakarta Pusat, Jakarta Utara (Kelapa Gading, Pluit).", "Wilayah DKI Jakarta: ")
    add_bullet(doc, "Kota Tangerang Selatan (Pondok Aren, Bintaro, BSD Serpong, Ciputat, Pamulang), Kota Tangerang (Karawaci, Pinang, Ciledug).", "Wilayah Tangerang & Tangsel: ")
    add_bullet(doc, "Kecamatan Beji, Pancoran Mas, Sukmajaya, Cimanggis, Sawangan, Cinere.", "Wilayah Kota Depok: ")
    add_bullet(doc, "Bekasi Barat, Bekasi Timur, Bekasi Selatan, Rawalumbu, Pondok Gede, Cikarang.", "Wilayah Bekasi & Cikarang: ")
    add_bullet(doc, "Kota Bogor, Cibinong, Sentul City, serta Kota Bandung (Wilayah Layanan Khusus).", "Wilayah Bogor & Bandung: ")

    add_h2(doc, "2.4 Setup Katalog Menu Layanan & Produk Kaya Kata Kunci")
    add_p(doc, "Google Maps kini mengekstrak menu layanan untuk mencocokkan kata kunci dalam kotak pencarian pengguna. Daftarkan 5 menu layanan utama berikut lengkap dengan deskripsi teknisnya:")
    
    service_headers = ["Nama Layanan", "Harga Acuan", "Deskripsi Teknis (Masukkan di GBP)"]
    service_rows = [
        ["Pelancaran Kloset & Toilet Duduk", "Mulai Rp 400.000", "Penanganan darurat toilet tersumbat pembalut, tisu, atau benda keras tanpa bongkar keramik menggunakan mesin Ridgid Spiral Cable K-50."],
        ["Pelancaran Pipa Wastafel & Bak Cuci", "Mulai Rp 350.000", "Pembersihan saluran dapur dari endapan lemak padat (fatberg) dan sisa makanan, mengembalikan diameter pipa 100% lancar."],
        ["Pelancaran Talang Air & Rooftop", "Mulai Rp 450.000", "Pembersihan pipa talang atap dari sedimentasi lumpur, pasir, dan daun kering mencegah kebocoran plafon rumah dan ruko saat hujan."],
        ["Inspeksi Kamera Pipa (CCTV Drain)", "Mulai Rp 600.000", "Deteksi visual pipa bawah tanah dengan endoskopi kamera beresolusi tinggi untuk melacak retakan, kebocoran, atau pipa amblas."],
        ["Cuci Pipa Lemak Resto & Grease Trap", "Mulai Rp 750.000", "Pembersihan berkala saluran pipa pembuangan minyak komersial restoran, kafe, dan kantin gedung bertingkat dengan jaminan tuntas."]
    ]
    add_styled_table(doc, service_headers, service_rows, [2.0, 1.2, 3.7])

    add_h2(doc, "2.5 Strategi Ulasan (Review Velocity & Review Keyword Hijacking)")
    add_p(doc, "Algoritma Google Maps menganalisis teks di dalam ulasan ulasan konsumen. Kueri 'jasa pipa mampet bintaro' akan naik peringkat secara instan jika terdapat minimal 3–5 review yang memuat kata 'Bintaro' dan 'pipa mampet'.")
    add_bullet(doc, "Kumpulkan 1–2 ulasan baru setiap minggu. Konsistensi mingguan dinilai jauh lebih tinggi oleh Google dibanding 50 ulasan dalam satu hari.", "Review Velocity (Kecepatan Ulasan): ")
    add_bullet(doc, "Bimbing pelanggan secara halus agar menyebutkan nama wilayah dan masalahnya saat memberikan ulasan bintang 5.", "Review Content Guidance: ")
    add_bullet(doc, "Wajib balas seluruh ulasan dalam kurun waktu 1x24 jam. Manfaatkan kolom balasan pemilik (Owner Response) untuk menyuntikkan kata kunci penelusuran lokal.", "SOP Balasan Pemilik: ")

    add_h2(doc, "2.6 SOP Foto Lapangan & Geotagging Otomatis (Anti-Stock Photo)")
    add_p(doc, "Google Vision AI secara otomatis memverifikasi keaslian foto. Listing yang menggunakan gambar stock internet atau gambar AI akan ditekan peringkatnya. Terapkan SOP dokumentasi teknisi:")
    add_bullet(doc, "Kamera HP teknisi wajib menyalakan fitur 'Location/GPS Tagging' sebelum memotret.", "Aktifkan GPS Kamera: ")
    add_bullet(doc, "Foto wajib menampilkan seragam Drainusantara, unit mesin Ridgid K-50/K-60, kabel spiral baja yang sedang bekerja di lubang saluran, dan air yang mengalir lancar setelah pengerjaan selesai.", "Objek Foto Wajib: ")
    add_bullet(doc, "Unggah minimal 2–3 foto asli setiap minggu ke tab Foto GBP.", "Frekuensi Unggah: ")

    # BAB 3
    add_h1(doc, "BAB 3: BLUEPRINT AKSELERASI POSISI (RANKING) DI GOOGLE SEARCH CONSOLE")
    add_p(doc, "Menaikkan posisi rata-rata dari 17.7 ke Top 3 membutuhkan pendekatan kombinasi antara Click-Through Rate (CTR) Hijacking, penguatan On-Page SEO, dan struktur internal linking silo.")
    
    add_h2(doc, "3.1 CTR Hijacking: Mengubah Snippet SERP Menjadi Pemicu Klik Darurat")
    add_p(doc, "Saat seseorang mencari tukang pipa, mereka berada dalam kondisi stres dan darurat. Judul yang terlalu datar dan akademis tidak akan diklik meskipun berada di peringkat 10. Bandingkan pola berikut:")
    
    title_headers = ["Komponen", "Pola Lama (Kurang Memikat)", "Pola Baru CTR Hijacking (High Conversion)"]
    title_rows = [
        ["Meta Title", "Jasa Pipa Mampet Bintaro - Drainusantara", "[Bergaransi] Jasa Pipa Mampet Bintaro: Tanpa Bongkar 24 Jam"],
        ["Meta Title (Kota)", "Jasa Saluran Mampet Depok Profesional", "Jasa Saluran Pipa Mampet Depok: 30 Menit Tiba & No Cure No Pay"],
        ["Meta Description", "Kami melayani jasa pipa mampet di Jakarta dan sekitarnya dengan harga terjangkau dan teknisi berpengalaman.", "Saluran mampet di Bintaro? Teknisi siaga 24 jam tiba 30 menit. Metode mesin Ridgid spiral baja tanpa bongkar keramik. Garansi tuntas & No Cure No Pay!"]
    ]
    add_styled_table(doc, title_headers, title_rows, [1.4, 2.3, 3.2])

    add_h2(doc, "3.2 De-Thinning Konten Lokal & Injeksi FAQ Schema per Kecamatan")
    add_p(doc, "Untuk menghindari penalti 'Doorway Pages' (halaman duplikat yang hanya mengganti nama kota), kita telah menerapkan modul RegionalTaxonomy di Laravel. Langkah berikutnya adalah menyisipkan modul FAQ interaktif dengan Schema.org FAQPage di setiap halaman kecamatan target:")
    add_bullet(doc, "Contoh Pertanyaan 1: 'Berapa estimasi waktu teknisi tiba di [Kecamatan]?' — Jawaban: 'Armada kami siaga di posko terdekat dan tiba dalam 30–45 menit ke seluruh perumahan dan ruko di area [Kecamatan].'", "Pertanyaan Waktu Tempuh: ")
    add_bullet(doc, "Contoh Pertanyaan 2: 'Apakah ada jaminan jika saluran tetap mampet?' — Jawaban: 'Kami memegang teguh prinsip No Cure No Pay. Jika saluran pembuangan Anda gagal kami lancarkan, Anda bebas biaya pengerjaan 100%.'", "Pertanyaan Garansi: ")
    add_bullet(doc, "Contoh Pertanyaan 3: 'Apakah merusak ubin keramik atau membongkar lantai semen?' — Jawaban: 'Sama sekali tidak. Mesin Ridgid kami menggunakan kawat spiral baja lentur berputar yang mengikuti lekukan leher angsa dan pipa tanpa pembongkaran fisik.'", "Pertanyaan Metode Kerja: ")

    add_h2(doc, "3.3 Silo Internal Linking Kontekstual dari Blog ke Halaman Wilayah")
    add_p(doc, "Domain baru membutuhkan aliran 'link equity' (kekuatan otoritas) internal. Artikel blog edukasi yang sudah terindeks wajib memberikan tautan langsung ke halaman komersial dengan anchor text yang bervariasi:")
    add_bullet(doc, "Pada artikel bertema lemak dapur, sisipkan link: '...khusus bagi pemilik hunian di Tangerang Selatan, layanan [jasa pipa mampet Bintaro](file:///area/tangerang-selatan/pondok-aren) kami siap membersihkan endapan lemak beku.'", "Anchor Text Wilayah 1: ")
    add_bullet(doc, "Pada artikel bertema pipa talang air, sisipkan link: '...hubungi posko [jasa saluran mampet Depok](file:///area/depok) untuk inspeksi talang rooftop sebelum puncak musim hujan.'", "Anchor Text Wilayah 2: ")
    add_bullet(doc, "Hindari anchor text generik seperti 'klik di sini' atau 'baca selengkapnya'. Gunakan selalu kombinasi [Layanan + Nama Wilayah].", "Kaidah Anchor Text: ")

    add_h2(doc, "3.4 Membangun Local Citations Resmi di Direktori Indonesia")
    add_p(doc, "Untuk mendongkrak Domain Authority tanpa risiko backlink spam (PBN), daftarkan Drainusantara ke 5 direktori bisnis terpercaya di Indonesia dengan data NAP 100% identik:")
    add_bullet(doc, "Pilih kategori Kontraktor Sanitasi / Tukang Ledeng.", "1. Yellowpages Indonesia (yellowpages.co.id): ")
    add_bullet(doc, "Buat profil perusahaan PT Jawa Jaya Rooter / Drainusantara.", "2. Indonetwork (indonetwork.co.id): ")
    add_bullet(doc, "Tampilkan daftar 5 katalog layanan utama.", "3. Indotrading (indotrading.com): ")
    add_bullet(doc, "Buat halaman bisnis resmi lengkap dengan tombol WhatsApp dan link website.", "4. Halaman Bisnis Facebook & Profil Instagram Profesional: ")
    add_bullet(doc, "Verifikasi profil korporasi PT Jawa Jaya Rooter.", "5. Halaman Perusahaan LinkedIn: ")

    # BAB 4
    add_h1(doc, "BAB 4: SOP & TEMPLATE KOMUNIKASI OPERASIONAL")
    add_p(doc, "Keberhasilan strategi SEO lokal sangat bertumpu pada eksekusi tim lapangan dan admin customer service. Berikut adalah template siap pakai:")
    
    add_h2(doc, "4.1 Script WhatsApp Teknisi Meminta Ulasan Pelanggan")
    add_callout(doc, "TEMPLATE WHATSAPP MEMOHON ULASAN BINTANG 5", [
        "Halo Bapak/Ibu [Nama Pelanggan],",
        "Terima kasih telah mempercayakan pelancaran saluran air rumah Anda kepada tim Drainusantara hari ini.",
        "",
        "Alhamdulillah pekerjaan di [Nama Area / Perumahan] telah selesai dan air sudah mengalir lancar kembali.",
        "Untuk membantu tetangga dan warga sekitar [Nama Kota] yang mengalami kendala saluran mampet serupa, sudikah Bapak/Ibu meluangkan waktu 1 menit untuk memberikan ulasan bintang 5 singkat di Google Maps kami?",
        "",
        "👉 Klik tautan singkat berikut untuk memberi ulasan: [MASUKKAN_LINK_SHORT_REVIEW_GBP]",
        "",
        "Ulasan Bapak/Ibu sangat berarti bagi perkembangan teknisi lokal kami. Terima kasih banyak dan salam sehat selalu! 🙏"
    ], bg_color="F0FDF4", border_color="16A34A")

    add_h2(doc, "4.2 Template Owner Response untuk Ulasan Bintang 5 (SEO Booster)")
    add_callout(doc, "TEMPLATE BALASAN PEMILIK BISNIS (INJEKSI KATA KUNCI LOKAL)", [
        "Terima kasih banyak Bapak/Ibu [Nama Pelanggan] atas kepercayaan dan ulasan bintang 5 yang diberikan!",
        "",
        "Tim teknisi Drainusantara cabang [Nama Kota] sangat senang dapat membantu melancarkan saluran [kloset / wastafel / talang air] rumah Anda di area [Nama Kecamatan] tanpa perlu membongkar keramik lantai menggunakan mesin Ridgid spiral baja kami.",
        "",
        "Ingat, seluruh pengerjaan kami dilindungi garansi operasional. Jika membutuhkan pengecekan pipa atau konsultasi sanitasi lainnya, kami selalu siaga 24 jam. Salam hangat dari tim Drainusantara!"
    ], bg_color="F0F9FF", border_color="0284C7")

    # BAB 5
    add_h1(doc, "BAB 5: ROADMAP EKSEKUSI 4 MINGGU (ACTION CHECKLIST)")
    add_p(doc, "Gunakan tabel checklist operasional berikut untuk memantau progres mingguan lintas tim teknis dan operasional:")
    
    roadmap_headers = ["Minggu", "Fokus Utama", "Tindakan Konkret", "Penanggung Jawab", "Target Output"]
    roadmap_rows = [
        [
            "Minggu 1",
            "Fondasi GBP & Validasi GSC",
            "1. Ubah Kategori Utama GBP menjadi 'Plumber'.\n2. Masukkan semua kota/kecamatan di Service Area.\n3. Pasang URL website ber-UTM di profil GBP.\n4. Deploy kode fallback 301 ke produksi.\n5. Klik 'Validasi Perbaikan' 404 di GSC.",
            "Admin & Web Dev",
            "Listing GBP terhubung rapi ke website; Error 404 tervalidasi di GSC."
        ],
        [
            "Minggu 2",
            "Katalog Layanan & Review Perdana",
            "1. Masukkan 5 katalog menu layanan di GBP.\n2. Terapkan SOP WhatsApp permintaan ulasan ke 5 pelanggan nyata pertama di Bintaro/Depok.\n3. Balas ulasan masuk dengan template kata kunci.",
            "Customer Service & Teknisi",
            "Minimal 5 ulasan bintang 5 organik terkumpul dengan sebutan nama area."
        ],
        [
            "Minggu 3",
            "Aktivitas Konten & Citations",
            "1. Unggah 3 foto lapangan ber-GPS ke GBP.\n2. Buat 1 postingan penawaran mingguan di GBP.\n3. Sisipkan internal link dari blog ke Bintaro & Depok.\n4. Daftarkan profil di Yellowpages & Indonetwork.",
            "Marketing & Content",
            "Peningkatan sinyal keaktifan profil; Backlink direktori lokal terpasang."
        ],
        [
            "Minggu 4",
            "Evaluasi SERP & Penajaman",
            "1. Buka laporan Performa GSC: filter kueri 'bintaro' dan 'depok'.\n2. Evaluasi lonjakan CTR dan posisi kueri Striking Distance.\n3. Cek panggilan telepon masuk via tombol GBP.",
            "Owner & Analis SEO",
            "Kueri target mulai tembus Halaman 1 (Top 10); Konversi WhatsApp meningkat."
        ]
    ]
    add_styled_table(doc, roadmap_headers, roadmap_rows, [0.8, 1.4, 2.7, 1.0, 1.0])
    
    # Final Sign-off Note
    add_callout(doc, "STATUS KESIAPAN KODE & REKOMENDASI DEPLOYMENT", [
        "Seluruh penyempurnaan kode lokal (Graceful 301 fallback untuk studi kasus, redirect alias Jakarta, mobile breadcrumb crawler, anchor text Tukang Pipa, dan konfigurasi Schema Plumber GBP) telah selesai diuji dan 100% lolos automated test suite.",
        "Kode tersimpan rapi di cabang 'ilham-dev' dan siap untuk di-commit dan di-push ke server produksi kapan saja Anda menginstruksikannya."
    ], bg_color="FFFBEB", border_color="F59E0B")
    
    output_path = os.path.abspath(r"C:\Users\Ilham Dwi Arsandy\Documents\drainusantara\docs\Panduan-Strategi-GBP-dan-Akselerasi-Peringkat-GSC-Drainusantara.docx")
    doc.save(output_path)
    print(f"Document successfully created at: {output_path}")

if __name__ == "__main__":
    build_document()
