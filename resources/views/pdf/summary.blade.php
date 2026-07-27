<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $summary->title }}</title>
    <style>
        @page {
            margin: 110px 45px 70px 45px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            font-size: 11pt;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Fixed Header */
        header {
            position: fixed;
            top: -90px;
            left: 0px;
            right: 0px;
            height: 70px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 8px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-brand {
            font-size: 14pt;
            font-weight: bold;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-sub {
            font-size: 8pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header-meta {
            text-align: right;
            font-size: 9pt;
            color: #475569;
        }

        /* Fixed Footer */
        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 35px;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            font-size: 8pt;
            color: #64748b;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pagenum:before {
            content: counter(page);
        }

        /* Main Content Container */
        .title-container {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #4f46e5;
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 25px;
        }

        .course-code-badge {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff;
            font-size: 8.5pt;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .doc-title {
            font-size: 16pt;
            font-weight: bold;
            color: #0f172a;
            margin: 4px 0 8px 0;
            line-height: 1.3;
        }

        .doc-info {
            font-size: 9pt;
            color: #475569;
        }

        /* Markdown Typography Formatting */
        h1, h2, h3, h4 {
            color: #0f172a;
            font-weight: bold;
            margin-top: 22px;
            margin-bottom: 10px;
            page-break-after: avoid;
        }

        h1 {
            font-size: 14pt;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 4px;
            color: #3730a3;
        }

        h2 {
            font-size: 12.5pt;
            color: #4f46e5;
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 4px;
            border-left: 3.5px solid #4f46e5;
        }

        h3 {
            font-size: 11.5pt;
            color: #1e293b;
        }

        p {
            margin-top: 0;
            margin-bottom: 12px;
            text-align: justify;
        }

        ul, ol {
            margin-top: 0;
            margin-bottom: 12px;
            padding-left: 22px;
        }

        li {
            margin-bottom: 4px;
        }

        blockquote {
            background: #f8fafc;
            border-left: 4px solid #818cf8;
            margin: 12px 0;
            padding: 8px 14px;
            font-style: italic;
            color: #334155;
        }

        code {
            font-family: 'Courier', monospace;
            background: #f1f5f9;
            color: #c026d3;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9.5pt;
        }

        pre {
            background: #0f172a;
            color: #f8fafc;
            padding: 12px;
            border-radius: 6px;
            font-family: 'Courier', monospace;
            font-size: 9pt;
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 9.5pt;
        }

        table th, table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }

        table th {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <table class="header-table">
            <tr>
                <td>
                    <div class="header-brand">EduMentor AI</div>
                    <div class="header-sub">Structured Academic Summary</div>
                </td>
                <td class="header-meta">
                    <strong>Course:</strong> {{ $course->course_code }}<br>
                    <strong>Generated:</strong> {{ now()->format('M d, Y') }}
                </td>
            </tr>
        </table>
    </header>

    <!-- Footer -->
    <footer>
        <table class="footer-table">
            <tr>
                <td>EduMentor AI &bull; Smart Learning Companion</td>
                <td style="text-align: right;">Page <span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>

    <!-- Main Title Banner -->
    <div class="title-container">
        <span class="course-code-badge">{{ $course->course_code }} &bull; {{ $course->course_unit }} Units</span>
        <div class="doc-title">{{ $summary->title }}</div>
        <div class="doc-info">
            <strong>Course:</strong> {{ $course->course_title }} ({{ $course->semester }}) &nbsp;|&nbsp;
            <strong>Document:</strong> {{ $material->original_filename ?? $material->title }} &nbsp;|&nbsp;
            <strong>AI Model:</strong> {{ $summary->ai_model ?? 'Gemma AI' }}
        </div>
    </div>

    <!-- Rendered Markdown HTML -->
    <div class="summary-body">
        {!! $summary->html_content !!}
    </div>

</body>
</html>
