<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lautan Karir - Online Test Hub</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --navy: #103783; --success-bg: #f0fdf4; --danger-bg: #fff5f5; }
        body { background-color: #f4f6f9; font-family: 'Nunito', sans-serif; user-select: none; }
        
        /* Utility Classes */
        .bg-navy { background-color: var(--navy); }
        .text-navy { color: var(--navy); }
        
        /* Card & UI Components */
        .test-card { transition: all 0.3s; border: 2px solid transparent; cursor: pointer; border-radius: 15px; }
        .test-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-color: var(--navy); }
        .test-card.completed { border-color: #1cc88a; background-color: var(--success-bg); }
        .test-card.incomplete { border-color: #e74a3b; background-color: var(--danger-bg); }
        
        .guide-box { border-left: 5px solid var(--navy); background: #fff; border-radius: 8px; }
        .soal-scroll-area { max-height: 65vh; overflow-y: auto; padding-right: 15px; margin-bottom: 20px; border-bottom: 2px solid #eee; }
        
        .papi-card { cursor: pointer; transition: all 0.2s; border: 2px solid #eaecf4; height: 100%; border-radius: 10px; }
        .papi-card:hover { border-color: #4e73df; background-color: #f8f9fc; }
        .papi-card.selected { border-color: #4e73df; background-color: #e8f0fe; font-weight: bold; border-width: 3px; }
        
        .section-screen { display: none; }
        .active-screen { display: block; }
        .autosave-badge { font-size: 0.75rem; color: #1cc88a; opacity: 0; transition: opacity 0.5s; font-weight: bold; }
        .autosave-badge.show { opacity: 1; }

        .btn-navy {
        background-color: #002366; /* Warna Navy Lautan Karir */
        border-color: #002366;
        transition: all 0.3s ease;
    }

    .btn-navy:hover {
        background-color: #001a4d; /* Warna lebih gelap saat di-hover */
        transform: translateY(-2px); /* Efek melayang sedikit */
        box-shadow: 0 5px 15px rgba(0, 35, 102, 0.3) !important;
    }

    .btn-navy:active {
        transform: translateY(0);
    }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand font-weight-bold d-flex align-items-center" href="#">
                <img src="{{ asset('img/logo.PNG') }}" height="35" class="mr-2" alt="Logo"> 
                <span class="text-navy">LAUTAN KARIR</span>
            </a>
            <div class="ml-auto d-flex align-items-center">
                <div id="autosave-indicator" class="autosave-badge mr-3">
                    <i class="fas fa-cloud-upload-alt mr-1"></i> Jawaban Tersimpan Otomatis
                </div>
                <div class="font-weight-bold text-dark border-left pl-3" id="nav-title">Portal Seleksi Tahap II</div>
            </div>
        </div>
    </nav>

    <div id="screen-menu" class="container py-5 section-screen active-screen">
        <div class="text-center mb-4">
            <h3 class="font-weight-bold text-dark">Halo, {{ Auth::guard('pelamar')->user()->nama }}!</h3>
            <p class="text-muted">Pantau progres pengerjaan psikotes Anda di bawah ini.</p>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <div class="card guide-box shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-navy"><i class="fas fa-info-circle mr-2"></i> Panduan Pengerjaan:</h6>
                        <div class="small text-secondary mt-3">
                            <div class="d-flex align-items-start mb-2">
                                <span class="font-weight-bold mr-2">1.</span>
                                <div><i class="fas fa-check-double text-success mr-1"></i> Wajib menyelesaikan <b>kedua modul tes</b> (PAPI & DISC).</div>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <span class="font-weight-bold mr-2">2.</span>
                                <div><i class="fas fa-save text-info mr-1"></i> Tes hanya bisa dikirim jika <b>"Kedua tes diselesaikan."</b> </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <span class="font-weight-bold mr-2">3.</span>
                                <div><i class="fas fa-paper-plane text-warning mr-1"></i> Jawaban <b>tersimpan otomatis</b>. Anda bebas menutup halaman dan melanjutkan kembali kapan saja sampai lowongan masih tersedia.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card shadow h-100 test-card" id="card-papi" onclick="prepareTest('papi')">
                    <div class="card-body text-center p-5">
                        <div class="mb-3"><i class="fas fa-tasks fa-3x text-primary"></i></div>
                        <h4 class="font-weight-bold text-dark">Tes Papikostik</h4>
                        <p class="small text-muted mb-3">Mengukur kecenderungan perilaku dalam lingkungan kerja.</p>
                        <div id="status-papi"><button class="btn btn-outline-primary rounded-pill px-4">Mulai</button></div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mb-4">
                <div class="card shadow h-100 test-card" id="card-disc" onclick="prepareTest('disc')">
                    <div class="card-body text-center p-5">
                        <div class="mb-3"><i class="fas fa-user-check fa-3x text-success"></i></div>
                        <h4 class="font-weight-bold text-dark">Tes DISC</h4>
                        <p class="small text-muted mb-3">Memahami tipe kepribadian dan gaya komunikasi Anda.</p>
                        <div id="status-disc"><button class="btn btn-outline-success rounded-pill px-4">Mulai</button></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="final-submit-container" class="text-center mt-5" style="display: none;">
            <div class="alert alert-success d-inline-block px-5 py-4 shadow-sm border-0">
                <h5 class="font-weight-bold mb-2">Semua Tes Telah Selesai!</h5>
                <p class="small mb-3">Klik tombol di bawah untuk mengirim hasil seleksi Anda ke HRD.</p>
                <button class="btn btn-success btn-lg font-weight-bold px-5 rounded-pill shadow" onclick="submitAll()">
                    KIRIM JAWABAN SEKARANG <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="screen-instruction" class="container py-5 section-screen">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-navy text-white py-3 d-flex align-items-center">
                        <i class="fas fa-book-open mr-3"></i>
                        <h5 class="m-0 font-weight-bold">Instruksi Pengerjaan</h5>
                    </div>
                    <div class="card-body p-5">
                        <h4 class="font-weight-bold text-dark mb-3" id="instruction-title"></h4>
                        <div id="instruction-content" class="text-secondary mb-4" style="font-size: 1.1rem; line-height: 1.6;"></div>
                        
                        <div class="alert alert-info border-0 small">
                            <i class="fas fa-lightbulb mr-1"></i> Tips: Kerjakan dengan jujur dan jadilah diri sendiri. Jawaban Anda tersimpan otomatis.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button class="btn btn-light px-4" onclick="backToMenu()"><i class="fas fa-arrow-left mr-2"></i>Kembali</button>
                            <button class="btn btn-primary px-5 font-weight-bold shadow" onclick="startTestActual()">Mulai Mengerjakan <i class="fas fa-play ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="screen-test" class="container py-5 section-screen">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4">
                    <div class="d-flex justify-content-between text-muted small mb-1 font-weight-bold">
                        <span id="label-progress">Progres Pengisian</span>
                        <span id="progress-text">0%</span>
                    </div>
                    <div class="progress" style="height: 12px; border-radius: 10px; background-color: #e9ecef;">
                        <div id="progress-bar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 0%;"></div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4 bg-warning text-dark">
                    <div class="card-body py-2 px-3 small font-weight-bold">
                        <i class="fas fa-info-circle mr-2"></i> <span id="hint-text"></span>
                    </div>
                </div>

                <div class="soal-scroll-area shadow-sm bg-white rounded p-4">
                    <div id="soal-container-papi" style="display: none;"></div>
                    <div id="soal-container-disc" style="display: none;"></div>
                </div>

                <div class="text-center mt-5 mb-5">
                    <button type="button" 
                            class="btn btn-navy btn-lg px-5 py-3 font-weight-bold shadow-lg text-white rounded-pill" 
                            onclick="finishTest()">
                        <i class="fas fa-save mr-2"></i> 
                        SIMPAN & KEMBALI KE MENU 
                        <i class="fas fa-chevron-right ml-2"></i>
                    </button>
                    <p class="text-muted small mt-2">Jawaban Anda sudah aman tersimpan.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const STORAGE_KEY_PAPI = 'lautan_karir_papi';
        const STORAGE_KEY_DISC = 'lautan_karir_disc';
        const TOTAL_PAPI = 90;
        const TOTAL_DISC = 24;

        let currentTestType = '';

        window.onload = updateMenuUI;

        function showScreen(screenId) {
            $('.section-screen').removeClass('active-screen').hide();
            $('#' + screenId).addClass('active-screen').fadeIn();
            window.scrollTo(0,0);
        }

        function prepareTest(type) {
            currentTestType = type;
            const title = type === 'papi' ? 'Tes Papikostik' : 'Tes DISC';
            const content = type === 'papi' 
                ? '<p>Tes ini terdiri dari 90 pasang pernyataan. Pada setiap nomor, pilihlah salah satu dari dua pernyataan (<b>A</b> atau <b>B</b>) yang menurut Anda paling menggambarkan diri Anda di tempat kerja.</p><p>Jika keduanya terasa cocok, pilihlah yang <b>paling</b> mendekati kebenaran.</p>'
                : '<p>Terdapat 24 kelompok kata. Pada setiap kelompok, Anda wajib memilih:<br>1. Satu pernyataan yang <b>Paling (Most/M)</b> menggambarkan Anda.<br>2. Satu pernyataan yang <b>Kurang (Least/L)</b> menggambarkan Anda.</p>';
            
            $('#instruction-title').text(title);
            $('#instruction-content').html(content);
            showScreen('screen-instruction');
        }

        function backToMenu() { showScreen('screen-menu'); }

        function startTestActual() {
            showScreen('screen-test');
            $('#soal-container-papi').toggle(currentTestType === 'papi');
            $('#soal-container-disc').toggle(currentTestType === 'disc');
            $('#hint-text').text(currentTestType === 'papi' ? 'Klik langsung pada kotak pernyataan yang Anda pilih.' : 'Pilih tepat satu M (Most) dan satu L (Least) per baris kelompok.');
            
            renderSoal();
            loadSavedAnswers();
            updateProgressBar();
        }

        function renderSoal() {
            const containerPapi = $('#soal-container-papi');
            const containerDisc = $('#soal-container-disc');
            
            if(currentTestType === 'papi' && containerPapi.is(':empty')) {
                @foreach($soalPapi as $soal)
                containerPapi.append(`
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <h6 class="text-muted font-weight-bold mb-3">Pernyataan {{ $soal->nomor_kelompok }} dari ${TOTAL_PAPI}</h6>
                            <div class="row">
                                @foreach($soal->opsiJawaban as $opsi)
                                <div class="col-md-6 mb-2">
                                    <div class="card papi-card p-3 d-flex align-items-center justify-content-center" 
                                         onclick="savePapiAnswer({{ $soal->id_soal_kelompok }}, '{{ $opsi->kode_aspek }}', this)" 
                                         id="papi_{{ $soal->id_soal_kelompok }}_{{ $opsi->kode_aspek }}">
                                        {{ $opsi->isi_opsi }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>`);
                @endforeach
            } 
            else if(currentTestType === 'disc' && containerDisc.is(':empty')) {
                @foreach($soalDisc as $soal)
                containerDisc.append(`
                    <div class="mb-5 border-bottom pb-4">
                        <div class="d-flex align-items-center mb-2">
                             <span class="badge badge-navy text-white mr-2">Grup {{ $soal->nomor_kelompok }}</span>
                             <small class="text-muted font-weight-bold">Pilih satu M dan satu L</small>
                        </div>
                        <table class="table table-bordered bg-white shadow-sm">
                            <thead class="thead-light text-center small">
                                <tr><th>Daftar Karakter</th><th width="80">Most (M)</th><th width="80">Least (L)</th></tr>
                            </thead>
                            <tbody>
                                @foreach($soal->opsiJawaban as $opsi)
                                <tr>
                                    <td class="font-weight-bold text-dark">{{ $opsi->isi_opsi }}</td>
                                    <td class="text-center">
                                        <input type="radio" name="disc_{{ $soal->id_soal_kelompok }}_m" 
                                               onchange="saveDiscAnswer({{ $soal->id_soal_kelompok }}, 'M', '{{ $opsi->kode_aspek }}')" 
                                               style="width:20px; height:20px" value="{{ $opsi->kode_aspek }}">
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" name="disc_{{ $soal->id_soal_kelompok }}_l" 
                                               onchange="saveDiscAnswer({{ $soal->id_soal_kelompok }}, 'L', '{{ $opsi->kode_aspek }}')" 
                                               style="width:20px; height:20px" value="{{ $opsi->kode_aspek }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>`);
                @endforeach
            }
        }

        function savePapiAnswer(soalId, pilihan, el) {
            let answers = JSON.parse(localStorage.getItem(STORAGE_KEY_PAPI)) || {};
            answers[soalId] = pilihan;
            localStorage.setItem(STORAGE_KEY_PAPI, JSON.stringify(answers));
            $(el).closest('.row').find('.papi-card').removeClass('selected');
            $(el).addClass('selected');
            showAutoSaveBadge();
            updateProgressBar();
        }

        function saveDiscAnswer(soalId, type, aspek) {
            let answers = JSON.parse(localStorage.getItem(STORAGE_KEY_DISC)) || {};
            if(!answers[soalId]) answers[soalId] = { M: null, L: null };
            answers[soalId][type] = aspek;
            localStorage.setItem(STORAGE_KEY_DISC, JSON.stringify(answers));
            showAutoSaveBadge();
            updateProgressBar();
        }

        function showAutoSaveBadge() {
            $('#autosave-indicator').addClass('show');
            setTimeout(() => $('#autosave-indicator').removeClass('show'), 1200);
        }

        function updateProgressBar() {
            const isPapi = currentTestType === 'papi';
            const answers = JSON.parse(localStorage.getItem(isPapi ? STORAGE_KEY_PAPI : STORAGE_KEY_DISC)) || {};
            let total = isPapi ? TOTAL_PAPI : TOTAL_DISC;
            let count = 0;

            if(isPapi) { count = Object.keys(answers).length; } 
            else { Object.values(answers).forEach(v => { if(v.M && v.L) count++; }); }
            
            let percent = Math.round((count/total)*100);
            $('#progress-bar').css('width', percent + '%');
            $('#progress-text').text(percent + '%');
        }

        function loadSavedAnswers() {
            if(currentTestType === 'papi') {
                const ans = JSON.parse(localStorage.getItem(STORAGE_KEY_PAPI)) || {};
                Object.keys(ans).forEach(id => { $(`#papi_${id}_${ans[id]}`).addClass('selected'); });
            } else {
                const ans = JSON.parse(localStorage.getItem(STORAGE_KEY_DISC)) || {};
                Object.keys(ans).forEach(id => {
                    if(ans[id].M) $(`input[name="disc_${id}_m"][value="${ans[id].M}"]`).prop('checked', true);
                    if(ans[id].L) $(`input[name="disc_${id}_l"][value="${ans[id].L}"]`).prop('checked', true);
                });
            }
        }

        function finishTest() {
            showScreen('screen-menu');
            updateMenuUI();
        }

        function updateMenuUI() {
            const ansPapi = JSON.parse(localStorage.getItem(STORAGE_KEY_PAPI)) || {};
            const countPapi = Object.keys(ansPapi).length;

            const ansDisc = JSON.parse(localStorage.getItem(STORAGE_KEY_DISC)) || {};
            let countDisc = 0;
            Object.values(ansDisc).forEach(v => { if(v.M && v.L) countDisc++; });

            // UI PAPI
            if(countPapi >= TOTAL_PAPI) {
                $('#card-papi').addClass('completed').removeClass('incomplete');
                $('#status-papi').html('<div class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Selesai</div>');
            } else if(countPapi > 0) {
                $('#card-papi').addClass('incomplete').removeClass('completed');
                $('#status-papi').html('<div class="text-danger small font-weight-bold mb-2">Lanjutkan ('+countPapi+'/'+TOTAL_PAPI+')</div><button class="btn btn-danger btn-sm rounded-pill px-3">Lanjutkan</button>');
            } else {
                $('#card-papi').removeClass('completed incomplete');
                $('#status-papi').html('<button class="btn btn-outline-primary rounded-pill px-4">Mulai</button>');
            }

            // UI DISC
            if(countDisc >= TOTAL_DISC) {
                $('#card-disc').addClass('completed').removeClass('incomplete');
                $('#status-disc').html('<div class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Selesai</div>');
            } else if(countDisc > 0) {
                $('#card-disc').addClass('incomplete').removeClass('completed');
                $('#status-disc').html('<div class="text-danger small font-weight-bold mb-2">Lanjutkan ('+countDisc+'/'+TOTAL_DISC+')</div><button class="btn btn-danger btn-sm rounded-pill px-3">Lanjutkan</button>');
            } else {
                $('#card-disc').removeClass('completed incomplete');
                $('#status-disc').html('<button class="btn btn-outline-success rounded-pill px-4">Mulai</button>');
            }

            // Tombol Submit Gabungan
            if(countPapi >= TOTAL_PAPI && countDisc >= TOTAL_DISC) {
                $('#final-submit-container').fadeIn();
            } else {
                $('#final-submit-container').hide();
            }
        }

        function submitAll() {
            if(!confirm("Kirim seluruh jawaban psikotes Anda? Jawaban yang sudah dikirim tidak dapat diubah kembali.")) return;
            
            fetch("{{ route('pelamar.tes.store') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({
                    papi: JSON.parse(localStorage.getItem(STORAGE_KEY_PAPI)),
                    disc: JSON.parse(localStorage.getItem(STORAGE_KEY_DISC))
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    localStorage.removeItem(STORAGE_KEY_PAPI);
                    localStorage.removeItem(STORAGE_KEY_DISC);
                    window.location.href = "{{ route('pelamar.dashboard') }}";
                } else {
                    alert("Gagal mengirim: " + data.message);
                }
            })
            .catch(() => alert("Koneksi bermasalah. Pastikan internet Anda stabil."));
        }
    </script>
</body>
</html>