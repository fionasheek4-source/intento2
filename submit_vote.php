<?php
// submit_vote.php
require 'config.php';
require 'functions.php';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Votación</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-[#0b3a53] to-[#f59e36]">
  <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-lg">
    <h2 class="text-2xl font-bold text-center mb-6 text-[#0b3a53]">Emitir Voto</h2>
    <form id="voteForm" class="space-y-4">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

      <!-- Ejemplo de secciones y candidatos -->
      <div>
        <label class="block font-semibold mb-1">Sección 1</label>
        <select name="choice[1]" required class="w-full border rounded p-2">
          <option value="">-- Seleccione un candidato --</option>
          <option value="101">Candidato 101</option>
          <option value="102">Candidato 102</option>
        </select>
      </div>

      <div>
        <label class="block font-semibold mb-1">Sección 2</label>
        <select name="choice[2]" required class="w-full border rounded p-2">
          <option value="">-- Seleccione un candidato --</option>
          <option value="201">Candidato 201</option>
          <option value="202">Candidato 202</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-[#0b3a53] hover:bg-[#092c3f] text-white py-2 rounded-lg shadow-md">
        Votar
      </button>
    </form>

    <!-- Mensajes dinámicos -->
    <div id="message" class="mt-4 hidden p-3 rounded-lg text-center font-semibold"></div>
  </div>

  <script>
    document.getElementById('voteForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const response = await fetch("submit_vote_action.php", { // archivo backend que procesa
        method: "POST",
        body: formData
      });

      const result = await response.json();
      const msgDiv = document.getElementById("message");

      msgDiv.classList.remove("hidden", "bg-green-100", "bg-red-100", "text-green-800", "text-red-800");

      if (result.success) {
        msgDiv.textContent = "✅ Voto registrado con éxito. Tu comprobante: " + result.token;
        msgDiv.classList.add("bg-green-100", "text-green-800");
      } else {
        msgDiv.textContent = "❌ Error: " + result.message;
        msgDiv.classList.add("bg-red-100", "text-red-800");
      }
    });
  </script>
</body>
</html>
