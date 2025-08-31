<?php
$host = getenv('MYSQL_HOST');
$db = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$port = getenv('MYSQL_PORT') ?: '3306';


try {
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
$pdo->exec("CREATE TABLE IF NOT EXISTS hello (id INT AUTO_INCREMENT PRIMARY KEY, msg VARCHAR(255))");
if (!$pdo->query("SELECT COUNT(*) FROM hello")->fetchColumn()) {
$pdo->prepare("INSERT INTO hello (msg) VALUES (?)")->execute(['PHP → Cloudways MySQL ✅']);
}
$msg = $pdo->query("SELECT msg FROM hello ORDER BY id DESC LIMIT 1")->fetchColumn();
} catch (Throwable $e) { $msg = 'DB error: ' . $e->getMessage(); }


$apiBase = getenv('API_BASE');
$apiCheck = 'API base not set';
if ($apiBase) {
$url = rtrim($apiBase, '/') . '/ping';
$apiCheck = @file_get_contents($url) ?: 'Flask not reachable';
}
?>
<!doctype html><html><body>
<h1><?= htmlspecialchars($msg) ?></h1>
<p>Flask check: <?= htmlspecialchars($apiCheck) ?></p>
</body></html>