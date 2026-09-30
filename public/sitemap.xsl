<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
    xmlns:html="http://www.w3.org/TR/REC-html40"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>

<xsl:template match="/">
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Peta Situs XML (XML Sitemap Index) &#8212; Drainusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            --color-bg: #f8fafc;
            --color-surface: #ffffff;
            --color-border: #e2e8f0;
            --color-border-subtle: #f1f5f9;
            --color-text-main: #0f172a;
            --color-text-muted: #64748b;
            --color-text-body: #334155;
            --color-brand: #0369a1;
            --color-brand-hover: #0284c7;
            --color-brand-subtle: #f0f9ff;
            --color-brand-border: #bae6fd;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--color-bg);
            color: var(--color-text-body);
            line-height: 1.5;
            padding: 2rem 1.25rem 3.5rem;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
        }

        /* Top System Navigation Bar */
        .system-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--color-border);
        }

        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: inherit;
        }

        .brand-monogram {
            width: 38px;
            height: 38px;
            background-color: #0f172a;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            letter-spacing: 0.05em;
            border: 1px solid #1e293b;
        }

        .brand-info {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--color-text-main);
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-brand);
            letter-spacing: 0.02em;
        }

        .system-meta {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .meta-tag {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--color-text-muted);
            background-color: #f1f5f9;
            border: 1px solid var(--color-border);
            border-radius: 6px;
            padding: 0.25rem 0.55rem;
        }

        .home-action {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--color-brand);
            text-decoration: none;
            background-color: var(--color-brand-subtle);
            border: 1px solid var(--color-brand-border);
            border-radius: 6px;
            padding: 0.35rem 0.75rem;
            transition: all 0.15s ease;
        }

        .home-action:hover {
            background-color: #e0f2fe;
            color: var(--color-brand-hover);
        }

        /* Document Header Card */
        .doc-header {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 10px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.25rem;
        }

        .doc-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--color-text-main);
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .doc-lead {
            font-size: 0.9rem;
            color: var(--color-text-muted);
            max-width: 900px;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        /* Summary Metric Strip - Genuine Numbers Only */
        .metric-strip {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem 1.75rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--color-border-subtle);
            font-size: 0.825rem;
        }

        .metric-cell {
            display: inline-flex;
            align-items: baseline;
            gap: 0.5rem;
        }

        .metric-label {
            color: var(--color-text-muted);
            font-weight: 500;
        }

        .metric-value {
            font-family: var(--font-mono);
            font-weight: 700;
            color: var(--color-text-main);
            font-size: 1rem;
        }

        .metric-divider {
            color: var(--color-border);
            user-select: none;
        }

        /* Main Directory Panel */
        .directory-panel {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 10px;
            overflow: hidden;
        }

        /* Integrated Control Bar */
        .control-bar {
            padding: 1rem 1.25rem;
            background-color: #ffffff;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 280px;
            max-width: 440px;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #94a3b8;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            font-family: var(--font-sans);
            font-size: 0.85rem;
            color: var(--color-text-main);
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 0.55rem 0.75rem 0.55rem 2.25rem;
            outline: none;
            transition: all 0.15s ease;
        }

        .search-input:focus {
            background-color: #ffffff;
            border-color: var(--color-brand);
            box-shadow: 0 0 0 3px rgba(3, 105, 161, 0.12);
        }

        .search-input::placeholder {
            color: #94a3b8;
        }

        .category-tabs {
            display: inline-flex;
            background-color: #f1f5f9;
            padding: 3px;
            border-radius: 8px;
            gap: 2px;
        }

        .tab-btn {
            font-family: var(--font-sans);
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            background: transparent;
            border: none;
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .tab-btn:hover {
            color: var(--color-text-main);
        }

        .tab-btn.active {
            background-color: #ffffff;
            color: var(--color-brand);
            font-weight: 700;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06);
        }

        .tab-count {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            padding: 0.1rem 0.35rem;
            background-color: #e2e8f0;
            border-radius: 4px;
            color: #475569;
        }

        .tab-btn.active .tab-count {
            background-color: var(--color-brand-subtle);
            color: var(--color-brand);
        }

        /* Status and Counter Strip */
        .directory-status-strip {
            padding: 0.6rem 1.25rem;
            background-color: #f8fafc;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--color-text-muted);
        }

        .counter-info strong {
            color: var(--color-text-main);
            font-family: var(--font-mono);
        }

        .shortcut-hint {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .kbd {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            padding: 0.1rem 0.35rem;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            box-shadow: 0 1px 0 #cbd5e1;
            color: var(--color-text-body);
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
            max-height: 720px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.825rem;
            text-align: left;
        }

        thead {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8fafc;
        }

        th {
            padding: 0.75rem 1rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #475569;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--color-border-subtle);
            transition: background-color 0.1s ease;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            color: var(--color-text-body);
        }

        .col-idx {
            width: 48px;
            text-align: center;
            font-family: var(--font-mono);
            font-size: 0.725rem;
            color: #94a3b8;
            font-weight: 600;
        }

        .col-url {
            min-width: 360px;
        }

        .url-entry {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .url-link {
            font-family: var(--font-mono);
            font-size: 0.81rem;
            color: var(--color-brand);
            text-decoration: none;
            word-break: break-all;
            transition: color 0.15s ease;
        }

        .url-link:hover {
            color: var(--color-brand-hover);
            text-decoration: underline;
        }

        .copy-btn {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 4px;
            padding: 0.2rem 0.35rem;
            cursor: pointer;
            color: #94a3b8;
            display: inline-flex;
            align-items: center;
            transition: all 0.15s ease;
        }

        .copy-btn:hover {
            background-color: #f1f5f9;
            color: var(--color-text-main);
            border-color: #cbd5e1;
        }

        .copy-icon {
            width: 14px;
            height: 14px;
        }

        .tag-segment {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .segment-main {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .segment-area {
            background-color: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .segment-article {
            background-color: #fefce8;
            color: #a16207;
            border: 1px solid #fef08a;
        }

        .segment-about {
            background-color: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .priority-val {
            font-family: var(--font-mono);
            font-weight: 700;
            font-size: 0.75rem;
            color: #334155;
            background-color: #f1f5f9;
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .priority-high {
            background-color: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .freq-val {
            font-size: 0.75rem;
            color: var(--color-text-muted);
            white-space: nowrap;
        }

        .lastmod-val {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: var(--color-text-muted);
            white-space: nowrap;
        }

        /* Empty Filter State */
        .empty-state {
            padding: 3.5rem 1.5rem;
            text-align: center;
        }

        .empty-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--color-text-main);
            margin-bottom: 0.35rem;
        }

        .empty-desc {
            font-size: 0.825rem;
            color: var(--color-text-muted);
            margin-bottom: 1rem;
        }

        .btn-reset {
            font-family: var(--font-sans);
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--color-brand);
            background-color: #ffffff;
            border: 1px solid var(--color-brand-border);
            border-radius: 6px;
            padding: 0.4rem 0.85rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-reset:hover {
            background-color: var(--color-brand-subtle);
        }

        /* Toast Notification */
        .toast-notify {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background-color: #0f172a;
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.65rem 1rem;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            pointer-events: none;
            transform: translateY(8px);
            transition: all 0.2s ease;
            z-index: 100;
        }

        .toast-notify.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Footer Info */
        .sitemap-footer {
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            font-size: 0.78rem;
            color: var(--color-text-muted);
        }

        .sitemap-footer a {
            color: var(--color-brand);
            text-decoration: none;
            font-weight: 600;
        }

        .sitemap-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0.75rem 2.5rem;
            }
            .doc-header {
                padding: 1.25rem;
            }
            h1 {
                font-size: 1.25rem;
            }
            .control-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-wrapper {
                max-width: 100%;
            }
            .category-tabs {
                overflow-x: auto;
                width: 100%;
            }
            .metric-strip {
                gap: 0.75rem 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top System Bar -->
        <header class="system-topbar">
            <a href="/" class="brand-link" title="Kembali ke Beranda Drainusantara">
                <div class="brand-monogram">DN</div>
                <div class="brand-info">
                    <span class="brand-title">DRAINUSANTARA</span>
                    <span class="brand-subtitle">Indeks Peta Situs (Sitemap Index)</span>
                </div>
            </a>
            <div class="system-meta">
                <span class="meta-tag">sitemaps.org 0.9</span>
                <span class="meta-tag">UTF-8</span>
                <a href="/" class="home-action">
                    <span>Beranda Drainusantara</span>
                    <span>&#8594;</span>
                </a>
            </div>
        </header>

        <!-- Document Header -->
        <section class="doc-header">
            <div class="doc-title-row">
                <h1>Peta Situs XML Resmi (Indeks Direktori URL)</h1>
            </div>
            <p class="doc-lead">
                Dokumen indeks teknis untuk perayap mesin pencari (Googlebot, Bingbot). Memetakan seluruh hierarki layanan perbaikan pipa mampet tanpa bongkar keramik, direktori pendaratan wilayah (Jabodetabek, Semarang, Bandar Lampung), serta basis pengetahuan teknis Drainusantara.
            </p>

            <!-- Accurate Real Metrics (Calculated directly from XML via XPath) -->
            <div class="metric-strip">
                <div class="metric-cell">
                    <span class="metric-label">Total URL:</span>
                    <span class="metric-value" id="statTotal"><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></span>
                </div>
                <span class="metric-divider">&#8226;</span>
                <div class="metric-cell">
                    <span class="metric-label">Landing Wilayah (SEO):</span>
                    <span class="metric-value"><xsl:value-of select="count(sitemap:urlset/sitemap:url[contains(sitemap:loc, '/area')])"/></span>
                </div>
                <span class="metric-divider">&#8226;</span>
                <div class="metric-cell">
                    <span class="metric-label">Artikel &amp; Edukasi:</span>
                    <span class="metric-value"><xsl:value-of select="count(sitemap:urlset/sitemap:url[contains(sitemap:loc, '/artikel')])"/></span>
                </div>
                <span class="metric-divider">&#8226;</span>
                <div class="metric-cell">
                    <span class="metric-label">Layanan &amp; Profil:</span>
                    <span class="metric-value"><xsl:value-of select="count(sitemap:urlset/sitemap:url[not(contains(sitemap:loc, '/area')) and not(contains(sitemap:loc, '/artikel'))])"/></span>
                </div>
            </div>
        </section>

        <!-- Unified Directory Panel -->
        <main class="directory-panel">
            <!-- Control Bar: Search and Category Tabs -->
            <div class="control-bar">
                <div class="search-wrapper">
                    <svg class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari URL, kota, kecamatan, artikel (Tekan '/' untuk fokus)..." autocomplete="off" spellcheck="false"/>
                </div>

                <div class="category-tabs" role="tablist">
                    <button type="button" class="tab-btn active" data-category="all" onclick="selectTab('all', this)">
                        <span>Semua</span>
                        <span class="tab-count"><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></span>
                    </button>
                    <button type="button" class="tab-btn" data-category="area" onclick="selectTab('area', this)">
                        <span>Wilayah</span>
                        <span class="tab-count"><xsl:value-of select="count(sitemap:urlset/sitemap:url[contains(sitemap:loc, '/area')])"/></span>
                    </button>
                    <button type="button" class="tab-btn" data-category="article" onclick="selectTab('article', this)">
                        <span>Artikel</span>
                        <span class="tab-count"><xsl:value-of select="count(sitemap:urlset/sitemap:url[contains(sitemap:loc, '/artikel')])"/></span>
                    </button>
                    <button type="button" class="tab-btn" data-category="core" onclick="selectTab('core', this)">
                        <span>Layanan &amp; Profil</span>
                        <span class="tab-count"><xsl:value-of select="count(sitemap:urlset/sitemap:url[not(contains(sitemap:loc, '/area')) and not(contains(sitemap:loc, '/artikel'))])"/></span>
                    </button>
                </div>
            </div>

            <!-- Dynamic Result Counter Strip -->
            <div class="directory-status-strip">
                <div class="counter-info">
                    Menampilkan <strong id="visibleCount"><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></strong> dari <strong><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></strong> entri URL
                </div>
                <div class="shortcut-hint">
                    <span>Pintasan:</span>
                    <span class="kbd">/</span>
                    <span>Cari</span>
                    <span class="kbd">ESC</span>
                    <span>Reset</span>
                </div>
            </div>

            <!-- Table of URLs -->
            <div class="table-responsive">
                <table id="sitemapTable">
                    <thead>
                        <tr>
                            <th class="col-idx">#</th>
                            <th class="col-url">Alamat URL Halaman</th>
                            <th>Segmen</th>
                            <th>Prioritas</th>
                            <th>Frekuensi</th>
                            <th>Terakhir Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody id="sitemapTbody">
                        <xsl:for-each select="sitemap:urlset/sitemap:url">
                            <xsl:variable name="prio" select="sitemap:priority"/>
                            <xsl:variable name="loc" select="sitemap:loc"/>
                            <tr class="url-row" data-url="{$loc}">
                                <td class="col-idx">
                                    <xsl:value-of select="position()"/>
                                </td>
                                <td>
                                    <div class="url-entry">
                                        <a href="{$loc}" target="_blank" rel="noopener noreferrer" class="url-link">
                                            <xsl:value-of select="$loc"/>
                                        </a>
                                        <button type="button" class="copy-btn" onclick="copyUrl('{$loc}')" title="Salin URL ke clipboard">
                                            <svg class="copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <xsl:choose>
                                        <xsl:when test="contains($loc, '/area')">
                                            <span class="tag-segment segment-area">Wilayah</span>
                                        </xsl:when>
                                        <xsl:when test="contains($loc, '/artikel')">
                                            <span class="tag-segment segment-article">Artikel</span>
                                        </xsl:when>
                                        <xsl:when test="contains($loc, '/tentang-kami') or contains($loc, '/profil') or contains($loc, '/sop') or contains($loc, '/peralatan') or contains($loc, '/garansi') or contains($loc, '/holding') or contains($loc, '/portofolio') or contains($loc, '/faq')">
                                            <span class="tag-segment segment-about">Profil / K3</span>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <span class="tag-segment segment-main">Utama</span>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                                <td>
                                    <xsl:choose>
                                        <xsl:when test="$prio = '1.0' or $prio = '0.9'">
                                            <span class="priority-val priority-high"><xsl:value-of select="$prio"/></span>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <span class="priority-val"><xsl:value-of select="$prio"/></span>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                                <td>
                                    <span class="freq-val">
                                        <xsl:value-of select="sitemap:changefreq"/>
                                    </span>
                                </td>
                                <td>
                                    <span class="lastmod-val">
                                        <xsl:value-of select="substring(sitemap:lastmod, 1, 10)"/>
                                    </span>
                                </td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>

                <!-- Empty Filter State -->
                <div id="emptyState" class="empty-state" style="display: none;">
                    <div class="empty-title">Tidak ada URL yang cocok</div>
                    <p class="empty-desc">Coba sesuaikan kata kunci pencarian atau pilih tab kategori yang lain.</p>
                    <button type="button" class="btn-reset" onclick="resetFilters()">Reset Filter</button>
                </div>
            </div>
        </main>

        <!-- Technical Footer -->
        <footer class="sitemap-footer">
            <div>
                Drainusantara XML Sitemap Engine &#8226; Terindeks sesuai standar protokol <a href="https://www.sitemaps.org" target="_blank" rel="noopener noreferrer">sitemaps.org</a>
            </div>
            <div>
                <a href="/">Kembali ke drainusantara.com</a>
            </div>
        </footer>
    </div>

    <!-- Notification Toast -->
    <div id="toast" class="toast-notify">URL berhasil disalin</div>

    <!-- Client-Side Filtering Script -->
    <script type="text/javascript">
    <![CDATA[
        var currentCategory = 'all';
        var searchInput = document.getElementById('searchInput');
        var visibleCountEl = document.getElementById('visibleCount');
        var emptyState = document.getElementById('emptyState');
        var sitemapTable = document.getElementById('sitemapTable');
        var rows = document.querySelectorAll('#sitemapTbody tr.url-row');
        var totalRows = rows.length;

        function applyFilters() {
            var query = searchInput.value.trim().toLowerCase();
            var visibleCount = 0;

            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var url = (row.getAttribute('data-url') || '').toLowerCase();
                var matchesQuery = query === '' || url.indexOf(query) !== -1;
                var matchesCategory = true;

                if (currentCategory === 'area') {
                    matchesCategory = url.indexOf('/area') !== -1;
                } else if (currentCategory === 'article') {
                    matchesCategory = url.indexOf('/artikel') !== -1;
                } else if (currentCategory === 'core') {
                    matchesCategory = url.indexOf('/area') === -1 && url.indexOf('/artikel') === -1;
                }

                if (matchesQuery && matchesCategory) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }

            visibleCountEl.textContent = visibleCount;

            if (visibleCount === 0) {
                emptyState.style.display = 'block';
                sitemapTable.style.display = 'none';
            } else {
                emptyState.style.display = 'none';
                sitemapTable.style.display = '';
            }
        }

        searchInput.addEventListener('input', applyFilters);

        function selectTab(category, btnElement) {
            currentCategory = category;
            var buttons = document.querySelectorAll('.category-tabs .tab-btn');
            for (var j = 0; j < buttons.length; j++) {
                buttons[j].classList.remove('active');
            }
            btnElement.classList.add('active');
            applyFilters();
        }

        function resetFilters() {
            searchInput.value = '';
            currentCategory = 'all';
            var buttons = document.querySelectorAll('.category-tabs .tab-btn');
            for (var k = 0; k < buttons.length; k++) {
                if (buttons[k].getAttribute('data-category') === 'all') {
                    buttons[k].classList.add('active');
                } else {
                    buttons[k].classList.remove('active');
                }
            }
            applyFilters();
            searchInput.focus();
        }

        // Keyboard shortcuts: '/' to focus search, 'Escape' to reset
        window.addEventListener('keydown', function(e) {
            if (e.key === '/' && document.activeElement !== searchInput) {
                e.preventDefault();
                searchInput.focus();
            } else if (e.key === 'Escape' && document.activeElement === searchInput) {
                if (searchInput.value !== '') {
                    resetFilters();
                } else {
                    searchInput.blur();
                }
            }
        });

        // Copy URL to Clipboard
        function copyUrl(url) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    showToast('URL berhasil disalin ke clipboard');
                }).catch(function() {
                    fallbackCopy(url);
                });
            } else {
                fallbackCopy(url);
            }
        }

        function fallbackCopy(text) {
            var tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand('copy');
                showToast('URL berhasil disalin ke clipboard');
            } catch (err) {
                showToast('Gagal menyalin URL');
            }
            document.body.removeChild(tempInput);
        }

        function showToast(message) {
            var toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(function() {
                toast.classList.remove('show');
            }, 2000);
        }
    ]]>
    </script>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
