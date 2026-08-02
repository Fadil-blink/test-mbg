<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!empty($_SESSION['user_id'])) {
  $roleName = strtolower($_SESSION['role_name'] ?? '');
  if (in_array($roleName, ['admin_pusat','auditor_pusat','auditor_khusus'])) header('Location: ../pusat/dashboard.php');
  elseif (in_array($roleName, ['manager_sppg','staf_sppg'])) header('Location: ../sppg/index.php');
  elseif (in_array($roleName, ['supplier','admin_supplier'])) header('Location: ../supplier/index.php');
  else header('Location: ../auth/login.php');
  exit;
}

$error = '';

$usersTableExists = true;
$tblCheck = $mysqli->query("SHOW TABLES LIKE 'users'");
if (!$tblCheck || $tblCheck->num_rows === 0) {
    $usersTableExists = false;
    $sqlPath = realpath(__DIR__ . '/../database_mbg.sql') ?: __DIR__ . '/../database_mbg.sql';
    $error = "Tabel 'users' tidak ditemukan. Impor file SQL sample: mysql -u root mbgfix < " . $sqlPath . "\nAtau import `" . $sqlPath . "` via phpMyAdmin atau tool MySQL lainnya.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($email === '' || $password === '') {
    $error = 'Email dan kata sandi wajib diisi.';
  } else {
    if (!$usersTableExists) {
      // keep $error as previously set (missing users table)
    } else {
      $stmt = $mysqli->prepare('SELECT u.id, u.email, u.password_hash, u.full_name, u.role_id, u.organization_id, r.name AS role_name, u.is_active FROM users u LEFT JOIN roles r ON u.role_id = r.id WHERE u.email = ? LIMIT 1');
      if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
          // --- Debug logging (append-only, safe diagnostics) ---
          $logDir = __DIR__ . '/../logs';
          if (!is_dir($logDir)) @mkdir($logDir, 0755, true);
          $logFile = $logDir . '/auth_debug.log';
          $d = date('Y-m-d H:i:s');
          $found = 'yes';
          $roleNameDbg = $row['role_name'] ?? '';
          $isActiveDbg = $row['is_active'] ? '1' : '0';
          $storedHash = $row['password_hash'] ?? '';
          $computedHash = md5($password);
          $match = ($storedHash === $computedHash) ? 'match' : 'nomatch';
          @file_put_contents($logFile, "$d\t$email\tfound:$found\trole:$roleNameDbg\tactive:$isActiveDbg\tstored:$storedHash\tcomputed:$computedHash\tresult:$match\n", FILE_APPEND | LOCK_EX);

          if ($row['is_active'] && $row['password_hash'] === md5($password)) {
            $_SESSION['user_id'] = (int)$row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['role_id'] = (int)$row['role_id'];
            $_SESSION['role_name'] = $row['role_name'] ?? '';
            $_SESSION['organization_id'] = is_numeric($row['organization_id']) ? (int)$row['organization_id'] : null;

            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $upd = $mysqli->prepare('UPDATE users SET last_login = NOW(), last_ip = ? WHERE id = ?');
            if ($upd) { $upd->bind_param('si', $ip, $row['id']); $upd->execute(); }

            $roleName = strtolower((string)($row['role_name'] ?? ''));
            if ($roleName === '') {
              $numericRole = (int)$row['role_id'];
              if (in_array($numericRole, [1,2,3])) {
                $roleName = 'pusat';
              } elseif (in_array($numericRole, [4,5])) {
                $roleName = 'sppg';
              } elseif (in_array($numericRole, [6,7])) {
                $roleName = 'supplier';
              }
            }

            if (in_array($roleName, ['admin_pusat','auditor_pusat','auditor_khusus','pusat'])) {
              header('Location: ../pusat/dashboard.php');
            } elseif (in_array($roleName, ['manager_sppg','staf_sppg','sppg'])) {
              header('Location: ../sppg/index.php');
            } elseif (in_array($roleName, ['supplier','admin_supplier','supplier'])) {
              header('Location: ../supplier/index.php');
            } else {
              header('Location: ../auth/login.php');
            }
            $stmt->close();
            exit;
          } else {
            $error = 'Email atau kata sandi salah, atau akun dinonaktifkan.';
            @file_put_contents($logFile, date('Y-m-d H:i:s') . "\tLOGIN_FAIL\t$email\trole:$roleNameDbg\tactive:$isActiveDbg\n", FILE_APPEND | LOCK_EX);
          }
        } else {
          $error = 'Email atau kata sandi salah.';
          $logDir = __DIR__ . '/../logs';
          if (!is_dir($logDir)) @mkdir($logDir, 0755, true);
          @file_put_contents($logDir . '/auth_debug.log', date('Y-m-d H:i:s') . "\tLOGIN_NOUSER\t$email\n", FILE_APPEND | LOCK_EX);
        }
        $stmt->close();
      } else {
        $error = 'Gagal memproses permintaan: ' . $mysqli->error;
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Sistem Monitoring dan Pengadaan MBG Nasional</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-wrap">
  <div class="auth-card">

    <!-- ================= LEFT: FORM ================= -->
    <div class="auth-left">
      <div class="auth-logo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 17V7l6 6 6-6v10"/>
        </svg>
        <div class="auth-logo-text">
          <span>MBG</span>
          <span>NASIONAL</span>
        </div>
      </div>

      <h1>Sistem Monitoring dan<br>Pengadaan MBG Nasional</h1>
      <p class="sub">Platform Terintegrasi Pengadaan dan Pengawasan Program Makan Bergizi Gratis</p>

      <?php if (!empty($error)): ?>
        <div class="auth-error"><?php echo nl2br(htmlspecialchars($error)); ?></div>
      <?php endif; ?>

      <form action="" method="post" autocomplete="off">
        <div class="field">
          <div class="field-row"><label for="email">Email</label></div>
          <div class="input-wrap">
            <svg class="left-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
            <input type="email" id="email" name="email" placeholder="nama@email.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
          </div>
        </div>

        <div class="field">
          <div class="field-row">
            <label for="password">Kata Sandi</label>
            <a href="#" class="fwd">Lupa Kata Sandi?</a>
          </div>
          <div class="input-wrap">
            <svg class="left-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            <button type="button" class="right-icon" id="togglePassword" aria-label="Tampilkan kata sandi">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>

        <div class="checkbox-row">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">Ingat Saya</label>
        </div>

        <button type="submit" class="btn-primary">
          Masuk
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M13 5l7 7-7 7"/><path d="M4 12h16"/></svg>
        </button>
      </form>

      <hr class="or-divider">

      <p class="center-text">Belum memiliki akun Supplier?</p>
      <a href="registrasi-supplier.php" class="btn-outline-full">Daftar Sebagai Supplier</a>
    </div>

    <!-- ================= RIGHT: ILLUSTRATION ================= -->
    <div class="auth-right">
      <div class="illust-card">
        <div class="illust-top">
          <span class="flag-badge"><i></i></span>
          SATU DATA<br>INDONESIA
        </div>

        <svg class="illust-img" viewBox="0 0 500 300" xmlns="http://www.w3.org/2000/svg">
          <g stroke="#93a9c4" stroke-width="1.5" stroke-dasharray="4 4" fill="none">
            <path d="M120 150 C170 140 200 120 230 120"/>
            <path d="M270 130 C300 140 320 150 340 160"/>
            <path d="M260 190 C280 220 320 235 360 230"/>
            <path d="M180 190 C190 220 220 240 250 245"/>
          </g>
          <g transform="translate(150,60)">
            <ellipse cx="30" cy="30" rx="42" ry="24" fill="#ffffff" opacity="0.9"/>
            <circle cx="40" cy="32" r="11" fill="none" stroke="#1d4ed8" stroke-width="3"/>
            <line x1="48" y1="40" x2="58" y2="50" stroke="#1d4ed8" stroke-width="3" stroke-linecap="round"/>
          </g>
          <g transform="translate(70,155)">
            <circle cx="20" cy="10" r="10" fill="#0f2846"/>
            <rect x="6" y="20" width="28" height="42" rx="8" fill="#1d4ed8"/>
            <rect x="0" y="35" width="16" height="22" rx="4" fill="#dbeafe"/>
          </g>
          <g transform="translate(105,165)">
            <circle cx="20" cy="10" r="10" fill="#7c2d12"/>
            <rect x="6" y="20" width="28" height="42" rx="8" fill="#0f2846"/>
            <rect x="24" y="33" width="16" height="22" rx="4" fill="#dbeafe"/>
          </g>
          <g transform="translate(40,140)">
            <rect x="0" y="0" width="34" height="26" rx="4" fill="#fff" stroke="#dbe3ee"/>
            <rect x="6" y="14" width="4" height="8" fill="#1d4ed8"/>
            <rect x="13" y="9" width="4" height="13" fill="#60a5fa"/>
            <rect x="20" y="5" width="4" height="17" fill="#1d4ed8"/>
          </g>
          <g transform="translate(155,205)">
            <rect x="0" y="0" width="34" height="26" rx="4" fill="#fff" stroke="#dbe3ee"/>
            <circle cx="17" cy="13" r="9" fill="none" stroke="#f59e0b" stroke-width="4" stroke-dasharray="14 30"/>
            <circle cx="17" cy="13" r="9" fill="none" stroke="#1d4ed8" stroke-width="4" stroke-dasharray="10 30" stroke-dashoffset="-14"/>
          </g>
          <g transform="translate(220,70)">
            <rect x="10" y="40" width="90" height="110" rx="4" fill="#ffffff" stroke="#c7d4e3"/>
            <rect x="10" y="12" width="90" height="30" fill="#0f2846"/>
            <g fill="#38bdf8" opacity="0.85">
              <rect x="18" y="16" width="12" height="8"/>
              <rect x="34" y="16" width="12" height="8"/>
              <rect x="50" y="16" width="12" height="8"/>
              <rect x="66" y="16" width="12" height="8"/>
              <rect x="82" y="16" width="12" height="8"/>
            </g>
            <g fill="#93c5fd">
              <rect x="20" y="55" width="14" height="16" rx="2"/>
              <rect x="42" y="55" width="14" height="16" rx="2"/>
              <rect x="64" y="55" width="14" height="16" rx="2"/>
              <rect x="86" y="55" width="14" height="16" rx="2"/>
              <rect x="20" y="80" width="14" height="16" rx="2"/>
              <rect x="42" y="80" width="14" height="16" rx="2"/>
              <rect x="64" y="80" width="14" height="16" rx="2"/>
              <rect x="86" y="80" width="14" height="16" rx="2"/>
            </g>
            <rect x="42" y="120" width="26" height="30" fill="#1d4ed8"/>
            <circle cx="0" cy="130" r="12" fill="#16a34a"/>
            <rect x="-2" y="130" width="4" height="14" fill="#7c4a1e"/>
            <circle cx="112" cy="128" r="12" fill="#16a34a"/>
            <rect x="110" y="128" width="4" height="14" fill="#7c4a1e"/>
          </g>
          <g transform="translate(370,110)">
            <circle cx="18" cy="8" r="9" fill="#e8b48a"/>
            <path d="M4 8 a14 8 0 0 1 28 0 z" fill="#d9a441"/>
            <rect x="4" y="16" width="28" height="36" rx="8" fill="#fff"/>
            <rect x="4" y="16" width="28" height="14" rx="6" fill="#0f766e"/>
            <ellipse cx="18" cy="46" rx="20" ry="12" fill="#c98b4a"/>
            <circle cx="10" cy="42" r="4" fill="#f5f0e6"/>
            <circle cx="18" cy="40" r="4" fill="#f5f0e6"/>
            <circle cx="26" cy="42" r="4" fill="#e8c468"/>
            <circle cx="14" cy="46" r="4" fill="#8bc34a"/>
            <circle cx="22" cy="46" r="4" fill="#8bc34a"/>
          </g>
          <rect x="428" y="98" width="30" height="15" rx="7" fill="#0f2846"/>
          <text x="433" y="108" font-size="8" fill="#fff" font-family="Arial" font-weight="700">UMKM</text>
          <g transform="translate(345,175)">
            <rect x="0" y="6" width="30" height="16" rx="2" fill="#fff" stroke="#c7d4e3"/>
            <rect x="30" y="10" width="14" height="12" rx="2" fill="#16a34a"/>
            <circle cx="9" cy="24" r="4" fill="#0f2846"/>
            <circle cx="34" cy="24" r="4" fill="#0f2846"/>
          </g>
          <g transform="translate(300,205)">
            <rect x="0" y="6" width="28" height="15" rx="2" fill="#fff" stroke="#c7d4e3"/>
            <rect x="28" y="9" width="13" height="12" rx="2" fill="#1d4ed8"/>
            <circle cx="8" cy="23" r="4" fill="#0f2846"/>
            <circle cx="32" cy="23" r="4" fill="#0f2846"/>
          </g>
          <g transform="translate(400,205)">
            <polygon points="10,0 -6,16 26,16" fill="#dc2626"/>
            <rect x="-4" y="16" width="28" height="24" fill="#fff" stroke="#c7d4e3"/>
          </g>
          <g transform="translate(432,220)">
            <polygon points="8,0 -5,13 21,13" fill="#f59e0b"/>
            <rect x="-3" y="13" width="22" height="19" fill="#fff" stroke="#c7d4e3"/>
          </g>
          <path d="M0 260 C 100 230, 180 280, 280 250 S 460 220, 500 240" fill="none" stroke="#9db3cf" stroke-width="22" stroke-linecap="round" opacity="0.55"/>
          <path d="M0 260 C 100 230, 180 280, 280 250 S 460 220, 500 240" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="10 10" opacity="0.9"/>
        </svg>

        <div class="mock-login">
          <div class="mock-field">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"/></svg>
            <span>Username</span>
          </div>
          <div class="mock-field">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
            <span>Password</span>
          </div>
        </div>

        <div class="floating-chip chip-top">
          <div class="fc-icon fc-blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/></svg>
          </div>
          <div><div class="fc-title">Monitoring Real-time</div><div class="fc-sub">Data Pengadaan Nasional</div></div>
        </div>

        <div class="floating-chip chip-bottom">
          <div class="fc-icon fc-green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3 6 7 1-5 5 1.5 7-6.5-3.5L5 21l1.5-7-5-5 7-1z"/></svg>
          </div>
          <div><div class="fc-title">Kualitas Terjamin</div><div class="fc-sub">Standar Gizi Terpadu</div></div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  var toggleBtn = document.getElementById('togglePassword');
  var passwordInput = document.getElementById('password');
  if (toggleBtn && passwordInput) {
    toggleBtn.addEventListener('click', function () {
      var isPassword = passwordInput.getAttribute('type') === 'password';
      passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
    });
  }
</script>
</body>
</html>