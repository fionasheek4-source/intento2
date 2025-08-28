<?php
require 'config.php';
header('Content-Type: application/json; charset=utf-8');

// devolvemos estructura: sections -> [ { candidate_id, candidate_name, votes } ]
$sections = $pdo->query("SELECT * FROM sections ORDER BY id")->fetchAll();
$out = [];
foreach ($sections as $s) {
    $stmt = $pdo->prepare("SELECT c.id as candidate_id, c.name as candidate_name, COUNT(v.id) as votes
                           FROM candidates c
                           LEFT JOIN votes v ON v.candidate_id = c.id
                           WHERE c.section_id = ?
                           GROUP BY c.id
                           ORDER BY c.id");
    $stmt->execute([$s['id']]);
    $out[] = [
        'section_id' => $s['id'],
        'section_name' => $s['name'],
        'candidates' => $stmt->fetchAll()
    ];
}
echo json_encode($out);
