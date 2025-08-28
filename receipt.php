<?php
require 'config.php';
$token = $_GET['token'] ?? '';
if (!$token) { die('Token inválido'); }

$stmt = $pdo->prepare("SELECT v.*, c.name as candidate_name, s.name as section_name, u.name as voter_name, u.email as voter_email
                       FROM votes v
                       JOIN candidates c ON v.candidate_id = c.id
                       JOIN sections s ON v.section_id = s.id
                       JOIN users u ON v.user_id = u.id
                       WHERE v.token = ?");
$stmt->execute([$token]);
$rows = $stmt->fetchAll();
if (!$rows) die('Comprobante no encontrado');
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Comprobante</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
  body {
    background: linear-gradient(135deg, #142143 0%, #2563eb 100%);
    font-family: 'Segoe UI', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 1rem;
  }
  .comprobante-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    border-top: 6px solid #f59e36;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    max-width: 600px;
    width: 100%;
  }
  .comprobante-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
  }
  .section-block {
    background: #f3f4f6;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    transition: background 0.3s ease;
  }
  .section-block:hover {
    background: #e0f2fe;
  }
  .print-btn {
    background: #0b3a53;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: background 0.3s ease;
  }
  .print-btn:hover {
    background: #2563eb;
  }
  .back-link {
    color: #f59e36;
    font-weight: 500;
    transition: color 0.3s ease;
  }
  .back-link:hover {
    color: #ffaf00;
  }
</style>
</head>
<body>
  <div class="comprobante-card">
    <h2 class="text-3xl font-bold text-[#0b3a53] mb-2">Comprobante de Votación</h2>
    <p class="text-sm text-gray-700 mb-1">Token: <strong><?= htmlspecialchars($token) ?></strong></p>
    <p class="text-sm text-gray-700 mb-4">Votante: <strong><?= htmlspecialchars($rows[0]['voter_name']) ?> (<?= htmlspecialchars($rows[0]['voter_email']) ?>)</strong></p>
    <hr class="my-4 border-gray-300">
    <div>
      <?php foreach($rows as $r): ?>
        <div class="section-block">
          <div class="font-semibold text-[#0b3a53]"><?= htmlspecialchars($r['section_name']) ?></div>
          <div class="text-gray-700"><?= htmlspecialchars($r['candidate_name']) ?></div>
          <div class="text-xs text-gray-400">Fecha: <?= $r['created_at'] ?></div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="mt-6 flex justify-end gap-3">
      <button onclick="window.print()" class="print-btn">🖨 Imprimir</button>
      <a href="index.php" class="back-link self-center">⬅ Volver</a>
    </div>
  </div>
</body>
</html>
