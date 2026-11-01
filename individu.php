<?php
$matkul = [
    ["nama" => "Sistem Operasi",     "sks" => 3, "nilai" => 89],
    ["nama" => "Jaringan Komputer",  "sks" => 4, "nilai" => 45],
    ["nama" => "Pemrograman Web",    "sks" => 3, "nilai" => 88],
    ["nama" => "Sistem Basis Data",  "sks" => 4, "nilai" => 40],
    ["nama" => "Internet of Things", "sks" => 4, "nilai" => 87],
];
 
function hitungBobot($nilai)
{
    if ($nilai >= 85) {
        return ["huruf" => "A", "bobot" => 4.0];
    } elseif ($nilai >= 70) {
        return ["huruf" => "B", "bobot" => 3.0];
    } elseif ($nilai >= 55) {
        return ["huruf" => "C", "bobot" => 2.0];
    } elseif ($nilai >= 40) {
        return ["huruf" => "D", "bobot" => 1.0];
    }
    return ["huruf" => "E", "bobot" => 0.0];
}
 
$totalSks  = 0;
$totalMutu = 0;
 
foreach ($matkul as $mk) {
    $h = hitungBobot($mk["nilai"]);
    $totalSks  += $mk["sks"];
    $totalMutu += $h["bobot"] * $mk["sks"];
}
 
$ips = $totalMutu / $totalSks;
 
$maksSks = ($ips >= 3.00) ? 24 : 20;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilai Semester</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #bae6fd, #fbcfe8);
            min-height: 100vh;
            color: #1e293b;
            margin: 0;
            padding: 30px 16px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.2);
        }
        h1 { margin: 0 0 4px; font-size: 1.6rem; font-weight: 700; color: #0284c7; }
        .sub { margin: 0 0 22px; color: #64748b; font-size: 0.92rem; }
 
        table { width: 100%; border-collapse: collapse; font-size: 0.93rem; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #0ea5e9; color: #fff; font-weight: 600; }
        th:first-child { border-top-left-radius: 10px; }
        th:last-child { border-top-right-radius: 10px; }
        .tengah { text-align: center; }
 
        /* Baris mata kuliah yang mengulang diberi warna merah */
        tr.mengulang { background: #fee2e2; color: #b91c1c; font-weight: 600; }
        td.lulus { color: #15803d; font-weight: 600; }
 
        .bawah { display: flex; gap: 16px; margin-top: 26px; flex-wrap: wrap; }
        .kotak { flex: 1; min-width: 240px; padding: 20px; border-radius: 16px; }
        .kotak h2 { margin: 0 0 10px; font-size: 1.05rem; font-weight: 600; }
        .kotak p { margin: 5px 0; font-size: 0.93rem; }
 
        .ips { background: #e0f2fe; border: 1px solid #7dd3fc; }
        .ips h2 { color: #0369a1; }
 
        .sks {
            background: linear-gradient(135deg, #f472b6, #ec4899);
            color: #fff;
            text-align: center;
        }
        .sks .angka { font-size: 2.6rem; font-weight: 700; line-height: 1.2; }
    </style>
</head>
<body>
<div class="container">
    <h1>Nilai Semester Ini</h1>
    <p class="sub">Daftar nilai, status, dan jatah SKS semester depan.</p>
 
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th class="tengah">SKS</th>
                <th class="tengah">Nilai</th>
                <th class="tengah">Huruf</th>
                <th class="tengah">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($matkul as $i => $mk):
            $h      = hitungBobot($mk["nilai"]);
            $status = ($h["bobot"] >= 2.0) ? "LULUS" : "MENGULANG";
        ?>
            <tr class="<?= $status === 'MENGULANG' ? 'mengulang' : '' ?>">
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($mk["nama"]) ?></td>
                <td class="tengah"><?= $mk["sks"] ?></td>
                <td class="tengah"><?= $mk["nilai"] ?></td>
                <td class="tengah"><?= $h["huruf"] ?></td>
                <td class="tengah <?= $status === 'LULUS' ? 'lulus' : '' ?>"><?= $status ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
 
    <div class="bawah">
        <div class="kotak ips">
            <h2>Ringkasan IPS</h2>
            <p>Total SKS: <strong><?= $totalSks ?></strong></p>
            <p>Total mutu: <strong><?= number_format($totalMutu, 1) ?></strong></p>
            <p>IPS: <strong><?= number_format($ips, 2) ?></strong></p>
        </div>
        <div class="kotak sks">
            <h2>SKS Semester Depan</h2>
            <div class="angka"><?= $maksSks ?> SKS</div>
            <p>
                <?= $ips >= 3.00
                    ? "IPS kamu 3,00 ke atas, jadi boleh ambil maksimal 24 SKS."
                    : "IPS kamu di bawah 3,00, jadi maksimal 20 SKS dulu." ?>
            </p>
        </div>
    </div>
</div>
</body>
</html>