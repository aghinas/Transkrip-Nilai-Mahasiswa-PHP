<?php

$matkul = [
    ["nama" => "Sistem Operasi",      "sks" => 3, "nilai" => 82],
    ["nama" => "Jaringan Komputer",   "sks" => 4, "nilai" => 67],
    ["nama" => "Pemrograman Web",     "sks" => 3, "nilai" => 88],
    ["nama" => "Sistem Basis Data",   "sks" => 3, "nilai" => 70],
    ["nama" => "Internet of Things",  "sks" => 4, "nilai" => 85],
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
    $hasil      = hitungBobot($mk["nilai"]);
    $totalSks  += $mk["sks"];
    $totalMutu += $hasil["bobot"] * $mk["sks"];
}
 
$ips = $totalSks > 0 ? $totalMutu / $totalSks : 0;
 
$maksSks = ($ips >= 3.00) ? 24 : 20;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transkrip Nilai Semester</title>
    <style>
        :root {
            --bg: #f3f6fa;
            --surface: #ffffff;
            --ink: #14213d;
            --muted: #5c6b82;
            --line: #d9e1ec;
            --accent: #1d4ed8;
            --fail-bg: #fde8e8;
            --fail-ink: #b91c1c;
            --pass-ink: #15803d;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 32px 16px;
            background: var(--bg);
            color: var(--ink);
            font-family: "Segoe UI", "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
        }
        .wrap { max-width: 860px; margin: 0 auto; }
        h1 { margin: 0 0 4px; font-size: 1.75rem; }
        .sub { margin: 0 0 24px; color: var(--muted); }
        .table-scroll { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface);
            border: 1px solid var(--line);
        }
        th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid var(--line); }
        th { background: var(--ink); color: #fff; font-weight: 600; }
        td.num, th.num { text-align: center; }
        tr.mengulang td { background: var(--fail-bg); color: var(--fail-ink); font-weight: 600; }
        tr.lulus td.status { color: var(--pass-ink); font-weight: 600; }
        .summary {
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 12px;
        }
        .box { background: var(--surface); border: 1px solid var(--line); padding: 14px 16px; }
        .box .label { color: var(--muted); font-size: 0.9rem; }
        .box .value { font-size: 1.5rem; font-weight: 700; }
        .box.main { border-left: 4px solid var(--accent); }
        .note { margin-top: 16px; padding: 14px 16px; background: var(--surface); border: 1px solid var(--line); }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Transkrip Nilai Semester</h1>
    <p class="sub">Daftar nilai, status kelulusan, dan rencana beban studi semester depan.</p>
 
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th class="num">No</th>
                    <th>Mata Kuliah</th>
                    <th class="num">SKS</th>
                    <th class="num">Nilai Angka</th>
                    <th class="num">Nilai Huruf</th>
                    <th class="num">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($matkul as $i => $mk):
                $hasil  = hitungBobot($mk["nilai"]);
                $status = ($hasil["bobot"] >= 2.0) ? "LULUS" : "MENGULANG";
                $kelas  = ($status === "MENGULANG") ? "mengulang" : "lulus";
            ?>
                <tr class="<?= $kelas ?>">
                    <td class="num"><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($mk["nama"]) ?></td>
                    <td class="num"><?= $mk["sks"] ?></td>
                    <td class="num"><?= $mk["nilai"] ?></td>
                    <td class="num"><?= $hasil["huruf"] ?></td>
                    <td class="num status"><?= $status ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
 
    <!-- 4. Ringkasan IPS -->
    <div class="summary">
        <div class="box">
            <div class="label">Total SKS</div>
            <div class="value"><?= $totalSks ?></div>
        </div>
        <div class="box">
            <div class="label">Total Mutu</div>
            <div class="value"><?= number_format($totalMutu, 1) ?></div>
        </div>
        <div class="box main">
            <div class="label">IPS</div>
            <div class="value"><?= number_format($ips, 2) ?></div>
        </div>
    </div>
 
    <!-- 5. Batas SKS semester depan -->
    <div class="note">
        Dengan IPS <strong><?= number_format($ips, 2) ?></strong>, kamu boleh mengambil maksimal
        <strong><?= $maksSks ?> SKS</strong> pada semester depan.
    </div>
</div>
</body>
</html>