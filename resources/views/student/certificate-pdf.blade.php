<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Completion - {{ $certificate->course->title }}</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: linear-gradient(135deg, #f9fafb 0%, #f3e8ff 100%);
            padding: 40px;
        }
        .certificate-container {
            width: 1000px;
            height: 707px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3e8ff 100%);
            position: relative;
            margin: 0 auto;
        }
        .outer-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 4px solid #9333ea;
            border-radius: 12px;
        }
        .inner-border {
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            border: 2px solid rgba(147, 51, 234, 0.5);
            border-radius: 8px;
        }
        .content {
            position: absolute;
            top: 60px;
            left: 80px;
            right: 80px;
            bottom: 60px;
            text-align: center;
        }
        .logo-circle {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .logo-text {
            font-size: 48px;
            font-weight: bold;
            color: white;
        }
        .brand-name {
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }
        .brand-subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 40px;
        }
        .certificate-title {
            font-family: serif;
            font-size: 56px;
            font-weight: bold;
            color: #1f2937;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        .of-completion {
            font-size: 18px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 20px;
        }
        .presented-to {
            font-size: 12px;
            color: #9ca3af;
            font-style: italic;
            margin-bottom: 20px;
        }
        .student-name {
            font-family: serif;
            font-size: 48px;
            font-weight: bold;
            background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 30px;
        }
        .course-intro {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .course-title {
            font-size: 22px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        .signatures {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            display: table;
            width: 100%;
        }
        .signature-row {
            display: table-row;
        }
        .signature-cell {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 20px;
        }
        .signature-line {
            border-top: 2px solid #9ca3af;
            padding-top: 8px;
            min-width: 180px;
            margin: 0 auto;
        }
        .signature-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            margin-bottom: 3px;
        }
        .signature-title {
            font-size: 11px;
            color: #6b7280;
        }
        .seal {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%);
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(12deg);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .seal-inner {
            width: 75px;
            height: 75px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .seal-icon {
            width: 40px;
            height: 40px;
            fill: #9333ea;
        }
        .certificate-details {
            margin-top: 30px;
            font-size: 10px;
            color: #9ca3af;
        }
        .cert-number {
            font-family: monospace;
            font-weight: 600;
            color: #9333ea;
        }
        .corner-tl {
            position: absolute;
            top: 50px;
            left: 50px;
            width: 60px;
            height: 60px;
            border-top: 4px solid #c084fc;
            border-left: 4px solid #c084fc;
            border-top-left-radius: 24px;
        }
        .corner-tr {
            position: absolute;
            top: 50px;
            right: 50px;
            width: 60px;
            height: 60px;
            border-top: 4px solid #c084fc;
            border-right: 4px solid #c084fc;
            border-top-right-radius: 24px;
        }
        .corner-bl {
            position: absolute;
            bottom: 50px;
            left: 50px;
            width: 60px;
            height: 60px;
            border-bottom: 4px solid #f0abfc;
            border-left: 4px solid #f0abfc;
            border-bottom-left-radius: 24px;
        }
        .corner-br {
            position: absolute;
            bottom: 50px;
            right: 50px;
            width: 60px;
            height: 60px;
            border-bottom: 4px solid #f0abfc;
            border-right: 4px solid #f0abfc;
            border-bottom-right-radius: 24px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Decorative Borders -->
        <div class="outer-border">
            <div class="inner-border"></div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Header with Logo -->
            <div style="margin-bottom: 30px;">
                <div class="logo-circle">
                    <span class="logo-text">IA</span>
                </div>
                <div class="brand-name">imole Africa</div>
                <div class="brand-subtitle">Learning Management System</div>
            </div>

            <!-- Certificate Title -->
            <div style="margin-bottom: 50px;">
                <h1 class="certificate-title">CERTIFICATE</h1>
                <p class="of-completion">Of Completion</p>
                <p class="presented-to">proudly presented to</p>

                <!-- Student Name -->
                <h2 class="student-name">{{ $certificate->user->name }}</h2>

                <!-- Course Title -->
                <p class="course-intro">for successfully completing the online course</p>
                <h3 class="course-title">{{ $certificate->course->title }}</h3>
            </div>

            <!-- Footer with Signatures -->
            <div class="signatures">
                <div class="signature-row">
                    <!-- Instructor Signature -->
                    <div class="signature-cell">
                        <div class="signature-line">
                            <div class="signature-name">{{ $certificate->course->instructor->name }}</div>
                            <div class="signature-title">Course Instructor</div>
                        </div>
                    </div>

                    <!-- Seal -->
                    <div class="signature-cell">
                        <div class="seal">
                            <div class="seal-inner">
                                <svg class="seal-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Platform Director -->
                    <div class="signature-cell">
                        <div class="signature-line">
                            <div class="signature-name">imole Africa</div>
                            <div class="signature-title">Platform Director</div>
                        </div>
                    </div>
                </div>

                <!-- Certificate Details -->
                <div class="certificate-details">
                    <p>Certificate Number: <span class="cert-number">{{ $certificate->certificate_number }}</span></p>
                    <p>Issued on: {{ $certificate->issued_at->format('F j, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Decorative Corner Elements -->
        <div class="corner-tl"></div>
        <div class="corner-tr"></div>
        <div class="corner-bl"></div>
        <div class="corner-br"></div>
    </div>
</body>
</html>
