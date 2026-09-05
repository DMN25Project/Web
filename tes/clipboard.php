<?php
// Nama file untuk menyimpan teks sementara
$file = 'data_teks.txt';

// Mengecek apakah ada teks yang dikirim dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shared_text'])) {
    $text = $_POST['shared_text'];
    // Menyimpan teks ke dalam file data_teks.txt
    file_put_contents($file, $text);
}

// Mengambil teks yang ada saat ini dari file (jika ada)
$current_text = '';
if (file_exists($file)) {
    $current_text = file_get_contents($file);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Clipboard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 600px; 
            margin: 50px auto; 
            padding: 20px;
            background-color: #f4f4f9;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        textarea { 
            width: 100%; 
            height: 100px; 
            margin-bottom: 10px; 
            padding: 10px; 
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }
        .btn-submit:hover { background-color: #218838; }
        
        .result-box { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            margin-top: 20px; 
            padding: 15px; 
            border: 1px solid #007bff; 
            background: #e9f2ff;
            border-radius: 4px;
        }
        .result-text { 
            flex-grow: 1; 
            word-break: break-all; 
            font-family: monospace;
            font-size: 14px;
        }
        .btn-copy { 
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px; 
            cursor: pointer; 
            border-radius: 4px;
            font-weight: bold;
            white-space: nowrap;
        }
        .btn-copy:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="container">
        <h2>📋 Local Network Clipboard</h2>
        
        <!-- Form input text -->
        <form method="POST">
            <textarea name="shared_text" placeholder="Ketik atau paste teks yang mau dishare ke jaringan lokal di sini..." required></textarea><br>
            <button type="submit" class="btn-submit">Bagikan Teks</button>
        </form>

        <hr style="margin: 30px 0; border-top: 1px solid #ddd;">

        <h3>Teks Tersedia:</h3>
        <p style="font-size: 12px; color: #666;">*Refresh halaman ini di perangkat lain untuk melihat teks terbaru.</p>
        
        <!-- Area hasil text dan tombol copy -->
        <div class="result-box">
            <div class="result-text" id="textToCopy"><?php echo htmlspecialchars($current_text); ?></div>
            <button class="btn-copy" onclick="copyText()">Copy Text</button>
        </div>
    </div>

    <!-- Script untuk fitur Copy to Clipboard -->
    <script>
        function copyText() {
            // Ambil teks dari div
            var text = document.getElementById("textToCopy").innerText;
            
            if (!text || text.trim() === "") {
                alert("Tidak ada teks untuk dicopy!");
                return;
            }

            // Gunakan API Clipboard bawaan browser
            navigator.clipboard.writeText(text).then(function() {
                alert("✅ Teks berhasil dicopy!");
            }, function(err) {
                alert("❌ Gagal copy teks: " + err);
            });
        }
    </script>

</body>
</html>
