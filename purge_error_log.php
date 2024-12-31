<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $search_string = $_POST['search_string'] ?? '';
  
  if (strlen($search_string) >= 3) {
    removeLines($search_string);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Delete Lines from error_log</title>
</head>
<body>
<div class="container mt-5">
  <h1>Delete Lines from error_log</h1>
  <form method="POST">
    <div class="form-group">
      <label for="search_string">Enter a String (at least 3 chars):</label>
      <input type="text" name="search_string" id="search_string" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-danger mt-3">Delete Matching Lines</button>
  </form>
</div>
</body>
</html>

<?php
function removeLines($search_string) {
  $filename = 'error_log';
  if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $filtered_lines = array_filter($lines, function($line) use ($search_string) {
      return strpos($line, $search_string) === false; // case-sensitive match
    });
    file_put_contents($filename, implode(PHP_EOL, $filtered_lines) . PHP_EOL);
  }
}
?>
